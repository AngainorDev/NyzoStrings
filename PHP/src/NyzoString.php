<?php
  /**
   * NyzoString Interface
   * ref: https://github.com/n-y-z-o/nyzoVerifier/blob/master/src/main/java/co/nyzo/verifier/nyzoString/NyzoString.java
   * version: 0.0.2
   */
   require_once("NyzoStringType.php");
  
  interface NyzoString {
    function getType(): NyzoStringType;
    function getBytes(): array;
  }
?>
