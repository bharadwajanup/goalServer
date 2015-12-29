<?php
include('connection.php');
include('functions.php');
include('tables.php');

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
	$res = array();
	foreach($tables as $table)
	{
		$res[$table] = return_results_as_json("select * from test.".$table,$connection);
		$connection->query("update test.".$table." set server_push=0");
	}
	$res_json = json_encode($res);
	echo $res_json;
}
else
{
	echo "Invalid Request";
}

?>