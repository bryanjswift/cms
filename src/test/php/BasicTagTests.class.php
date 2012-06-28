<?php

include_once(dirname(__FILE__) . "/setup.php");

require_once "$testRoot/../lib/simpletest/autorun.php";
require_once "$srcRoot/BasicTag.class.php";

class BasicTagTests extends UnitTestCase {

  function testTagReturnsTextFormField() {
    $markup = '<cms:content id="test" />';
    $tag = Tag::getInstance($markup);
    $field = $tag->form();
    $this->assertNotNull($field);
    $this->assertEqual('<input type="text" name="test" />', $field);
  }

  function testTagReturnsTextareaFormField() {
    $markup = '<cms:content id="test" type="textarea" />';
    $tag = Tag::getInstance($markup);
    $field = $tag->form();
    $this->assertNotNull($field);
    $this->assertEqual('<textarea name="test"></textarea>', $field);
  }

}
