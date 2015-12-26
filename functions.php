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