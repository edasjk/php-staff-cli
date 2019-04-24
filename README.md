# php-staff-cli
Staff application with CLI

SUMMARY

The application should have following functionality:
• Register a new person
Done

• Delete a person from the register
Deletes by lastname

• Find a person in the register
Finds by lastname fragment

• Import of persons using a CSV-file
Imports from staff_archive.csv

Potential problem areas to think about:
• Duplicated persons
Finding duplicate emails implemented
• Data validation (email)
Email validation is checking is implemented

All commands are executed from CLI
Done
- Application should not use any framework
Yes
- Include at least few unit tests
Done 
But unit tests are not implemented with database.
- Application Data should be stored in file
stored in config.ini

- Provide brief information what wasn’t implemented due to time limitation
Some refactoring should be done in index.php (code in case statement should be moved to functions)
Database unit tests should be implemented
Data validity should have more checks to be done



STARTING AND WORKING WITH APPLICATION

Database import:
staff_database.sql (no data, just fields)


Data import:
php index.php -i
Imports from staff_archive.csv

Add a new staff (person):
php index.php -rPetras;Petraitis;petras@example.com;12345;2233445;newcomment;

Delete a staff by last name:
php index -dPetraitis

Find a staff by last name:
php index -fPetraitis

Run Unit Tests:
php phpunit.phar test/StaffTest.php
