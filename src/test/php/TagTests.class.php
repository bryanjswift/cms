<?php

include_once(dirname(__FILE__) . "/setup.php");

require_once "$testRoot/../lib/simpletest/autorun.php";
require_once "$srcRoot/Tag.class.php";
require_once "$testRoot/MockTag.class.php";

class TagTests extends UnitTestCase {

  function testTagParsing() {
    $markup = '<cms:content key="test" value="test value" />';
    $tag = Tag::getInstance($markup);
    $this->assertNotNull($tag);
    $this->assertEqual($tag->key(), "test");
    $this->assertEqual($tag->value(), "test value");
  }

  function testExceptionForTemplateContainingKind() {
    $this->expectException(new Exception("kind is reserved. Tag can't contain value for kind"));
    $markup = '<cms:content kind="what kind is it?" />';
    $tag = Tag::getInstance($markup);
  }

  function testExceptionForTemplateContainingNs() {
    $this->expectException(new Exception("ns is reserved. Tag can't contain value for ns"));
    $markup = '<cms:content ns="namespace" />';
    $tag = Tag::getInstance($markup);
  }

  function testTagParsesNamespaceAndKind() {
    $markup = '<cms:content id="test" />';
    $tag = Tag::getInstance($markup);
    $this->assertNotNull($tag);
    $this->assertEqual($tag->id(), "test");
    $this->assertEqual($tag->ns(), "cms");
    $this->assertEqual($tag->kind(), "content");

    $markup = '<hi:there id="test" />';
    $tag = Tag::getInstance($markup);
    $this->assertNotNull($tag);
    $this->assertEqual($tag->id(), "test");
    $this->assertEqual($tag->ns(), "hi");
    $this->assertEqual($tag->kind(), "there");
  }

  function testRegisterKindHappy() {
    $this->assertTrue(Tag::registerKind('mock', 'MockTag'));
    $tag = Tag::getInstance('<cms:mock id="hi" />');
    $this->assertEqual(get_class($tag), 'MockTag');
  }

  function testRegisterKindNonExistantClass() {
    $this->expectException(new Exception("Must be passed a class name"));
    Tag::registerKind('dummy', 'DummyTag');
  }

  function testExceptionWhenRegisteringExistingKind() {
    $kind = 'dummy';
    $this->expectException(new Exception("Definition already exists for $kind"));
    Tag::registerKind($kind, 'MockTag');
    Tag::registerKind($kind, 'MockTag');
  }

  function testFalseForUnknownAttribute() {
    $markup = '<hi:there id="test" />';
    $tag = Tag::getInstance($markup);
    $this->assertNotNull($tag);
    $this->assertTrue($tag->oh() === false);
  }

}
