<?php

  class NyzoStringType {

    private $type;
    private function __construct(string $type) {
      $this->type = $type;
    }

    public function getType(): string {
      return $this->type;
    }

    public function value(): string {
      return $this->getType();
    }

    public function __toString(): string {
      return $this->value();
    }

    public static function PrefilledData() {
      return new NyzoStringType("pre_");
    }

    public static function PrivateSeed() {
      return new NyzoStringType("key_");
    }

    public static function PublicIdentifier() {
      return new NyzoStringType("id__");
    }

    public static function Micropay() {
      return new NyzoStringType("pay_");
    }

    public static function Transaction() {
      return new NyzoStringType("tx__");
    }
  }

?>