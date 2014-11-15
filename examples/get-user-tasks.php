<?php
require_once('../asana.php');
error_reporting(E_ALL);
// See class comments and Asana API for full info

$asana = new Asana(array('apiKey' => '1zPU8hPH.vHEjx2kpnRe0j8koRm3XCo0')); // Your API Key, you can get it in Asana
$projectId = '16190544708608'; // Your Project ID Key, you can get it in Asana
$userId = '5557613435774';
if(isset($_GET['user'])){
$userId = $_GET['user'];
}
//echo $userId;
$taskOpts = array('opt_fields'=>"name,due_on,completed");
$filter = array('assignee'=>$userId,'workspace' =>'3745545476284');
$result = $asana->getTasksByFilter($filter,$taskOpts);




// As Asana API documentation says, when response is successful, we receive a 200 in response so...
if ($asana->responseCode != '200' || is_null($result)) {
    echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
    return;
}

$resultJson = json_decode($result);

$payload=array('tasks' => $resultJson, 'userID'=>$userId);
if(isset($_GET['callback'])){
echo $_GET['callback'].'('.json_encode($payload).')';
}else{
	echo '<pre>';
	echo $result;
	echo '</pre>';
}
/*else{
echo $result;

echo '<pre>';
var_dump($resultJson);
echo '</pre>';
}*/
?>