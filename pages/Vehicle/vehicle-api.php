<?php
/**************************************
 * File Name: vehicle-api.php
 * Date: 2019-10-10/23/2019
 *This file will handle the post, get, delete, and put requests from the vehicle-UI
 *
 **************************************/
sleep(1);
require_once '../../lib/Vehicle.php';
require_once  '../../lib/ORM/Repository.php';

//IF the formdata JS object is not used (in the ui) when posting php will not fill the $_POST
//we have to get the json data from php://input
//$_REQUEST contains all params from  GET and POST - we can check if any params exist in $_REQUEST if not, use PHP://input
$test = $_REQUEST;

$requestData = empty($_REQUEST)? json_decode(file_get_contents('php://input'), true) : $_REQUEST; //telling it to return an associative array


//GET- ALL vehicle from DB
$vehicleDB = new \ORM\Repository('vehicle.db');
$resultToJSONEncode = '';

//checking the request type
switch ($_SERVER['REQUEST_METHOD'])
{
    case 'GET':
        $resultToJSONEncode = handleGetRequest($vehicleDB, $requestData['searchfor']);
        break;
    case 'POST':
        //deserialize json into new vehicle object
        $vehicle = (new Vehicle()) ->parseArray($requestData);
        //call handle post function
        $resultToJSONEncode = handleInsertRequest($vehicle,$vehicleDB);
        break;
    case 'PUT':
        $vehicle = (new Vehicle()) ->parseArray($requestData);
        //get vehicle object from db
        $resultToJSONEncode = handlePutRequest($vehicle,$vehicleDB);
        break;
    default;
        $resultToJSONEncode = 'METHOD NOT SUPPORTED';
        header('http/1.1 405 METHOD NOT ALLOWED');
}
/**
 * This method will be used to search for a specific vehicle if require,
 * but for this assignment since there is no searching function, this method will return
 * all vehicle in the database to be displayed
 * @param $vehicleDB
 * @param $searchString
 * @return mixed
 */
function handleGetRequest($vehicleDB, $searchString)
{
    $vehicle = new Vehicle();
    //if search string is empty or null just pass in the empty vehicle
    //if the search string contains a value then add the wildcard characters and set the value to all text fields in vehicle
    if(!empty($searchString))
    {
        $vehicle->make = '%' . $searchString . '%';
        $vehicle->model = '%' . $searchString . '%';
        $vehicle->type = '%' . $searchString . '%';
        $vehicle->year = '%' . $searchString . '%';
    }
    $result =   $vehicleDB->select($vehicle, true); //use OR instead of AND as a join

    if(!is_array($result)) //Not an array so it means it got -2, -1, or 0 all of them are errors
    {
        header("http/1.1 418 I'm a teapot");
        $result =  $vehicleDB->getLastStatement();
    }
    elseif(empty($result)) //no vehicle meet the criteria
    {
        header("http/1.1 404 Not Found");
    }
    return $result;
}

/**
 * This method will be used to handle the insert request.
 * It will validate the new vehicle, if the new vehicle is valid,
 * it will process to update by calling the insert function in the repository
 * @param $vehicle
 * @param $vehicleDB
 * @return mixed
 */
function handleInsertRequest($vehicle,$vehicleDB)
{
    //at this point we need an ID and a username to save into the database
    $result = $vehicle->validate();
    if(count($result))
    {
        header("http/1.1 422 Unprocessable Entity");
    }
    else if($vehicleDB->insert($vehicle)<1) //database error if less than 1 is returned by insert functions
    {
        header("http/1.1 418 I'm a teapot");
        $result =  $vehicleDB->getLastStatement();
    }
    else
    {
        header("http/1.1 201 Created");
        $result = $vehicle; //to send back the new generated ID and userName
    }
    return $result;
}

//PUT - Edit Vehicle
/**
 * This method will be used to handle the insert request.
 * It will validate the edited vehicle, if the edited vehicle is valid,
 * it will process to update by calling the update function in the repository
 * @param $vehicle
 * @param $vehicleDB
 * @return mixed
 */
function handlePutRequest($vehicle, $vehicleDB)
{
    //validate the input vehicle
    $result = $vehicle->validate();
    if(count($result)) //check if there are any returned errors
    {
        header("http/1.1 422 Unprocessable Entity");
    }
    else if($vehicleDB->update($vehicle)<1) //database error if less than 1 is returned by update function
    {
        header("http/1.1 418 I'm a teapot");
        $result =  $vehicleDB->getLastStatement();
    }
    else
    {
        header("http/1.1 200 OK "); //default status code from most websites
        $result = $vehicle; //to send back the edited Student
    }
    return $result;
}

//OUTPUT JSON
header('Content-type:application/json');
echo json_encode($resultToJSONEncode);
