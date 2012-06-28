<?php

require_once("BasicTag.class.php");

abstract class Tag {

  private $attrs = array();
  private $kind = "";
  private $ns = "";
  private $processed = false;

  protected function __construct($ns, $kind, $attrs) {
    $this->ns = $ns;
    $this->kind = $kind;
    $this->attrs = $attrs;
  }

  function __toString() {
    return $this->_markup();
  }

  function __call($name, $arguments) {
    $attrs = $this->attrs;
    if (isset($attrs[$name])) {
      return $attrs[$name];
    } else {
      return false;
    }
  }

  final function kind() {
    return $this->kind;
  }

  final function ns() {
    return $this->ns;
  }

  abstract public function form();

  // *** Static Definitions *** //

  private static $kinds = array();
  public static $reserved = array('ns', 'kind', 'form');

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
    $attrs = Tag::getAttributes($markup);
    if (isset(Tag::$kinds[$kind])) {
      $constructor = Tag::$kinds[$kind];
      return new $constructor($ns, $kind, $attrs);
    } else {
      return new BasicTag($ns, $kind, $attrs);
    }
  }

  /**
   * Gets map of attributes to attribute values in $markup
   * @param $markup - String - Full markup of the tag (e.g. <cms:content params="are here" />)
   * @return Array of attributes and values in tag
   */
  private static function getAttributes($markup) {
    $attrs = array();
    $matches = array();
    $needle = '/([a-zA-Z]*)="([^"]*)"/';
    preg_match_all($needle, $markup, $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
      $key = $match[1];
      if (in_array($key, Tag::$reserved)) {
        throw new Exception("$key is reserved. Tag can't contain value for $key");
      }
      $attrs[$key] = $match[2];
    }

    return $attrs;
  }

}
