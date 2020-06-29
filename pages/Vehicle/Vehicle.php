<?php
/**************************************
 * File Name: Vehicle.php
 * User: cst223
 * Date: 2019-11-27
 * Project: vehicleEntityAndAPI
 **************************************/
require_once 'ORM/Entity.php';

class Vehicle extends ORM\Entity
{
    public $vehicleID;
    public function validate_vehicleID(){
        $validationResult=[];
        if($this->vehicleID == null){
            return $validationResult;
        }
        else if(!is_int($this->vehicleID) || $this->vehicleID < 0 ){
            $validationResult['vehicleID'] = 'VehicleID must be an integer greater than 0';
        }

        return $validationResult;
    }
    public $make;
    public function validate_make(){
        $validationResult=[];
        $this->make = trim($this->make);
        $this->make = trim($this->make);
        if(strlen($this->make) > 25 || strlen($this->make) <= 0 ){
            $validationResult['make'] = 'Make cannot be empty, or have more than 25 characters';
        }
        return $validationResult;
    }
    public $model;
    public function validate_model(){
        $validationResult=[];
        $this->model = trim($this->model);
        if(strlen($this->model) > 25 || strlen($this->model) <= 0 ){
            $validationResult['model'] = 'Model cannot be empty, or have more than 25 characters';
        }
        return $validationResult;
    }
    public $type;
    private $types=['Sedan', 'Compact', 'Cross Over', 'Truck'];
    public function validate_Type(){
         $validationResult=[];
        if(!in_array(trim($this->type), $this->types)){ //https://www.php.net/manual/en/function.in-array.php check if the array contains the value
            $validationResult['type'] = 'Type must be: ' . $this->arrayToString();
        }
        return $validationResult;
    }

    /**
     * this is a helper method that will loop through the types array, and concatenate all the values into a string for output
     * @return string concatenated from the array
     */
    public function arrayToString(){

        $resultString ='';
        foreach($this->types as $value){

            $resultString .=  $this->types[count($this->types)-1] != $value ? $value . ', ' : 'or ' .$value;
        }
        return trim($resultString);
    }
    public $year;
    public function validate_year(){
        $validationResult=[];
        $maxValidYear = (intval(date('Y')) + 2);
        $this->year = trim($this->year);

        //this will check if the year that you input in contains any letter
        //when you first get the year value from the input form, it is being sent as a string
        //we cannot convert it to number immediately because if it contains letter, intval will return a 1
        if($this->year == null || strlen($this->year < 0)) {
          $validationResult['year'] = 'Year cannot be empty, and it must be a four digits number between 1970 and ' . $maxValidYear;
            return $validationResult;
        }

        //date('Y') will return the current year
        //date cannot be smaller than 1970
        //Source: https://www.w3schools.com/php/php_date.asp, https://www.w3schools.com/php/phptryit.asp?filename=tryphp_date_copyright
        //the intval() function will convert the return type of date() into an integer https://www.php.net/manual/en/function.intval.php
        //https://www.regextester.com/99810 checking for invalid special character
        if(preg_match('/[aA-zZ!@#$%^&*(),.?":{}|<>+-]/',$this->year)){
          $validationResult['year']='Invalid Input Type. Year must be a four digits numbers between 1970 and ' . $maxValidYear;
            return $validationResult;
        }
        $this->year = intval($this->year);
        if($this->year >  $maxValidYear || $this->year < 1970){
          $validationResult['year'] = 'Year must be a four digits number between 1970 to ' . $maxValidYear ;
            return $validationResult;
        }

        return $validationResult;

    }

//NOTE: constructor is only needed if you want to create a new vehicle database using the pre-declare columns name and
//column definitions
//
//    public function __construct()
//    {
//        $this->addColumnDefinition('vehicleID', 'INTEGER', 'PRIMARY KEY AUTOINCREMENT');
//        $this->addColumnDefinition('make', 'VARCHAR(25)', 'NOT NULl');
//        $this->addColumnDefinition('model', 'VARCHAR(25)', 'NOT NULL');
//        $this->addColumnDefinition('type', 'VARCHAR(10)', 'NOT NULL');
//        $this->addColumnDefinition('year', 'INTEGER(4)', 'NOT NULL');
//    }

}