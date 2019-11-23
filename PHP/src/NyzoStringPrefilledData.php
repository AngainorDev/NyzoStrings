<?php
 /**
   * ref: https://github.com/n-y-z-o/nyzoVerifier/blob/master/src/main/java/co/nyzo/verifier/nyzoString/NyzoStringPrefilledData.java
   * version: 0.0.2
   */
  require_once("NyzoString.php");
  require_once("NyzoStringType.php");
  require_once("utils/UInt8Array.php");
  require_once("utils/Buffer.php");

  final class NyzoStringPrefilledData implements NyzoString {
    
    private $receiverIdentifier;
    private $senderData;

    public function __construct(Buffer $receiverIdentifier, Buffer $senderData) {
      $senderData = $senderData->slice(0, 32);
      $this->receiverIdentifier = $receiverIdentifier;
      $this->senderData = $senderData;
    }

    public function getReceiverIdentifier(): Buffer {
      return $this->receiverIdentifier;
    }

    public function getSenderData(): Buffer {
      return $this->senderData;
    }

    /** override */
    public function getType(): NyzoStringType {
      return NyzoStringType::PrefilledData();
    }

    /** @override */
    public function getBytes(): array {
      $bytes = new UInt8Array(32 + 1 + $this->senderData->size());
      UInt8Array::fromBuffer($this->receiverIdentifier)->copy($bytes, 0);
      $bytes[32] = $this->senderData->size();
      UInt8Array::fromBuffer($this->senderData)->copy($bytes, 33);
      return $bytes->toArray();
    }

    public static function fromByteBuffer(Buffer $buffer): NyzoStringPrefilledData {
      $receiverBuffer = $buffer->slice(0, 32);
      $senderDataLength = min($buffer[32] & 0xff, 32);
      $dataBuffer = $buffer->slice(33, 33 + $senderDataLength);
      return new NyzoStringPrefilledData($receiverBuffer, $dataBuffer);
    }

    public static function fromHex(string $receiverHexString, string $dataHexString): NyzoStringPrefilledData {
      $filteredString = substr(implode("", explode("-", $receiverHexString)), 0, 64);
      $receiverArray = Buffer::fromHex($filteredString);
      $dataArray = Buffer::fromHex($dataHexString);
      return new NyzoStringPrefilledData($receiverArray, $dataArray);
    }
  }
?>
