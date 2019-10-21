<?php
  /**
   * ref: https://github.com/n-y-z-o/nyzoVerifier/blob/master/src/main/java/co/nyzo/verifier/nyzoString/NyzoStringMicropay.java
   * version: 0.0.2
   */
  require_once("NyzoString.php");
  require_once("NyzoStringType.php");
  require_once("utils/Buffer.php");
  require_once("utils/Int64.php");
  
  final class NyzoStringMicropay implements NyzoString {

    private $receiverIdentifier;
    private $senderData;
    private $amount;
    private $timestamp;
    private $previousHashHeight;
    private $previousBlockHash;

    public function __construct(Buffer $receiverIdentifier, Buffer $senderData, Int64 $amount, Int64 $timestamp,
    Int64 $previousHashHeight, Buffer $previousBlockHash) {
      $senderData = $senderData->slice(0, 32);
      $this->receiverIdentifier = $receiverIdentifier;
      $this->senderData = $senderData;
      $this->amount = $amount;
      $this->timestamp = $timestamp;
      $this->previousHashHeight = $previousHashHeight;
      $this->previousBlockHash = $previousBlockHash;
    }

    public function getReceiverIdentifier(): Buffer {
      return $this->receiverIdentifier;
    }

    public function getSenderData(): Buffer {
      return $this->senderData;
    }

    public function getAmount(): Int64 {
      return $this->amount;
    }

    public function getTimestamp(): Int64 {
      return $this->timestamp;
    }

    public function getPreviousHashHeight(): Int64 {
      return $this->previousHashHeight;
    }

    public function getPreviousBlockHash(): Buffer {
      return $this->previousBlockHash;
    }

    public function getType(): NyzoStringType {
      return NyzoStringType::Micropay();
    }
    public function getBytes(): array {
      $bytes = new Buffer(32 + 1 + $this->senderData->size() + 8 + 8 + 8 + 32);
      $this->receiverIdentifier->copy($bytes, 0);
      $senderDataLength = $this->senderData->size();
      $bytes[32] = $senderDataLength;
      $this->senderData->copy($bytes, 33);
      $this->amount->copy($bytes, 33 + $senderDataLength);
      $this->timestamp->copy($bytes, 33 + $senderDataLength + 8);
      $this->previousHashHeight->copy($bytes, 33 + $senderDataLength + 8 + 8);
      $this->previousBlockHash->copy($bytes, 33 + $senderDataLength + 8 + 8 + 8);
      return $bytes->toArray();
    }

    public static function fromByteBuffer(Buffer $buffer): NyzoStringMicropay {
      $receiverBuffer = $buffer->slice(0, 32);
      $senderDataLength = min($buffer[32] & 0xff, 32);
      $dataBuffer = $buffer->slice(33, 33 + $senderDataLength);
      $amount = new Int64($buffer->slice(33 + $senderDataLength, 33 + $senderDataLength + 8));
      $timestamp = new Int64($buffer->slice(33 + $senderDataLength + 8, 33 + $senderDataLength + 8 + 8));
      $previousHashHeight = new Int64($buffer->slice(33 + $senderDataLength + 8 + 8, 33 + $senderDataLength + 8 + 8 + 8));
      $previousBlockHashBuffer = $buffer->slice(33 + $senderDataLength + 8 + 8 + 8, 33 + $senderDataLength + 8 + 8 + 8 + 32);
      return new NyzoStringMicropay($receiverBuffer, $dataBuffer, $amount, $timestamp, $previousHashHeight, $previousBlockHashBuffer);
    }

    public static function fromHex(string $receiverHexString, string $dataHexString, string $amountHex, string $timestampHex, string $previousHashHeightHex, string $previousBlockHashBufferHex): NyzoStringMicropay {
      $filteredString = substr(implode("", explode("-", $receiverHexString)), 0, 64);
      $receiverBuffer = Buffer::fromHex($filteredString);
      $dataBuffer = Buffer::fromHex($dataHexString);
      $amount = new Int64(Buffer::fromHex($amountHex));
      $timestamp = new Int64(Buffer::fromHex($timestampHex));
      $previousHashHeight = new Int64(Buffer::fromHex($previousHashHeightHex));
      $filteredHash = substr(implode("", explode("-", $previousBlockHashBufferHex)), 0, 64);
      $previousBlockHashBuffer = Buffer::fromHex($filteredHash);
      return new NyzoStringMicropay($receiverBuffer, $dataBuffer, $amount, $timestamp, $previousHashHeight, $previousBlockHashBuffer);
    }
  }
?>
