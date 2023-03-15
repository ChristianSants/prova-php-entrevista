<?php

class Connection{
    
    protected function getConexao(){
        try{            
            $pdo = new PDO("sqlite:../database/db.sqlite");
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;
        } catch(Exception $e){
            echo $e->__toString();
            die();
        }
    }    
    
}