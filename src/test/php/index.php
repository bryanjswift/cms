<?php

require_once "../lib/simpletest/simpletest.php";
require_once "HtmlShowPassReporter.class.php";

/* Enable this to see passing assertions - verbose */
//SimpleTest::prefer(new HtmlShowPassReporter());

/* Include files with Test classes to execute them */
require_once "ParserTests.class.php";

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
