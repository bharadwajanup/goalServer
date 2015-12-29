<?php
include('gcm_server_key.php');

function echo_results_as_json($query, $connection)
{
	try
	{
	$results = array();
	$results_json;
	foreach($connection->query($query) as $v)
	{
	$results[] = $v;
	}
	$results_json = json_encode($results);

	echo $results_json;
	}catch(Exception $e)
	{
		echo "Error while executing query\n";
	}
}

function add_rows_to_table($tableName,$rowArray,$connection)
{
	switch($tableName)
	{
		case "user": add_rows_to_user_table($rowArray,$connection);break;
		default: echo "Invalid table name";
	}
}

function add_rows_to_user_table($rowArray,$connection)
{
	foreach($rowArray as $user)
	{
	  $id = $user["user_id"];
	  $firstName = $user["first_name"];
	  $lastName = $user["last_name"];
	  $type = $user["type"];
	  $age = $user["age"];
	  $phone = $user["phone"];
	  $gender = $user["gender"];
	  $program = $user["program"];
	  $rewards_count = $user["rewards_count"];
	  
	  
	  $query = "Select * from test.user where user_id='$id'";
	  $stmt = $connection->prepare($query);
	  $res = $stmt->execute();
	  $count = $stmt->rowCount();
	  if($count ==0)
	  {
		  $query = "insert into test.user(user_id,first_name,last_name,type,age,phone,gender,program,rewards_count) values ('$id','$firstName','$lastName','$type','$age','$phone','$gender','$program','$rewards_count')";
		//  $insertCounter++;
	  }
	  else
	  {
		  $row = $stmt->fetch();
		  $server_push_flag = $row["server_push"];
		  if($server_push_flag == 0 || $server_push_flag == "0") //Update only if there has been no manual change done from the backend for this row...
		  	$query = "update test.user set first_name = '$firstName',first_name = '$firstName', last_name = '$lastName', type = '$type', age = '$age', phone = '$phone', gender = '$gender', program = '$program'  where user_id = '$id'";
		//The server changes always take higher precedence and that change will be pushed to the client.
		  //$updateCounter++;
	  }
	  $connection->query($query);
	}



//echo "$insertCounter rows inserted. $updateCounter rows updated.";

echo_results_as_json("select * from test.user where server_push=1",$connection);
$connection->query("update test.user set server_push=0 where server_push=1");

}
function send_notification($registrationIds, $message, $type)
{
	// prep the bundle
	$msg = array
	(
		'message' 	=> $message,
		'type' => $type
	);
	$fields = array
	(
		'registration_ids' 	=> $registrationIds,
		'data'			=> $msg
	);
 
	$headers = array
	(
		'Authorization: key=' . API_ACCESS_KEY,
		'Content-Type: application/json'
	);
 
	$ch = curl_init();
	curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
	curl_setopt( $ch,CURLOPT_POST, true );
	curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	$result = curl_exec($ch );
	curl_close( $ch );
	$response = json_decode($result,true);
	//TODO: Error handling...
}


?>