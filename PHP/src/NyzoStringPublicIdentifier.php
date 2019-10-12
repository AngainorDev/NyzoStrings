<?php
/**
 * ref: https://github.com/n-y-z-o/nyzoVerifier/blob/master/src/main/java/co/nyzo/verifier/nyzoString/NyzoStringPublicIdentifier.java
 */
  require_once("./NyzoString.php");

  $version = "0.0.1";

  final class NyzoStringPublicIdentifier extends NyzoString {

    public function __construct(array $identifier) {
      parent::__construct("id__", $identifier);
    }

    public function getIdentifier() {
      return $this->bytes;
    }

    public static function fromHex(string $hexString): NyzoStringPublicIdentifier {
      $filteredString = substr(implode("", explode("-", $hexString)), 0, 64);
      $hexArray = unpack("H*", $filteredString);
      return new NyzoStringPublicIdentifier($hexArray);
    }
  }

?>