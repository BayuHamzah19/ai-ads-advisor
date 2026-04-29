<?php
require 'vendor/autoload.php';
use Illuminate\Support\Facades\Http;

$apiKey = 'AIzaSyByebPAM4px31bJNiJWHnDvzhqs-2iH95Y';
$url = "https://generativelanguage.googleapis.com/v1/models?key={$apiKey}";

$response = file_get_contents($url);
echo $response;
