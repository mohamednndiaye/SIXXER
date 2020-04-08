<?php


class DatabaseController {
    private $host;
    private $dbName;
    private $user;
    private $pass;

    private $dbh;
    private $error;
    private $qError;

    private $stmt;

    private $bindArr;

    public function __construct() {
        $this->host = 'localhost';
        $this->dbName = 'mini-cms';
        $this->user = 'root';
        $this->pass = '';

        //dsn for mysql
        $dsn = "mysql:host=".$this->host.";dbname=".$this->dbName;
        $options = array(
            PDO::ATTR_PERSISTENT=> true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        }
            //catch any errors
        catch (PDOException $e){
            $this->error = $e->getMessage();
        }

    }

    public function query($query){

        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null){
        $this->bindArr[$param] = $value;
        if(is_null($type)){
            switch (true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function print_query() {
        $queryStr = $this->stmt->queryString;
        
        if (!empty($this->bindArr)) {
            foreach ($this->bindArr as $key => $val) {
                switch (true){
                    case is_int($val):
                    case is_bool($val):
                    case is_null($val):
                        $queryStr = str_replace($key, $val, $queryStr);
                        break;
                    case is_string($val):
                    default:
                        $queryStr = str_replace($key, '"'.$val.'"', $queryStr);
                }
            }
        }
        
        print($queryStr);
    }

    public function execute(){
        return $this->stmt->execute();

        $this->qError = $this->dbh->errorInfo();
        if(!is_null($this->qError[2])){
            echo $this->qError[2];
        }
        echo 'done with query';
    }

    public function resultset(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount(){
        return $this->stmt->rowCount();
    }

    public function lastInsertId(){
        return $this->dbh->lastInsertId();
    }

    public function beginTransaction(){
        return $this->dbh->beginTransaction();
    }

    public function endTransaction(){
        return $this->dbh->commit();
    }

    public function cancelTransaction(){
        return $this->dbh->rollBack();
    }

    public function debugDumpParams(){
        return $this->stmt->debugDumpParams();
    }

    public function queryError(){
        $this->qError = $this->dbh->errorInfo();
        if(!is_null($qError[2])){
            echo $qError[2];
        }
    }

}

?>