<?php

$path = $_SERVER['DOCUMENT_ROOT']."/settings.json";
$json = file_get_contents($path);
$db = json_decode($json, true);

return $db['database'];
