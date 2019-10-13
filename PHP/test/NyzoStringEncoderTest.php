<?php
  declare(strict_types=1);

  use PHPUnit\Framework\TestCase;
  require_once("src/NyzoString.php");
  require_once("src/NyzoStringEncoder.php");

  final class NyzoStringEncoderTest extends TestCase {
    
    private $encoder;

    public function setUp(): void {
      $this->encoder = new NyzoStringEncoder();
    }

    /** @test */
    public function canConstructNyzoStringEncoder(): void {
      $this->assertInstanceOf(NyzoStringEncoder::class, $this->encoder);
    }

    /** @test */
    public function canEncodeToStringFromNyzoString(): void {
      $nyzoString = new NyzoString("id__", [1, 2, 3]);
      $encodedString = $this->encoder->encode($nyzoString);
      $this->assertNotNull($encodedString);
      // Encoded value taken from JavaScript implementation
      $this->assertEquals("id__0N420WQ76Kwr", $encodedString);
    }

    /** @test */
    public function canCreateByteArrayFromEncodedString(): void {
      $encodedString = "id__0N420WQ76Kwr";
      $byteArray = $this->encoder->byteArrayForEncodedString($encodedString);
      $this->assertNotNull($byteArray);
      $this->assertIsArray($byteArray);
      // Byte array value taken from JavaScript implementation
      $this->assertEquals(12, sizeof($byteArray));
      $this->assertEquals([72, 223, 255, 3, 1, 2, 3, 140, 135, 26, 215, 218], $byteArray);
    }

    /** @test */
    public function canCreateEncodedStringForByteArray(): void {
      // Byte array value taken from JavaScript implementation
      $byteArray = [72, 223, 255, 3, 1, 2, 3, 140, 135, 26, 215, 218];
      $encodedString = $this->encoder->encodedStringForByteArray($byteArray);
      $this->assertNotNull($encodedString);
      $this->assertIsString($encodedString);
      $this->assertEquals("id__0N420WQ76Kwr", $encodedString);
    }

  }

?>