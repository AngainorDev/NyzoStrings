<?php

  class AbstractArray extends ArrayObject {

    public function __construct(array $array) {
      for($i=0; $i<sizeof($array); $i++) {
        $this[$i] = $array[$i];
      }
    }

    /**
     * Returns a subsection of the items in the array, from the start index,
     * up to, but not including, the end index.
     */
    public function slice(int $start, int $end): Buffer {
      $sliceStart = $start;
      $sliceLength = $end - $start;
      $array = array_slice($this->toArray(), $sliceStart, $sliceLength);
      return Buffer::from($array);
    }

    /**
     * Copies data from a region of this array into a region in $target even if the $target memory region overlaps with this array.
     * @param array $target An array to copy into
     * @param int $targetStart The offset within $target at which to begin writing. Default: 0.
     * @param int $sourceStart The offset within the source array from which to begin copying. Default: 0.
     * @param int $sourceEnd The offset within the source array at which to stop copying (not inclusive). Default: source length.
     * @return int The number of bytes copied.
     */
    public function copy(ArrayObject &$target, int $targetStart=null, int $sourceStart=null, int $sourceEnd=null): int {
      return array_copy($this->toArray(), $target, $targetStart, $sourceStart, $sourceEnd);
    }

    /**
     * Returns the number of allocated elements found in the array.
     */
    public function size(): int {
      return sizeof($this);
    }

    /**
     * Determines if the provided array is considered to equivalent to the source array.
     * Both arrays must have the same size, and each item is then compared using default php
     * equality checking of arrays (includes keys and values).
     * @param AbstractArray another instance of an array
     */
    public function equals(AbstractArray $other): bool {
      if($this->size() === $other->size()) {
        return $this->toArray() === $other->toArray();
      }
      return false;
    }

    /**
     * Retuns a copy of all elements in this array object
     * as a default primitive array type.
     */
    public function toArray(): array {
      $array = [];
      for($i=0; $i<sizeof($this); $i++) {
        $array[$i] = $this[$i];
      }
      return $array;
    }
  }

  /**
   * Copies data from a region of $source to a region in $target even if the $target memory region overlaps with $source.
   * @param array $source The source array to copy from
   * @param array $target An array to copy into
   * @param int $targetStart The offset within $target at which to begin writing. Default: 0.
   * @param int $sourceStart The offset within $source from which to begin copying. Default: 0.
   * @param int $sourceEnd The offset within $source at which to stop copying (not inclusive). Default: $source.length.
   * @return int The number of bytes copied.
   */
  function array_copy(array $source, ArrayObject &$target, int $targetStart=null, int $sourceStart=null, int $sourceEnd=null): int {
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
    if ($nb > $targetLen) $nb = $targetLen;
    if ($nb > $sourceLen) $nb = $sourceLen;

    for($i = 0; $i < $nb; $i++) {
      $target[$i + $targetStart] = $source[$i + $sourceStart];
    }

    return $nb;
  }

?>