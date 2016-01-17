<?php
include('connection.php');
include('functions.php');

try{
$firstName = $_POST['first_name'];
$ID = $_POST['ID'];

$query = "select * from goal2.user where user_id='$ID'";
$stmt = $connection->prepare($query);
$res = $stmt->execute();
$count = $stmt->rowCount();

$response = array();

if($count == 0)
{
	$response["result"] = "error";
	$response["data"] = "Invalid Credentials";
}
else
{
	$row = $stmt->fetch();
	if(strcasecmp($firstName,$row["first_name"]) != 0)
	{
		$response["result"] = "error";
		$response["data"] = "First name given do not match";
	}
	else
	{
		$response["result"] = "success";
		$response["data"] = push_server_changes(false,$ID);
	}
}

echo json_encode($response);
}catch(Exception $e)
{
	$exception_response = array();
	$exception_response["result"] = "server_error";
	$exception_response["data"] = json_encode($e);
	
	echo json_encode($exception_response);
}

?>