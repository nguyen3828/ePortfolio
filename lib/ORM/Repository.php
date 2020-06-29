<?php
namespace ORM;

spl_autoload_register(function($entityClassName){
    require_once '../' . $entityClassName . '.php';
});

class Repository extends \SQLite3
{
    private $lastStatement;

    public function getLastStatement()
    {
        return $this->lastStatement;
    }

    public function createTables($entities)
    {
        $results=[];
        foreach ($entities as $entity){
            $tableName = $entity->getClassName();
            $this->lastStatement = "DROP TABLE IF EXISTS $tableName";
            if(!$this->exec($this->lastStatement)){
                $results[$tableName] = 'ERROR: ' . $this->lastStatement;
            }else{
                $columnString = implode(',' . PHP_EOL, $entity->getColumnDefinitions());
                $this->lastStatement = "CREATE TABLE $tableName ($columnString)";
                $results[$tableName] = $this->exec($this->lastStatement) ? 1 : 'ERROR: ' . $this->lastStatement;
            }
        }
        return $results;
    }

    public function insert($entity) {
        if(count($entity->validate())){return -2;}

        $tableName = $entity->getClassName();
        $autoFields = $entity->getAutoIncrementColumnDefinitions();
        $filteredProperties = array_diff_key(get_object_vars($entity), $autoFields );

        $fieldString = implode(',', array_keys($filteredProperties));
        $qMarkString = str_repeat('?,', count($filteredProperties)-1) . '?';

        $this->lastStatement = "INSERT INTO $tableName ($fieldString) VALUES($qMarkString)";
        $stmt=$this->prepare($this->lastStatement);
        if(!$stmt){return -1;}

        $i = 1;
        foreach($filteredProperties as $field=>$val){
            $this->lastStatement .= " [$i:$field=$val] ";
            $stmt->bindValue($i++,$val,$entity->getBindType($field));
        }


        $result = $stmt->execute();
        if($result){
            $autoID = $this->lastInsertRowID();
            foreach (array_keys($autoFields) as $field){
                $entity->$field = $autoID;
            }
        }
        $stmt->close();
        return $result ? 1: 0;

    }

    public function select($entity)
    {
        $tableName = $entity->getClassName();
        $properties = get_object_vars($entity);

        $fieldString = implode(',', array_keys($properties));
        $filteredProperties = array_filter($properties);
        $whereString = empty($filteredProperties)? ' 1=1 ': implode('=? AND ', array_keys($filteredProperties)) . '=?';

        $this->lastStatement = "SELECT $fieldString FROM $tableName WHERE $whereString";
        $stmt=$this->prepare($this->lastStatement);
        if(!$stmt){return -1;}

        $i = 1;
        foreach($filteredProperties as $field=>$val){
            $this->lastStatement .= " [$i:$field=$val] ";
            $stmt->bindValue($i++,$val,$entity->getBindType($field));
        }

        $result = $stmt->execute();
        if(!$result){
            $stmt->close();
            return 0;
        }


        $entityArray=[];
        while ($tableRow = $result->fetchArray(SQLITE3_ASSOC)) {
            $entityArray[] = (new $tableName())->parseArray($tableRow);
        }
        $stmt->close();
        return $entityArray;
    }


    public function update($entity)
    {
        if(count($entity->validate())){return -2;}
       
        $properties = get_object_vars($entity);
        $pkName = $entity->getPkName();

        unset($properties[$pkName]);
        $setString = implode('=?, ',array_keys($properties)).'=?';

        $this->lastStatement = "UPDATE {$entity->getClassName()} SET $setString WHERE $pkName=?";
        $stmt=$this->prepare($this->lastStatement);
        if(!$stmt){return -1;}

        $i = 1;
        foreach($properties as $field=>$val){
            $this->lastStatement .= " [$i:$field=$val] ";
            $stmt->bindValue($i++,$val,$entity->getBindType($field));
        }

        $this->lastStatement .= " [$i:$pkName={$entity->$pkName}] ";
        $stmt->bindValue($i,$entity->$pkName,$entity->getBindType($pkName));


        $result = $stmt->execute();
        $stmt->close();
        return $result ? 1: 0;

    }

    public function delete($entity){
        $pkName = $entity->getPkName();

        $this->lastStatement="DELETE FROM {$entity->getClassName()} WHERE $pkName=?";
        $stmt = $this->prepare($this->lastStatement);
        if(!$stmt){return -1;}

        $this->lastStatement .= " [1:$pkName={$entity->$pkName}] ";
        $stmt->bindValue(1,$entity->$pkName,$entity->getBindType($pkName));

        $result =$stmt->execute();
        $stmt->close();
        return $result ? 1: 0;
    }

}