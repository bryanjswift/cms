<?php

require_once("Tag.class.php");

class BasicTag extends Tag {

  protected function __construct($ns, $kind, $markup) {
    parent::__construct($ns, $kind, $markup);
  }

}
