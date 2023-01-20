<?php
// this will be your backend
// some things this file should do
// get query string 
// handle get requests
// open and read data.csv file
// handle post requests
// (optional) write to csv file. 
// format data into an array of objects 
// return all data for every request. 
// set content type of response.
// return JSON encoded data

require "bootstrap.php";
 
use Src\Controller\GreenController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$id = null;
if(isset($uri[2])){
	$id = (int) $uri[2];
}

$actionMethod = null;
if(isset($uri[3])){
	$actionMethod = $uri[3];	
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

if( $requestMethod === "OPTIONS"){
	// simple return to bypass CORS
	return 0;
}

switch ($uri[1]) {
    case "green":
		$controller = new GreenController($requestMethod, $actionMethod, $id);
		$controller->processRequest();
        break;
    default:
        header("HTTP/1.1 404 Not Found");
        exit();
}