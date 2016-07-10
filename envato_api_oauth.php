<?php
/*
 * Plugin Name: Envato API OAuth Sample
 * Version: 1.1
 * Plugin URI: http://dtbaker.net
 * Description: Sample plugin using the new Envato API OAuth feature
 * Author: dtbaker
 * Author URI: http://dtbaker.net
 * Requires at least: 4.1
 * Tested up to: 4.1
 *
 * Version 1.1 - 2015-05-04 - initial release
 *
 */


if ( ! defined( 'ABSPATH' ) ) exit;
defined('__DIR__') or define('__DIR__', dirname(__FILE__));

define('_ENVATO_APP_CLIENT_ID','envatooauthtest-ifsin07r'); // add your own client id here.

require_once 'class.envato_api.php';

class EnvatoOAuth {

	private static $instance = null;
	private static $ch_api = false;

	public static function getInstance( $file = false ) {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self( $file );
		}
		return self::$instance;
	}

	public function __construct() {
		add_action( 'admin_menu' , array( $this, 'add_menu_item' ) );
	}

	public function add_menu_item(){

		add_management_page( 'Envato API Test', 'Envato API Test', 'manage_options', 'envato-api-oauth', array( $this, 'envato_api_page_display') );

	}

	public function envato_api_page_display(){

		require_once $this->_get_template('envato_api_page.php');

	}


	private function _get_template($template_name){
	    if( file_exists( get_stylesheet_directory() .'/'.$template_name)){
	        return get_stylesheet_directory() .'/'.$template_name;
	    }else if( file_exists( get_template_directory() .'/'.$template_name)){
	        return get_template_directory() .'/'.$template_name;
	    }else if (file_exists(dirname( __FILE__ ) . '/templates/' . $template_name)) {
	        return dirname( __FILE__ ) . '/templates/' . $template_name;
	    }
	    return false;
	}

	/**
	 *
	 * Helper for curl requests
	 *
	 * @param string $url
	 * @param array $post
	 */
	private function _curl( $url, $post ){
		self::$ch_api = curl_init();
		curl_setopt(self::$ch_api, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt(self::$ch_api, CURLOPT_USERAGENT, "dtbaker sample oauth api");
		curl_setopt(self::$ch_api, CURLOPT_RETURNTRANSFER, true);
		curl_setopt(self::$ch_api, CURLOPT_SSL_VERIFYPEER, false);
		@curl_setopt(self::$ch_api, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt(self::$ch_api, CURLOPT_HEADER, 0);
		curl_setopt(self::$ch_api, CURLOPT_REFERER, 'http://dtbaker.net/sample_envato_api');
		curl_setopt(self::$ch_api, CURLOPT_RETURNTRANSFER,1);
		curl_setopt(self::$ch_api, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt(self::$ch_api, CURLOPT_TIMEOUT, 20);

		curl_setopt(self::$ch_api, CURLOPT_URL, $url);
		if($post !== false && is_array($post)){
			curl_setopt(self::$ch_api, CURLOPT_POST, true);
			curl_setopt(self::$ch_api, CURLOPT_POSTFIELDS, $post);
		}
		$data = curl_exec(self::$ch_api);
		return $data;
	}
}


$plugin_obj = EnvatoOAuth::getInstance();