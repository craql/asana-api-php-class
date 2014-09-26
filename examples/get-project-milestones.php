<?php
require_once('../asana.php');
error_reporting(E_ALL);
// See class comments and Asana API for full info

$asana = new Asana(array('apiKey' => '1zPU8hPH.vHEjx2kpnRe0j8koRm3XCo0')); // Your API Key, you can get it in Asana
$projectId = '16190544708608'; // Your Project ID Key, you can get it in Asana
$projectId = '14926699560298';

$payload = new stdClass();
//projectID
if(isset($_GET['project'])){
$projectId = $_GET['project'];
}
$payload->projectID=$projectId;


//callback-ajax
if(isset($_GET['callback'])){
	$callback = $_GET['callback'];
}


//echo $projectId;
$result = $asana->getProjectTasks($projectId);

// As Asana API documentation says, when response is successful, we receive a 200 in response so...
if ($asana->responseCode != '200' || is_null($result)) {
    echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
    return;
}


//HANDLE RESPONSE

$resultJson = json_decode($result);
//echo '<br/>';
//echo $result;
//echo '<br/>';

//get

$taskCount = count($resultJson->{'data'});
$tasksArray = $resultJson->{'data'};
$a1=array($resultJson->{'data'});
//echo 'array count = '.$taskCount ;

foreach($tasksArray as $task){
$name = $task->{'name'};
$pos = strrpos($name, "Milestones");
// if($name == "Milestones"){
// $milestoneTask = $task;
// }
if ($pos !== false) {
    $milestoneTask = $task;
}
//echo '<br/>';
//echo $resultJson->{'data'}[$t]["id"];
}


//GET MILESTONES

if(isset($milestoneTask)){
	//echo '<br/><br/>MilestoneTask<br/>';
	//var_dump($milestoneTask);
	//echo '<br/>';
	$taskOpts = array('opt_fields'=>"name,due_on,completed");
	//$taskOpts = array();
	//echo '<br/>'.var_dump($taskOpts).'<br/>';
	$result = $asana->getSubTasks($milestoneTask->{'id'},$taskOpts);

	// As Asana API documentation says, when response is successful, we receive a 200 in response so...
	if ($asana->responseCode != '200' || is_null($result)) {
		echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
		return;
	}
	$resultJson = json_decode($result);
	$payload->milestones=$resultJson->{'data'};
}else{
	$payload->milestones=array();
	$payload->errors=true;
}

//var_dump($payload);
if(isset($_GET['callback'])){
echo $_GET['callback'].'('.json_encode($payload).')';
}else{
	echo '<pre>';
	echo $resultJson;
	echo '</pre>';
}
