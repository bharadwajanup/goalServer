<?php
include('gcm_server_key.php');
include('tables.php');

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
		echo "Error while executing query with value $query\n";
	}
}

function return_results_as_json($query, $connection)
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

	return $results_json;
	}catch(Exception $e)
	{
		echo "Error while executing query with value $query\n";
	}
}

function add_rows_to_table($tableName,$rowArray,$connection)
{
	switch($tableName)
	{
		case "user": add_rows_to_user_table($rowArray,$connection);break;
		case "user_goal": add_rows_to_user_goal_table($rowArray,$connection);break;
		case "activity" : add_rows_to_activity_table($rowArray); break;
		case "user_steps": add_rows_to_user_steps_table($rowArray); break;
		case "activity_entry": add_rows_to_activity_entry_table($rowArray);break;
		case "nutrition_entry":add_rows_to_nutrition_entry_table($rowArray);break;
		default: echo "Invalid table name $tableName";
	}
}

function add_rows_to_activity_entry_table($rowArray)
{
		$connection = $GLOBALS["connection"];
		
		foreach($rowArray as $activityEntry)
		{
			$id = $activityEntry["activity_entry_id"];
			$goalId = $activityEntry["goal_id"];
			$activityId = $activityEntry["activity_id"];
			$timestamp = $activityEntry["timestamp"];
			$rpe = $activityEntry["rpe"];
			$activityLength = $activityEntry["activity_length"];
			$countTowardsGoal = $activityEntry["count_towards_goal"];
			$notes = $activityEntry["notes"];
			$image = $activityEntry["image"];
			$base64Image = $activityEntry["base64Image"];
			
			$filename = basename($image); 
			$len = file_put_contents("images/".$filename, base64_decode($base64Image)); //Error handling required here.
			
			
	  $query = "Select * from goal2.activity_entry where activity_entry_id='$id'";
	  $stmt = $connection->prepare($query);
	  $res = $stmt->execute();
	  $count = $stmt->rowCount();
	  if($count ==0)
	  {
		  $query = "INSERT INTO `activity_entry` (`activity_entry_id`, `goal_id`, `activity_id`, `timestamp`, `rpe`, `activity_length`, `count_towards_goal`, `notes`, `image`) VALUES ('$id', '$goalId', '$activityId', '$timestamp', '$rpe', '$activityLength', '$countTowardsGoal', '$notes', '$image')";
		//  $insertCounter++;
	  }
	  else
	  {
		  $row = $stmt->fetch();
		  $server_push_flag = $row["server_push"];
		  if($server_push_flag == 0 || $server_push_flag == "0") //Update only if there has been no manual change done from the backend for this row...
		  	$query = "update goal2.activity_entry set goal_id = '$goalId', activity_id = '$activityId', timestamp='$timestamp', rpe = '$rpe', activity_length = '$activityLength', count_towards_goal = '$countTowardsGoal', notes='$notes', image = '$image' where activity_entry_id = '$id'";
		//The server changes always take higher precedence and that change will be pushed to the client.
		  //$updateCounter++;
	  }
	  $connection->query($query);
	}
	echo push_server_changes(true);
}

