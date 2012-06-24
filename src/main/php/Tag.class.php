<?php

class Tag {

  private $markup = "";
  private $attrs = array();
  private $processed = false;

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
    if (count($this->processed) === true) { return $this->attrs; }

    $attrs = array();
    $matches = array();
    $needle = '/[a-zA-Z]*="[^"]*"/';
    preg_match_all($needle, $this->markup, $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
      $parts = explode('=', $match[0], 2);
      $attrs[$parts[0]] = preg_replace('/"([^"]*)"/', '${1}', $parts[1]);
    }
    $this->attrs = $attrs;
    $this->processed = true;

    return $attrs;
  }

  function raw() {
    return htmlentities($this->markup);
  }

  /**
   * Gets an instance of Tag dependent on $kind with attributes defined by $markup
   * @param $kind - String - Type of tag, after prefix in the markup
   * @param $markup - String - Full markup of the tag
   * @return an instance of Tag dependent on $kind
   */
  public static function getInstance($kind, $markup) {
    return new Tag($markup);
  }

}
