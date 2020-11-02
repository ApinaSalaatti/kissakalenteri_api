<?php

//echo $_SERVER['REQUEST_URI'];

$myPath = dirname($_SERVER['PHP_SELF']);
$queryPath = str_replace($myPath, "", $_SERVER['REQUEST_URI']);

echo "my path: " . $myPath . "<br>";
echo "request uri: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "query: " . $queryPath;

$uriParts = explode("/", $_SERVER['REQUEST_URI']);
$last = $uriParts[count($uriParts)-1];

if($last == "thumb") {
    
}
else {

}