<?php
  declare(strict_types=1);

  use PHPUnit\Framework\TestCase;
  require_once("src/NyzoStringMicropay.php");
  require_once("src/NyzoStringEncoder.php");
  require_once("src/NyzoStringType.php");
  require_once("src/utils/Buffer.php");
  require_once("src/utils/Int64.php");

  final class NyzoStringMicropayTest extends TestCase {

    private $encoder;

    private $nyzoStringMicropay;

    private $constructorValues = [];

    public function setUp(): void {
      $this->encoder = new NyzoStringEncoder();
      $receiverIdentifier = $this->constructorValues["receiverIdentifier"] = Buffer::from([1, 2, 3]);
      $senderData = $this->constructorValues["senderData"] = Buffer::from([4,5,6]);
      $amount = $this->constructorValues["amount"] = Int64::fromInt(500);
      $timestamp = $this->constructorValues["timestamp"] = Int64::fromInt(1571455558398);
      $previousHashHeight = $this->constructorValues["previousHashHeight"] = Int64::fromInt(256);
      $previousBlockHash = $this->constructorValues["previousBlockHash"] = Buffer::from([7,8,9]);
      $this->nyzoStringMicropay = new NyzoStringMicropay($receiverIdentifier, $senderData, $amount, $timestamp, $previousHashHeight, $previousBlockHash);
    }

    /** @test */
    public function canConstructNyzoStringMicropay(): void {
      $this->assertNotNull($this->nyzoStringMicropay);
      $this->assertInstanceOf(NyzoStringMicropay::class, $this->nyzoStringMicropay);
    }

    /** @test */
    public function canGetReceiverIdentifier(): void {
      $this->assertNotNull($this->nyzoStringMicropay->getReceiverIdentifier());
      $this->assertEquals($this->constructorValues["receiverIdentifier"], $this->nyzoStringMicropay->getReceiverIdentifier());
    }

    /** @test */
    public function canGetSenderData(): void {
      $this->assertNotNull($this->nyzoStringMicropay->getSenderData());
      $this->assertEquals($this->constructorValues["senderData"], $this->nyzoStringMicropay->getSenderData());
    }

    /** @test */
    public function canGetAmount(): void {
      $this->assertNotNull($this->nyzoStringMicropay->getAmount());
      $this->assertEquals($this->constructorValues["amount"], $this->nyzoStringMicropay->getAmount());
    }

    /** @test */
    public function canGetTimestamp(): void {
      $this->assertNotNull($this->nyzoStringMicropay->getTimestamp());
      $this->assertEquals($this->constructorValues["timestamp"], $this->nyzoStringMicropay->getTimestamp());
    }

    /** @test */
    public function canGetPreviousHashHeight(): void {
      $this->assertNotNull($this->nyzoStringMicropay->getPreviousHashHeight());
      $this->assertEquals($this->constructorValues["previousHashHeight"], $this->nyzoStringMicropay->getPreviousHashHeight());
    }

    /** @test */
    public function canGetPreviousBlockHash(): void {
      $this->assertNotNull($this->nyzoStringMicropay->getPreviousBlockHash());
      $this->assertEquals($this->constructorValues["previousBlockHash"], $this->nyzoStringMicropay->getPreviousBlockHash());
    }

    /** @test */
    public function canGetType(): void {
      $this->assertNotNull($this->nyzoStringMicropay->getType());
      $this->assertInstanceOf(NyzoStringType::class, $this->nyzoStringMicropay->getType());
      $this->assertEquals(NyzoStringType::Micropay(), $this->nyzoStringMicropay->getType());
    }

    /** @test */
    public function canGetBytes(): void {
      $bytes = [1,2,3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,3,4,5,6,0,0,0,0,0,0,1,244,0,0,1,109,226,12,226,254,0,0,0,0,0,0,1,0,7,8,9,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
      $this->assertNotNull($this->nyzoStringMicropay->getBytes());
      $this->assertEquals($bytes, $this->nyzoStringMicropay->getBytes());
    }

    /** @test */
    public function canConvertFromHexToNyzoStringMicropay(): void {
      $nyzoStringMicropay = NyzoStringMicropay::fromHex("f786ad285a251faa-6b59b353b83b0cc7-5a5a9e53a99d148c-a7f1439909da15a6",
        "1e0621f818c44de5700ccb243fb9e8d0a65acdc70943",
        "fbe53e25acb1caf0", "d8e13cd700325825", "6da37b293519ca78",
        "a045e3c666ffec05-e7e392c0c09c8a99-3a883c8f2a40f915-a9e50659e0e16f08"
      );
      $this->assertNotNull($nyzoStringMicropay);
      $this->assertInstanceOf(NyzoStringMicropay::class, $nyzoStringMicropay);
    }

    ////// Vector tests //////
    /** @test */
    public function canEncodeAndDecodeFromHexVector0(): void {
      $nyzoStringMicropay = NyzoStringMicropay::fromHex("f786ad285a251faa-6b59b353b83b0cc7-5a5a9e53a99d148c-a7f1439909da15a6",
        "1e0621f818c44de5700ccb243fb9e8d0a65acdc70943",
        "fbe53e25acb1caf0", "d8e13cd700325825", "6da37b293519ca78",
        "a045e3c666ffec05-e7e392c0c09c8a99-3a883c8f2a40f915-a9e50659e0e16f08"
      );
      $encoded = $this->encoder->encode($nyzoStringMicropay);
      $this->assertEquals("pay_s_v6Iiyr9h~HrTDRkZxZ3curnGXjHqSkAawPgXB9UynD5yW68wxpP4VCt0Rb93~XYd2DnJV72kfZXjWCIb7a-dAyfdt0cCxCsrdZajkqQEzxhvf6qM_J1vwABJ30E8HqeFx-AQG0~hnGXgqqWe5M2avMAHTp", $encoded);
      $decoded = $this->encoder->decode($encoded);
      $this->assertEquals($nyzoStringMicropay->getBytes(), $decoded->getBytes());
    }
  }
?>
