<?php
header('Content-Type: application/json');
$id = intval($_GET['id']);

$filter = ['id' => strval($id)];
$options = ["projection" => ['_id' => 0]];

$mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
$query = new MongoDB\Driver\Query($filter, $options);
$rows = $mng->executeQuery("nobel.laureates", $query);
$laureate_array = current($rows -> toArray());
echo(json_encode($laureate_array, JSON_PRETTY_PRINT));
?>
