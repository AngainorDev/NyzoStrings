<?php
  /**
   * ref: https://github.com/n-y-z-o/nyzoVerifier/blob/master/src/main/java/co/nyzo/verifier/nyzoString/NyzoStringEncoder.java
   * version: 0.0.1
   */
  require_once("NyzoString.php");
  require_once("NyzoStringMicropay.php");
  require_once("NyzoStringPrefilledData.php");
  require_once("NyzoStringPrivateSeed.php");
  require_once("NyzoStringPublicIdentifier.php");
  require_once("NyzoStringTransaction.php");
  require_once("utils/Buffer.php");
  require_once("utils/UInt8Array.php");

  final class NyzoStringEncoder {
    
    const CHARACTER_LOOKUP = "0123456789" .
                             "abcdefghijkmnopqrstuvwxyz" . // all except lowercase "L"
                             "ABCDEFGHIJKLMNPQRSTUVWXYZ" . // all except uppercase "o"
                             "-.~_";                       // see https://tools.ietf.org/html/rfc3986#section-2.3
    
    // These were computed once by the test suite, then hardcoded here so NyzoStringType is not needed in real code.
    const NYZO_PREFIXES_BYTES = [
      "pre_" => [97, 163, 191],
      "key_" => [80, 232, 127],
      "id__" => [72, 223, 255],
      "pay_" => [96, 168, 127],
      "tx__" => [114, 15, 255]
    ];

    // Get a list of valid prefixes for future use.
    const NYZO_PREFIXES = [
      "pre_",
      "key_",
      "id__",
      "pay_",
      "tx__"
    ];
  
    const HEADER_LENGTH = 4;

    private $characterToValueMap;

    public function __construct() {
      $this->characterToValueMap = [];

      for($i = 0; $i < strlen(NyzoStringEncoder::CHARACTER_LOOKUP); $i++) {
        $this->characterToValueMap[NyzoStringEncoder::CHARACTER_LOOKUP[$i]] = $i;
      }
    }

    /**
     * Encodes an instance of a NyzoString type into a string.
     */
    public function encode(NyzoString $stringObject): string {
      // Get the prefix array from the type and the content array from the content object.
      $prefixBytes = NyzoStringEncoder::NYZO_PREFIXES_BYTES[$stringObject->getType()->value()];
      $contentBytes = $stringObject->getBytes();

      // Determine the length of the expanded array with the header and the checksum. The header is the type-specific
      // prefix in characters followed by a single byte that indicates the length of the content array (four bytes
      // total). The checksum is a minimum of 4 bytes and a maximum of 6 bytes, widening the expanded array so that
      // its length is divisible by 3.
      $checksumLength = 4 + (3 - (sizeof($contentBytes) + 2) % 3) % 3;
      $expandedLength = NyzoStringEncoder::HEADER_LENGTH + sizeof($contentBytes) + $checksumLength;

      // Create the array and add the header and the content. The first three bytes turn into the user-readable
      // prefix in the encoded string. The next byte specifies the length of the content array, and it is immediately
      // followed by the content array.
      $prefixBuffer = new Buffer(sizeof($prefixBytes) + 1);
      $i = 0;
      for(; $i < sizeof($prefixBytes); $i++) {
        $prefixBuffer[$i] = $prefixBytes[$i];
      }
      $prefixBuffer[$i++] = sizeof($contentBytes);
      $contentBuffer = Buffer::concat([$prefixBuffer, Buffer::from($contentBytes)]);
       
      // Compute the checksum and add the appropriate number of bytes to the end of the array.
      $checksum = $this->createChecksum($contentBuffer);
      $expandedBuffer = Buffer::concat([$contentBuffer, $checksum], $expandedLength);
      // Build and return the encoded string from the expanded array.
      return $this->encodedStringForByteArray($expandedBuffer);
    }

    /**
     * Decodes an encoded instance of a NyzoString type. If checksum failes,
     * or the string cannot be decoded, null will be returned.
     */
    public function decode(string $encodedString): ?NyzoString {
      $result = null;
      try {
        // Map characters from the old encoding to the new encoding. A few characters were changed to make Nyzo
        // strings more URL-friendly.
        $encodedString = str_replace("*", "-", $encodedString);
        $encodedString = str_replace("+", ".", $encodedString);
        $encodedString = str_replace("=", "~", $encodedString);
        // Map characters that may be mistyped. Nyzo strings contain neither 'l' nor 'O'.
        $encodedString = str_replace("l", "1", $encodedString);
        $encodedString = str_replace("O", "0", $encodedString);

        $type = substr($encodedString, 0, 4);
        if(array_key_exists($type, NyzoStringEncoder::NYZO_PREFIXES_BYTES)) {
          $expandedArray = $this->byteArrayForEncodedString($encodedString);
          // Get the content length from the next byte and calculate the checksum length.
          $contentLength = $expandedArray[3] & 0xff;
          $checksumLength = sizeof($expandedArray) - $contentLength - 4;
          // Only continue if the checksum length is valid.
          if($checksumLength >= 4 && $checksumLength <= 6) {
            // Calculate the checksum and compare it to the provided checksum.
            // Only create the result array if the checksums match.
            $contentBuffer = Buffer::from($expandedArray)->slice(0, NyzoStringEncoder::HEADER_LENGTH + $contentLength);
            $fullCalculatedChecksum = $this->createChecksum($contentBuffer);
            $calculatedChecksum = Buffer::from($fullCalculatedChecksum)->slice(0, $checksumLength);
            $providedChecksum = Buffer::from($expandedArray)->slice(sizeof($expandedArray) - $checksumLength, sizeof($expandedArray));
            if($providedChecksum->equals($calculatedChecksum)) {
              // Get the content array. This is the encoded object with the prefix, length byte, and checksum
              // removed.
              $contentBytes = Buffer::from($expandedArray)->slice(NyzoStringEncoder::HEADER_LENGTH, sizeof($expandedArray) - $checksumLength);
              // Make the object from the content array.
              switch($type) {
                case "pre_": 
                  $result = NyzoStringPrefilledData::fromByteBuffer($contentBytes);
                  break;
                case "key_":
                  $result = new NyzoStringPrivateSeed($contentBytes);
                  break;
                case "id__":
                  $result = new NyzoStringPublicIdentifier($contentBytes);
                  break;
                case "pay_":
                  $result = NyzoStringMicropay::fromByteBuffer($contentBytes); // TODO
                  break;
                case "tx__":
                  $result = NyzoStringTransaction::fromByteBuffer($contentBytes);
                  break;
              }
            }
          }
        }
      }
      catch(Exception $ignored) {
        
      }
      return $result;
    }

    /**
     * TODO: add documentation
     */
    public function byteArrayForEncodedString(string $encodedString): array {
      $arrayLength = (int) floor((strlen($encodedString) * 6 + 7) / 8);
      $array = new UInt8Array($arrayLength);
      for($i = 0; $i < $arrayLength; $i++) {
        $leftCharacter = $encodedString[intval($i * 8 / 6)];
        $rightCharacter = $encodedString[intval($i * 8 / 6 + 1)];
        $leftValue = $this->getOrDefault($leftCharacter, 0);
        $rightValue = $this->getOrDefault($rightCharacter, 0);
        $bitOffset = ($i * 2) % 6;
        $array[$i] = (((($leftValue << 6) + $rightValue) >> 4 - $bitOffset) & 0xff);
      }
      return $array->toArray();
    }

    /**
     * TODO: add documentation
     */
    public function encodedStringForByteArray(Buffer $buff): string {
      $index = 0;
      $bitOffset = 0;
      $encodedString = "";
      while($index < $buff->size()) {
        // Get the current and next byte
        $leftByte = $buff[$index] & 0xff;
        $rightByte = $index < sizeof($buff) - 1 ? $buff[$index + 1] & 0xff : 0;
        // Append the character for the next 6 bits in the array.
        $lookupIndex = ((($leftByte << 8) + $rightByte) >> (10 - $bitOffset)) & 0x3f;
        $encodedString .= NyzoStringEncoder::CHARACTER_LOOKUP[$lookupIndex];
        // Advance forward 6 bits
        if($bitOffset == 0) {
          $bitOffset = 6;
        }
        else {
          $index++;
          $bitOffset -= 2;
        }
      }
      return $encodedString;
    }

    /**
     * Helper utility to return a default value if the provided key does not
     * exist in the characterToValueMap
     */
    private function getOrDefault(string $key, int $value): int {
      if(array_key_exists($key, $this->characterToValueMap)) {
        return $this->characterToValueMap[$key];
      }
      return $value;
    }

    /**
     * Helper utility method for creating a checksum for encoding and decoding
     * a nyzo string using a double sha256 hash.
     * @param array $contentBuffer The buffer of bytes to create a checksum for.
     * @return array The hashed checkum byte array.
     */
    private function createChecksum(Buffer $contentBuffer): array {
      // Need to use pack to convert contentArray into a binary string
      // because hash function requires string input. Using C* will treat each item
      // in the binary string as as char (UInt8)
      $contentBufferBinaryStr = pack("C*", ...$contentBuffer);
      $hash1Raw = hash('sha256', $contentBufferBinaryStr, true);
      $checksumRaw = hash('sha256', $hash1Raw, true);
      // Need to use unpack to convert the binary string back into an array of char (UInt8).
      $checksum = unpack("C*", $checksumRaw);
      return $checksum;
    }
  }
?>
