<?php

require_once("Tag.class.php");

class Parser {

  private $template = "";
  private $prefix = "cms";
  private $tags = array();

  function __construct($template, $prefix="cms") {
    if (file_exists($template)) {
      $fh = fopen($template, "r");
      if (filesize($template) > 0) {
        $this->template = fread($fh, filesize($template));
      }
      fclose($fh);
    } else {
      $this->template = $template;
    }

    $this->prefix = $prefix;
  }

  function tags() {
    $matches = array();
    $needle = "/<\/?" . $this->prefix . ":([a-zA-Z0-9]*)( [^>]*)?>/";
    preg_match_all($needle, $this->template, $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
      array_push($this->tags, Tag::getInstance($match[1], $match[0]));
    }
    return $this->tags;
  }

  function raw() {
    return htmlentities($this->template);
  }

}
