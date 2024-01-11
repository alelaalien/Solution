<?php

class Connection{
 

     public static function connect()
     {

        try {

            $dataSource = new PDO("mysql:host=localhost;dbname=employeer",
            "root",
            "",
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                  PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

            return $dataSource;

        } catch (Exception $e) {
             
            die("Connection error:  " . $e->getMessage());
        
        }
        
     }
}