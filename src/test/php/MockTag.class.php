<?php

include_once(dirname(__FILE__) . "/setup.php");

require_once "$srcRoot/BasicTag.class.php";

class MockTag extends BasicTag {
  public function __construct($ns, $kind, $markup) {
    parent::__construct($ns, $kind, $markup);
  }

  public function _isMock() {
    return true;
  }
}
