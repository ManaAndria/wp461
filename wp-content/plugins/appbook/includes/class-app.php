<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * App class.
 *
 */
class App
{
	protected $db_name;

	public $app_id = null;

	public $datas = null;

	public $employee = null;

	public $service = null;
	
	public $userinfo =null;
	
	public $period = null;

	public $booking = null;

	public $opening = null;
	
	public $closing = null;
	
	public $stats = null;

	public $holiday = null;

	public $module = null;

	public $user_id;

	protected $editable_fields = array("app_name", "address", "zip", "city", "hour_zone", "country_code", "email_contact", "phonenumber", "currency"/*, "days_last_booking", "capacity", "message"*/);

	protected $required_fields = array("app_name", "address", "zip", "city", "hour_zone", "country_code", "email_contact", "phonenumber", "currency"/*, "capacity"*/);

	public function __construct($user_id)
	{
		if($user_id == 0)
			return null;
		global $wpdb;

		$this->db_name = $wpdb->prefix . appBook()->slug . '_app';
		$this->user_id = (int)$user_id;
		$this->loadDatas();
		if($this->app_id == null)
			return null;
		if ($this->app_id)
			$this->load();
	}
	
	public static function getInformations($app_id){
		global $wpdb;
		$query = "SELECT * FROM `".$wpdb->prefix."appbook_app` WHERE `app_id`=".$app_id;
		$datas = $wpdb->get_row($query, OBJECT);
		return $datas;
	}

	public function loadDatas()
	{
		global $wpdb;
		$query = "SELECT * FROM {$this->db_name} WHERE `user_id`={$this->user_id}";
		$datas = $wpdb->get_row($query, OBJECT);
		if (!empty( $datas) )
		{
			$this->datas = $datas;
			if ($this->app_id == null)
				$this->app_id = (int)$datas->app_id;
		}
		
	}

	public function load()
	{
		$this->employee = new AppEmployee($this->app_id);
		$this->service = new AppService($this->app_id);
		$this->userinfo = new AppUserInfo($this->app_id);
		$this->period = new AppPeriod($this->app_id);
		$this->booking = new AppBooking($this->app_id);
		$this->opening = new AppOpening($this->app_id);
		$this->closing = new AppClosing($this->app_id);
		$this->stats = new AppStats($this->app_id);
		$this->holiday = new AppHoliday($this->app_id);
		$this->module = new AppModule($this->app_id);
	}

	public function getRequiredFields()
	{
		return $this->required_fields;
	}

	public function create($user_id, $datas)
	{
		global $wpdb;

		$user_id = (int)$user_id;
		$field = array( 
			'user_id' => $user_id,
		);
		$format = array(
			'%d' 
		);
		$app = $wpdb->insert( $this->db_name, $field, $format );
		$app_id = $wpdb->insert_id;

		$info = new AppUserInfo($app_id);
		$create = $info->create($user_id, $datas);

		return $create;
	}

	public function update($datas)
	{
		global $wpdb;

		$fields = array();
		foreach ($this->editable_fields as $key) {
			$fields[$key] = $datas[$key];
		}
		$fields["country_name"] = $datas["country_name"];
		$format = array(
			'%s', '%s', '%s', '%s','%s', '%s', '%s', '%s', '%s'
		);
		$format[] = '%s';
		$where = array( 'app_id' => $this->app_id , 'user_id' => $this->user_id);
		$where_format = array( '%d', '%d' );
		$res = $wpdb->update( $this->db_name, $fields, $where, $format, $where_format );
		if ($res)
			$this->loadDatas();
		
		return $res;
	}

	public function deleteAll($app_id)
	{
		global $wpdb;
		
		if($this->employee->datas !== null){ // employee
			$employee = $wpdb->delete($wpdb->prefix.'appbook_employee', array('app_id' => $app_id), '%d');
			if($employee === false)
				return false;
		}
		if($this->service->datas !== null){ // service
			$service = $wpdb->delete($wpdb->prefix.'appbook_service', array('app_id' => $app_id), '%d');
			if($service === false)
				return false;
		}
		if($this->period->datas !== null){ // period
			$period = $wpdb->delete($wpdb->prefix.'appbook_period', array('app_id' => $app_id), '%d');
			if($period === false)
				return false;
		}
		if($this->opening->datas !== null){ // openings
			$opening = $wpdb->delete($wpdb->prefix.'appbook_opening', array('app_id' => $app_id), '%d');
			if($opening === false)
				return false;
		}
		if($this->closing->datas !== null){ // closing
			$closing = $wpdb->delete($wpdb->prefix.'appbook_closing', array('app_id' => $app_id), '%d');
			if($closing === false)
				return false;
		}
		if($this->holiday->datas !== null){ // holiday
			$holiday = $wpdb->delete($wpdb->prefix.'appbook_holiday', array('app_id' => $app_id), '%d');
			if($holiday === false)
				return false;
		}
		if($this->booking->datas !== null){ // booking
			$booking = $wpdb->delete($wpdb->prefix.'appbook_booking', array('app_id' => $app_id), '%d');
			if($booking === false)
				return false;
		}
		if($this->module->datas !== null){ // module
			$module = $wpdb->delete($wpdb->prefix.'appbook_module', array('app_id' => $app_id), '%d');
			if($module === false)
				return false;
		}
		if($this->userinfo->datas !== null){ // userinfo
			$userinfo = $wpdb->delete($wpdb->prefix.'appbook_userinfo', array('app_id' => $app_id), '%d');
			if($userinfo === false)
				return __("Les informations de son compte n'ont pas été supprimées.", appBook()->slug);
		}
		$appli = $wpdb->delete($wpdb->prefix.'appbook_app', array('app_id' => $app_id), '%d'); // app
		// return 'appli:'.$appli;
		if($appli === false)
			return __("Les informations de la société n'ont pas été supprimées.", appBook()->slug);
		return true;
	}

	public function updateDisplayEmployee($display_employee)
	{
		global $wpdb;
		$display_employee = (int)$display_employee;
		$where = array( 'app_id' => $this->app_id );
		$where_format = array( '%d' );
		return $wpdb->update( $this->db_name, array('display_employee' => $display_employee), $where, array("%d"), $where_format );
	}

	public function updateColor($update_color)
	{
		global $wpdb;
		$where = array( 'app_id' => $this->app_id );
		$where_format = array( '%d' );
		return $wpdb->update( $this->db_name, array('color' => $update_color), $where, array("%s"), $where_format );
	}
}