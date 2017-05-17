<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AppBook AppService class.
 *
 */
class AppService 
{
	protected $db_name;

	public $service_id = null;

	public $datas = null;

	public $app_id = null;

	public function __construct($app_id)
	{
		global $wpdb;
		
		$this->app_id = (int)$app_id;
		$this->db_name = $wpdb->prefix . appBook()->slug . '_service';
		$this->loadDatas();
	}

	public function loadDatas()
	{
		global $wpdb;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id}";
		$this->datas = $wpdb->get_results($query, OBJECT);
	}

	public function getServiceName($service_id)
	{
		global $wpdb;

		$service_id = (int)$service_id;
		$db_name = $wpdb->prefix . appBook()->slug . '_service';
		$query = "SELECT service_name FROM {$db_name} WHERE `app_id`={$this->app_id} AND `service_id`={$service_id}";
		$res = $wpdb->get_var($query);
		return $res;
	}

	public function getSingle($id)
	{
		global $wpdb;
		$service_id = (int)$id;
		$query = "SELECT * FROM {$this->db_name} WHERE `service_id`={$service_id}";
		return $wpdb->get_row($query, OBJECT);
	}

	public function create($datas)
	{
		global $wpdb;
		
		$fields = array( 
			'app_id' => $this->app_id,
			'service_name' => $datas["service_name"],
			'duration' => $datas['duration'],
			'description' => $datas['description']
		);
		$format = array(
			'%d', 
			'%s',
			'%s',
			'%s',
		);

		if (isset($datas['price']))
		{
			$price = floatval(trim(str_replace(',', '.', str_replace(' ', '', $datas['price']))));
			$fields['price'] = number_format($price, 2, ',', ' ');
			$format[] = '%s';
		}
		else{
			$fields['price'] = '';
			$format[] = '%s';
		}

		$res = $wpdb->insert( $this->db_name, $fields, $format );
		if ($res)
			$this->loadDatas();

		return $res;
	}

	public function update($datas)
	{
		global $wpdb;
		$service_id = (int)$datas['service_id'];
		$fields = array('service_name' => $datas['service_name'], 'duration' => $datas['duration'], 'description' => $datas['description']);
		$format = array('%s','%s','%s');
		if (isset($datas['price']))
		{
			$price = floatval(trim(str_replace(',', '.', str_replace(' ', '', $datas['price']))));
			$fields['price'] = number_format($price, 2, ',', ' ');
			$format[] = '%s';
			// return floatval($_datas['price']);
		}
		else{
			$fields['price'] = '';
			$format[] = '%s';
		}
		$where = array( 'app_id' => $this->app_id, 'service_id' => $service_id );
		$where_format = array( '%d', '%d' );
		$res = $wpdb->update( $this->db_name, $fields, $where, $format, $where_format );
		if ($res)
			$this->loadDatas();
		
		return $res;
	}

	public function delete($id)
	{
		global $wpdb;
		
		$service_id = (int)$id;
		return $wpdb->delete($this->db_name, array('app_id' => $this->app_id, 'service_id' => $service_id), '%d');
	}

	public function getFieldById($id, $field)
	{
		global $wpdb;

		$service_id = (int)$id;
		$query = "SELECT `{$field}` FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `service_id`={$service_id}";
		return $wpdb->get_var($query);
	}
}