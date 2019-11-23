<?php

  require_once("Buffer.php");
  require_once("UInt8Array.php");
  require_once("AbstractArray.php");

  final class Int64 {

    private $buff;
    public function __construct(AbstractArray $array) {
      $this->buff = new UInt8Array(8);
      $array->copy($this->buff, $this->buff->size()-$array->size(), 0, 9);
    }

    public static function fromArray(array $array) {
      return new Int64(Buffer::from($array));
    }

    public static function fromInt(int $int) {
      return new Int64(UInt8Array::fromInt($int));
    }
  
    public function copy(ArrayObject &$targetBuffer, int $targetOffset): int {
      return $this->buff->copy($targetBuffer, $targetOffset);
    }

    public function toUInt8Array(): UInt8Array {
      $out = new UInt8Array(8);
      array_copy((array) $this->buff, $out);
      return $out;
    }

    public function toInt(): int {
      $num = 0;
      for ($i = 7, $m = 1; $i >= 0; $i--, $m *= 256) {
        $v = $this->buff[$i];  
        $num += $v * $m;
      }
      return $num;
    }

    public function toHex(): string {
      $binstr = implode("", array_map(function($dec) {
        return dechex($dec);
      }, $this->buff->toArray()));
      return $binstr;
    }
  }
?>
