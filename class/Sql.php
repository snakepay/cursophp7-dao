<?php

class Sql extends PDO {
    
    private $conn;
    
    public function __construct() {
        $this->conn = new PDO("mysql:dbname=dbphp7;host=localhost", "root", "");
    }
    
    private function setParams( $statment, $parameters = array() ) {        
        foreach ( $parameters as $key => $values ) {            
            $this->setParam( $key, $values );            
        }        
    }
    
    private function setParam( $statment, $key, $value ) {
        $statment->bindParam( $key, $value );
    }


    public function query($rawQuery, $params = array()) {        
        
        $stmt = $this->conn->prepare($rawQuery);        
        
        $this->setParams($params);
        
        $stmt->execute();
        
        return $stmt;
        
    }
    
    /* Método para o SELECT */    
    public function select( $rawQuery, $params = array() ):array {       
        
        $stmt = $this->query( $rawQuery, $params );
        
        return $stmt->fetchAll( PDO::FETCH_ASSOC );
        
    }
}

?>