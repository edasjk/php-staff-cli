<?php

Class Staff
{
    public $firstname;
    public $lastname;
    public $phonenumber1;
    public $phonenumber2;
    public $comment;

    /**
     * Checks if fields are not empty
     * @param string $person
     * 
     * @return boolean
     */
    function isValidData($person) {
        $persona = explode(";", $person);
        for ($i=0; $i<sizeof($persona); $i++) {
            if (strlen($persona[$i]) > 0) {
                echo $persona[$i] . " ";
            } else {
                echo "bad data\n";
                return false;
            }
        }
    }

    function isValidEmail($person) {
        $persona = explode(";", $person);
        if (filter_var($persona[2], FILTER_VALIDATE_EMAIL)) {
            echo "Email address {$persona[2]} is valid. \n";
        } else {
            echo "\nEmail address {$persona[2]} is invalid.\n";
            return false;
        }
        return true;
    }

    /**
     * Checks if email is original
     * 
     * @param Arrray $allPersons
     * @param string $value
     * 
     * @return boolean
     */
    function isNewEmail($allPersons, $newPerson) {
        //ar originalus emailas
        $new =  (explode(";", $newPerson));
        $arr = [];
        foreach ($allPersons as $person) {
            $arr =  (explode(";", $person));
            echo $arr[2] . "\n";
            if ($arr[2] == $new[2]) {
                echo 'Duplicate email ' . $new[2] .  " found \n";
                return false;
            }
        }
        echo 'Email ' . $new[2] . ' is unique';
        return true;
    }

   
   /**
    * Opens a file and read file content
    * 
    *  @return Array $persons
    */
    function readPersons($file= 'staff.txt')
    {
        //skaitymas is failo -> array
        if ($file = fopen($file, 'r')) {  //read only
            while (!feof($file)) {
                $persons[] = fgets($file);
            }
            fclose($file);
        }
        return $persons;
    }

   /**
    * Imports data from archive to working file
    * 
    * @param string $file
    *
    *  @return Array $persons
    */
    function readArchive($file = 'staff_archive.csv')
    {
        $persons = [];
        if ($file = fopen($file, 'r')) {  
            while (!feof($file)) {
                $person = fgets($file); 
                $person = str_replace(',', ';', $person);
                $persons[] .= $person;
            }
            fclose($file);
        }
        return $persons;
    }

    /**
     * Compares if any string contains fragment. If so deletes that string returns updated array
     * 
     * @param Array $allPersons
     * @param string $fragment
     * 
     * @return Array $updated
     */
    function deletePerson($allPersons, $fragment)
    {
        //skaityti masyvo eilute
        //jeigu masyvo narys neturi $fragment, deti i nauja masyva
        $updated = [];
        $count = 0;
        echo "\n\nAll persons from deletePerson\n";

        for ($i=0; $i<sizeof($allPersons); $i++) {
            if (!strstr($allPersons[$i], $fragment)) {
                array_push($updated, $allPersons[$i]);
            }
        }
        print_r($updated);
        return $updated;
    } 

    function findPerson($allPersons, $fragment)
    {
        $found = [];

        for ($i=0; $i<sizeof($allPersons); $i++) {
            if (strstr($allPersons[$i], $fragment)) {
                $person = str_replace(';', ' ', $allPersons[$i]);
                echo $person;
            }
        }
        return $found;
    }
 
    /**
     * Writes string to file
     * 
     * @param string $person
     * @param boolean  $append
     * 
     * @return void
     */
    function writeToFile($data, $append  = false)
    {   
        $file = 'staff.txt';
        if ($append) {
            file_put_contents($file, "\n", FILE_APPEND);
            file_put_contents($file, $data, FILE_APPEND);
        } else {
            file_put_contents($file, $data);
        }
    }    

}