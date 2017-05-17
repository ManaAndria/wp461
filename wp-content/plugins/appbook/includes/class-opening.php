<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AppBook AppOpening class.
 *
 */
class AppOpening
{
	protected $db_name;

	public $app_id = null;

	public $datas = null;

	public $days = array('0' => 'dimanche', '1' => 'lundi', '2' => 'mardi', '3' => 'mercredi', '4' => 'jeudi', '5' => 'vendredi', '6' => 'samedi');

	public function __construct($app_id)
	{
		global $wpdb;
		$this->app_id = (int)$app_id;
		$this->db_name = $wpdb->prefix . appBook()->slug . '_opening';
		$this->loadDatas();
	}

	public function loadDatas()
	{
		global $wpdb;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id}";
		$this->datas = $wpdb->get_results($query, OBJECT);
	}

	public function getOpeningsByDay($day)
	{
		global $wpdb;

		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `day`={$day}";
		return $wpdb->get_results($query, OBJECT);
	}

	public function getSingle($id)
	{
		global $wpdb;

		$opening_id = (int)$id;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `opening_id`={$opening_id}";
		$res = $wpdb->get_row($query, OBJECT);
		if ($res)
			return $res;
		else
			return null;
	}

	public function getOpenings($day = null)
	{
		global $wpdb;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id}";
		if($day != null)
			$query .= " AND `day`={$day}";
		else
			$query .= " ORDER BY `day` ASC";
		$results = $wpdb->get_results($query, OBJECT);
		$ret = [];
		foreach ($results as $result) {
			$ret[$result->day][] = array('start' => $result->start, 'end' => $result->end) ;
		}
		return $ret;
	}

	public function getServiceByDay($day)
	{
		global $wpdb;
		$day = (int)$day;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `day`={$day}";
		return $wpdb->get_results($query, OBJECT);
	}

	public function create($datas)
	{
		global $wpdb;

		$day = (int)$datas['day'];
		$start = $datas['start-hour'].':'.$datas['start-minute'];
		$end = $datas['end-hour'].':'.$datas['end-minute'];

		if($start >= $end)
			return false;
		
		$fields = array( 
			'app_id' => $this->app_id,
			'day' => $day,
			'start' => $start,
			'end' => $end,
		);
		$format = array(
			'%d', 
			'%d',
			'%s',
			'%s'
		);
		return $wpdb->insert( $this->db_name, $fields, $format );
	}

	public function update($datas)
	{
		global $wpdb;

		$opening_id = (int)$datas['opening_id'];
		$start = $datas['start-hour'].':'.$datas['start-minute'];
		$end = $datas['end-hour'].':'.$datas['end-minute'];
		
		if($start >= $end)
			return false;
		
		$fields = array(
			'start' => $start,
			'end' => $end,
		);
		$format = array(
			'%s',
			'%s'
		);
		$where = array( 'app_id' => $this->app_id, 'opening_id' => $opening_id );
		$where_format = array( '%d', '%d' );
		return $wpdb->update( $this->db_name, $fields, $where, $format, $where_format );
	}

	public function delete($id)
	{
		global $wpdb;
		
		$opening_id = (int)$id;
		return $wpdb->delete($this->db_name, array('app_id' => $this->app_id, 'opening_id' => $opening_id), '%d');
	}

	public function getDayOff()
	{
		global $wpdb;
		$ret = [];
		foreach ($this->days as $key => $value) {
			$res = $wpdb->query("SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `day`={$key}");
			if(!$res)
				$ret[] = $key;
		}
		$closing_db = $wpdb->prefix . appBook()->slug . '_closing';
		$weekly_closings = $wpdb->get_results("SELECT * FROM {$closing_db} WHERE `app_id`={$this->app_id} AND `frequency`=2");
		if($weekly_closings !== null)
		{
			foreach ($weekly_closings as $weekly_closing) {
				$days = json_decode($weekly_closing->day);
				foreach ($days as $day) {
					$_day = (int)$day;
					if(!in_array($_day, $ret))
						$ret[] = $_day;
				}
			}
		}
		return $ret;
	}

	public function getBusinessHours()
	{
		global $wpdb;
		$ret = [];
		foreach ($this->days as $key => $value) {
			$res = $wpdb->get_row("SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `day`={$key}", OBJECT);
			if ($res)
				$ret[] = array( 'dow' => array($key), 'start' => $res->start, 'end' => $res->end );
		}
		return $ret;
	}
}