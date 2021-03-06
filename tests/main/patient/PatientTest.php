<?php

namespace Dinet\Tests\Patient;

use Dinet\Patient\Patient;
use WP_UnitTestCase;

require_once '/var/www/html/Dinet/src/wp-content/plugins/dinet/app/main/patient/Patient.php';

class PatientTest extends WP_UnitTestCase
{
    const USERNAME = 'testUser';

    private $Patient;

    public function __construct( ?string $name = null, array $data = [], string $dataName = '' )
    {
        parent::__construct( $name, $data, $dataName );

        $userId = wp_create_user( self::USERNAME, 'password' );
        $this->Patient = new Patient( $userId );
    }

    /**
     * Test to get patient first name when it's not given.
     *
     * @test
     */
    public function firstNameEmpty()
    {
        $this->assertEmpty( $this->Patient->getFirstName() );
    }

    /**
     * Test to get patient first name.
     *
     * @test
     */
    public function firstNameGiven()
    {
        $firstName = 'firstName';
        $this->Patient->setFirstName( $firstName );
        $this->assertEquals( $firstName, $this->Patient->getFirstName() );
    }

    /**
     * @test
     */
    public function lastNameEmpty()
    {
        $this->assertEmpty( $this->Patient->getLastName() );
    }

    /**
     * Test to get patient last name.
     *
     * @test
     */
    public function lastNameGiven()
    {
        $firstName = 'lastName';
        $this->Patient->setLastName( $firstName );
        $this->assertEquals( $firstName, $this->Patient->getLastName() );
    }

    /**
     * @test
     */
    public function weightEmpty()
    {
        $this->assertEmpty( $this->Patient->getWeight() );
    }

    /**
     * @test
     */
    public function weightGiven()
    {
        $weight = 55.5;
        $this->Patient->setWeight( $weight );
        $this->assertEquals( $weight, $this->Patient->getWeight() );
    }

    /**
     * @expectedException \TypeError
     * @test
     */
    public function weightString()
    {
        $weight = 'TOTO';
        $this->Patient->setWeight( $weight );
    }

    /**
     * @test
     */
    public function heightEmpty()
    {
        $this->assertEmpty( $this->Patient->getHeight() );
    }

    /**
     * @test
     */
    public function heightGiven()
    {
        $height = 1.74;
        $this->Patient->setHeight( $height );
        $this->assertEquals( $height, $this->Patient->getHeight() );
    }

    /**
     * @test
     */
    public function phoneEmpty()
    {
        $this->assertEmpty( $this->Patient->getPhone() );
    }

    /**
     * @test
     */
    public function phoneGiven()
    {
        $phone = '0123456789';
        $this->Patient->setPhone( $phone );
        $this->assertEquals( $phone, $this->Patient->getPhone() );
    }

    /**
     * @test
     */
    public function observationEmpty()
    {
        $this->assertEmpty( $this->Patient->getObservation() );
    }

    /**
     * @test
     */
    public function observationGiven()
    {
        $observation = 'I am an observation.';
        $this->Patient->setObservation( $observation );
        $this->assertEquals( $observation, $this->Patient->getObservation() );
    }
}
