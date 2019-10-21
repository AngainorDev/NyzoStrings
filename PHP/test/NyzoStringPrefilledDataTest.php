<?php
  declare(strict_types=1);

  use PHPUnit\Framework\TestCase;
  require_once("src/NyzoStringPrefilledData.php");
  require_once("src/NyzoStringEncoder.php");
  require_once("src/NyzoStringType.php");
  require_once("src/utils/Buffer.php");

  final class NyzoStringPrefilledDataTest extends TestCase {

    private $encoder;

    private $nyzoStringPrefilledData;

    private $constructorValues = [];

    public function setUp(): void {
      $this->encoder = new NyzoStringEncoder();
      $receiverIdentifier = $this->constructorValues["receiverIdentifier"] = Buffer::from([1,2,3]);
      $senderData = $this->constructorValues["senderData"] = Buffer::from([4,5,6]);
      $this->nyzoStringPrefilledData = new NyzoStringPrefilledData($receiverIdentifier, $senderData);
    }

     /** @test */
     public function canConstructNyzoStringPrefilledData(): void {
      $this->assertNotNull($this->nyzoStringPrefilledData);
      $this->assertInstanceOf(NyzoStringPrefilledData::class, $this->nyzoStringPrefilledData);
    }

    /** @test */
    public function canGetReceiverIdentifier(): void {
      $this->assertNotNull($this->nyzoStringPrefilledData->getReceiverIdentifier());
      $this->assertEquals($this->constructorValues["receiverIdentifier"], $this->nyzoStringPrefilledData->getReceiverIdentifier());
    }

    /** @test */
    public function canGetSenderData(): void {
      $this->assertNotNull($this->nyzoStringPrefilledData->getSenderData());
      $this->assertEquals($this->constructorValues["senderData"], $this->nyzoStringPrefilledData->getSenderData());
    }

    /** @test */
    public function canGetType(): void {
      $this->assertNotNull($this->nyzoStringPrefilledData->getType());
      $this->assertInstanceOf(NyzoStringType::class, $this->nyzoStringPrefilledData->getType());
      $this->assertEquals(NyzoStringType::PrefilledData(), $this->nyzoStringPrefilledData->getType());
    }

    /** @test */
    public function canGetBytes(): void {
      $bytes = [1,2,3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,3,4,5,6];
      $this->assertNotNull($this->nyzoStringPrefilledData->getBytes());
      $this->assertEquals($bytes, $this->nyzoStringPrefilledData->getBytes());
    }

    /** @test */
    public function canConvertFromHexToNyzoStringPrefilledData(): void {
      $nyzoStringPrefilledData = NyzoStringPrefilledData::fromHex("1a74dff9c1bb47f7-01eabcfd217f2d6e-ab58a6889efaa44b-5bbe06d396596560", "82fb2a31c2fdedd9");
      $this->assertNotNull($nyzoStringPrefilledData);
      $this->assertInstanceOf(NyzoStringPrefilledData::class, $nyzoStringPrefilledData);
    }

    ////// Vector tests //////
    /** @test */
    public function canEncodeAndDecodeFromHexVector0(): void {
      $nyzoStringPrefilledData = NyzoStringPrefilledData::fromHex("1a74dff9c1bb47f7-01eabcfd217f2d6e-ab58a6889efaa44b-5bbe06d396596560", "82fb2a31c2fdedd9");
      $encoded = $this->encoder->encode($nyzoStringPrefilledData);
      $this->assertEquals("pre_ahGSV_E1LSwV0vH-_i5_bnYInar8EMHBiTL~1Kennnmx28bZaA72_vVqroRgFqRe", $encoded);
      $decoded = $this->encoder->decode($encoded);
      $this->assertEquals($nyzoStringPrefilledData->getReceiverIdentifier(), $decoded->getReceiverIdentifier());
      $this->assertEquals($nyzoStringPrefilledData->getSenderData(), $decoded->getSenderData());
      $this->assertEquals($nyzoStringPrefilledData->getBytes(), $decoded->getBytes());
    }

    /** @test */
    public function canEncodeAndDecodeFromHexVector17000(): void {
      $nyzoStringPrefilledData = NyzoStringPrefilledData::fromHex("53daaf0f7243222a-89324a82a2f2da6d-e9a3c025c3156b9d-fbd1bdab6af1409c", "536142cd5127b085fd48d3512cc3300abdd7bbca774d691e76437f7db0");
      $encoded = $this->encoder->encode($nyzoStringPrefilledData);
      $this->assertEquals("pre_fCfrIN.QgQ8Hzj9axHbQUDVGF-0CNPmIEwMhMrKH-k2t7mdygJTh9Z25_kAjkiR3c0H.TZMauSTG7Eq3wVUNIh0cVwG-", $encoded);
      $decoded = $this->encoder->decode($encoded);
      $this->assertEquals($nyzoStringPrefilledData->getReceiverIdentifier(), $decoded->getReceiverIdentifier());
      $this->assertEquals($nyzoStringPrefilledData->getSenderData(), $decoded->getSenderData());
      $this->assertEquals($nyzoStringPrefilledData->getBytes(), $decoded->getBytes());
    }

    /** @test */
    public function canEncodeAndDecodeFromHexVector44000(): void {
      // Take care to include at least one test with empty data
      $nyzoStringPrefilledData = NyzoStringPrefilledData::fromHex("b0c5aef7f03d6c95-e6643f98e12196cb-41fff5e71d4903f4-55419cf80e28781e", "");
      $encoded = $this->encoder->encode($nyzoStringPrefilledData);
      $this->assertEquals("pre_8s35IMwNfnQmXDg_De4yCJK1__oE7kB3.5m1Efxea7xv0c64GT24", $encoded);
      $decoded = $this->encoder->decode($encoded);
      $this->assertEquals($nyzoStringPrefilledData->getReceiverIdentifier(), $decoded->getReceiverIdentifier());
      $this->assertEquals($nyzoStringPrefilledData->getSenderData(), $decoded->getSenderData());
      $this->assertEquals($nyzoStringPrefilledData->getBytes(), $decoded->getBytes());
    }

    /** @test */
    public function canEncodeAndDecodeFromHexVector75000(): void {
      // max data size
      $nyzoStringPrefilledData = NyzoStringPrefilledData::fromHex("7182d875367fbb32-eef8831d47079a78-fd5daf7aabaa145e-1bdb4914676ae579", "8044e813bd9acf83149a31d819e22c820edc76f3cd00cd87e67958495e562cd3");
      $encoded = $this->encoder->encode($nyzoStringPrefilledData);
      $this->assertEquals("pre_go62U7kUwZJQZMz37kt7DEA.or.YHYFkoyMsihhErLmX8814Y1e.DJ~359FPU1Ezb88eV7sRRg3dy~qXn4CvmzRjFuo.qVfn", $encoded);
      $decoded = $this->encoder->decode($encoded);
      $this->assertEquals($nyzoStringPrefilledData->getReceiverIdentifier(), $decoded->getReceiverIdentifier());
      $this->assertEquals($nyzoStringPrefilledData->getSenderData(), $decoded->getSenderData());
      $this->assertEquals($nyzoStringPrefilledData->getBytes(), $decoded->getBytes());
    }

    ////// Custom Vector tests //////
    /** @test */
    public function canEncodeAndDecodeFromHexVector75000Plus(): void {
      // max data size + more data
      $nyzoStringPrefilledData = NyzoStringPrefilledData::fromHex("7182d875367fbb32-eef8831d47079a78-fd5daf7aabaa145e-1bdb4914676ae579", "8044e813bd9acf83149a31d819e22c820edc76f3cd00cd87e67958495e562cd38044e813bd9acf83149a31d819e22c820edc76f3cd00cd87e67958495e562cd3");
      $encoded = $this->encoder->encode($nyzoStringPrefilledData);
      $this->assertEquals("pre_go62U7kUwZJQZMz37kt7DEA.or.YHYFkoyMsihhErLmX8814Y1e.DJ~359FPU1Ezb88eV7sRRg3dy~qXn4CvmzRjFuo.qVfn", $encoded);
      $decoded = $this->encoder->decode($encoded);
      $this->assertEquals($nyzoStringPrefilledData->getReceiverIdentifier(), $decoded->getReceiverIdentifier());
      $this->assertEquals($nyzoStringPrefilledData->getSenderData(), $decoded->getSenderData());
      $this->assertEquals($nyzoStringPrefilledData->getBytes(), $decoded->getBytes());
    }

    /** @test */
    public function returnsNullWhenDecodedFromHexVector75000PlusNoise18(): void {
      $encoded = "pre_go62U7kUwZJQZMz37kt7DEA.or.YHYFkoyMsihhErLmX8814Y1e.DJ~359FPU1Ezb88eV7sRRg3dy~qXn4CvmzRjFuo.qVfn" . "qXn4CvmzRjFuo.qVfn"; // Add content at the end
      $decoded = $this->encoder->decode($encoded);
      $this->assertNull($decoded); // checksum length does not match 4 to 6
    }

    /** @test */
    public function returnsNullWhenDecodedFromHexVector75000PlusNoise1(): void {
      $encoded = "pre_go62U7kUwZJQZMz37kt7DEA.or.YHYFkoyMsihhErLmX8814Y1e.DJ~359FPU1Ezb88eV7sRRg3dy~qXn4CvmzRjFuo.qVfn" . "q"; // Add content at the end
      $decoded = $this->encoder->decode($encoded);
      $this->assertNull($decoded); // checksum length does not match 4 to 6
    }

    /** @test */
    public function returnsNullWhenDecodedFromHexVector75000Corrupted(): void {
      $encoded = "pre_go62U7kUwZJQZMz37kt7DEA.or.YHYFkoyMsihhErLmX8814Y1e.DJ~359FPU1Ezb88eV7sRRg3dy~qXn3CvmzRjFuo.qVfn"; // 1 changed char
      $decoded = $this->encoder->decode($encoded);
      $this->assertNull($decoded); // checksum does not match
    }
  }
?>
