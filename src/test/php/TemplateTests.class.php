<?php

include_once(dirname(__FILE__) . "/setup.php");

require_once "$testRoot/../lib/simpletest/autorun.php";
require_once "$srcRoot/Parser.class.php";
require_once "$srcRoot/Template.class.php";

class TemplateTests extends UnitTestCase {

  function testTemplateConstruction() {
    $templatePath = dirname(__FILE__) . "/../resources/template.html";
    $template = new Template($templatePath);
    $this->assertNotNull($template);
    $this->assertNotNull($template->tags());
    $this->assertEqual($template->tags(), Parser::getTags($templatePath));
  }

}
