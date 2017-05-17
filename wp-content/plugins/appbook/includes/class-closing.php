<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AppBook AppClosing class.
 *
 */
class AppClosing
{
	protected $db_name;

	public $app_id = null;
	
	public $datas = null;

	protected $frequency = array('aucune', 'annuelle', 'hebdomadaire');

	public function __construct($app_id)
	{
		global $wpdb;
		$this->app_id = (int)$app_id;
		$this->db_name = $wpdb->prefix . appBook()->slug . '_closing';
		$this->loadDatas();
	}

	public function loadDatas()
	{
		global $wpdb;

		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id}";
		$results = $wpdb->get_results($query, OBJECT);
		if ($results)
		{
			foreach ($results as $key => $result) {
				$results[$key]->frequency = $this->frequency[$result->frequency];
			}
			$this->datas = $results;
		}
	}

	public function checkIfCloseDay($num_day, $val_day) {
		global $wpdb;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id}";
		$results = $wpdb->get_results($query, OBJECT);

		$date_lists = array();
		$tmstmp_appointment_day = strtotime($val_day);
		$j = 0;
		foreach ($results as $data) {
			$date_lists[$j]['start'] = $data->start;
			$date_lists[$j]['end'] = $data->end;
			$date_lists[$j]['frequency'] = (int)$data->frequency;
			$date_lists[$j]['day'] = $data->day;
			$j++;
		}
		foreach ($date_lists as $date_list) {
			$tmstmp_start = strtotime($date_list['start']);
			$tmstmp_end = strtotime($date_list['end']);
			if ((int)$date_list['frequency'] != 2) {
				if ($tmstmp_start <= $tmstmp_appointment_day && $tmstmp_appointment_day <= $tmstmp_end) {
					return false;
					exit();
				}
			} else {
				$all_days = json_decode($date_list['day']);
				for($k = 0; $k < count($all_days); $k++) {
					if ((int)$all_days[$k] == (int)$num_day) {
						return false;
						exit();
					}
					$k++;
				}
			}
		}
		return true;
		exit();
	}

	public function getFrequency()
	{
		return $this->frequency;
	}

	public function getSingle($id)
	{
		global $wpdb;

		$closing_id = (int)$id;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `closing_id`={$closing_id}";
		$res = $wpdb->get_row($query, OBJECT);
		if ($res)
		{
			
			$res->frequency = $this->frequency[$res->frequency];
			return $res;
		}
		else
			return null;
	}

	public function create($datas)
	{
		global $wpdb;


		$start = $datas['start'];
		$end = $datas['end'];
		$frequency = (int)$datas['frequency'];
		if($frequency == 2)
		{
			$_days = $datas['day'];
			$is_duplicate = $this->isDuplicated($_days);
			if($is_duplicate === false){
				$days = json_encode($datas['day']);
				$fields = array( 
					'app_id' => $this->app_id,
					'frequency' => $frequency,
					'day' => $days
				);
				$format = array(
					'%d',
					'%d',
					'%s'
				);
				$res = $wpdb->insert( $this->db_name, $fields, $format );
			}
			else{
				return array(__('Un ou plusieurs des jours selectionnés sont déjà fériés.', appBook()->slug));
			}
		}
		else
		{
			$fields = array( 
				'app_id' => $this->app_id,
				'start' => $start,
				'end' => $end,
				'frequency' => $frequency
			);
			$format = array(
				'%d', 
				'%s',
				'%s',
				'%d',
			);
			$res = $wpdb->insert( $this->db_name, $fields, $format );
		}
		if ($res)
			$this->loadDatas();

		return $res;
	}

	public function update($datas)
	{
		global $wpdb;

		$closing_id = (int)$datas['closing_id'];
		$start = $datas['start'];
		$end = $datas['end'];
		$frequency = (int)$datas['frequency'];
		if($frequency == 2)
		{
			// $_days = $datas['day'];
			// $is_duplicate = $this->isDuplicated($_days);
			// if($is_duplicate === false){
				$day = json_encode($datas['day']);
				$fields = array( 
					'frequency' => $frequency,
					'day' => $day
				);
				$format = array(
					'%d',
					'%s',
				);
				$where = array( 'app_id' => $this->app_id, 'closing_id' => $closing_id );
				$where_format = array( '%d', '%d' );
				$res = $wpdb->update( $this->db_name, $fields, $where, $format, $where_format );
			// }else{
			// 	return array(__('Un ou plusieurs des jours selectionnés sont déjà fériés.', appBook()->slug));
			// }
		}
		else{
			$fields = array( 
				'start' => $start,
				'end' => $end,
				'frequency' => $frequency
			);
			$format = array(
				'%s',
				'%s',
				'%d'
			);
			$where = array( 'app_id' => $this->app_id, 'closing_id' => $closing_id );
			$where_format = array( '%d', '%d' );
			$res = $wpdb->update( $this->db_name, $fields, $where, $format, $where_format );
		}
		if ($res)
			$this->loadDatas();
		return $res;
	}

	public function delete($id)
	{
		global $wpdb;
		
		$closing_id = (int)$id;
		return $wpdb->delete($this->db_name, array('app_id' => $this->app_id, 'closing_id' => $closing_id), '%d');
	}

	public function isDuplicated($days)
	{
		global $wpdb;

		$and_where = '';
		foreach ($days as $kd => $day) {
			$and_where .= ($kd != 0 ? " OR " : "")."`day` LIKE '%$day%'";
		}
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND ({$and_where})";
		if($wpdb->query($query))
			return true;
		else
			return false;
	}

	public function getClosingEventsSingle()
	{
		global $wpdb;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `frequency`=0 ORDER BY `start` ASC ";
		$results = $wpdb->get_results($query, OBJECT);
		$ret = [];
		foreach ($results as $result) {
			$ret[] = array(
				'start' => $result->start." 00:00:00",
				'end' => $result->end." 23:59:59",
			);
		}
		return $ret;
	}

	public function getClosingEventsFrequenty()
	{
		global $wpdb;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `frequency`=1 ORDER BY `start` ASC ";
		$results = $wpdb->get_results($query, OBJECT);
		$ret = [];
		foreach ($results as $result) {
			$ret[] = array(
				'start' => $result->start." 00:00:00",
				'end' => $result->end." 23:59:59",
			);
		}
		return $ret;
	}

	function getWeeklyClosingDays()
	{
		global $wpdb;

		$weekly_closings = $wpdb->get_results("SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `frequency`=2");
		$ret = array();
		if($weekly_closings !== null){
			foreach ($weekly_closings as $weekly_closing) {
				$days = json_decode($weekly_closing->day);
				foreach ($days as $day) {
					$ret[] = (int)$day;
				}
			}
		}
		return $ret;
	}
}