<?php
  declare(strict_types=1);

  use PHPUnit\Framework\TestCase;
  require_once("src/NyzoStringPrivateSeed.php");
  require_once("src/NyzoStringEncoder.php");
  require_once("src/NyzoStringType.php");
  require_once("src/utils/Buffer.php");

  final class NyzoStringPrivateSeedTest extends TestCase {

    private $encoder;

    private $nyzoStringPrivateSeed;

    private $constructorValues = [];

    public function setUp(): void {
      $this->encoder = new NyzoStringEncoder();
      $seed = $this->constructorValues["seed"] = Buffer::from([1,2,3]);
      $this->nyzoStringPrivateSeed = new NyzoStringPrivateSeed($seed);
    }

    /** @test */
    public function canConstructNyzoStringPrivateSeed(): void {
      $this->assertNotNull($this->nyzoStringPrivateSeed);
      $this->assertInstanceOf(NyzoStringPrivateSeed::class, $this->nyzoStringPrivateSeed);
    }

    /** @test */
    public function canGetSeed(): void {
      $this->assertNotNull($this->nyzoStringPrivateSeed->getSeed());
      $this->assertEquals($this->constructorValues["seed"], $this->nyzoStringPrivateSeed->getSeed());
    }

    /** @test */
    public function canGetType(): void {
      $this->assertNotNull($this->nyzoStringPrivateSeed->getType());
      $this->assertInstanceOf(NyzoStringType::class, $this->nyzoStringPrivateSeed->getType());
      $this->assertEquals(NyzoStringType::PrivateSeed(), $this->nyzoStringPrivateSeed->getType());
    }

    /** @test */
    public function canGetBytes(): void {
      $bytes = [1,2,3];
      $this->assertNotNull($this->nyzoStringPrivateSeed->getBytes());
      $this->assertEquals($bytes, $this->nyzoStringPrivateSeed->getBytes());
    }

    /** @test */
    public function canConvertFromHexToNyzoStringPrivateSeed(): void {
      $nyzoStringPrivateSeed = NyzoStringPrivateSeed::fromHex("74d84ed425f51e6f-aa9bae140e952601-29d16a73241231dc-6962619b5fbc6e27");
      $this->assertNotNull($nyzoStringPrivateSeed);
      $this->assertInstanceOf(NyzoStringPrivateSeed::class, $nyzoStringPrivateSeed);
    }

    ////// Vector tests //////
    /** @test */
    public function canEncodeAndDecodeFromHexVector0(): void {
      $nyzoStringPrivateSeed = NyzoStringPrivateSeed::fromHex("74d84ed425f51e6f-aa9bae140e952601-29d16a73241231dc-6962619b5fbc6e27");
      $encoded = $this->encoder->encode($nyzoStringPrivateSeed);
      $this->assertEquals("key_87jpjKgC.hXMHGLL50Ym9x4GSnGR918PV6CzpqKwM6WEgqRzfABZ", $encoded);
      $decoded = $this->encoder->decode($encoded);
      $this->assertEquals($nyzoStringPrivateSeed->getBytes(), $decoded->getBytes());
    }

    /** @test */
    public function canEncodeAndDecodeFromHexVector8000(): void {
      $nyzoStringPrivateSeed = NyzoStringPrivateSeed::fromHex("83a2c34eef86da60-e0d26b82a305367b-cf4ed6893ed5d807-0f2fae99a97d77bd");
      $encoded = $this->encoder->encode($nyzoStringPrivateSeed);
      $this->assertEquals("key_88ezNSZMyKGxWd9IxHc5dEMfjKr9fKop1N-MIGDGwov.tBBqPRDY", $encoded);
      $decoded = $this->encoder->decode($encoded);
      $this->assertEquals($nyzoStringPrivateSeed->getBytes(), $decoded->getBytes());
    }

    /** @test */
    public function canEncodeAndDecodeFromHexVector13000(): void {
      $nyzoStringPrivateSeed = NyzoStringPrivateSeed::fromHex("e58d51a913e209db-8645d6d78f061309-d2af2ef1ed651788-4ea8d4bc4f678401");
      $encoded = $this->encoder->encode($nyzoStringPrivateSeed);
      $this->assertEquals("key_8endkrBjWxEsyBonTW-64NEiIQZPZnkoz4YFTbPfqWg1jt28sUiM", $encoded);
      $decoded = $this->encoder->decode($encoded);
      $this->assertEquals($nyzoStringPrivateSeed->getBytes(), $decoded->getBytes());
    }

    /** @test */
    public function canEncodeAndDecodeFromHexVector19000(): void {
      $nyzoStringPrivateSeed = NyzoStringPrivateSeed::fromHex("c253802154f4aa04-906275b8f922ed86-81cf11d2cac11a92-8dcdf3bee1c5af32");
      $encoded = $this->encoder->encode($nyzoStringPrivateSeed);
      $this->assertEquals("key_8c9jx25k.aF4B69TLfBzZpr1RP7iQJ4rBFVd-ZZyPr-QQWm3Ivcv", $encoded);
      $decoded = $this->encoder->decode($encoded);
      $this->assertEquals($nyzoStringPrivateSeed->getBytes(), $decoded->getBytes());
    }

    /** @test */
    public function canEncodeAndDecodeFromHexVector25000(): void {
      $nyzoStringPrivateSeed = NyzoStringPrivateSeed::fromHex("2882cc9feb9e0861-ccb999c8400cf515-49b73fab4cc6c7a8-0cffef201fc2e777");
      $encoded = $this->encoder->encode($nyzoStringPrivateSeed);
      $this->assertEquals("key_82z2R9_IExyyRbDqQ40c.hm9KR~Ijcs7H0R_ZQ0wNLuV9ieWk_p4", $encoded);
      $decoded = $this->encoder->decode($encoded);
      $this->assertEquals($nyzoStringPrivateSeed->getBytes(), $decoded->getBytes());
    }
    /** @test */
    public function canEncodeAndDecodeFromHexVector79000(): void {
      $nyzoStringPrivateSeed = NyzoStringPrivateSeed::fromHex("d60987f22773e4c7-7efb079e9900554e-b6efb568de81ec74-f7396efab7f5605d");
      $encoded = $this->encoder->encode($nyzoStringPrivateSeed);
      $this->assertEquals("key_8dp9y_8Et~j7wMJ7EGB0mkYUZZmFVF7JuftXsMHV.n1upfKfwunh", $encoded);
      $decoded = $this->encoder->decode($encoded);
      $this->assertEquals($nyzoStringPrivateSeed->getBytes(), $decoded->getBytes());
    }
  }

?>
