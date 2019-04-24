<?php

use PHPUnit\Framework\TestCase;

/**
 * Reikia sukurti funkcija, kad butu patogu testuoti
 */
class StaffTest extends TestCase
{

    public function testIsValidEmailFunctionGivesCorrectResult()
    {
        require 'classes\StaffDb.php';

        $staff = new StaffDb;

        $this->assertEquals(true, $staff->isValidEmail('Jonas;JOnaitis;jonas@example.com;12345;232324;komentaras;'));

        $this->assertNotEquals(true, $staff->isValidEmail('Jonas;JOnaitis;jonasexample.com;12345;232324;komentaras;'));
    }

    public function testIfAllFieldsFilledReturnsCorrectResult() {
        $staff = new StaffDb;

        $this->assertEquals(true, $staff->allFieldsFilled('Jonas;JOnaitis;jonasexample.com;12345;232324;komentaras'));

        $this->assertEquals(false, $staff->allFieldsFilled('Jonas;JOnaitis;jonasexample.com;12333;232324;;')); //one field is empty
    }

}