function add_rows_to_nutrition_entry_table($rowArray)
{
		$connection = $GLOBALS["connection"];
		
		foreach($rowArray as $NutritionEntry)
		{
			$id = $NutritionEntry["nutrition_entry_id"];
			$goalId = $NutritionEntry["goal_id"];
			$nutritionType = $NutritionEntry["nutrition_type"];
			$timestamp = $NutritionEntry["timestamp"];
			$towardsGoal = $NutritionEntry["towards_goal"];
			$type = $NutritionEntry["type"];
			$atticFood = $NutritionEntry["attic_food"];
			$diary = $NutritionEntry["diary"];
			$vegetable = $NutritionEntry["vegetable"];
			$fruit = $NutritionEntry["fruit"];
			$grain = $NutritionEntry["grain"];
			$waterIntake = $NutritionEntry["water_intake"];
			$notes = $NutritionEntry["notes"];
			$image = $NutritionEntry["image"];
			
			//INSERT INTO `nutrition_entry` (`nutrition_entry_id`, `goal_id`, `nutrition_type`, `timestamp`, `towards_goal`, `type`, `attic_food`, `diary`, `vegetable`, `fruit`, `grain`, `water_intake`, `notes`, `image`, `server_push`) VALUES (NULL, '', '', '', '', '', '', '', '', '', '', '', '', NULL, '')
			
			$query = "Select * from goal2.nutrition_entry where activity_entry_id='$id'";
	  $stmt = $connection->prepare($query);
	  $res = $stmt->execute();
	  $count = $stmt->rowCount();
	  if($count ==0)
	  {
		  $query = "INSERT INTO `nutrition_entry` (`nutrition_entry_id`, `goal_id`, `nutrition_type`, `timestamp`, `towards_goal`, `type`, `attic_food`, `diary`, `vegetable`, `fruit`, `grain`, `water_intake`, `notes`, `image`) VALUES ('$id', '$goalId', '$nutritionType', '$timestamp', '$towardsGoal', '$type', '$atticFood', '$diary', '$vegetable', '$fruit', '$grain', '$waterIntake', '$notes', '$image')";
		//  $insertCounter++;
	  }
	  else
	  {
		  $row = $stmt->fetch();
		  $server_push_flag = $row["server_push"];
		  if($server_push_flag == 0 || $server_push_flag == "0") //Update only if there has been no manual change done from the backend for this row...
		  	$query = "update goal2.nutrition_entry set goal_id = '$goalId', nutrition_type = '$nutritionType', timestamp='$timestamp', towards_goal = '$towardsGoal' type = '$type', vegetable='$vegetable',fruit='$fruit',grain='$grain', water_intake='$waterIntake', notes='$notes', image = '$image' where nutrition_entry_id = '$id'";
		//The server changes always take higher precedence and that change will be pushed to the client.
		  //$updateCounter++;
	  }
	  $connection->query($query);
	}
	echo push_server_changes(true);
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
	  
	  
	  $query = "Select * from goal2.user where user_id='$id'";
	  $stmt = $connection->prepare($query);
	  $res = $stmt->execute();
	  $count = $stmt->rowCount();
	  if($count ==0)
	  {
		  $query = "insert into goal2.user(user_id,first_name,last_name,type,age,phone,gender,program,rewards_count) values ('$id','$firstName','$lastName','$type','$age','$phone','$gender','$program','$rewards_count')";
		//  $insertCounter++;
	  }
	  else
	  {
		  $row = $stmt->fetch();
		  $server_push_flag = $row["server_push"];
		  if($server_push_flag == 0 || $server_push_flag == "0") //Update only if there has been no manual change done from the backend for this row...
		  	$query = "update goal2.user set first_name = '$firstName',first_name = '$firstName', last_name = '$lastName', type = '$type', age = '$age', phone = '$phone', gender = '$gender', program = '$program'  where user_id = '$id'";
		//The server changes always take higher precedence and that change will be pushed to the client.
		  //$updateCounter++;
	  }
	  $connection->query($query);
	}
	echo push_server_changes(true);
}
	
	
	
function add_rows_to_user_goal_table($rowArray,$connection)
{
	foreach($rowArray as $usergoal)
	{  
	  $id = $usergoal["goal_id"];
	  $user_id = $usergoal["user_id"];
	  $timestamp = $usergoal["timestamp"];
	  $type = $usergoal["type"];
	  $start_date = $usergoal["start_date"];
	  $end_date = $usergoal["end_date"];
	  $weekly_count = $usergoal["weekly_count"];
	  $reward_type = $usergoal["reward_type"];
	  $text = $usergoal["text"];
	  
	  
	  
	  $query = "Select * from user_goal where goal_id='$id'";
	  $stmt = $connection->prepare($query);
	  $res = $stmt->execute();
	  $count = $stmt->rowCount();
	  if($count ==0)
	  {
		  $query = "INSERT INTO `user_goal` (`goal_id`, `user_id`, `timestamp`, `type`, `start_date`, `end_date`, `weekly_count`, `reward_type`, `text`) VALUES ('$id', '$user_id', '$timestamp', '$type', '$start_date', '$end_date', '$weekly_count', '$reward_type', '$text')";
		//  $insertCounter++;
	  }
	  else
	  {
		  $row = $stmt->fetch();
		  $server_push_flag = $row["server_push"];
		  if($server_push_flag == 0 || $server_push_flag == "0") //Update only if there has been no manual change done from the backend for this row...
		  	$query = "update user_goal set user_id = '$user_id',timestamp = '$timestamp', type = '$type', start_date = '$start_date', end_date = '$end_date', weekly_count = '$weekly_count', reward_type = '$reward_type', text = '$text'  where goal_id = '$id'";
		//The server changes always take higher precedence and that change will be pushed to the client.
	  }
	  $connection->query($query);
	}
echo push_server_changes(true);
}

