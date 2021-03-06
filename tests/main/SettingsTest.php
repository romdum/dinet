<?php

namespace Dinet\Tests;

use Dinet\Settings;
use Dinet\SettingsEnum;
use Dinet\Util;
use stdClass;
use \WP_UnitTestCase;

require_once getenv( 'WP_DEVELOP_DIR' ) . 'src/wp-content/plugins/dinet/app/main/Settings.php';
require_once getenv( 'WP_DEVELOP_DIR' ) . 'src/wp-content/plugins/dinet/app/main/utils/Util.php';

class SettingsTest extends WP_UnitTestCase
{
	private $settings;

	public function __construct()
	{
		$this->settings = new Settings();
		$this->settings->createDefaultOption();

		parent::__construct();
	}

	/**
	 * Test default settings values.
	 *
	 * @covers Settings::getSetting
	 * @test
	 */
	public function createDefaultOption()
	{
		$this->assertTrue( $this->settings->getSetting( SettingsEnum::MONITORING, SettingsEnum::ACTIVATE ),
			'Test default settings failed: {"Monitoring":{"activate":false} (should be true)');
	}

	/**
	 * Test if the JSON setting format is correct.
	 *
	 * @after
	 * @coversNothing
	 * @test
	 * @param string $testCode
	 */
	public function settingsFormat( $testCode = 'UNKNOW' )
	{
		$settings = json_decode( get_option( Settings::NAME ), null );
		$this->assertNotNull( $settings,
			'Settings format incorrect after test ' . $testCode );
    }

	/**
	 * Test to get all settings.
	 *
	 * @covers Settings::getSettings
	 * @test
	 */
    public function getAllSettings()
    {
	    $this->assertTrue(
		    $this->settings->getSetting() ===
		    Util::object_to_array( json_decode( get_option( Settings::NAME ), null ) ),
		    'getSettings doesn\'t return all settings.' );
    }

	/**
	 * Test setSetting method (normal use)
	 *
	 * @covers Settings::setSetting
	 * @covers Settings::getSetting
	 * @test
	 */
    public function setSetting()
    {
	    $this->settings->setSetting( false, 'VehiclePostType', 'display', 'photo' );
	    $this->assertFalse( $this->settings->getSetting( 'VehiclePostType', 'display', 'photo' ),
		    'setSetting test failed: {"VehiclePostType":{"display":{"photo":true}}} (should be false)');
	    $this->settingsFormat( 'SET001' );
    }

	/**
	 * Test setSetting method to create a new setting
	 *
	 * @covers Settings::setSetting
	 * @covers Settings::getSetting
	 * @test
	 */
    public function createSetting()
    {
	    $this->settings->setSetting( 'Hello', 'test', 'tes', 'te' );
	    $this->assertTrue( $this->settings->getSetting( 'test', 'tes', 'te' ) === 'Hello',
		    'setSetting recursively test failed.');
	    $this->settingsFormat( 'SET002' );
    }

	/**
	 * Test getSetting method with incorrect parameter
	 *
	 * @covers Settings::getSetting
	 * @dataProvider SettingsTest::failDataProvider
	 * @test
	 */
    public function incorrectGetSetting()
    {
    	$failSettings = self::failDataProvider();

		foreach( $failSettings as $message => $setting )
        {
            $this->assertNull( $this->settings->getSetting( $setting ), $message );
        }
    }

	/**
	 * Test setSetting method with incorrect parameter
	 *
	 * @covers Settings::setSetting
	 * @covers Settings::getSetting
	 * @test
	 */
    public function incorrectSetSetting()
    {
	    $correctSettings = Util::object_to_array( json_decode( get_option( Settings::NAME ), null ) );
	    $failSettings = self::failDataProvider();

	    foreach( $failSettings as $message => $setting )
	    {
	        $this->settings->setSetting( 'Hello', $setting );
	        $this->assertTrue($this->settings->getSetting() === $correctSettings, $message );
	    }
    }

	public static function failDataProvider()
	{
		return [
			'Fail with stdClass'         => new stdClass(),
			'Fail with empty array'      => [],
			'Fail with boolean'          => true,
			'Fail with null'             => null,
			'Fail with numeric'          => 0,
			'Fail with array of strings' => ['You','shall','not','pass','...','tests']
		];
	}
}