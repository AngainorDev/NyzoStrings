<?php

  require_once("AbstractArray.php");

  class Buffer extends AbstractArray {

    public function __construct(int $size) {
      parent::__construct(array_fill(0, $size, null));
    }

    /**
     * Constructs a new Buffer from the items found in the provided array.
     */
    public static function from(array $array): Buffer {
      // reindex everyting to 0 based array
      $array = array_merge($array);
      $newBuff = new Buffer(sizeof($array));
      for($i=0; $i<$newBuff->size(); $i++) {
        $newBuff[$i] = $array[$i];
      }
      return $newBuff;
    }

    /**
     * Creates a new Buffer using the hex value provided, making
     * the assumption that every 2 characters from the hex
     * values represents an integer number in the range of 0-255.
     */
    public static function fromHex(string $hex): Buffer {
      $arr = unpack("C*", hex2bin($hex));
      return Buffer::from($arr);
    }

    /**
     * @param list An array of array-like objects or objects which extend
     * AbstractArray.
     * @param length Total length of the buffers when concatenated. If length is not provided,
     * it is read from the buffers in the list. However, this adds an additional loop to the function,
     * so it is faster to provide the length explicitly.
     */
    public static function concat(array $list, ?int $length=null): Buffer {
      for($i = 0; $i<sizeof($list); $i++) {
        $items[$i] = array_merge((array) $list[$i]);
      }
      if($length == null) {
        $length = 0;
        foreach($items as $arr) {
          $length += sizeof($arr);
        }
      }
      $merged = array_merge(...$items);
      if(sizeof($merged) === $length) {
        return Buffer::from($merged);
      }
      else {
        $buff = new Buffer($length);
        for($i=0; $i<$buff->size(); $i++) {
          $buff[$i] = $merged[$i];
        }
        return $buff;
      }
    }
  }
?>
