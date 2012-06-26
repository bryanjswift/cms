<?php

require_once("Tag.class.php");

class Parser {

  static function getTags($tmpl, $prefix="cms") {
    if (file_exists($tmpl)) {
      $fh = fopen($tmpl, "r");
      if (filesize($tmpl) > 0) {
        $template = fread($fh, filesize($tmpl));
      }
      fclose($fh);
    } else {
      $template = $tmpl;
    }

    $tags = array();
    $matches = array();
    $needle = "/<\/?" . $prefix . ":([a-zA-Z0-9]*)( [^>]*)?>/";
    preg_match_all($needle, $template, $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
      array_push($tags, Tag::getInstance($match[0]));
    }
    return $tags;
  }

}
