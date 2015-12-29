<?php
include('connection.php');
include('functions.php');

$test = $_POST['tableName'];
$mode = $_POST['syncMode'];


if($mode == "CS")
{
$tableName = $_POST['tableName'];
$tableRows = $_POST['tableRows'];


$rowArray = json_decode($tableRows,true);

$insertCounter=0;
$updateCounter=0;

add_rows_to_table($tableName,$rowArray,$connection);


}
else if($mode == "SC")
{
	echo_results_as_json("select * from test.user",$connection);
	$connection->query("update test.user set server_push=0");
}
else
{
	echo "Invalid Request";
}

?>