<?php
    /*
    *   PDO Database Class
    *   Connect to database
    *   Create prepared Statments
    *   Bind values
    *   Return rows and results
    */
class Database{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    private $databaseHandler;
    private $statment;
    private $error;

    public function __construct(){
        // change this if you want to work on any database other than mysql
        $databaseHandler = "mysql:host={$this->host};dbname={$this->dbname}";
        
        $options = [
            PDO::ATTR_PERSISTENT => true, // check if there is a connection with the database
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        try{
            $this->databaseHandler = new PDO($databaseHandler, 
            $this->user, 
            $this->pass, 
            $options);
        }catch(PDOException $e){
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    public function query($sql){
        return $this->statment = $this->databaseHandler->prepare($sql);
    }

    public function bind($param, $value, $type = null): bool{
        if(!is_null($type)){
            switch(true){
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
        return $this->statment->bindValue($param, $value, $type);
    }

    public function execute(): bool{
        return $this->statment->execute();
    }

    // Get result as array of objects
    public function resultSet(): array{
        if($this->execute())
            return $this->statment->fetchAll(PDO::FETCH_OBJ);
     
    }

    // Get single recored as Object
    public function single(): object{
        if($this->execute())
            return $this->statment->fetch(PDO::FETCH_OBJ);

    }

    public function rowCount(){
        return $this->statment->rowCount(); // rowCount is s a PDO method
    }
}