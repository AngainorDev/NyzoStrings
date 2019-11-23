<?php
  declare(strict_types=1);

  use PHPUnit\Framework\TestCase;
  require_once("src/NyzoStringType.php");

  final class NyzoStringTypeTest extends TestCase {

    public function setUp(): void {

    }

    /** @test */
    public function canGetStaticNyzoStringMicropayType(): void {
      $type = NyzoStringType::Micropay();
      $this->assertNotNull($type);
      $this->assertInstanceOf(NyzoStringType::class, $type);
      $this->assertEquals("pay_", $type->value());
    }

    /** @test */
    public function canGetStaticNyzoStringPrefilledDataType(): void {
      $type = NyzoStringType::PrefilledData();
      $this->assertNotNull($type);
      $this->assertInstanceOf(NyzoStringType::class, $type);
      $this->assertEquals("pre_", $type->value());
    }

    /** @test */
    public function canGetStaticNyzoStringPrivateSeedType(): void {
      $type = NyzoStringType::PrivateSeed();
      $this->assertNotNull($type);
      $this->assertInstanceOf(NyzoStringType::class, $type);
      $this->assertEquals("key_", $type->value());
    }

    /** @test */
    public function canGetStaticNyzoStringPublicIdentifierType(): void {
      $type = NyzoStringType::PublicIdentifier();
      $this->assertNotNull($type);
      $this->assertInstanceOf(NyzoStringType::class, $type);
      $this->assertEquals("id__", $type->value());
    }

    /** @test */
    public function canGetStaticNyzoStringTransactionType(): void {
      $type = NyzoStringType::Transaction();
      $this->assertNotNull($type);
      $this->assertInstanceOf(NyzoStringType::class, $type);
      $this->assertEquals("tx__", $type->value());
    }
  }
?>
