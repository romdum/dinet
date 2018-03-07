<?php

namespace Dinet\Monitoring;

use Dinet\Dinet;
use Dinet\Patient\Patient;
use Dinet\Patient\PatientCtrl;
use Dinet\SettingsEnum;
use Dinet\UtilPath;
use Dinet\UtilWP;

class UI
{
    const ADD_EATEN_FOOD_SLUG  = 'addEatenFood';
    const FOOD_PAGINATION_SLUG = 'foodPagination';
    const FOOD_SEARCH_SLUG     = 'foodSearch';
    const REMOVE_CONSUMPTION   = 'removeCons';


    public function loadScript()
	{
	    $dep = ['jquery'];

	    UtilWP::loadJS( self::ADD_EATEN_FOOD_SLUG, UtilPath::getJSPath( 'monitoring/add_eaten_food'), $dep );
        UtilWP::loadJS( self::FOOD_PAGINATION_SLUG, UtilPath::getJSPath( 'monitoring/food_pagination' ), $dep );
        UtilWP::loadJS( self::FOOD_SEARCH_SLUG, UtilPath::getJSPath( 'monitoring/search' ), $dep );
        UtilWP::loadJS( self::REMOVE_CONSUMPTION, UtilPath::getJSPath( 'monitoring/remove_eaten_food' ), $dep );
	}

	function dinet_add_plugin_menu()
	{
		add_submenu_page( 'dinet_plugin',__( 'Mon suivi' ), __( 'Mon suivi' ), 'read', 'dinet_monitoring_page', array( 'Dinet\Monitoring\UI', 'displayMonitoring' ) );

		remove_submenu_page( 'dinet_plugin', 'dinet_plugin' );
	}

	function add_admin_menu_item( \WP_Admin_Bar $wp_admin_bar )
	{
		$wp_admin_bar->add_node( array(
			'id'    => 'dinet_admin_menu_item',
			'title' => 'Mon suivi',
			'href'  => admin_url( 'admin.php?page=dinet_plugin' ),
		) );
	}

	/**
	 * Display plugin's customers page
	 */
	static function displayMonitoring()
	{
		$PatientCtrl = new PatientCtrl();
		$PatientCtrl->setPatient( new Patient() );
		$PatientCtrl->load();

		$FoodPagination = new FoodListCtrl();

		$ConsumptionList = new ConsumptionListCtrl();
		$ConsumptionList->setPatient( $PatientCtrl->getPatient() );
		$ConsumptionList->fillList();

		$limit = 5;

		$nonceName = \Dinet\UI::JS_SAVE_PATIENT_NONCE;

		if( Dinet::$setting->getSetting( SettingsEnum::MONITORING, SettingsEnum::DISPLAY, SettingsEnum::CHART ) )
		{
		    if( $PatientCtrl->settings->getSetting( SettingsEnum::MONITORING, SettingsEnum::DISPLAY, SettingsEnum::CHART ) )
            {
                $Chart = new FoodMonitoringChart();
                $Chart->setTitle( __( 'Consommation mensuelle' ) );
            }
        }

		$display = [
            'hungryLevel'   => false,
		    'feelingBefore' => false,
            'feelingAfter'  => false,
        ];

		include UtilPath::getTemplatesPath( 'monitoring' );
	}
}