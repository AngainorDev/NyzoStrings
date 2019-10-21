<?php
  declare(strict_types=1);

  use PHPUnit\Framework\TestCase;
  require_once("src/utils/Int64.php");
  require_once("src/utils/Buffer.php");
  require_once("src/utils/UInt8Array.php");

  final class Int64Test extends TestCase {

    public function setUp(): void {
      
    }

    /** @test */
    public function canCreateFromInt(): void {
      $time = 1571455558398;
      $int = Int64::fromInt($time);
      $this->assertNotNull($int);
      $this->assertEquals([0,0,1,109,226,12,226,254], $int->toUInt8Array()->toArray());
    }

    /** @test */
    public function canCreateFromBuffer(): void {
      $buff = Buffer::from([0,1,2,3,4,5,6,7]);
      $int = new Int64($buff);
      $this->assertNotNull($int);
      $this->assertEquals([0,1,2,3,4,5,6,7], $int->toUInt8Array()->toArray());
    }

     /** @test */
    public function canGetValueInUInt8Array(): void {
      $u8a = UInt8Array::fromArray([0,1,2,3,4,5,6,7]);
      $int = new Int64($u8a);
      $this->assertNotNull($int);
      $this->assertEquals([0,1,2,3,4,5,6,7], $int->toUInt8Array()->toArray());
    }

    /** @test */
    public function canGetIntValueFromArray(): void {
      $u8aFromInt = UInt8Array::fromInt(256);
      $int = new Int64($u8aFromInt);
      $this->assertEquals(256, $int->toInt());

      $u8aFromArray = UInt8Array::fromArray([0,0,0,0,0,0,1,0]);
      $int = new Int64($u8aFromArray);
      $this->assertEquals(256, $int->toInt());

      $u8aHex = UInt8Array::fromInt(0x0100);
      $int = new Int64($u8aHex);
      $this->assertEquals(256, $int->toInt());

      $u8aHexStr = UInt8Array::fromHex("0100");
      $int = new Int64($u8aHexStr);
      $this->assertEquals(256, $int->toInt());
    }

    /** @test */
    public function canGetIntValueFromInt(): void {
      $int = Int64::fromInt(512);
      $this->assertEquals(512, $int->toInt());

      $int = Int64::fromInt(PHP_INT_MAX);
      $this->assertEquals(PHP_INT_MAX, $int->toInt());
    }
  }
?>
