<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AppResto AppUserInfo class.
 *
 */
class AppUserInfo 
{
	protected $db_name;

	public $info_id = null;

	public $datas = null;

	public $app_id = null;

	protected $editable_fields = array("firstname", "lastname", "email", "phonenumber");

	public function __construct($app_id)
	{
		global $wpdb;
		$this->app_id = (int)$app_id;
		$this->db_name = $wpdb->prefix . appBook()->slug . '_userinfo';
		$this->loadDatas();
	}

	public function loadDatas()
	{
		global $wpdb;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id}";
		$datas = $wpdb->get_row($query, OBJECT);
		if (!empty($datas))
		{
			$this->datas = $datas;
			$this->info_id = $datas->info_id;
		}
	}

	public function get($field)
	{
		global $wpdb;
		$query = "SELECT $field FROM {$this->db_name} WHERE `app_id`={$this->app_id}";
		return $wpdb->get_var($query);
	}

	public function create($user_id, $datas)
	{
		global $wpdb;
		
		$fields = array( 
			'user_id' => $user_id,
			'app_id' => $this->app_id,
			'firstname' => $datas["firstname"],
			'lastname' => $datas["lastname"],
			'email' => $datas["email"],
			'phonenumber' => $datas["phonenumber"]
		);
		$format = array(
			'%d', 
			'%d', 
			'%s',
			'%s',
			'%s',
			'%s',
		);
		return $wpdb->insert( $this->db_name, $fields, $format );
	}

	public function update($datas)
	{
		global $wpdb;

		$fields = array();
		foreach ($this->editable_fields as $key) {
			$fields[$key] = $datas[$key];
		}
		$format = array(
			'%s', '%s', '%s', '%s'
		);
		$where = array( 'app_id' => $this->app_id , 'info_id' => $this->info_id);
		$where_format = array( '%d', '%d' );
		$res = $wpdb->update( $this->db_name, $fields, $where, $format, $where_format );
		if ($res)
			$this->loadDatas();
		
		return $res;
	}
}