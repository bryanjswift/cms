<?php

include_once(dirname(__FILE__) . "/setup.php");

require_once "$testRoot/../lib/simpletest/autorun.php";
require_once "$srcRoot/Tag.class.php";

class TagTests extends UnitTestCase {

  function testTagParsing() {
    $markup = '<cms:content key="test" value="test value" />';
    $tag = new Tag($markup);
    $this->assertNotNull($tag);
    $this->assertEqual($tag->key(), "test");
    $this->assertEqual($tag->value(), "test value");
    $this->assertEqual($tag->markup(), $markup);
  }

}
