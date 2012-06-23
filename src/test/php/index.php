<?php

$testRoot = dirname(__FILE__);
$srcRoot = "$testRoot/../../main/php";

require_once "$testRoot/../lib/simpletest/simpletest.php";
require_once "$testRoot/HtmlShowPassReporter.class.php";

/* Enable this to see passing assertions - verbose */
//SimpleTest::prefer(new HtmlShowPassReporter());

/* Include files with Test classes to execute them */
require_once "$testRoot/ParserTests.class.php";

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
