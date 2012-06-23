<?php

require_once "$testRoot/../lib/simpletest/reporter.php";

class HtmlShowPassReporter extends HtmlReporter {

  function paintPass($message) {
    parent::paintPass($message);
    print "<span class=\"pass\">Pass</span>: ";
    $breadcrumb = $this->getTestList();
    array_shift($breadcrumb);
    print implode("->", $breadcrumb);
    print "->$message<br />\n";
  }

}
