<?php

require "aps/2/runtime.php";
require "controllers/OS.php";

date_default_timezone_set("UTC");

function logme($title, $var = null) {
    if (gettype($var) == "string") {
        error_log("\n\[OpenStack] ==> [$title] " . $var);
    } else {
        error_log("\n\[OpenStack] ==> [$title] " . (is_null($var) ? "" : json_encode($var, true)));
    }
}
