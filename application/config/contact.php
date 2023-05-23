<?php

$path = $_SERVER['DOCUMENT_ROOT']."/settings.json";
$json = file_get_contents($path);
$contact = json_decode($json, true);

return $contact['contact'];
