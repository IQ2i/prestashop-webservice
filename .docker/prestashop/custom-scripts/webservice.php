<?php

include('./config/config.inc.php');

// enable webservice
Configuration::updateValue('PS_WEBSERVICE', 1);

// create access
$apiAccess = new WebserviceKey();
$apiAccess->key = '6MBWZM37S6XCZXYT81GD6XD41SKZ14TP';
$apiAccess->save();

// add permissions
$permissions = [
    'addresses' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
    'categories' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
    'combinations' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
    'products' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
];
WebserviceKey::setPermissionForAccount($apiAccess->id, $permissions);
