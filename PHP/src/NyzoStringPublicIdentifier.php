<?php
  /**
   * ref: https://github.com/n-y-z-o/nyzoVerifier/blob/master/src/main/java/co/nyzo/verifier/nyzoString/NyzoStringPublicIdentifier.java
   * version: 0.0.2
   */
  require_once("NyzoString.php");
  require_once("NyzoStringType.php");
  require_once("utils/Buffer.php");

  final class NyzoStringPublicIdentifier implements NyzoString {

    /** array */
    private $identifier;

    public function __construct(Buffer $identifier) {
      $this->identifier = $identifier;
    }

    public function getIdentifier(): Buffer {
      return $this->identifier;
    }

    /** @override */
    public function getType(): NyzoStringType {
      return NyzoStringType::PublicIdentifier();
    }

    /** @override */
    public function getBytes(): array {
      return $this->identifier->toArray();
    }

    public static function fromHex(string $hexString): NyzoStringPublicIdentifier {
      $filteredString = substr(implode("", explode("-", $hexString)), 0, 64);
      $buff = Buffer::fromHex($filteredString);
      return new NyzoStringPublicIdentifier($buff);
    }
  }
?>
