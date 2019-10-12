<?php

  require_once("./NyzoString.php");  

  $version = "0.0.2";

  final class NyzoStringEncoder {
    
    const CHARACTER_LOOKUP = "0123456789" .
                             "abcdefghijkmnopqrstuvwxyz" .
                             "ABCDEFGHIJKLMNPQRSTUVWXYZ" .
                             "-.~_";
    
    // These were computed once by he test suite, then hardcoded here so NyzoStringType is not needed in real code.
    const NYZO_PREFIXES_BYTES = [
      "pre_" => [97, 163, 191],
      "key_" => [80, 232, 227],
      "id__" => [72, 223, 255],
      "pay_" => [96, 168, 127],
      "tx__" => [114, 15, 255]
    ];
  
    const HEADER_LENGTH = 4;
    private $characterToValueMap;

    public function __construct(){
      $this->characterToValueMap = [];

      for($i = 0; $i < strlen(NyzoStringEncoder::CHARACTER_LOOKUP); $i++) {
        $this->characterToValueMap[NyzoStringEncoder::CHARACTER_LOOKUP[$i]] = $i;
      }
      
    }

    public function encode(NyzoString $stringObject): string {
      // Get the prefix array from the type and the content array from the content object.
      $prefixBytes = NyzoStringEncoder::NYZO_PREFIXES_BYTES[$stringObject->getType()];
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
      $prefixBuffer = new SplFixedArray(sizeof($prefixBytes) + 1);
      $i = 0;
      for(; $i < sizeof($prefixBytes); $i++) {
        $prefixBuffer[$i] = $prefixBytes[$i];
      }
      $prefixBuffer[$i++] = sizeof($contentBytes);
      $contentBuffer = array_merge($prefixBuffer->toArray(), $contentBytes);
      
      
      // Compute the checksum and add the appropriate number of bytes to the end of the array.
      // Need to use pack to convert contentBuffer into a binary string
      // because hash function requires string input. Using C* will treat each item
      // in the binary string as as char (UInt8)
      $contentBufferBinaryStr = pack("C*", ...$contentBuffer);
      $hash1Raw = hash('sha256', $contentBufferBinaryStr, true);
      $checksumRaw = hash('sha256', $hash1Raw, true);
      // Need to use unpack to convert the binary string back into an array of char (UInt8).
      $checksum = unpack("C*", $checksumRaw);
      $expandedBuffer = array_slice(array_merge($contentBuffer, $checksum), 0, $expandedLength);
      // Build and return the encoded string from the expanded array.
      return $this->encodedStringForByteArray($expandedBuffer);
    }


    public function byteArrayForEncodedString(string $encodedString): array {
      $arrayLength = floor((strlen($encodedString) * 6 + 7) / 8);
      $array = new SplFixedArray($arrayLength);
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


    public function encodedStringForByteArray(array $array): string {
      $index = 0;
      $bitOffset = 0;
      $encodedString = "";
      while($index < sizeof($array)) {
        // Get the current and next byte
        $leftByte = $array[$index] & 0xff;
        $rightByte = $index < sizeof($array) - 1 ? $array[$index + 1] & 0xff : 0;
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

    private function getOrDefault(string $key, int $value): int {
      if(array_key_exists($key, $this->characterToValueMap)) {
        return $this->characterToValueMap[$key];
      }
      return $value;
    }
  }

?>