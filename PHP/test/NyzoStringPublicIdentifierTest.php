<?php
  declare(strict_types=1);

  use PHPUnit\Framework\TestCase;
  require_once("src/NyzoStringPublicIdentifier.php");
  require_once("src/NyzoStringEncoder.php");

  final class NyzoStringPublicIdentifierTest extends TestCase {

    private $encoder;

    public function setUp(): void {
      $this->encoder = new NyzoStringEncoder();
    }

    /** @test */
    public function canConstructNyzoStringPublicIdentifier(): void {
      $identifier = [1, 2, 3];
      $this->assertInstanceOf(NyzoStringPublicIdentifier::class, new NyzoStringPublicIdentifier($identifier));
    }

    /** @test */
    public function canGetIdentifier(): void {
      $identifier = [1, 2, 3];
      $nyzoStringPublicIdentifier = new NyzoStringPublicIdentifier($identifier);
      $this->assertNotNull($nyzoStringPublicIdentifier->getIdentifier());
      $this->assertEquals($identifier, $nyzoStringPublicIdentifier->getIdentifier());
      $this->assertEquals($nyzoStringPublicIdentifier->getIdentifier(), $nyzoStringPublicIdentifier->getBytes());
    }

    /** @test */
    public function canConvertFromHexToNyzoStringPublicIdentifier(): void {
      $hex = "848db2de31cbe4c4-28dbb9e6bdda3aba-98581356ab0e6e02-37b37fd370ac3c7b";
      $nyzoString = NyzoStringPublicIdentifier::fromHex($hex);
      $this->assertNotNull($nyzoString);
      $this->assertInstanceOf(NyzoStringPublicIdentifier::class, $nyzoString);
    }

    /** @test */
    public function canEncodeFromHexVector0(): void {
      $nyzoString = NyzoStringPublicIdentifier::fromHex("848db2de31cbe4c4-28dbb9e6bdda3aba-98581356ab0e6e02-37b37fd370ac3c7b");
      $encoded = $this->encoder->encode($nyzoString);
      $this->assertEquals("id__88idJKWPQ~j4adLXXIVreIHpn1dnHNXL0AvRw.dNI3PZXtxdHx7u", $encoded);
    }

    /** @test */
    public function canEncodeFromHexVector8000(): void {
      $nyzoString = NyzoStringPublicIdentifier::fromHex("1a7d496278a9ffc7-febfed9f3e8d83ab-eb4a227d020fbbaa-ab1544f0cef8f53f");
      $encoded = $this->encoder->encode($nyzoString);
      $this->assertEquals("id__81G.in9WHw_7_I_KERYdxYMIiz9.0x~ZHHJmhf3e~fk_3tn4IuEs", $encoded);
    }

    /** @test */
    public function canEncodeFromHexVector13000(): void {
      $nyzoString = NyzoStringPublicIdentifier::fromHex("39558c7380ba4817-1a748b48fac7bed0-b2d5cbff5d38bf45-8b1f41aacef67881");
      $encoded = $this->encoder->encode($nyzoString);
      $this->assertEquals("id__83CmA7e0LBxo6EibifI7MK2QTtM_ojz_hpJwgrIe.Ez1H8dsIm5.", $encoded);
    }

    /** @test */
    public function canEncodeFromHexVector19000(): void {
      $nyzoString = NyzoStringPublicIdentifier::fromHex("4c66c2c9ef2f6d7a-ec0057d224dcf8eb-f21ce9f1f938fd7c-b3ab6c77ffd805cc");
      $encoded = $this->encoder->encode($nyzoString);
      $this->assertEquals("id__84PDNJEMbUTYZ01oSzjt~eMQ7eEP~jA.wbeIs7w_U0ocYX2G.tGZ", $encoded);
    }

    /** @test */
    public function canEncodeFromHexVector25000(): void {
      $nyzoString = NyzoStringPublicIdentifier::fromHex("701a37089b596a18-b719922a543fff1b-54879e7ca1d4fd5c-64eabd2c85d55231");
      $encoded = $this->encoder->encode($nyzoString);
      $this->assertEquals("id__870rdNzsnnFpKPDiaCg__PKkyXX-Fuj.o6jHMiQ5Tm8PkBAY.aa9", $encoded);
    }

    /** @test */
    public function canEncodeFromHexVector79000(): void {
      $nyzoString = NyzoStringPublicIdentifier::fromHex("af4fdb9a637d7e83-a0b9d222e3cd1326-8c07c20ad66cf08e-b506f79d2865e2ad");
      $encoded = $this->encoder->encode($nyzoString);
      $this->assertEquals("id__8a.fUXGAwoY3FbEi8Lfd4Qrc1-8aTDRNAIk6.XSFqvaKuiPwfgjC", $encoded);
    }

  }
?>