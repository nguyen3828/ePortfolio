<?php
/**************************************
 * File Name: createtable.php
 * User: Hieu Nguyen
 * Date: 2019-11-27
 * Project: vehicleEntityAndAPI
 **************************************/
require_once '../../lib/Vehicle.php';
require_once '../../lib/ORM/Repository.php';
require_once  '../../lib/Vehicle.php';
$db = new SQLite3('vehicle.db');
$repo = new \ORM\Repository('vehicle.db');

$vehicle = new Vehicle();
$entity[] = $vehicle;
$command = $repo->createTables($entity);

foreach($command as $sql){
    $db ->exec($sql);
}


