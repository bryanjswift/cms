<?php

require_once("Parser.class.php");
require_once("Tag.class.php");

class Template {

  private $tags = array();

  function __construct($filePath) {
    $this->tags = Parser::getTags($filePath);
  }

  function tags() {
    return $this->tags;
  }

}
