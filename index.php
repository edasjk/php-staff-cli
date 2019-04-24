<?php

require 'classes\Database.php';
require 'classes\StaffDb.php';

$db = new Database;
$staff = new StaffDb;

$conn = $db->getConn();

//visos personos is failo
$allPersons = $staff->getAllData($conn);

//Register, Delete, Find, Import
$options = getopt("r:d:f:i");

foreach ($options as  $key => $value) { //$key => $value) {
    switch ($key) {
        case 'r':
            echo $value . "\n";
            $validEmail = $staff->isValidEmail($value);
            $newEmail = $staff->isNewEmail($allPersons, $value);
            $allFieldsFilled = $staff->allFieldsFilled($value);
            if ($validEmail && $newEmail && $allFieldsFilled) {
                $result = $staff->addPerson($conn, $value);
            }
        break;
        case "d":
            echo "Persons with lastname $value will be deleted\n";
            $staff->deletePersonByLastname($conn, $value);
        break;
        case "f":
            echo "Persons found: \n";
            $foundPersons = $staff->findPersonByLastName($conn, $value);
            break;            
        case "i":
            echo "Importing archive staff_archive.csv to staff.txt \n";
            $persons = $staff->readStaffArchive('staff_archive.csv');
            print_r($persons);
            
            foreach ($persons as $key => $value) {
                $validEmail = $staff->isValidEmail($value);
                $newEmail = $staff->isNewEmail($allPersons, $value);
                $allFieldsFilled = $staff->allFieldsFilled($value);
                if ($validEmail && $newEmail && $allFieldsFilled) {
                    $result = $staff->addPerson($conn, $value);
                } 
            }
            break;            
    }
}


$db->closeConn($conn);

