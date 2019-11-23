<?php
  /**
   * ref: https://github.com/n-y-z-o/nyzoVerifier/blob/master/src/main/java/co/nyzo/verifier/nyzoString/NyzoStringPrivateSeed.java
   * version: 0.0.2
   */
  require_once("NyzoString.php");
  require_once("NyzoStringType.php");
  require_once("utils/Buffer.php");

  final class NyzoStringPrivateSeed implements NyzoString {

    /** array */
    private $seed;

    public function __construct(Buffer $seed) {
      $this->seed = $seed;
    }

    public function getSeed(): Buffer {
      return $this->seed;
    }

    /** @override */
    public function getType(): NyzoStringType {
      return NyzoStringType::PrivateSeed();
    }

    /** @override */
    public function getBytes(): array {
      return $this->seed->toArray();
    }

    public static function fromHex(string $hexString): NyzoStringPrivateSeed {
      $filteredString = substr(implode("", explode("-", $hexString)), 0, 64);
      $buff = Buffer::fromHex($filteredString);
      return new NyzoStringPrivateSeed($buff);
    }
  }
?>
