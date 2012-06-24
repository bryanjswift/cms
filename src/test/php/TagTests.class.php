<?php

include_once(dirname(__FILE__) . "/setup.php");

require_once "$testRoot/../lib/simpletest/autorun.php";
require_once "$srcRoot/Tag.class.php";

class TagTests extends UnitTestCase {

  function testTagParsing() {
    $markup = '<cms:content key="test" value="test value" />';
    $tag = new Tag("cms", "content", $markup);
    $this->assertNotNull($tag);
    $this->assertEqual($tag->key(), "test");
    $this->assertEqual($tag->value(), "test value");
    $this->assertEqual($tag->markup(), $markup);
  }

  function testTagParsesNamespaceAndKind() {
    $markup = '<cms:content id="test" />';
    $tag = Tag::getInstance($markup);
    $this->assertNotNull($tag);
    $this->assertEqual($tag->id(), "test");
    $this->assertEqual($tag->ns(), "cms");
    $this->assertEqual($tag->kind(), "content");
    $this->assertEqual($tag->markup(), $markup);

    $markup = '<hi:there id="test" />';
    $tag = Tag::getInstance($markup);
    $this->assertNotNull($tag);
    $this->assertEqual($tag->id(), "test");
    $this->assertEqual($tag->ns(), "hi");
    $this->assertEqual($tag->kind(), "there");
    $this->assertEqual($tag->markup(), $markup);
  }

}
