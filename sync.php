<?php
include('connection.php');
include('functions.php');


$mode = $_POST['syncMode'];
$user_id = $_POST['user_id'];


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

	
	echo push_server_changes(false,$user_id);
}
else
{
	echo "Invalid Request";
}

?>