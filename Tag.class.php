<?php

class Tag {

  private $markup = "";
  private $attrs = array();

  function __construct($markup) {
    $this->markup = $markup;
  }

  function __toString() {
    return $this->raw();
  }

  function __call($name, $arguments) {
    $attrs = $this->attributes();
    if (isset($attrs[$name])) {
      return $attrs[$name];
    } else {
      // undefined method error
    }
  }

  function attributes() {
    if (count($this->attrs) > 0) { return $this->attrs; }

    $attrs = array();
    $matches = array();
    $needle = '/[a-zA-Z]*="[^"]*"/';
    preg_match_all($needle, $this->markup, $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
      $parts = explode('=', $match[0], 2);
      $attrs[$parts[0]] = $parts[1];
    }
    $this->attrs = $attrs;

    return $attrs;
  }

  function raw() {
    return htmlentities($this->markup);
  }

}
