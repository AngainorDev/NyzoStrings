<?php
  declare(strict_types=1);

  use PHPUnit\Framework\TestCase;
  require_once("src/NyzoStringTransaction.php");
  require_once("src/NyzoStringEncoder.php");
  require_once("src/utils/Buffer.php");
  require_once("src/utils/Int64.php");

  final class NyzoStringTransactionTest extends TestCase {
    
    private $encoder;

    private $nyzoStringTransaction;

    private $constructValues = [
      "timestamp"=> null,
      "amount"=> null,
      "receiverIdentifier" => null,
      "previousHashHeight" => null,
      "previousBlockHash" => null,
      "senderIdentifier" => null,
      "senderData" => null,
      "signature" => null
    ];

    public function setUp(): void {
      $this->encoder = new NyzoStringEncoder();
      $timestamp = $this->constructValues["timestamp"] = Int64::fromInt(1571455558398);
      $amount = $this->constructValues["amount"] = Int64::fromInt(255);
      $receiverIdentifier = $this->constructValues["receiverIdentifier"] = Buffer::from([1,2,3,4]);
      $previousHashHeight = $this->constructValues["previousHashHeight"] = Int64::fromInt(45);
      $previousBlockHash = $this->constructValues["previousBlockHash"] = Buffer::from([6,6,6]);
      $senderIdentifier = $this->constructValues["senderIdentifier"] = Buffer::from([5,6,7,8]);
      $senderData = $this->constructValues["senderData"] = Buffer::from([8,9,10]);
      $signature = $this->constructValues["signature"] = Buffer::from([255,255,255]);
      $this->nyzoStringTransaction = new NyzoStringTransaction($timestamp, $amount, $receiverIdentifier, $previousHashHeight, $previousBlockHash, $senderIdentifier, $senderData, $signature);
    }

    /** @test */
    public function canConstructNyzoStringTransaction(): void {
      $this->assertInstanceOf(NyzoStringTransaction::class, $this->nyzoStringTransaction);
    }

    /** @test */
    public function canGetTimestamp(): void {
      $this->assertNotNull($this->nyzoStringTransaction->getTimestamp());
      $this->assertEquals($this->constructValues["timestamp"], $this->nyzoStringTransaction->getTimestamp());
    }

    /** @test */
    public function canGetAmount(): void {
      $this->assertNotNull($this->nyzoStringTransaction->getAmount());
      $this->assertEquals($this->constructValues["amount"], $this->nyzoStringTransaction->getAmount());
    }

    /** @test */
    public function canGetReceiverIdentifier(): void {
      $this->assertNotNull($this->nyzoStringTransaction->getReceiverIdentifier());
      $this->assertEquals($this->constructValues["receiverIdentifier"], $this->nyzoStringTransaction->getReceiverIdentifier());
    }

    /** @test */
    public function canGetPreviousHashHeight(): void {
      $this->assertNotNull($this->nyzoStringTransaction->getPreviousHashHeight());
      $this->assertEquals($this->constructValues["previousHashHeight"], $this->nyzoStringTransaction->getPreviousHashHeight());
    }

    /** @test */
    public function canGetPreviousBlockHash(): void {
      $this->assertNotNull($this->nyzoStringTransaction->getPreviousBlockHash());
      $this->assertEquals($this->constructValues["previousBlockHash"], $this->nyzoStringTransaction->getPreviousBlockHash());
    }

     /** @test */
     public function canGetSenderIdentifier(): void {
      $this->assertNotNull($this->nyzoStringTransaction->getSenderIdentifier());
      $this->assertEquals($this->constructValues["senderIdentifier"], $this->nyzoStringTransaction->getSenderIdentifier());
    }

     /** @test */
     public function canGetSenderData(): void {
      $this->assertNotNull($this->nyzoStringTransaction->getSenderData());
      $this->assertEquals($this->constructValues["senderData"], $this->nyzoStringTransaction->getSenderData());
    }

     /** @test */
     public function canGetSignature(): void {
      $this->assertNotNull($this->nyzoStringTransaction->getSignature());
      $this->assertEquals($this->constructValues["signature"], $this->nyzoStringTransaction->getSignature());
    }

     /** @test */
     public function canGetType(): void {
      $this->assertNotNull($this->nyzoStringTransaction->getType());
      $this->assertInstanceOf(NyzoStringType::class, $this->nyzoStringTransaction->getType());
      $this->assertEquals(NyzoStringType::Transaction(), $this->nyzoStringTransaction->getType());
    }

     /** @test */
     public function canGetBytes(): void {
      $bytes = [2,0,0,1,109,226,12,226,254,0,0,0,0,0,0,0,255,1,2,3,4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,45,5,6,7,8,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,3,8,9,10,255,255,255,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
      $this->assertNotNull($this->nyzoStringTransaction->getBytes());
      $this->assertEquals($bytes, $this->nyzoStringTransaction->getBytes());
    }

    ////// Vector tests //////
    /** @test */
    public function canConvertFromHexToNyzoStringTransaction(): void {
      $nyzoStringTransaction = NyzoStringTransaction::fromHex("9bdecd1085b8f5e1", "545d4b257f8def80",
      "3ce4eaf311934276-673752ccb5cf4cac-61eed231d8fcb649-6310887ecf99f6e5", "e6e882dc8cd92291",
      "d5fbaeaeb085b299-eb028094fe472330-5eb9f6427e7c3d38-7ece7edc91fb3983",
      "7695f21b83c22fff-5172d720e6aca180-a017d5af55dbd85f-3b23526794a75872",
      "360cb35fc71a111e2576cf",
      "6a675732bd20a2c203a925fc62f1d5249b98c128b555472c980f84d9d37fb3452c7211ea448eeed51b7af17785490593a429e97a4f373788a1a768e40d64657c");
      $this->assertNotNull($nyzoStringTransaction);
      $this->assertInstanceOf(NyzoStringTransaction::class, $nyzoStringTransaction);
    }

    /** @test */
    public function canEncodeAndDecodeFromHexVector0(): void {
      $nyzoStringTransaction = NyzoStringTransaction::fromHex("9bdecd1085b8f5e1", "545d4b257f8def80",
        "3ce4eaf311934276-673752ccb5cf4cac-61eed231d8fcb649-6310887ecf99f6e5", "e6e882dc8cd92291",
        "d5fbaeaeb085b299-eb028094fe472330-5eb9f6427e7c3d38-7ece7edc91fb3983",
        "7695f21b83c22fff-5172d720e6aca180-a017d5af55dbd85f-3b23526794a75872",
        "360cb35fc71a111e2576cf",
        "6a675732bd20a2c203a925fc62f1d5249b98c128b555472c980f84d9d37fb3452c7211ea448eeed51b7af17785490593a429e97a4f373788a1a768e40d64657c"
      );
      $encoded = $this->encoder->encode($nyzoStringTransaction);
      $this->assertEquals("tx__GgasVJSgysATWmhuiQm_Av~0fejH-P6jgEqEdTbcKt.cI67LSA7p_bq9pP28wJ~q.LoDY8btAdBzBorm-yL3Nz__kobo8erJFp2x5.nMmuMpoRJAkDvkGTyQ2RpcJT_76y4v9osfrDuocISxFJ83Hio-pM7m99LpNizTmktJD0~4Uud_JSkJty7Hh8ZLThKY-ov5ignjG2EGvB-VdWzyGUAB3nhCwe~GDN_e", $encoded);
      $decoded = $this->encoder->decode($encoded);
      $this->assertEquals($nyzoStringTransaction->getBytes(), $decoded->getBytes());
    }

    /** @test */
    public function canEncodeAndDecodeFromHexVector26000(): void {
      $nyzoStringTransaction = NyzoStringTransaction::fromHex("ba94f30cfffa6590", "ba80822eefb07338",
        "7aad5eb4000f5400-a848d584c7eeabd9-4e28ed04a249115f-a17c126bf9fe896c", "7091c9f882e5b51d",
        "d8f53af77b321d7b-82f04ff1db0c86fa-6516744752fcd9e0-df49f5a7c83bd148",
        "2e4df5134377f512-86ddee2159689033-a0cb484d757b223f-439b6c7cd03c5d2f",
        "",
        "54ea57754c832e04bdef6d06adbab4a7b754550b92bb7323c7d0fa75825bd8d2445f49bc5926359eac5de99e9b36b30113894f3f0a4e5afd8523a5763ea90483"
      );
      $encoded = $this->encoder->encode($nyzoStringTransaction);
      $this->assertEquals("tx__DxaYCfcc__GCBbH0xzZMJ7cWvHTvK00fm02Fidn4P~YIUkWFZgizih5wFoNir_E~znPNBtEWxLnT7iXd.hd3u_kiyKVL8mCFB3exQSyduoJzfSess7Rgf5SM05jHmVmcxQW4Mv.K1HUYKavVm5kbBIKR8-wg~En2n.Aih5.9M5BDdqYJovDvDRrR0he9jR-ajCI.yieCuAYG18cYfyrZ", $encoded);
      $decoded = $this->encoder->decode($encoded);
      $this->assertEquals($nyzoStringTransaction->getBytes(), $decoded->getBytes());
    }    
  }
?>
