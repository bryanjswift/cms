<?php

require_once("Tag.class.php");

class BasicTag extends Tag {

  protected function __construct($ns, $kind, $attrs) {
    parent::__construct($ns, $kind, $attrs);
  }

}

Tag::registerKind('basic', BasicTag);
