<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AppBook AppPeriod class.
 *
 */
class AppPeriod
{
	protected $db_name;

	public $app_id = null;

	public $datas = null;

	protected $days = array('0' => 'dimanche', '1' => 'lundi', '2' => 'mardi', '3' => 'mercredi', '4' => 'jeudi', '5' => 'vendredi', '6' => 'samedi');

	public function __construct($app_id)
	{
		global $wpdb;
		$this->app_id = (int)$app_id;
		$this->db_name = $wpdb->prefix . appBook()->slug . '_period';
		$this->loadDatas();
	}

	public function loadDatas()
	{
		global $wpdb;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id}";
		$datas = $wpdb->get_results($query, OBJECT);
		$this->datas = $datas;
	}

	public function getDays()
	{
		return $this->days;
	}

	public function getPeriodEmployeeService($employee_id, $service_id, $num_day)
	{
		global $wpdb;

		$employee_id = (int)$employee_id;
		$service_id = (int)$service_id;
		$day = (int)$day;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `employee_id`={$employee_id} AND `service_id`={$service_id} AND `day`={$num_day}";
		return $wpdb->get_results($query, OBJECT);
	}

	public function checkDayExist($employee_id, $service_id, $day)
	{
		global $wpdb;

		$employee_id = (int)$employee_id;
		$service_id = (int)$service_id;
		$day = (int)$day;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `employee_id`={$employee_id} AND `service_id`={$service_id} AND `day`={$day}";
		return $wpdb->query($query);
	}

	public function getSingle($id)
	{
		global $wpdb;

		$period_id = (int)$id;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `period_id`={$period_id}";
		$res = $wpdb->get_row($query, OBJECT);
		if ($res)
			return $res;
		else
			return null;
	}

	public function getPeriodByEmployee($id)
	{
		global $wpdb;

		$employee_id = (int)$id;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `employee_id`={$employee_id}";
		$res = $wpdb->get_results($query, ARRAY_A);
		if ($res)
			return $res;
		else
			return null;
	}

	public function create($datas)
	{
		global $wpdb;
		
		$period = $datas['hour'].':'.$datas['minute'];
		$end = $datas['end_hour'].':'.$datas['end_minute'];
		$employee_id = (int)$datas['employee_id'];
		$service_id = (int)$datas['service_id'];

		$days = $datas['day'];
		$count_days = count($days);
		$msg = array("success" => array(), "failed" => array());
		if (count($days))
		{
			foreach ($days as $k => $day) {
				$day = (int)$day;

				$valid = $this->filterByOpening($period, $end, $day);
				if(!$valid)
				{
					$msg["failed"][$this->days[$day]] = __("La période choisie est hors des heures d'ouverture du jour.", appBook()->slug);
					$check = false;
				}else{
					$check = $this->filterByDay($employee_id, $service_id, $period, $end, $day);
				}

				if ($check)
				{
					$fields = array( 
						'app_id' => $this->app_id,
						'employee_id' => $employee_id,
						'service_id' => $service_id,
						'day' => $day,
						'period' => $period,
						'end' => $end
					);
					$format = array(
						'%d',
						'%d',
						'%d',
						'%d',
						'%s',
						'%s'
					);
					$res = $wpdb->insert( $this->db_name, $fields, $format );
					if($res)
						$msg["success"][] = $this->days[$day];
					else
						$msg["failed"][$this->days[$day]] = __("Une erreur est survenue lors de l'ajout de la période.", appBook()->slug);
					
				}
				else
					$msg["failed"][$this->days[$day]] = __("La période choisie est inclue dans une période déjà définie pour ce jour.", appBook()->slug);
			}
		}else{
			$msg["failed"]['Erreur'] = __("Aucun jour n'a été sélectionné.", appBook()->slug);
		}
		return $msg;
		// else{
		// 	$day = (int)$datas['day'][0];

		// 	$valid = $this->filterByOpening($period, $end, $day);

		// 	if ($valid)
		// 	{
		// 		$fields = array( 
		// 			'app_id' => $this->app_id,
		// 			'employee_id' => $employee_id,
		// 			'service_id' => $service_id,
		// 			'day' => $day,
		// 			'period' => $period,
		// 			'end' => $end
		// 		);
		// 		$format = array(
		// 			'%d',
		// 			'%d',
		// 			'%d',
		// 			'%d',
		// 			'%s',
		// 			'%s'
		// 		);
		// 		$res = $wpdb->insert( $this->db_name, $fields, $format );

		// 		return $res;
		// 	}
		// 	else
		// 		return false;
		// }
		
	}

	public function update($datas)
	{
		global $wpdb;

		$period = $datas['hour'].':'.$datas['minute'];
		$end = $datas['end_hour'].':'.$datas['end_minute'];
		$employee_id = (int)$datas['employee_id'];
		$period_id = (int)$datas['period_id'];
		$day = (int)$datas['day'];

		$valid = $this->filterByOpening($period, $end, $day);
		if(!$valid)
			return false;
		else
			$check = $this->filterByDay($employee_id, $period_id, $period, $end, $day, $period_id);
		
		if($check)
		{
			$fields = array('period' => $period, 'end' => $end, 'day' => $day);
			$format = array('%s', '%s', '%d');
			$where = array( 'period_id' => $period_id, 'app_id' => $this->app_id, 'employee_id' => $employee_id );
			$where_format = array( '%d', '%d', '%d' );
			$res = $wpdb->update( $this->db_name, $fields, $where, $format, $where_format );
			return $res;
		}
		else
			return false;
	}

	public function delete($id)
	{
		global $wpdb;
		
		$period_id = (int)$id;
		return $wpdb->delete($this->db_name, array('app_id' => $this->app_id, 'period_id' => $period_id), '%d');
	}

	public function getFieldById($id, $field)
	{
		global $wpdb;

		$period_id = (int)$id;
		$query = "SELECT `{$field}` FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `period_id`={$period_id}";
		return $wpdb->get_var($query);
	}

	public function getByEmployeeService($employee_id, $service_id)
	{
		global $wpdb;

		$employee_id = (int)$employee_id;
		$service_id = (int)$service_id;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `employee_id`={$employee_id} AND `service_id`={$service_id} ORDER BY `day` ASC";
		$res = $wpdb->get_results($query, ARRAY_A);
		if ($res)
			return $res;
		else
			return null;
	}

	public function getByService($service_id)
	{
		global $wpdb;

		$service_id = (int)$service_id;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `service_id`={$service_id}";
		$res = $wpdb->get_results($query, ARRAY_A);
		if ($res)
			return $res;
		else
			return null;
	}
	public function getByServiceDate($service_id, $num_date)
	{
		global $wpdb;

		$service_id = (int)$service_id;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `service_id`={$service_id} AND `day`={$num_date}";
		$res = $wpdb->get_results($query, OBJECT);
		if ($res)
			return $res;
		else
			return null;
	}

	/*
	** Check if the time is included in the opening time for the day.
	*/
	public function filterByOpening($start, $end, $_day)
	{
		// $start = timeStringToInt($_start);
		// $end = timeStringToInt($_end);
		$day = (int)$_day;
		if($start >= $end)
			return false;
		$opening = new AppOpening($this->app_id);
		$day_opens = $opening->getOpenings($day);
		$valid = 0;
		foreach ($day_opens[$day] as $key => $day_open) {
			if( isInRefTime($day_open['start'], $day_open['end'], $start, $end) )
				$valid++;
		}
		if($valid)
			return true;
		else
			return false;
	}

	/*
	** Check if the given time is out to the time period registered for the day
	*/
	public function filterByDay($_employee_id, $_service_id, $start, $end, $_day, $period_id = 0){
		$employee_id = (int)$_employee_id;
		$service_id = (int)$_service_id;
		// $start = timeStringToInt($_start);
		// $end = timeStringToInt($_end);
		$day = (int)$_day;
		global $wpdb;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `employee_id`={$employee_id} AND `service_id`={$service_id} AND `day`={$day}";
		$res = $wpdb->query($query);
		if(!$res)
			return true;
		else{
			$results = $wpdb->last_result;
			$check = 0;
			foreach ($results as $result) {
				$res_start = timeStringToInt($result->period);
				$res_end = timeStringToInt($result->end);
				// if ( ($res_start > $start || $start >= $res_end) && ($res_start > $end || $end > $res_end) )
				if (isOutRefTime($res_start, $res_end, $start, $end))
					continue;
				elseif ($period_id != 0 && $period_id == $result->period_id) {
					continue;
				}
				else
					return false;
			}
			return true;
		}
	}

	public function checkPeriodByEmployee($employee_id, $start, $end, $days, $period_id = 0)
	{
		global $wpdb;
		$employee_id = (int)$employee_id;
		$days = implode(',', $days);
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `day` IN ('{$days}') AND `employee_id`={$employee_id}";
		$res = $wpdb->query($query);
		if(!$res)
		{
			return true;
		}
		else
		{
			$results = $wpdb->last_result;
			foreach ($results as $result) {
				if (isOutRefTime($result->period, $result->end, $start, $end))
					continue;
				elseif ($period_id != 0 && $period_id == $result->period_id) {
					continue;
				}
				else
					return false;
			}
			return true;
		}
	}

}