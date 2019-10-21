<?php
  declare(strict_types=1);

  use PHPUnit\Framework\TestCase;
  require_once("src/NyzoString.php");
  require_once("src/NyzoStringEncoder.php");
  require_once("src/NyzoStringPublicIdentifier.php");
  require_once("src/utils/Buffer.php");

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
      $identifier = Buffer::from([1, 2, 3]);
      $nyzoString = new NyzoStringPublicIdentifier($identifier);
      $encodedString = $this->encoder->encode($nyzoString);
      $this->assertNotNull($encodedString);
      // Encoded value taken from JavaScript implementation
      $this->assertEquals("id__0N420WQ76Kwr", $encodedString);
    }

    /** @test */
    public function canDecodeToNyzoStringFromString(): void {
      $encodedString = "id__0N420WQ76Kwr";
      $decoded = $this->encoder->decode($encodedString);
      $this->assertNotNull($decoded);
      $byteArray = [1, 2, 3];
      $this->assertEquals($byteArray, $decoded->getBytes());
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
    public function canCreateEncodedStringFromByteArray(): void {
      // Byte array value taken from JavaScript implementation
      $byteArray = Buffer::from([72, 223, 255, 3, 1, 2, 3, 140, 135, 26, 215, 218]);
      $encodedString = $this->encoder->encodedStringForByteArray($byteArray);
      $this->assertNotNull($encodedString);
      $this->assertIsString($encodedString);
      $expectedEncodedString = "id__0N420WQ76Kwr";
      $this->assertEquals(strlen($expectedEncodedString), strlen($encodedString));
      $this->assertEquals($expectedEncodedString, $encodedString);
    }
  }
?>

