<?php

include_once(dirname(__FILE__) . "/setup.php");

require_once "$testRoot/../lib/simpletest/autorun.php";
require_once "$srcRoot/Parser.class.php";

class ParserTests extends UnitTestCase {

  function testParserReadsExistingNotEmptyFile() {
    $templatePath = dirname(__FILE__) . "/../resources/template.html";
    $this->assertTrue(file_exists($templatePath));
    $parser = new Parser($templatePath);
    $this->assertNotNull($parser);
    $this->assertTrue(count($parser->tags()) > 0);
  }

  function testParserReadsExistingEmptyFile() {
    $templatePath = dirname(__FILE__) . "/../resources/empty-template.html";
    $this->assertTrue(file_exists($templatePath));
    $parser = new Parser($templatePath);
    $this->assertNotNull($parser);
    $this->assertTrue(count($parser->tags()) === 0);
  }

  function testParserHandlesNonExistingFile() {
    $templatePath = dirname(__FILE__) . "/../resources/nonexistant-template.html";
    $this->assertFalse(file_exists($templatePath));
    $parser = new Parser($templatePath);
    $this->assertNotNull($parser);
    $this->assertTrue(count($parser->tags()) === 0);
    $this->assertEqual($parser->raw(), $templatePath);
  }

  function testParserReadsEmptyString() {
    $parser = new Parser("");
    $this->assertNotNull($parser);
    $this->assertTrue(count($parser->tags()) === 0);
  }

  function testParserReadsNotEmptyString() {
    $templatePath = dirname(__FILE__) . "/../resources/template.html";
    $this->assertTrue(file_exists($templatePath));

    $fh = fopen($templatePath, "r");
    $template = fread($fh, filesize($templatePath));
    fclose($fh);
    $this->assertTrue(count($template) > 0);

    $parser = new Parser($template);
    $this->assertNotNull($parser);
    $this->assertTrue(count($parser->tags()) > 0);
  }

}