function add_rows_to_activity_table($rowArray)
{
	$connection = $GLOBALS["connection"];
	foreach($rowArray as $activity)
	{
		$id = $activity["activity_id"];
		$user_id = $activity["user_id"];
		$name = $activity["name"];
		$type = $activity["type"];
		$hitCount = $activity["hit_count"];
		$last_used = $activity["last_used"];
		$timestamp = $activity["timestamp"];
		
		
	  $query = "Select * from activity where activity_id='$id'";
	  $stmt = $connection->prepare($query);
	  $res = $stmt->execute();
	  $count = $stmt->rowCount();
	  
	  
	  
	  if($count ==0)
	  {
		  $query = "INSERT INTO `activity` (`activity_id`, `user_id`, `name`, `type`, `hit_count`, `last_used`, `timestamp`, `server_push`) VALUES ('$id', '$user_id', '$name', '$type', '$hitCount', '$last_used', '$timestamp', '0')";
		//  $insertCounter++;
	  }
	  else
	  {
		  $row = $stmt->fetch();
		  $server_push_flag = $row["server_push"];
		  if($server_push_flag == 0 || $server_push_flag == "0") //Update only if there has been no manual change done from the backend for this row...
		  	$query = "update activity set user_id = '$user_id',timestamp = '$timestamp', type = '$type', name = '$name', hit_count = '$hitCount', last_used = '$last_used' where activity_id = '$id'";
		//The server changes always take higher precedence and that change will be pushed to the client.
	  }
	  $connection->query($query);
	}
	echo push_server_changes(true);
}


//INSERT INTO `user_steps` (`steps_id`, `user_id`, `steps_count`, `timestamp`, `server_push`) VALUES (NULL, '', '', '', '0')
function add_rows_to_user_steps_table($rowArray)
{
	$connection = $GLOBALS["connection"];
	foreach($rowArray as $userSteps)
	{
		$id = $userSteps["steps_id"];
		$user_id = $userSteps["user_id"];
		$steps_count = $userSteps["steps_count"];
		$timestamp = $userSteps["timestamp"];
		
		$query = "Select * from user_steps where steps_id='$id'";
	  $stmt = $connection->prepare($query);
	  $res = $stmt->execute();
	  $count = $stmt->rowCount();
	  
	  
	  
	  if($count ==0)
	  {
		  $query = "INSERT INTO `user_steps` (`steps_id`, `user_id`, `steps_count`, `timestamp`, `server_push`) VALUES ('$id', '$user_id', '$steps_count', '$timestamp', '0')";
		//  $insertCounter++;
	  }
	  else
	  {
		  $row = $stmt->fetch();
		  $server_push_flag = $row["server_push"];
		  if($server_push_flag == 0 || $server_push_flag == "0") //Update only if there has been no manual change done from the backend for this row...
		  	$query = "update user_steps set user_id = '$user_id',timestamp = '$timestamp', steps_count = '$steps_count' where steps_id = '$id'";
		//The server changes always take higher precedence and that change will be pushed to the client.
	  }
	  $connection->query($query);
		
	}
	echo push_server_changes(true);
}


function push_server_changes($flagged_rows_only = true,$user_id)
{
	$res = array();
	$tables = $GLOBALS["tables"];
	$connection = $GLOBALS["connection"];
	foreach($tables as $table)
	{
		$query = get_query_for_table($flagged_rows_only,$user_id,$table);
		$res[$table] = return_results_as_json($query,$connection);
		$connection->query("update goal2.".$table." set server_push=0 where server_push=1");
	}
	$res_json = json_encode($res);
	return $res_json;
}


function get_query_for_table($flagged_rows_only,$user_id,$tableName)
{
	$query = "";
	
	if($tableName == "activity_entry" || $tableName == "nutrition_entry")
	{
		if($flagged_rows_only)
		{
			$query = "select * from goal2.".$tableName." where goal_id in (select goal_id from user_goal where user_id = $user_id) and server_push=1";
		}
		else
		{
			$query = "select * from goal2.".$tableName." where goal_id in (select goal_id from user_goal where user_id = $user_id)";
		}
	}
	else
	{
		if($flagged_rows_only)
		{
			$query = "select * from goal2.".$table." where user_id = $user_id and server_push=1";
		}
		else
		{
			$query = "select * from goal2.".$table." where user_id = $user_id";	
		}
	}
	
	return $query;
	
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