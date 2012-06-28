<?php

require_once("Tag.class.php");

class BasicTag extends Tag {

  protected function __construct($ns, $kind, $attrs) {
    parent::__construct($ns, $kind, $attrs);
  }

  public function form() {
    $type = $this->type();
    $id = $this->id();
    $ret = "";
    switch ($type) {
      case "textarea":
        $ret = "<textarea name=\"$id\"></textarea>";
        break;
      default:
        $ret = "<input type=\"text\" name=\"$id\" />";
    }
    return $ret;
  }

}

Tag::registerKind('basic', BasicTag);
