<?php

$root = realpath(__DIR__ . "/../");

require_once $root . "/vendor/autoload.php";

if (!isset($_SERVER["DOCUMENT_ROOT"]) || !$_SERVER["DOCUMENT_ROOT"]) {
    $DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"] = $root;
}
