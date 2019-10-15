<?php
  /**
   * NyzoString Ancestor
   * ref: https://github.com/n-y-z-o/nyzoVerifier/blob/master/src/main/java/co/nyzo/verifier/nyzoString/NyzoString.java
   * version: 0.0.1
   */
  
  class NyzoString {

    protected $type, $bytes;

    public function __construct(string $type, array $bytes) {
      $this->type = $type;
      $this->bytes = $bytes;
    }

    public function getType(): string {
      return $this->type;
    }

    public function getBytes(): array {
      return $this->bytes;
    }
  }

?>
