<?php

include("Parser.class.php");

$parser = new Parser("./template.html", "cms:content");

echo "<pre>";
print($parser->raw());
echo "</pre>";

echo "<pre>";
$tags = $parser->tags();
foreach ($tags as $tag) {
	print_r($tag->attributes());
}
echo "</pre>";
