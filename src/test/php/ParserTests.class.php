<?php

include_once(dirname(__FILE__) . "/setup.php");

require_once "$testRoot/../lib/simpletest/autorun.php";
require_once "$srcRoot/Parser.class.php";

class ParserTests extends UnitTestCase {

  function testParserReadsExistingNotEmptyFile() {
    $templatePath = dirname(__FILE__) . "/../resources/template.html";
    $this->assertTrue(file_exists($templatePath));
    $this->assertTrue(count(Parser::getTags($templatePath)) > 0);
  }

  function testParserReadsExistingEmptyFile() {
    $templatePath = dirname(__FILE__) . "/../resources/empty-template.html";
    $this->assertTrue(file_exists($templatePath));
    $this->assertTrue(count(Parser::getTags($templatePath)) === 0);
  }

  function testParserHandlesNonExistingFile() {
    $templatePath = dirname(__FILE__) . "/../resources/nonexistant-template.html";
    $this->assertFalse(file_exists($templatePath));
    $this->assertTrue(count(Parser::getTags($templatePath)) === 0);
  }

  function testParserReadsEmptyString() {
    $this->assertTrue(count(Parser::getTags("")) === 0);
  }

  function testParserReadsNotEmptyString() {
    $templatePath = dirname(__FILE__) . "/../resources/template.html";
    $this->assertTrue(file_exists($templatePath));

    $fh = fopen($templatePath, "r");
    $template = fread($fh, filesize($templatePath));
    fclose($fh);

    $this->assertTrue(count($template) > 0);
    $this->assertTrue(count(Parser::getTags($template)) > 0);
  }

  function testParserReadsKnownString() {
    $template = '<cms:content id="test" />';
    $tags = Parser::getTags($template);
    $this->assertEqual(count($tags), 1);
  }

  function testParserNamespaceCanBeConfigured() {

$template = <<<EOF
  <cms:content id="test" />
  <cms:content id="fun" />
  <test:content id="test" />
EOF;

    $tags = Parser::getTags($template, "test");
    $this->assertEqual(count($tags), 1);

    $tags = Parser::getTags($template, "cms");
    $this->assertEqual(count($tags), 2);
  }

}
