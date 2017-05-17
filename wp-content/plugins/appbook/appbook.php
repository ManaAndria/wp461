<?php
/*
Plugin Name: Application RDV
Plugin URI: 
Description: Application de rendez-vous
Version: 1.0
Author: Netunivers
Author URI:
License: GPL2
*/
if ( ! defined( 'ABSPATH' ) )
	exit;

if ( !class_exists( 'AppBook' ) ) {
	class AppBook 
	{
	    protected static $_instance = null;

	    public $app = null;

	    public $template_path ;

	    public $slug = 'appbook';

	    public $role = 'user-app-book';

	    public $form_action = null;

	    public static function instance()
	    {
	    	if (is_null(self::$_instance))
	    	{
	    		self::$_instance = new self();
	    	}
    		return self::$_instance;
	    }
		
		public function __construct(){
			register_activation_hook( __FILE__, array($this, 'appInstall') );
			$this->template_path = plugin_dir_path( __FILE__ )."templates/";
			// hide admin bar if not admin
			add_action( 'after_setup_theme', array($this, 'remove_admin_bar') );
			add_action( 'wp_login_failed', array($this, 'login_fail') );
			
			add_action( 'init', array($this, 'init'), 0 );
		}

		public function appInstall() {
			global $wpdb;
			
			// create tables --------------------- doesn't work --------------------

			/*$collate = '';
			if ( $wpdb->has_cap( 'collation' ) ) {
				$collate = $wpdb->get_charset_collate();
			}

			$sql = "
			CREATE TABLE IF NOT EXISTS {$wpdb->prefix}{$this->slug}_app (
			  app_id int(11) NOT NULL AUTO_INCREMENT,
			  user_id int(11) NOT NULL,
			  app_name varchar(255) NOT NULL,
			  address varchar(255) NOT NULL,
			  zip varchar(127) NOT NULL,
			  city varchar(255) NOT NULL,
			  country_code varchar(127) DEFAULT '' NOT NULL,
			  hour_zone varchar(127) DEFAULT '' NOT NULL,
			  email_contact varchar(255) NOT NULL,
			  phonenumber varchar(127) NOT NULL,
			  days_last_booking int(11) NOT NULL,
			  capacity int(11) NOT NULL,
			  message varchar(512) NOT NULL,
			  created timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
			  PRIMARY KEY  (app_id)
			) $collate;
			CREATE TABLE IF NOT EXISTS {$wpdb->prefix}{$this->slug}_employee (
			  employee_id int(11) NOT NULL AUTO_INCREMENT,
			  app_id int(11) NOT NULL,
			  firstname varchar(255) NOT NULL,
			  lastname varchar(255) NOT NULL,
			  email varchar(255) NOT NULL,
			  country_code varchar(127) DEFAULT '' NOT NULL,
			  phonenumber varchar(127) NOT NULL,
			  poste int(11) NOT NULL,
			  PRIMARY KEY  (employee_id)
			) $collate;
			CREATE TABLE IF NOT EXISTS {$wpdb->prefix}{$this->slug}_service (
			  service_id int(11) NOT NULL AUTO_INCREMENT,
			  app_id int(11) NOT NULL,
			  service_name varchar(255) NOT NULL,
			  PRIMARY KEY  (service_id)
			) $collate;
			CREATE TABLE IF NOT EXISTS {$wpdb->prefix}{$this->slug}_userinfo (
			  info_id int(11) NOT NULL AUTO_INCREMENT,
			  user_id int(11) NOT NULL,
			  app_id int(11) NOT NULL,
			  firstname varchar(255) NOT NULL,
			  lastname varchar(255) NOT NULL,
			  email varchar(255) NOT NULL,
			  phonenumber varchar(255) NOT NULL,
			  PRIMARY KEY  (info_id)
			) $collate;
			";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			$res = dbDelta( $sql );*/

			// en create tables


			// add role
			add_role( 'user-app-book', __('Utilisateur de rendez-vous', $this->slug), array( 'read' => false, 'level_0' => true ) );
			global $wp_roles;
  			$wp_roles->remove_cap( 'user-app-book', 'read' );
		}

		public function init()
		{
			$this->includes();
			$this->assets();
			
			$user_id = wp_get_current_user()->ID;
			$this->app = new App($user_id);

			if( !empty($this->app->datas->hour_zone) )
				date_default_timezone_set($this->app->datas->hour_zone);

			// shortcodes
			add_action( 'init', array('appShortcodes', 'init') );

			// menu
			$this->createMenu();

			// widget
			add_action( 'widgets_init', array($this ,'register_widget') );
		}

		function remove_admin_bar() {
			if (!current_user_can('administrator') && !is_admin()) {
			  show_admin_bar(false);
			}
		}

		function login_fail( $username ) {
		     $referrer = $_SERVER['HTTP_REFERER'];
		     if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
		          wp_redirect($referrer . '?login=failed' );
		          exit;
		     }
		}

		public function assets()
		{
			// register styles
			wp_register_style( $this->slug.'_bootstrap', plugins_url().'/'.$this->slug.'/assets/css/bootstrap.min.css' );
			//wp_register_style( $this->slug.'_bootstrap-switch', plugins_url().'/'.$this->slug.'/assets/css/bootstrap-switch.css' );
			wp_register_style( $this->slug.'_bootstrap-toggle', plugins_url().'/'.$this->slug.'/assets/css/bootstrap-toggle.min.css' );
			wp_register_style( $this->slug.'_style', plugins_url().'/'.$this->slug.'/assets/css/style.css' );

			wp_register_style( $this->slug.'_fullcalendar', plugins_url().'/'.$this->slug.'/assets/css/fullcalendar.css' );
			wp_register_style( $this->slug.'_fullcalendar_print', plugins_url().'/'.$this->slug.'/assets/css/fullcalendar.print.css', array(), false, 'print' );
			wp_register_style( $this->slug.'_multiselect-css', plugins_url().'/'.$this->slug.'/assets/css/bootstrap-multiselect.css' );
			wp_register_style( $this->slug.'_style-admin', plugins_url().'/'.$this->slug.'/assets/css/style-admin.css' );
			wp_register_style( $this->slug.'_bootstrap-colorpicker', plugins_url().'/'.$this->slug.'/assets/css/bootstrap-colorpicker.min.css' );

			// load styles
			if (!is_admin()){
				wp_enqueue_style($this->slug.'_bootstrap');
				wp_enqueue_style($this->slug.'_bootstrap-toggle');
			}
			if (is_admin())
				wp_enqueue_style($this->slug.'_style-admin');

			wp_enqueue_style($this->slug.'_style');

			// register scripts
			wp_register_script( $this->slug.'_bootstrap', plugins_url().'/'.$this->slug.'/assets/js/bootstrap.min.js', array(), false, true );
			//wp_register_script( $this->slug.'_bootstrap-switch', plugins_url().'/'.$this->slug.'/assets/js/bootstrap-switch.js', array(), false, true );
			wp_register_script( $this->slug.'_bootstrap-toggle', plugins_url().'/'.$this->slug.'/assets/js/bootstrap-toggle.min.js', array(), false, true );
			wp_register_script( $this->slug.'_script', plugins_url().'/'.$this->slug.'/assets/js/script.js', array(), false, true );

			wp_register_script( $this->slug.'_service', plugins_url().'/'.$this->slug.'/assets/js/service.js', array(), false, true );
			wp_register_script( $this->slug.'_employee', plugins_url().'/'.$this->slug.'/assets/js/employee.js', array(), false, true );
			wp_register_script( $this->slug.'_holiday', plugins_url().'/'.$this->slug.'/assets/js/holiday.js', array(), false, true );
			wp_register_script( $this->slug.'_setting', plugins_url().'/'.$this->slug.'/assets/js/setting.js', array(), false, true );
			wp_register_script( $this->slug.'_userinfo', plugins_url().'/'.$this->slug.'/assets/js/userinfo.js', array(), false, true );
			wp_register_script( $this->slug.'_period', plugins_url().'/'.$this->slug.'/assets/js/period.js', array(), false, true );
			wp_register_script( $this->slug.'_opening', plugins_url().'/'.$this->slug.'/assets/js/opening.js', array(), false, true );
			wp_register_script( $this->slug.'_closing', plugins_url().'/'.$this->slug.'/assets/js/closing.js', array(), false, true );

			wp_register_script( $this->slug.'_moment_min', plugins_url().'/'.$this->slug.'/assets/js/moment.min.js', array(), false, false );
			wp_register_script( $this->slug.'_jquery_min', plugins_url().'/'.$this->slug.'/assets/js/jquery.min.js', array(), '3.1.0', false );
			wp_register_script( $this->slug.'_fullcalendar', plugins_url().'/'.$this->slug.'/assets/js/fullcalendar.min.js', array(), '3.1.0', false );
			wp_register_script( $this->slug.'_locale_fr', plugins_url().'/'.$this->slug.'/assets/js/locale/fr.js', array(), '3.1.0', false );
			wp_register_script( $this->slug.'_booking', plugins_url().'/'.$this->slug.'/assets/js/booking.js', array(), false, false );
			wp_register_script( $this->slug.'_chart', plugins_url().'/'.$this->slug.'/assets/js/Chart.js', array(), false, false );
			wp_register_script( $this->slug.'_stats', plugins_url().'/'.$this->slug.'/assets/js/stats.js', array(), false, false );
			wp_register_script( $this->slug.'_multiselect', plugins_url().'/'.$this->slug.'/assets/js/bootstrap-multiselect.js', array(), false, false );
			wp_register_script( $this->slug.'_bootstrap-colorpicker', plugins_url().'/'.$this->slug.'/assets/js/bootstrap-colorpicker.min.js', array(), false, true );

			// load scripts
			if (!is_admin())
			{
				wp_enqueue_script( $this->slug.'_script' );
				wp_localize_script($this->slug.'_script', 'rdv', array(
		      		'logged' => (is_user_logged_in() ? '1' : '0')
		      		)
		    	);
				wp_enqueue_script( $this->slug.'_bootstrap' );
				wp_enqueue_script( $this->slug.'_bootstrap-toggle' );
				wp_enqueue_script( 'jquery-ui-core');
				wp_enqueue_script( 'jquery-ui-datepicker' );
				wp_localize_jquery_ui_datepicker();
			}
		}

		public function includes()
		{
			// Tables classes
			require_once( 'helpers.php' );
			require_once( 'includes/class-employee.php' );
			require_once( 'includes/class-service.php' );
			require_once( 'includes/class-userinfo.php' );
			require_once( 'includes/class-period.php' );
			require_once( 'includes/class-opening.php' );
			require_once( 'includes/class-closing.php' );
			require_once( 'includes/class-booking.php' );
			require_once( 'includes/class-stats.php' );
			require_once( 'includes/class-holiday.php' );
			require_once( 'includes/class-module.php' );
			require_once( 'includes/class-app.php' );
			
			// widget class
			require_once( 'includes/class-widget.php' );

			// shortcode class
			require_once( 'includes/class-shortcodes.php' );

			// Ajax
			require_once( 'includes/class-ajax.php' );
		}

		public function createMenu()
		{
			// Check if the menu exists
			$menu_services = __('Planning', $this->slug);
			$menu_services_exists = wp_get_nav_menu_object( $menu_services );

			// If it doesn't exist, let's create it.
			if( !$menu_services_exists){
			    $menu_services_id = wp_create_nav_menu($menu_services);

				// Set up default menu items
			    wp_update_nav_menu_item($menu_services_id, 0, array(
			        'menu-item-title' =>  __('Ouvertures', $this->slug),
			        'menu-item-status' => 'publish'));

			    wp_update_nav_menu_item($menu_services_id, 0, array(
			        'menu-item-title' =>  __('Fermetures', $this->slug),
			        'menu-item-status' => 'publish'));
			}

			$menu_managing = __("Gestion de l'application", $this->slug);
			$menu_managing_exists = wp_get_nav_menu_object( $menu_managing );

			if( !$menu_managing_exists){
			    $menu_managing_id = wp_create_nav_menu($menu_managing);
			    wp_update_nav_menu_item($menu_managing_id, 0, array(
			        'menu-item-title' =>  __('Société', $this->slug),
			        'menu-item-status' => 'publish'));

			    wp_update_nav_menu_item($menu_managing_id, 0, array(
			        'menu-item-title' =>  __('Employés', $this->slug),
			        'menu-item-status' => 'publish'));

			    wp_update_nav_menu_item($menu_managing_id, 0, array(
			        'menu-item-title' =>  __('Services', $this->slug),
			        'menu-item-status' => 'publish'));

			    wp_update_nav_menu_item($menu_managing_id, 0, array(
			        'menu-item-title' =>  __('Configuration des périodes', $this->slug),
			        'menu-item-status' => 'publish'));

		    }

		    $menu_booking = __('Module de rendez-vous', $this->slug);
			$menu_booking_exists = wp_get_nav_menu_object( $menu_booking );

			if( !$menu_booking_exists){
			    $menu_booking_id = wp_create_nav_menu($menu_booking);
			    wp_update_nav_menu_item($menu_booking_id, 0, array(
			        'menu-item-title' =>  __("Module principal", $this->slug),
			        'menu-item-status' => 'publish'));
			}
		}

		public function register_widget()
		{
			register_widget( 'AppWidget' );
		}

		public function register_admin_menu_page()
		{
			add_menu_page(
		        'Application RDV',
		        'Application RDV',
		        'level_10',
		        'app-rdv',
		        'AppBook::display_list'
		    );
		}

		public static function display_list()
		{
			load_template(appBook()->template_path."admin.php", false);
		}
	}
}
function appBook()
{
	return AppBook::instance();
}

$instApp = appBook();
if(is_admin())
{
	add_action( 'admin_menu', array('AppBook', 'register_admin_menu_page') );
}
if(!is_admin()){
	function add_custom_query_var( $vars ){
		$vars[] = "booking";
		return $vars;
	}
	add_filter( 'query_vars', 'add_custom_query_var' );

}
