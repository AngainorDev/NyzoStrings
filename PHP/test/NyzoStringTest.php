<?php
  declare(strict_types=1);

  use PHPUnit\Framework\TestCase;
  require_once("src/NyzoString.php");

  final class NyzoStringTest extends TestCase {
    
    /** @test */
    public function canConstructNyzoString(): void {
      $this->assertInstanceOf(NyzoString::class, new NyzoString("id__", [1, 2, 3]));
    }

    /** @test */
    public function canGetTypeFromInstance(): void {
      $type = "id__";
      $bytes = [1, 2, 3];
      $nyzoString = new NyzoString($type, $bytes);
      $this->assertNotNull($nyzoString);
      $this->assertEquals($type, $nyzoString->getType());
    }

    /** @test */
    public function canGetBytesFromInstance(): void {
      $type = "id__";
      $bytes = [1, 2, 3];
      $nyzoString = new NyzoString($type, $bytes);
      $this->assertNotNull($nyzoString);
      $this->assertEquals($bytes, $nyzoString->getBytes());
    }
  }

?>