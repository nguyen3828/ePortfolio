<?php
/**************************************
 * File Name: Vehicle.php
 * User: Hieu Nguyen
 * Date: 2019-11-27
 * Project: vehicleEntityAndAPI
 **************************************/
require_once 'ORM/Entity.php';

class Vehicle extends ORM\Entity
{
    public $vehicleID;
    public function validate_vehicleID(){
        $validationResult=[];
        if(!is_int($this->vehicleID) || $this->vehicleID < 0){
            $validationResult['vehicleID'] = 'VehicleID must be an integer greater than 0';
        }
        return $validationResult;
    }
    public $make;
    public function validate_make(){
        $validationResult=[];
        if(strlen(trim($this->make)) > 25 || strlen(trim($this->make)) <= 0 ){
            $validationResult['make'] = 'make cannot be empty, or have more than 25 characters';
        }
    }
    public $model;
    public function validate_model(){
        $validationResult=[];
        if(strlen(trim($this->model)) > 25 || strlen(trim($this->model)) <= 0 ){
            $validationResult['model'] = 'model cannot be empty, or have more than 25 characters';
        }
    }
    public $type;
    private $types=['Sedan', 'Compact', 'Cross Over', 'Truck'];
    public function validate_Type(){
        if(strlen(trim($this->type)) > 10 || strlen(trim($this->type)) <= 0 ){
            $validationResult['model'] = 'model cannot be empty, or have more than 10 characters';
        }
        elseif(!in_array(strlen(trim($this->type)), $this->types)){ //https://www.php.net/manual/en/function.in-array.php check if the array contains the value
            $validationResult['model'] = 'type must be: ' . $this->arrayToString();
        }
    }

    /**
     * this is a helper method that will loop through the types array, and concatenate all the values into a string for output
     * @return string concatenated from the array
     */
    public function arrayToString(){
        $resultString ='';
        foreach($this->types as $value){
            $resultString .= $value . ' ';
        }
        return trim($resultString);
    }
    public $year;
    public function validate_year(){
        $validationResult=[];
        $maxValidYear = (intval(date('Y')) + 2);
        //date('Y') will return the current year
        //date cannot be smaller than 1970
        //Source: https://www.w3schools.com/php/php_date.asp, https://www.w3schools.com/php/phptryit.asp?filename=tryphp_date_copyright
        //the intval() function will convert the return type of date() into an integer https://www.php.net/manual/en/function.intval.php
        if(!is_int($this->year) || $this->year <=  $maxValidYear){
            $validationResult['year'] = 'year must be a four digits number between 1970 to ' . $maxValidYear ;
        }
        return $validationResult;
    }


    public function __construct()
    {
        $this->addColumnDefinition('vehicleID', 'INTEGER', 'PRIMARY KEY AUTOINCREMENT');
        $this->addColumnDefinition('make', 'VARCHAR(25)', 'NOT NULl');
        $this->addColumnDefinition('model', 'VARCHAR(25)', 'NOT NULL');
        $this->addColumnDefinition('type', 'VARCHAR(10)', 'NOT NULL');
        $this->addColumnDefinition('year', 'INTEGER(4)', 'NOT NULL');
    }

}