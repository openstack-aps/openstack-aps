<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
function p($text){ echo "<pre>"; print_r($text); echo "</pre>"; }
require_once 'controllers/OSApi.php';
echo "Test api Open Stack<br>";

$api = new OSApi('http://176.74.221.57', 'admin', 'parallels0');
date_default_timezone_set("UTC");

$admin_tenant_id = "99623ab4985b41a0ad00ba5f31e07fa0";
$tenant_id = "deba8d9af5a9435aa0040752de6ace24";

p($api->getNetworks());

/*
$request = $api->getLimits($tenant_id);
p($request);*/

?>