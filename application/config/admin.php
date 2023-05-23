<?php

$path = $_SERVER['DOCUMENT_ROOT']."/settings.json";
$json = file_get_contents($path);
$admin = json_decode($json, true);

return $admin['admin'];