<?php
  require_once("AbstractArray.php");
  require_once("Buffer.php");

  final class UInt8Array extends AbstractArray {

    public function __construct(int $size) {
      parent::__construct(array_fill(0, $size, 0));
    }

    public static function fromBuffer(Buffer $buff): UInt8Array {
      $u8a = new UInt8Array($buff->size());
      for($i = 0; $i < $u8a->size(); $i++) {
        $u8a[$i] = $buff[$i];
      }
      return $u8a;
    }

    public static function fromArray(array $array): UInt8Array {
      $array = array_merge($array);
      $u8a = new UInt8Array(sizeof($array));
      for($i = 0; $i < $u8a->size(); $i++) {
        $u8a[$i] = $array[$i];
      }
      return $u8a;
    }

    public static function fromBinStr(string $bin): UInt8Array {
      $array = unpack("C*", $bin);
      return UInt8Array::fromArray($array);
    }

    public static function fromHex(string $hex): UInt8Array {
      $binArr = unpack("C*", hex2bin($hex));
      return UInt8Array::fromArray($binArr);
    }

    public static function fromInt(int $int): UInt8Array {
      $bin = decbin($int);
      if(strlen($bin)%8 > 0) {
        $bin = str_pad($bin, strlen($bin) + 8-(strlen($bin)%8), "0", STR_PAD_LEFT);
      }
      $decArray = array_map(function($binstr) {
        return bindec($binstr);
      }, str_split($bin, 8));
      return UInt8Array::fromArray($decArray);
    }
  }
?>
