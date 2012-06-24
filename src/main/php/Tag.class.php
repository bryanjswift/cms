<?php

require_once("BasicTag.class.php");

abstract class Tag {

  private $attrs = array();
  private $kind = "";
  private $markup = "";
  private $ns = "";
  private $processed = false;

  protected function __construct($ns, $kind, $markup) {
    $this->ns = $ns;
    $this->kind = $kind;
    $this->markup = $markup;
  }

  function __toString() {
    return $this->markup();
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
    $needle = '/([a-zA-Z]*)="([^"]*)"/';
    preg_match_all($needle, $this->markup, $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
      $attrs[$match[1]] = $match[2];
    }
    $this->attrs = $attrs;
    $this->processed = true;

    return $attrs;
  }

  function kind() {
    return $this->kind;
  }

  function markup() {
    return $this->markup;
  }

  function ns() {
    return $this->ns;
  }

  private static $kinds = array();

  public static function registerKind($kind, $constructor) {
    Tag::$kinds[$kind] = $constructor;
  }

  /**
   * Gets an instance of Tag dependent on $kind with attributes defined by $markup
   * @param $kind - String - Type of tag, after prefix in the markup
   * @param $markup - String - Full markup of the tag
   * @return an instance of Tag dependent on $kind
   */
  public static function getInstance($markup) {
    $needle = '/^<([_a-zA-Z0-9]*):([_a-zA-Z0-9]*) .*$/';
    $ns = preg_replace($needle, '${1}', $markup);
    $kind = preg_replace($needle, '${2}', $markup);
    if (isset(Tag::$kinds[$kind])) {
      $constructor = Tag::$kinds[$kind];
      return new $constructor($ns, $kind, $markup);
    } else {
      return new BasicTag($ns, $kind, $markup);
    }
  }

}
