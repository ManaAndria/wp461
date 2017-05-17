<?php
if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * AppBook AppHoliday class.
 *
 */
class AppHoliday
{
	protected $db_name;

	public $datas = null;

	public $app_id = null;

	protected $editable_fields = array("date", "employee_id", "country_code", "all_day", "poste");
	
	protected $required_fields = array("date", "employee_id");

	public function __construct($app_id)
	{
		global $wpdb;
		$this->app_id = (int)$app_id;
		$this->db_name = $wpdb->prefix . appBook()->slug . '_holiday';
		$this->loadDatas();
	}

	public function loadDatas()
	{
		global $wpdb;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id}";
		
		$datas = $wpdb->get_results($query, OBJECT);
		$this->datas = $datas;
	}
	public function getHolidayByEmployee($employee_id) {
		global $wpdb;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `employee_id`=".(int)$employee_id;
		
		$datas = $wpdb->get_results($query, OBJECT);

		return $datas;
	}
	public function getEmployeeIfHolidayOneDay($day, $employee_id=0) {
		global $wpdb;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `date`='".$day."' AND `one_day`=1 AND `all_day`=0 AND `employee_id`=".(int)$employee_id;
		$datas = $wpdb->get_results($query, OBJECT);

		return $datas;
	}
	public function checkEmployeeIfHolidaybyDate($day, $employee_id=0) {
		$holidays = array();
		$i = 0;
		$f_holidays = ($employee_id ? $this->getHolidayByEmployee($employee_id) : $this->datas);
		$tmstmp_appointment_day = strtotime($day);
		foreach ($f_holidays as $data) {
			$holidays[$i]['one_day'] = (int)$data->one_day;
			$holidays[$i]['date'] = $data->date;
			$holidays[$i]['date_start'] = $data->date_start;
			$holidays[$i]['date_end'] = $data->date_end;
			$holidays[$i]['all_day'] = (int)$data->all_day;
			$holidays[$i]['start'] = $data->start;
			$holidays[$i]['end'] = $data->end;
			$i++;
		}
		foreach ($holidays as $holiday) {
			$tmstmp_start = strtotime($holiday['date_start']);
			$tmstmp_end = strtotime($holiday['date_end']);
			if (!$holiday['one_day']) {
				if ($tmstmp_start <= $tmstmp_appointment_day && $tmstmp_appointment_day <= $tmstmp_end) {
					return false;
					exit();
				}
			}
		}
		return true;
		exit();
	}
	public function loadDatasOrderBy($orderby){
		global $wpdb;
		$query = "SELECT h.*, e.firstname, e.lastname, s.service_name FROM {$this->db_name} as h LEFT JOIN `".$wpdb->prefix.appBook()->slug."_employee` as e ON e.employee_id = h.employee_id 
		LEFT JOIN `".$wpdb->prefix.appBook()->slug."_service` as s ON s.service_id = h.service_id 
		WHERE h.`app_id`={$this->app_id}";
		switch ((int)$orderby) {
			//orderby date desc
			case 1:
				$query .= " ORDER BY h.date_start DESC";
				break;
			//orderby date asc
			case 2:
				$query .= " ORDER BY h.date_start ASC";
				break;
			//orderby date desc
			case 7:
				$query .= " ORDER BY h.date_end DESC";
				break;
			//orderby date asc
			case 8:
				$query .= " ORDER BY h.date_end ASC";
				break;
			//orderby firstname desc
			case 3:
				$query .= " ORDER BY e.firstname DESC";
				break;
			//orderby firstname asc
			case 4:
				$query .= " ORDER BY e.firstname ASC";
				break;

			default:
				$query .= " ORDER BY h.date ASC";
				break;
		}
		return $wpdb->get_results($query, OBJECT);
	}
	public function getSingle($id)
	{
		global $wpdb;
		$holiday_id = (int)$id;
		$query = "SELECT * FROM {$this->db_name} WHERE `holiday_id`={$holiday_id}";
		return $wpdb->get_row($query, OBJECT);
	}
	public function create($datas)
	{
		global $wpdb;
		if (!(int)$datas['employee_id']) {
			return array(__('Employé(e) invalide.'));
		}
		$datebrute = explode('-', $datas['date']);
		$fields = array(
			'app_id' => $this->app_id,
			'employee_id' => $datas['employee_id'],
			'date' => $datebrute[2].'-'.$datebrute[1].'-'.$datebrute[0]
			);
		$fields['one_day'] = 0;
		$fields['all_day'] = 1;
		$fields['start'] = '';
		$fields['end'] = '';

		if ((int)$datas['one_day'] === 1) {
			if($datas['all_day'] === null)
			{
				if ($datas['h_start'] == "" || $datas['m_start'] == "" || $datas['h_end'] == "" || $datas['m_end'] == "") {
					return array(__('Certains champs de la période sont incorrectes.'));
				} elseif ((int)$datas['h_start'] > (int)$datas['h_end']) {
					return array(__('L\'heure de début du congé doit être inférieure à celle de la fin.'));
				}

				$holiday_start = sprintf('%02d', $datas['h_start']).':'.sprintf('%02d', $datas['m_start']);
				$holiday_end = sprintf('%02d', $datas['h_end']).':'.sprintf('%02d', $datas['m_end']);
				$fields['all_day'] = 0;
				$fields['start'] = $holiday_start;
				$fields['end'] = $holiday_end;
				$fields['one_day'] = 1;
			}
			elseif ((int)$datas['all_day'] === 1) {
				$fields['all_day'] = 1;
				$fields['one_day'] = 1;
			}
			$fields['date_start'] = $fields['date'];
			$fields['date_end'] = $fields['date'];
		}
		elseif ($datas['one_day'] === null) {
			$date_start_brute = explode('-', $datas['date_start']);
			$date_end_brute = explode('-', $datas['date_end']);
			$fields['date_start'] = $date_start_brute[2].'-'.$date_start_brute[1].'-'.$date_start_brute[0];
			$fields['date_end'] = $date_end_brute[2].'-'.$date_end_brute[1].'-'.$date_end_brute[0];
			$fields['one_day'] = 0;
			$fields['all_day'] = 0;
		}
		
		$format = array(
			'%d',
			'%d',
			'%s',
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
		$holiday_id = (int)$datas['holiday_id'];
		$datebrute = explode('-', $datas['date']);
		
		$fields = array(
			'app_id' => $this->app_id,
			'employee_id' => $datas['employee_id'],
			'date' => $datebrute[2].'-'.$datebrute[1].'-'.$datebrute[0]
			);
		$fields['one_day'] = 0;
		$fields['all_day'] = 1;
		$fields['start'] = '';
		$fields['end'] = '';
		
		if ((int)$datas['one_day'] === 1) {
			if($datas['all_day'] === null)
			{
				if ($datas['h_start'] == "" || $datas['m_start'] == "" || $datas['h_end'] == "" || $datas['m_end'] == "") {
					return array(__('Certains champs de la période sont incorrectes.'));
				} elseif ((int)$datas['h_start'] > (int)$datas['h_end']) {
					return array(__('L\'heure de début du congé doit être inférieure à celle de la fin.'));
				}

				$holiday_start = sprintf('%02d', $datas['h_start']).':'.sprintf('%02d', $datas['m_start']);
				$holiday_end = sprintf('%02d', $datas['h_end']).':'.sprintf('%02d', $datas['m_end']);
				$fields['all_day'] = 0;
				$fields['start'] = $holiday_start;
				$fields['end'] = $holiday_end;
				$fields['one_day'] = 1;
			}
			elseif ((int)$datas['all_day'] === 1) {
				$fields['all_day'] = 1;
				$fields['one_day'] = 1;
			}
			$fields['date_start'] = $fields['date'];
			$fields['date_end'] = $fields['date'];
		}
		elseif ($datas['one_day'] === null) {
			$date_start_brute = explode('-', $datas['date_start']);
			$date_end_brute = explode('-', $datas['date_end']);
			$fields['date_start'] = $date_start_brute[2].'-'.$date_start_brute[1].'-'.$date_start_brute[0];
			$fields['date_end'] = $date_end_brute[2].'-'.$date_end_brute[1].'-'.$date_end_brute[0];
			$fields['one_day'] = 0;
			$fields['all_day'] = 0;
		}
		
		$format = array(
			'%d',
			'%d',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s'
		);
		$where = array( 'app_id' => $this->app_id, 'holiday_id' => $holiday_id );
		$where_format = array( '%d', '%d' );

		$res = $wpdb->update( $this->db_name, $fields, $where, $format, $where_format );
		if ($res)
			$this->loadDatas();
		
		return $res;
	}

	public function delete($id)
	{
		global $wpdb;
		
		$holiday_id = (int)$id;
		return $wpdb->delete($this->db_name, array('app_id' => $this->app_id, 'holiday_id' => $holiday_id), '%d');
	}
}