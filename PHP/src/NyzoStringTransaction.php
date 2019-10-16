<?php
  /**
   * ref: https://github.com/n-y-z-o/nyzoVerifier/blob/master/src/main/java/co/nyzo/verifier/nyzoString/NyzoStringTransaction.java
   * version: 0.0.1
   */
  require_once("NyzoString.php");
  require_once("utils/arrays.php");

  class NyzoStringTransaction extends NyzoString {
    private $timestamp;
    private $amount;
    private $receiverIdentifier;
    private $previousHashHeight;
    private $previousBlockHash;
    private $senderIdentifier;
    private $senderData;
    private $signature;

    public function __construct(array $timestamp, array $amount, array $receiverIdentifier, array $previousHashHeight, ?array $previousBlockHash, array $senderIdentifier, array $senderData, array $signature) {
      $senderData = array_slice($senderData, 0, 32);
      $senderDataLength = sizeof($senderData);
      $bytes = new UInt8Array(1 + 8 + 8 + 32 + 8 + 32 + 1 + $senderDataLength + 64);
      $bytes[0] = 2; // typeStandard
      UInt8Array::fromArray($timestamp)->copy($bytes, 1);
      UInt8Array::fromArray($amount)->copy($bytes, 1 + 8);
      UInt8Array::fromArray($receiverIdentifier)->copy($bytes, 1 + 8 + 8);
      UInt8Array::fromArray($previousHashHeight)->copy($bytes, 1 + 8 + 8 + 32);
      UInt8Array::fromArray($senderIdentifier)->copy($bytes, 1 + 8 + 8 + 32 + 8);
      $bytes[1 + 8 + 8 + 32 + 8 + 32] = $senderDataLength;
      UInt8Array::fromArray($senderData)->copy($bytes, 1 + 8 + 8 + 32 + 8 + 32 + 1);
      UInt8Array::fromArray($signature)->copy($bytes, 1 + 8 + 8 + 32 + 8 + 32 + 1 + $senderDataLength);
      parent::__construct("tx__", $bytes->toArray());
      $this->timestamp = $timestamp;
      $this->amount = $amount;
      $this->receiverIdentifier = $receiverIdentifier;
      $this->previousHashHeight = $previousHashHeight;
      $this->previousBlockHash = $previousBlockHash;
      $this->senderIdentifier = $senderIdentifier;
      $this->senderData = $senderData;
      $this->signature = $signature;
    }

    public function getTimestamp() {
      return $this->timestamp;
    }

    public function getAmount() {
      return $this->amount;
    }

    public function getReceiverIdentifier() {
      return $this->receiverIdentifier;
    }

    public function getPreviousHashHeight() {
      return $this->previousHashHeight;
    }

    public function getPreviousBlockHash() {
      return $this->previousBlockHash;
    }

    public function getSenderIdentifier() {
      return $this->senderIdentifier;
    }

    public function getSenderData() {
      return $this->senderData;
    }
    
    public function getSignature() {
      return $this->signature;
    }

    public static function fromByteBuffer(array $buffer): NyzoStringTransaction {
      $index = 0;
      $type = array_slice($buffer, $index, $index + 1);
      $index += 1;
      $timestamp = UInt8Array::fromBinStr(pack("L*", array_slice($buffer, $index, $index + 8)))->toArray();
      $index += 8;
      $amount = UInt8Array::fromBinStr(pack("L*", array_slice($buffer, $index, $index + 8)))->toArray();
      $index += 8;
      $receiverBuffer = array_slice($buffer, $index, $index + 32);
      $index += 32;
      $previousHashHeight = UInt8Array::fromBinStr(pack("L*", array_slice($buffer, $index, $index + 8)))->toArray();
      $index += 8;
      $previousBlockHash = null;
      $senderBuffer = array_slice($buffer, $index, $index + 32);
      $index += 32;
      $senderDataLength = min($buffer[$index] & 0xff, 32);
      $index += 1;
      $dataBuffer = array_slice($buffer, $index, $index + $senderDataLength);
      $index += $senderDataLength;
      $signatureBuffer = array_slice($buffer, $index, $index + 64);

      return new NyzoStringTransaction($timestamp, $amount, $receiverBuffer, $previousHashHeight, $previousBlockHash, $senderBuffer, $dataBuffer, $signatureBuffer);
    }

    public static function fromHex(string $timestampHex, string $amountHex, string $receiverHex, string $previousHashHeightHex, string $previousBlockHashHex, string $senderHex, string $dataHex, string $signatureHex): NyzoStringTransaction {
      $timestamp = UInt8Array::fromHex($timestampHex)->toArray();
      $amount = UInt8Array::fromHex($amountHex)->toArray();
      $filteredString = substr(implode("", explode("-", $receiverHex)), 0, 64);
      $receiverBuffer = UInt8Array::fromHex($filteredString)->toArray();
      $previousHashHeight = UInt8Array::fromHex($previousHashHeightHex)->toArray();
      $filteredHash = substr(implode("", explode("-", $previousBlockHashHex)), 0, 64);
      $previousBlockHashBuffer = UInt8Array::fromHex($filteredHash)->toArray();
      $filteredSender = substr(implode("", explode("-", $senderHex)), 0, 64);
      $senderBuffer = UInt8Array::fromHex($filteredSender)->toArray();
      $dataBuffer = UInt8Array::fromHex($dataHex)->toArray();
      $signatureBuffer = UInt8Array::fromHex($signatureHex)->toArray();
      return new NyzoStringTransaction($timestamp, $amount, $receiverBuffer, $previousHashHeight, $previousBlockHashBuffer, $senderBuffer, $dataBuffer, $signatureBuffer);
    }
  }

?>