<?php

$path = $_SERVER['DOCUMENT_ROOT']."/settings.json";
$json = file_get_contents($path);
$status = json_decode($json, true);

return $status['status'];