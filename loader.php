<?php
$appPath = implode("/", [ dirname(__FILE__), "app/" ]);

foreach (scandir($appPath) as $filename) {
    if($filename == "." || $filename == "..") continue;

    $path = $appPath . $filename;
    if (is_file($path)) {
        require_once $path;
    }
}