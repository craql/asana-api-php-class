<?php
require_once('../asana.php');
error_reporting(E_ALL);
// See class comments and Asana API for full info

$asana = new Asana(array('apiKey' => '1zPU8hPH.vHEjx2kpnRe0j8koRm3XCo0')); // Your API Key, you can get it in Asana
$projectId = '16190544708608'; // Your Project ID Key, you can get it in Asana
$projectId = '14926699560298';

if(isset($_GET['project'])){
$projectId = $_GET['project'];
}
echo $projectId;
$result = $asana->getProjectTasks($projectId);

// As Asana API documentation says, when response is successful, we receive a 200 in response so...
if ($asana->responseCode != '200' || is_null($result)) {
    echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
    return;
}

$resultJson = json_decode($result);

echo $result;

echo '<pre>';
var_dump($resultJson);
echo '</pre>';
