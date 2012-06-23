<?php

include_once "./src/main/php/Parser.class.php";

$parser = new Parser("./src/test/resources/template.html");

echo "<pre>";
print($parser->raw());
echo "</pre>";

echo "<pre>";
$tags = $parser->tags();
foreach ($tags as $tag) {
	print_r($tag->attributes());
}
echo "</pre>";
