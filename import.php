<?php
require_once "loader.php";

$config = new \App\Config();

$db = new \App\Database("root", "", "kissakalenteri");

$inputFolder = $config->importPath;
$targetFolder = $config->imagePath;

$incoming = scandir($inputFolder);

$days = [];

foreach($incoming as $i) {
    if($i == "." || $i == "..") continue;

    $withoutExtension = explode(".", $i)[0];

    $parts = explode("_", $withoutExtension);
    $y = $parts[0];
    $d = $parts[1];
    $isThumb = strpos($i, "_t") !== false;
    $key = $y . "_" . $d;

    if(!isset($days[$key])) $days[$key] = [
        "year" => $y,
        "day" => $d,
        "thumb" => null,
        "image" => null
    ];

    if($isThumb) $days[$key]["thumb"] = $i;
    else $days[$key]["image"] = $i;
}

foreach($days as $key => $data) {
    $i = $data["image"];
    $t = $data["thumb"];
    $y = $data["year"];
    $d = $data["day"];

    rename($inputFolder . $i, $targetFolder . $i);
    rename($inputFolder . $t, $targetFolder . $t);

    $db->query("INSERT INTO window_images(year, day, filename, thumb_filename) values($y, $d, '$i', '$t');");
}