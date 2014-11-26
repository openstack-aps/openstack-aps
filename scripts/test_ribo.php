<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
function p($text){ echo "<pre>"; print_r($text); echo "</pre>"; }
require_once 'controllers/OSApi.php';
echo "Test api Open Stack<br>";


$api = new OSApi('http://176.74.221.57', 'admin', 'parallels0');


date_default_timezone_set("UTC");


//p($api->getTenants());
 
//p($api->createTenant("prueba mamasuwadawd", "desc ", true));

p($api->getImageDetails("1ef78068-e94d-4e96-a3ae-c4fb3d0b8119"));

