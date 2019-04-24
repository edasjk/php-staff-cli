<?php

/**
 * Database
 *
 * A connection to the database
 */
class Database
{
    /**
     * Get the database connection
     *
     * @return $conn  Connection to the database server
     */
    function getConn()
    {
        //$db_host = "localhost";
        //$db_name = "staff";
        //$db_user = "staff";
        //$db_pass = "staff";
    
        $ini = parse_ini_file('config.ini');
    
        $conn = new mysqli($ini['db_host'], $ini['db_user'], $ini['db_pass'], $ini['db_name']) 
                or die("Connect failed: %s\n". $conn -> error);
    
        return $conn;
    }

    function closeConn($conn)
    {
        $conn -> close();
    }    
}