<?php

include_once(dirname(__FILE__) . "/setup.php");

/* Include files with Test classes to execute them */
require_once "$testRoot/ParserTests.class.php";
require_once "$testRoot/TagTests.class.php";
require_once "$testRoot/BasicTagTests.class.php";
require_once "$testRoot/TemplateTests.class.php";

/* Seems un-necessary as tests get run but leaving around in case
 * it stops working
 * /

require_once "../lib/simpletest/autorun.php";

class AllTests extends TestSuite {

  function __construct() {
    parent::__construct();
    $this->add(new ParserTests());
  }

}
/* */
