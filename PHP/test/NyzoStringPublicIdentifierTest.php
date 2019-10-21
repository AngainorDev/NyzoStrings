<?php
  declare(strict_types=1);

  use PHPUnit\Framework\TestCase;
  require_once("src/NyzoStringPublicIdentifier.php");
  require_once("src/NyzoStringEncoder.php");
  require_once("src/utils/Buffer.php");

  final class NyzoStringPublicIdentifierTest extends TestCase {

    private $encoder;

    private $nyzoStringPublicIdentifier;

    private $constructorValues = [];

    public function setUp(): void {
      $this->encoder = new NyzoStringEncoder();
      $identifier = $this->constructorValues["identifier"] = Buffer::from([1, 2, 3]);
      $this->nyzoStringPublicIdentifier = new NyzoStringPublicIdentifier($identifier);
    }

    /** @test */
    public function canConstructNyzoStringPublicIdentifier(): void {
      $this->assertNotNull($this->nyzoStringPublicIdentifier);
      $this->assertInstanceOf(NyzoStringPublicIdentifier::class, $this->nyzoStringPublicIdentifier);
    }

    /** @test */
    public function canGetIdentifier(): void {
      $this->assertNotNull($this->nyzoStringPublicIdentifier->getIdentifier());
      $this->assertEquals($this->constructorValues["identifier"], $this->nyzoStringPublicIdentifier->getIdentifier());
    }

    /** @test */
    public function canGetType(): void {
      $this->assertNotNull($this->nyzoStringPublicIdentifier->getType());
      $this->assertInstanceOf(NyzoStringType::class, $this->nyzoStringPublicIdentifier->getType());
      $this->assertEquals(NyzoStringType::PublicIdentifier(), $this->nyzoStringPublicIdentifier->getType());
    }

    /** @test */
    public function canGetBytes(): void {
      $this->assertNotNull($this->nyzoStringPublicIdentifier->getBytes());
      $this->assertEquals($this->constructorValues["identifier"]->toArray(), $this->nyzoStringPublicIdentifier->getBytes());
    }

    /** @test */
    public function canConvertFromHexToNyzoStringPublicIdentifier(): void {
      $hex = "848db2de31cbe4c4-28dbb9e6bdda3aba-98581356ab0e6e02-37b37fd370ac3c7b";
      $nyzoStringPublicIdentifier = NyzoStringPublicIdentifier::fromHex($hex);
      $this->assertNotNull($nyzoStringPublicIdentifier);
      $this->assertInstanceOf(NyzoStringPublicIdentifier::class, $nyzoStringPublicIdentifier);
    }

    ////// Vector tests //////
    /** @test */
    public function canEncodeAndDecodeFromHexVector0(): void {
      $nyzoStringPublicIdentifier = NyzoStringPublicIdentifier::fromHex("848db2de31cbe4c4-28dbb9e6bdda3aba-98581356ab0e6e02-37b37fd370ac3c7b");
      $encoded = $this->encoder->encode($nyzoStringPublicIdentifier);
      $this->assertEquals("id__88idJKWPQ~j4adLXXIVreIHpn1dnHNXL0AvRw.dNI3PZXtxdHx7u", $encoded);
      $decoded = $this->encoder->decode($encoded);
      $this->assertEquals($nyzoStringPublicIdentifier->getBytes(), $decoded->getBytes());
    }

    /** @test */
    public function canEncodeAndDecodeFromHexVector8000(): void {
      $nyzoStringPublicIdentifier = NyzoStringPublicIdentifier::fromHex("1a7d496278a9ffc7-febfed9f3e8d83ab-eb4a227d020fbbaa-ab1544f0cef8f53f");
      $encoded = $this->encoder->encode($nyzoStringPublicIdentifier);
      $this->assertEquals("id__81G.in9WHw_7_I_KERYdxYMIiz9.0x~ZHHJmhf3e~fk_3tn4IuEs", $encoded);
      $decoded = $this->encoder->decode($encoded);
      $this->assertEquals($nyzoStringPublicIdentifier->getBytes(), $decoded->getBytes());
    }

    /** @test */
    public function canEncodeAndDecodeFromHexVector13000(): void {
      $nyzoStringPublicIdentifier = NyzoStringPublicIdentifier::fromHex("39558c7380ba4817-1a748b48fac7bed0-b2d5cbff5d38bf45-8b1f41aacef67881");
      $encoded = $this->encoder->encode($nyzoStringPublicIdentifier);
      $this->assertEquals("id__83CmA7e0LBxo6EibifI7MK2QTtM_ojz_hpJwgrIe.Ez1H8dsIm5.", $encoded);
      $decoded = $this->encoder->decode($encoded);
      $this->assertEquals($nyzoStringPublicIdentifier->getBytes(), $decoded->getBytes());
    }

    /** @test */
    public function canEncodeAndDecodeFromHexVector19000(): void {
      $nyzoStringPublicIdentifier = NyzoStringPublicIdentifier::fromHex("4c66c2c9ef2f6d7a-ec0057d224dcf8eb-f21ce9f1f938fd7c-b3ab6c77ffd805cc");
      $encoded = $this->encoder->encode($nyzoStringPublicIdentifier);
      $this->assertEquals("id__84PDNJEMbUTYZ01oSzjt~eMQ7eEP~jA.wbeIs7w_U0ocYX2G.tGZ", $encoded);
      $decoded = $this->encoder->decode($encoded);
      $this->assertEquals($nyzoStringPublicIdentifier->getBytes(), $decoded->getBytes());
    }

    /** @test */
    public function canEncodeAndDecodeFromHexVector25000(): void {
      $nyzoStringPublicIdentifier = NyzoStringPublicIdentifier::fromHex("701a37089b596a18-b719922a543fff1b-54879e7ca1d4fd5c-64eabd2c85d55231");
      $encoded = $this->encoder->encode($nyzoStringPublicIdentifier);
      $this->assertEquals("id__870rdNzsnnFpKPDiaCg__PKkyXX-Fuj.o6jHMiQ5Tm8PkBAY.aa9", $encoded);
      $decoded = $this->encoder->decode($encoded);
      $this->assertEquals($nyzoStringPublicIdentifier->getBytes(), $decoded->getBytes());
    }

    /** @test */
    public function canEncodeAndDecodeFromHexVector79000(): void {
      $nyzoStringPublicIdentifier = NyzoStringPublicIdentifier::fromHex("af4fdb9a637d7e83-a0b9d222e3cd1326-8c07c20ad66cf08e-b506f79d2865e2ad");
      $encoded = $this->encoder->encode($nyzoStringPublicIdentifier);
      $this->assertEquals("id__8a.fUXGAwoY3FbEi8Lfd4Qrc1-8aTDRNAIk6.XSFqvaKuiPwfgjC", $encoded);
      $decoded = $this->encoder->decode($encoded);
      $this->assertEquals($nyzoStringPublicIdentifier->getBytes(), $decoded->getBytes());
    }
  }
?>
