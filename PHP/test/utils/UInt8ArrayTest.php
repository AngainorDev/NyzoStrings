<?php
  declare(strict_types=1);

  use PHPUnit\Framework\TestCase;
  require_once("src/utils/UInt8Array.php");

  final class UInt8ArrayTest extends TestCase {

    /** @test */
    public function arrayCopyTest(): void {
      $arraySrc = [3,4,5];
      $arrayTarget = UInt8Array::fromArray([1,2,0,0,0,6,7]);
      $num = array_copy($arraySrc, $arrayTarget, 2);
      $this->assertEquals(3, $num);
      $this->assertEquals([1,2,3,4,5,6,7], $arrayTarget->toArray());
    }

    /** @test */
    public function canCreateFromArray(): void {
      $u8a = UInt8Array::fromArray([1,2,3,4,5]);
      $this->assertEquals([1,2,3,4,5], $u8a->toArray());
    }

    /** @test */
    public function canCreateFromHex(): void {
      $u8a = UInt8Array::fromHex("9bdecd1085b8f5e1");
      $this->assertEquals([155, 222, 205, 16, 133, 184, 245, 225], $u8a->toArray());
    }

    /** @test */
    public function canCreateFromInt(): void {
      $u8a = UInt8Array::fromInt(2);
      $this->assertEquals([2], $u8a->toArray());
    }

    /** @test */
    public function canCreateFromBinaryString(): void {
      $u8a = UInt8Array::fromBinStr("\x9b\xde");
      $this->assertEquals([155, 222], $u8a->toArray());
    }
  }
?>
