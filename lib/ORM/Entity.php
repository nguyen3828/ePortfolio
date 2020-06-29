<?php
namespace ORM;


abstract class Entity
{
    
    private $pkName = 'rowid';
    protected $displayNames =[]; 
    private $bindTypes=[];
    private $columnDefinitions=[];

    public function getPkName(): string
    {
        return $this->pkName;
    }

    public function getClassName(){
        return get_class($this);
    }

    public function getDisplayName($field){
        return isset($this->displayNames[$field])? $this->displayNames[$field] : $field;
    }

    public function getBindType($field){
        return isset($this->bindTypes[$field])? $this->bindTypes[$field] : SQLITE3_TEXT;
    }

    public function getColumnDefinitions()
    {
        return $this->columnDefinitions;
    }

    public function getAutoIncrementColumnDefinitions()
    {
        $result = preg_grep('/AUTOINCREMENT/i', $this->columnDefinitions);
        return $result? $result : [];
    }

    protected function addColumnDefinition($field,$type,$description=''){

        $type = strtoupper($type);
        $description = strtoupper($description);

        if(strpos($description,'PRIMARY KEY')>-1){$this->pkName=$field;}

        $this->columnDefinitions[$field] = "$field $type $description";

        $bindType=null;
        switch ( strtok($type,'(') )
        {
            case 'INTEGER':
            case 'BIGINT':
            case 'BOOLEAN':
                $bindType = SQLITE3_INTEGER;
                break;

            case 'REAL':
            case 'FLOAT':
            case 'DECIMAL':
            case 'DOUBLE':
                $bindType =  SQLITE3_FLOAT;
                break;

            case 'BLOB':
                $bindType =  SQLITE3_BLOB;
                break;

            default:
                $bindType =  SQLITE3_TEXT;
                break;
        }

        $this->bindTypes[$field] = $bindType;
    }

    public function parseArray($array)
    {
         foreach (array_intersect_key($array, get_object_vars($this)) as $field=>$valFromArray){
            $this->$field = $valFromArray;
        }
        return $this;
    }

    public function validate()
    {
        $errorsArray =[];
        foreach (get_class_methods($this) as $functionName){
            if(strpos($functionName,'validate_')===0) {
                $errorsArray = array_merge($errorsArray, call_user_func([$this, $functionName]));
            }
        }
        return $errorsArray;
    }

}