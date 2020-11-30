<?php

// Allow CORS
header("Access-Control-Allow-Origin: *");

require_once "../loader.php";

$myPath = dirname($_SERVER['PHP_SELF']);
$queryPath = str_replace($myPath, "", $_SERVER['REQUEST_URI']);
if(substr($queryPath, 0, 1) == "/") $queryPath = substr($queryPath, 1);
if(substr($queryPath, -1, 1) == "/") $queryPath = substr($queryPath, 0, -1);

$queryParts = explode("/", $queryPath);
$last = $queryParts[count($queryParts)-1];

$config = new \App\Config();

try {
    $db = new \App\Database($config->user, $config->password, $config->database);
    $window = new \App\Window($db, $config->imagePath);
    $counter = new \App\Counter($db);

    if(count($queryParts) == 1 && $queryParts[0] == "visitors") {
        $v = $counter->getVisitors();
        foreach($v as $year => $visitors) {
            echo $year . " : " . $visitors;
        }
    }
    else if($last == "thumb" && count($queryParts) == 3) {
        // Getting a thumb
        $window->thumb(["year" => $queryParts[0], "day" => $queryParts[1]]);
    }
    else if(count($queryParts) == 2) {
        // Add visitor counter
        $counter->newVisitor();
        
        // getting the main image
        $window->get(["year" => $queryParts[0], "day" => $queryParts[1]]);
    }
    else {
        throw new \App\HttpErrorCodeException(404);
    }
} catch(\App\HttpErrorCodeException $ex) {
    $code = $ex->httpError;
    echo $code;
    http_response_code($code);
}