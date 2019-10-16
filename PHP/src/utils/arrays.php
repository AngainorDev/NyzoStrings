<?php

  /**
   * Copies data from a region of $source to a region in $target even if the $target memory region overlaps with $source.
   * @param array $source The source array to copy from
   * @param array $target An array to copy into
   * @param int $targetStart The offset within $target at which to begin writing. Default: 0.
   * @param int $sourceStart The offset within $source from which to begin copying. Default: 0.
   * @param int $sourceEnd The offset within $source at which to stop copying (not inclusive). Default: $source.length.
   * @return int The number of bytes copied.
   */
  function array_copy(array $source, &$target, int $targetStart=null, int $sourceStart=null, int $sourceEnd=null): int {
    // if (!is_array($source))
    //   throw new Exception("source is not an array");
    // if (!is_array($target))
    //   throw new Exception("target is not an array");

    if ($targetStart === null) {
      $targetStart = 0;
    } else {
      $targetStart = intval($targetStart);
      if ($targetStart < 0)
        throw new Exception("targetStart must be >= 0");
    }

    if ($sourceStart === null) {
      $sourceStart = 0;
    } else {
      $sourceStart = intval($sourceStart);
      if ($sourceStart < 0)
        throw new Exception("sourceStart must be >= 0");
    }

    if ($sourceEnd === null) {
      $sourceEnd = sizeof($source);
    } else {
      $sourceEnd = intval($sourceEnd);
      if ($sourceEnd < 0)
        throw new Exception("sourceEnd must be >= 0");
    }

    if ($targetStart >= sizeof($target) || $sourceStart >= $sourceEnd)
      return 0;

    if ($sourceStart > sizeof($source)) {
      throw new Exception("sourceStart must be <= " . sizeof($source));
    }

    if ($sourceEnd - $sourceStart > sizeof($target) - $targetStart)
      $sourceEnd = $sourceStart + sizeof($target) - $targetStart;

    $nb = $sourceEnd - $sourceStart;
    $targetLen = sizeof($target) - $targetStart;
    $sourceLen = sizeof($source) - $sourceStart;
    if ($nb > $targetLen)
      $nb = $targetLen;
    if ($nb > $sourceLen)
      $nb = $sourceLen;

    // if ($sourceStart !== 0 || $sourceEnd !== sizeof($source))
    //   $source = new Uint8Array(source.buffer, source.byteOffset + sourceStart, nb);

    // target.set(source, targetStart);

    for($i = 0; $i < $nb; $i++) {
      $target[$i + $targetStart] = $source[$i + $sourceStart];
    }

    return $nb;
  }

  class UInt8Array extends ArrayObject {
    public function __construct(int $size) {
      parent::__construct(array_fill(0, $size, null));
    }


    public function toArray(): array {
      $array = [];
      for($i = 0; $i < sizeof($this); $i++) {
        $array[$i] = $this[$i];
      }
      return $array;
    }

    public function size(): int {
      return sizeof($this);
    }

    public function copy(UInt8Array &$target, int $targetStart=null, int $sourceStart=null, int $sourceEnd=null): int {
      return array_copy($this->toArray(), $target, $targetStart, $sourceStart, $sourceEnd);
    }

    public static function fromArray(array $array): UInt8Array {
      $uint = array_merge(unpack("C*", pack("C*", ...$array)));
      $u8a = new UInt8Array(sizeof($uint));
      for($i = 0; $i < $u8a->size(); $i++) {
        $u8a[$i] = $uint[$i];
      }
      return $u8a;
    }

    public static function fromBinStr(string $bin): UInt8Array {
      $array = array_merge(unpack("C*", $bin));
      return UInt8Array::fromArray($array);
    }

    public static function fromInt(int $int): UInt8Array {
      return UInt8Array::fromBinStr(decbin($int));
    }

    public static function fromHex(string $hex): UInt8Array {
      return UInt8Array::fromBinStr(hex2bin($hex));
    }
  }

?>