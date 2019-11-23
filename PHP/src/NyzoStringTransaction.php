<?php
  /**
   * ref: https://github.com/n-y-z-o/nyzoVerifier/blob/master/src/main/java/co/nyzo/verifier/nyzoString/NyzoStringTransaction.java
   * version: 0.0.2
   */
  require_once("NyzoString.php");
  require_once("NyzoStringType.php");
  require_once("utils/Buffer.php");
  require_once("utils/Int64.php");

  class NyzoStringTransaction implements NyzoString {

    private $timestamp;
    private $amount;
    private $receiverIdentifier;
    private $previousHashHeight;
    private $previousBlockHash;
    private $senderIdentifier;
    private $senderData;
    private $signature;

    public function __construct(Int64 $timestamp, Int64 $amount, Buffer $receiverIdentifier, Int64 $previousHashHeight, Buffer $previousBlockHash=null, Buffer $senderIdentifier, Buffer $senderData, Buffer $signature) {
      $senderData = $senderData->slice(0, 32);
      $this->timestamp = $timestamp;
      $this->amount = $amount;
      $this->receiverIdentifier = $receiverIdentifier;
      $this->previousHashHeight = $previousHashHeight;
      $this->previousBlockHash = $previousBlockHash;
      $this->senderIdentifier = $senderIdentifier;
      $this->senderData = $senderData;
      $this->signature = $signature;
    }

    public function getTimestamp(): Int64 {
      return $this->timestamp;
    }

    public function getAmount(): Int64 {
      return $this->amount;
    }

    public function getReceiverIdentifier(): Buffer {
      return $this->receiverIdentifier;
    }

    public function getPreviousHashHeight(): Int64 {
      return $this->previousHashHeight;
    }

    public function getPreviousBlockHash(): Buffer {
      return $this->previousBlockHash;
    }

    public function getSenderIdentifier(): Buffer {
      return $this->senderIdentifier;
    }

    public function getSenderData(): Buffer {
      return $this->senderData;
    }
    
    public function getSignature(): Buffer {
      return $this->signature;
    }

    /** @override */
    public function getType(): NyzoStringType {
      return NyzoStringType::Transaction();
    }

    /** @override */
    public function getBytes(): array {
      $senderDataLength = sizeof($this->senderData);
      $bytes = new Buffer(1 + 8 + 8 + 32 + 8 + 32 + 1 + $senderDataLength + 64);
      $bytes[0] = 2; // typeStandard
      $this->timestamp->copy($bytes, 1);
      $this->amount->copy($bytes, 1 + 8);
      $this->receiverIdentifier->copy($bytes, 1 + 8 + 8);
      $this->previousHashHeight->copy($bytes, 1 + 8 + 8 + 32);
      $this->senderIdentifier->copy($bytes, 1 + 8 + 8 + 32 + 8);
      $bytes[1 + 8 + 8 + 32 + 8 + 32] = $senderDataLength;
      $this->senderData->copy($bytes, 1 + 8 + 8 + 32 + 8 + 32 + 1);
      $this->signature->copy($bytes, 1 + 8 + 8 + 32 + 8 + 32 + 1 + $senderDataLength);
      return $bytes->toArray();
    }

    public static function fromByteBuffer(Buffer $buffer): NyzoStringTransaction {
      $index = 0;
      $type = $buffer->slice($index, $index + 1); // Ignored - only supports type 2, standard transaction
      $index += 1;
      $timestamp = new Int64($buffer->slice($index, $index + 8));
      $index += 8;
      $amount = new Int64($buffer->slice($index, $index + 8));
      $index += 8;
      $receiverBuffer = $buffer->slice($index, $index + 32);
      $index += 32;
      $previousHashHeight = new Int64($buffer->slice($index, $index + 8));
      $index += 8;
      $previousBlockHash = null;
      $senderBuffer = $buffer->slice($index, $index + 32);
      $index += 32;
      $senderDataLength = min($buffer[$index] & 0xff, 32);
      $index += 1;
      $dataBuffer = $buffer->slice($index, $index + $senderDataLength);
      $index += $senderDataLength;
      $signatureBuffer = $buffer->slice($index, $index + 64);

      return new NyzoStringTransaction($timestamp, $amount, $receiverBuffer, $previousHashHeight, $previousBlockHash, $senderBuffer, $dataBuffer, $signatureBuffer);
    }

    public static function fromHex(string $timestampHex, string $amountHex, string $receiverHex, string $previousHashHeightHex, string $previousBlockHashHex, string $senderHex, string $dataHex, string $signatureHex): NyzoStringTransaction {
      $timestamp = new Int64(Buffer::fromHex($timestampHex));
      $amount = new Int64(Buffer::fromHex($amountHex));
      $filteredString = substr(implode("", explode("-", $receiverHex)), 0, 64);
      $receiverBuffer = Buffer::fromHex($filteredString);
      $previousHashHeight = new Int64(Buffer::fromHex($previousHashHeightHex));
      $filteredHash = substr(implode("", explode("-", $previousBlockHashHex)), 0, 64);
      $previousBlockHashBuffer = Buffer::fromHex($filteredHash);
      $filteredSender = substr(implode("", explode("-", $senderHex)), 0, 64);
      $senderBuffer = Buffer::fromHex($filteredSender);
      $dataBuffer = Buffer::fromHex($dataHex);
      $signatureBuffer = Buffer::fromHex($signatureHex);
      return new NyzoStringTransaction($timestamp, $amount, $receiverBuffer, $previousHashHeight, $previousBlockHashBuffer, $senderBuffer, $dataBuffer, $signatureBuffer);
    }
  }

?>