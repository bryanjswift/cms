<?php

require_once("Tag.class.php");

class Parser {

  private $template = "";
  private $prefix = "cms:content";
  private $tags = array();

  function __construct($template, $prefix="cms:content") {
    $fh = fopen($template, "r");
    $this->template = fread($fh, filesize($template));
    fclose($fh);

    $this->prefix = $prefix;
  }

  function tags() {
    $matches = array();
    $needle = "/<$this->prefix [^>]*>/";
    preg_match_all($needle, $this->template, $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
      array_push($this->tags, new Tag($match[0]));
    }
    return $this->tags;
  }

  function raw() {
    return htmlentities($this->template);
  }

}
