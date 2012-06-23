<?php

require_once "../lib/simpletest/autorun.php";

class ParserTests extends UnitTestCase {

  function testLoadExistingFile() {
    $this->assertTrue(file_exists("../resources/template.html"));
  }

}
