<?php

Class StaffDb
{
    public $firstname;
    public $lastname;
    public $email;
    public $phonenumber1;
    public $phonenumber2;
    public $comment;

    /**
    * Opens a file and read file content
    * 
    *  @return Array $persons
    */
    function readStaffArchive($file= 'staff.txt')
    {
        //skaitymas is failo -> array
        $persons = [];
        if ($file = fopen($file, 'r')) {  //read only
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
    * Reads database 
    * 
    *  @return Array of obj
    */
    function getAllData($conn)
    {
    $sql =  "SELECT firstname, lastname, email, phonenumber1, phonenumber2, comment FROM staff";

    $result = $conn->query($sql);
        if ($result->num_rows === 0) {
            echo "0 results";
        }
    return $result;
    }      

    /**
     * Checks if all fields are not empty
     */
    function allFieldsFilled($person) {
        $persona = explode(";", $person);
        if (count($persona) < 3) {
            return false;
        }
        for ($i=0; $i<count($persona)-1; $i++) {
            if (strlen($persona[$i]) == 0) {
                echo "$person has invalid fields";
                return false;
            }
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
    function isValidEmail($person) {
        $persona = explode(";", $person);
        echo $persona[2];
        if (filter_var($persona[2], FILTER_VALIDATE_EMAIL)) {
            echo "Email address {$persona[2]} is valid. \n";
        } else {
            echo "\nEmail address {$persona[2]} is invalid.\n";
            return false;
        }
        return true;
    }

    function isNewEmail($allPersons, $newPerson) {
        //ar originalus emailas
        $new =  (explode(";", $newPerson));
        $email = $new[2];
        echo $email;

        if ($allPersons->num_rows > 0) {
            while($row = $allPersons->fetch_assoc()) {
                if ($row["email"] == $email) {
                    echo "\nDuplicate email " . $new[2] .  " found \n";
                    echo "New person NOT added\n";
                    return false;       
                }
            }
        } 
        echo "\nEmail " . $new[2] . " is unique\n";
        return true;
    }    

    function addPerson($conn, $personString)
    {
        $person = explode(';', $personString);

        $sql = "INSERT INTO staff(firstname, lastname, email, phonenumber1, phonenumber2, comment)
              VALUES('".$person[0]."', '".$person[1]."', '".$person[2]."', '".$person[3]."', '".$person[4]."', '".$person[5]."')";

        if ($conn->query($sql) === TRUE) {
            echo "\nNew person added successfully\n";
        } else {
            echo "Error: " . $sql . "\n" . $conn->error;
        }
    }

     /**
     * Compares if any string contains fragment. If so deletes that string returns updated array
     * 
     * @param string $lastname
     * @param Array  $conn
     * 
     * @return void
     */
    function deletePersonByLastname($conn, $lastname)
    {
        $sql = "DELETE from staff where lastname ='$lastname'";

        $conn->query($sql);
        echo "Deleting person with family name $lastname\n";

        if (mysqli_affected_rows($conn) > 0) {
            "$lastname deleted\n";
        } else {
            "$lastname not found\n";
        }
        echo "Deleted persons: " . mysqli_affected_rows($conn);
    } 

         /**
     * Compares if any string contains fragment. If so deletes that string returns updated array
     * 
     * @param string $lastname
     * @param Array  $conn
     * 
     * @return void
     */
    function findPersonByLastname($conn, $lastname)
    {
        //$sql =  "SELECT id, firstname, lastname, email, phonenumber1, phonenumber2, comment FROM staff";
        $sql = "SELECT id, firstname, lastname, email, phonenumber1, phonenumber2, comment 
                FROM staff WHERE lastname LIKE '%$lastname%'";
        //$conn->query($sql);
        $result = $conn->query($sql);

        echo "Searching for person containing $lastname in family name\n";

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"] . " " . $row["email"] .
                    " phones:  " . $row["phonenumber1"] . " " . $row["phonenumber2"] .  " "  . $row["comment"]. "\n";
            } 
        } else {
            echo "0 results";
        }         

        echo "Found persons: " . mysqli_affected_rows($conn);
    } 


}