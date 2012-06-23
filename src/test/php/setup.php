<?php

$testRoot = dirname(__FILE__);
$srcRoot = "$testRoot/../../main/php";

require_once "$testRoot/../lib/simpletest/simpletest.php";
require_once "$testRoot/HtmlShowPassReporter.class.php";

/* Enable this to see passing assertions - verbose */
//SimpleTest::prefer(new HtmlShowPassReporter());
