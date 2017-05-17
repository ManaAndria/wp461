<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AppEmployee class.
 *
 */
class AppEmployee 
{
	protected $db_name;

	public $datas = null;

	public $app_id = null;

	protected $editable_fields = array("firstname", "lastname", "email", "country_code", "phonenumber", "poste");
	
	protected $required_fields = array("firstname", "lastname", "email", "poste");

	public function __construct($app_id)
	{
		global $wpdb;
		$this->app_id = (int)$app_id;
		$this->db_name = $wpdb->prefix . appBook()->slug . '_employee';
		$this->loadDatas();
	}

	public function loadDatas()
	{
		global $wpdb;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id}";
		$datas = $wpdb->get_results($query, OBJECT);
		//$service = new AppService($this->app_id);
		// foreach ($datas as $key => $data) {
		// 	$datas[$key]->poste_name = $service->getServiceName($data->poste);
		// }
		$this->datas = $datas;
	}
	// public static function getEmployeesWithService($app_id)
	// {
	// 	global $wpdb;
	// 	$query = "SELECT e.*, s.* FROM `".$wpdb->prefix . appBook()->slug ."_employee` as e LEFT JOIN `".$wpdb->prefix. appBook()->slug."_service` as s ON s.app_id=e.app_id WHERE e.`app_id`=".$app_id;
	// 	$datas = $wpdb->get_results($query, OBJECT);
	// 	return $datas;
	// }

	public function getEditableFields()
	{
		return $this->editable_fields;
	}

	public function getRequiredFields()
	{
		return $this->required_fields;
	}

	public function getSingle($id)
	{
		global $wpdb;
		$employee_id = (int)$id;
		$query = "SELECT * FROM {$this->db_name} WHERE `employee_id`={$employee_id}";
		return $wpdb->get_row($query, OBJECT);
	}

	public function create($datas)
	{
		global $wpdb;

		foreach ($this->required_fields as $value) {
			if ($datas[$value] == '')
				return array(__('Certains champs sont invalides'));
		}
		
		$fields = array('app_id' => $this->app_id);
		foreach ($this->editable_fields as $key) {
			if($key == 'poste')
			{
				$fields[$key] = json_encode($datas[$key]);
			}
			else
				$fields[$key] = $datas[$key];
		}
		$format = array(
			'%d',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s'
		);
		$res = $wpdb->insert( $this->db_name, $fields, $format );
		if ($res)
			$this->loadDatas();

		return $res;
	}

	public function update($datas)
	{
		global $wpdb;

		foreach ($this->required_fields as $value) {
			if ($datas[$value] == '')
				return array(__('Certains champs sont invalides'));
		}
		$employee_id = (int)$datas['employee_id'];
		$fields = array();
		foreach ($this->editable_fields as $key) {
			if($key == 'poste')
			{
				$fields[$key] = json_encode($datas[$key]);
			}
			else
				$fields[$key] = $datas[$key];
		}
		$format = array(
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s'
		);
		$where = array( 'app_id' => $this->app_id, 'employee_id' => $employee_id );
		$where_format = array( '%d', '%d' );
		$res = $wpdb->update( $this->db_name, $fields, $where, $format, $where_format );
		if ($res)
			$this->loadDatas();
		
		return $res;
	}

	public function delete($id)
	{
		global $wpdb;
		
		$employee_id = (int)$id;
		return $wpdb->delete($this->db_name, array('app_id' => $this->app_id, 'employee_id' => $employee_id), '%d');
	}

	public function getByPoste($poste)
	{
		global $wpdb;
		$poste = '"'.$poste.'"';
		// $query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `poste`={$poste}";
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `poste` LIKE '%{$poste}%'";
		$res = $wpdb->get_results($query);
		return ( $res ? $res : null );
	}
}