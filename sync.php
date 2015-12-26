<?php
include('connection.php');
include('functions.php');
$mode = $_POST['syncMode'];

if($mode == "CS")
{
$userTable = $_POST['userTable'];


$userArray = json_decode($userTable,true);

$insertCounter=0;
$updateCounter=0;


foreach($userArray as $user)
{
	$id = $user["user_id"];
	$name = $user["user_name"];
	$email = $user["user_email"];
	$query = "Select * from test.user where user_id='$id'";
	$stmt = $connection->prepare($query);
	$res = $stmt->execute();
	$count = $stmt->rowCount();
	if($count ==0)
	{
		$query = "insert into test.user(user_id,user_email,user_name) values ('$id','$email','$name')";
		$insertCounter++;
	}
	else
	{
		$query = "update test.user set user_email = '$email', user_name = '$name' where user_id = '$id'";
		$updateCounter++;
	}
	$connection->query($query);
}



//echo "$insertCounter rows inserted. $updateCounter rows updated.";

echo_results_as_json("select * from test.user where server_push=1",$connection);
$connection->query("update test.user set server_push=0");
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