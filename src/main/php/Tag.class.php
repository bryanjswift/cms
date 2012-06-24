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
    $this->_attributes();
  }

  function __toString() {
    return $this->_markup();
  }

  function __call($name, $arguments) {
    $attrs = $this->_attributes();
    if (isset($attrs[$name])) {
      return $attrs[$name];
    } else {
      // undefined method error
    }
  }

  function _attributes() {
    if (count($this->processed) === true) { return $this->attrs; }

    $attrs = array();
    $matches = array();
    $needle = '/([a-zA-Z]*)="([^"]*)"/';
    preg_match_all($needle, $this->markup, $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
      $key = $match[1];
      if (in_array($key, Tag::$reserved)) {
        throw new Exception("Tag can't contain value for $key");
      }
      $attrs[$key] = $match[2];
    }
    $this->attrs = $attrs;
    $this->processed = true;

    return $attrs;
  }

  final function kind() {
    return $this->kind;
  }

  final function _markup() {
    return $this->markup;
  }

  final function ns() {
    return $this->ns;
  }

  // *** Static Definitions *** //

  private static $kinds = array();
  public static $reserved = array('ns', 'kind');

  /**
   * Register a Tag type for a given kind
   * @param $kind - String of tags to handle
   * @param $constructor - class name invoked with new keyword if $kind matches when using Tag::getInstance
   * @return true if successfully registered
   */
  public static function registerKind($kind, $constructor) {
    try {
      $r = new ReflectionClass($constructor);
    } catch (Exception $e) {
      throw new Exception("Must be passed a class name");
    }
    if (isset(Tag::$kinds[$kind])) { throw new Exception("Definition already exists for $kind"); }
    Tag::$kinds[$kind] = $constructor;
    return Tag::$kinds[$kind] === $constructor;
  }

  /**
   * Gets an instance of Tag dependent on $kind with attributes defined by $markup
   * @param $markup - String - Full markup of the tag (e.g. <cms:content params="are here" />)
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
