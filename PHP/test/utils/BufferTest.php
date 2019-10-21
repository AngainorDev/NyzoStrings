<?php
  declare(strict_types=1);

  use PHPUnit\Framework\TestCase;
  require_once("src/utils/Buffer.php");

  final class BufferTest extends TestCase {

    public function setUp(): void {
      
    }

    /** @test */
    public function canCreateNewBuffer(): void {
      $buff = new Buffer(10);
      $this->assertNotNull($buff);
      $this->assertInstanceOf(Buffer::class, $buff);
    }

    /** @test */
    public function canCreateBufferForSize(): void {
      $buff10 = new Buffer(10);
      $this->assertEquals(10, $buff10->size());
      $buff1024 = new Buffer(1024);
      $this->assertEquals(1024, $buff1024->size());
    }

     /** @test */
     public function canCreateFromArray(): void {
      $buff = Buffer::from([1,2,3,4,5]);
      $this->assertEquals([1,2,3,4,5], $buff->toArray());
    }

    /** @test */
    public function canCreateFromHex(): void {
      $buff = Buffer::fromHex("9bdecd1085b8f5e1");
      $this->assertEquals([155, 222, 205, 16, 133, 184, 245, 225], $buff->toArray());
    }

    /** @test */
    public function canConcatMultipleBuffers(): void {
      $buff1 = Buffer::from([1,2,3]);
      $buff2 = Buffer::from([4,5,6]);
      $buffConcat = Buffer::concat([$buff1, $buff2]);

      $expectedSize = $buff1->size() + $buff2->size();
      $expectedArray = [1,2,3,4,5,6];
      $this->assertNotNull($buffConcat);
      $this->assertEquals($expectedSize, $buffConcat->size());
      $this->assertEquals($expectedArray, $buffConcat->toArray());
    }

    /** @test */
    public function canConcatMultipleBuffersWithLength(): void {
      $buff1 = Buffer::from([1,2,3]);
      $buff2 = Buffer::from([4,5,6]);
      $expectedSize = 4;
      $expectedArray = [1,2,3,4];
      $buffConcat = Buffer::concat([$buff1, $buff2], $expectedSize);
      $this->assertNotNull($buffConcat);
      $this->assertEquals($expectedSize, $buffConcat->size());
      $this->assertEquals($expectedArray, $buffConcat->toArray());
    }

    /** @test */
    public function canCreateSliceFromBuffer(): void {
      $buff = Buffer::from([1,2,3,4,5,6,7,8,9,0]);
      $buffSliced = $buff->slice(2,7);

      $expectedSize = 5;
      $expectedArray = [3,4,5,6,7];
      $this->assertNotNull($buffSliced);
      $this->assertEquals($expectedSize, $buffSliced->size());
      $this->assertEquals($expectedArray, $buffSliced->toArray());
    }

    /** @test */
    public function canPerformComparisonUsingEquals(): void {
      $original = Buffer::from([1,2,3]);
      $expectedEqual = Buffer::from([1,2,3]);
      $expectedUnequal = Buffer::from([4,5,6]);

      $this->assertTrue($original->equals($expectedEqual));
      $this->assertFalse($original->equals($expectedUnequal));
    }
  }
?>
