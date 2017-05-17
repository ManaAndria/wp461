<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * AppBook AppBooking class.
 *
 */
class AppBooking
{
	protected $db_name;

	protected $db_name_period;

	public $app_id = null;

	public $datas = null;

	public function __construct($app_id)
	{		
		global $wpdb;
		$this->app_id = (int)$app_id;
		$this->db_name = $wpdb->prefix . appBook()->slug . '_booking';
		$this->db_name_period = $wpdb->prefix . appBook()->slug . '_period';
		$this->loadDatas();
	}

	public function loadDatas()
	{
		global $wpdb;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id}";
		$this->datas = $wpdb->get_results($query, OBJECT);
	}

	public function getSingle($booking_id)
	{
		global $wpdb;
		$booking_id = (int)$booking_id;
		$query = "SELECT * FROM {$this->db_name} WHERE `booking_id`={$booking_id} AND `app_id`={$this->app_id}";
		return $wpdb->get_row($query, OBJECT);
	}

	public function isChecked($service_id, $employee_id, $date) {
		global $wpdb;
		$service_id = (int)$service_id;
		$employee_id = (int)$employee_id;

		$query = "SELECT hour FROM {$this->db_name} WHERE `date`='{$date}' AND `app_id`={$this->app_id} AND `employee_id`={$employee_id} AND `service_id`={$service_id}";
		return $wpdb->get_var($query);
	}
	public function isCheckedNoEmployee($service_id, $date) {
		global $wpdb;
		$service_id = (int)$service_id;
		$employee_id = (int)$employee_id;

		$query = "SELECT hour FROM {$this->db_name} WHERE `date`='{$date}' AND `app_id`={$this->app_id} AND `service_id`={$service_id}";
		return $wpdb->get_col($query);
	}

	public function create($datas)
	{
		global $wpdb;
		$employee_id = (int)$datas["employee_id"];
		$service_id = (int)$datas["service_id"];
		$hour = $datas["hour"];
		$fields = array( 
			'app_id' => $this->app_id,
			'employee_id' => $employee_id,
			'service_id' => $service_id,
			'firstname' => $datas["userfirstname"],
			'lastname' => $datas["username"],
			'email' => $datas["useremail"],
			'phonenumber' => $datas["userphone"],
			'date' => $datas["date"],
			'hour' => $datas["hour"],
			'message' => $datas["usermessage"]
		);

		$format = array(
			'%d', 
			'%d', 
			'%d', 
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
		);
		$res = $wpdb->insert( $this->db_name, $fields, $format );

		return $res;
	}

	public function update($datas)
	{
		global $wpdb;
		$employee_id = (int)$datas["employee_id"];
		$service_id = (int)$datas["service_id"];
		$hour = $datas["hour"];
		$booking_id = (int)$datas["booking_id"];
		$_date = explode('-', $datas["date"]);
		$date = $_date[2].'-'.$_date[1].'-'.$_date[0];
		$fields = array( 
			'employee_id' => $employee_id,
			'service_id' => $service_id,
			'firstname' => $datas["userfirstname"],
			'lastname' => $datas["username"],
			'email' => $datas["useremail"],
			'phonenumber' => $datas["userphone"],
			'date' => $date,
			'hour' => $datas["hour"],
			'message' => $datas["usermessage"]
		);

		$format = array(
			'%d', 
			'%d', 
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
		);
		$where = array( 'app_id' => $this->app_id, 'booking_id' => $booking_id );
		$where_format = array( '%d', '%d' );
		$res = $wpdb->update( $this->db_name, $fields, $where, $format, $where_format );

		return $res;
	}

	public function getEvents()
	{
		global $wpdb;

		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} ORDER BY `date` ASC ";
		$results = $wpdb->get_results($query);
		$res = [];
		foreach ($results as $result) {
			$num_day = (int)date('w', strtotime($result->date));
			$arr = $this->getInfos($result->employee_id, $result->service_id/*, $num_day, $result->hour*/);
			$title = __('Client: ', appBook()->slug).$result->firstname.' '.$result->lastname.', email: '.$result->email.', téléphone: '.$result->phonenumber.( $result->message != '' ? ', message: '.$result->message : '' );
			$title .= ', '.$arr[0];
			$start = $result->date.' '.$result->hour;
			$res[] = array(
					'title' => $title,
					'start' => $start,
					'end' => $result->date.' '.date( 'H:i', strtotime($arr[1].' minute', strtotime($result->hour)) ),
					'url' => esc_url( add_query_arg( 'booking', $result->booking_id, site_url( '/rendez-vous/' ) ) )
				);
		}
		return json_encode($res);
	}

	public function getInfos($employee_id, $service_id)
	{
		$employee_id = (int)$employee_id;
		$service_id = (int)$service_id;
		
		$res = [];
		$employeeObject = new AppEmployee($this->app_id);
		$employee = $employeeObject->getSingle($employee_id);

		$serviceObject = new AppService($this->app_id);
		$service = $serviceObject->getServiceName($service_id);
		$duration = $serviceObject->getFieldById($service_id, 'duration');

		$res[] = __('service: ', appBook()->slug).$service.', '.__('employé(e): ', appBook()->slug).(!empty($employee) ? $employee->firstname.' '.$employee->lastname : __('non spécifié(e)', appBook()->slug) );
		$res[] = $duration; 
		return $res;
	}

	public function getCount($services, $from = null , $to = null)
	{
		if($from === null)
			$from = date( 'Y-m-d', strtotime('-1 month') );
		else
			$from = date_format(date_create_from_format('d-m-Y', $from), 'Y-m-d');

		if($to === null)
			$to = date('Y-m-d', strtotime('+1 month'));
		else
			$to = date_format(date_create_from_format('d-m-Y', $to), 'Y-m-d');

		$service_id = (int)$services;

		global $wpdb;
		$query = $wpdb->prepare("SELECT DATE(`date`) date, COUNT(`booking_id`) count FROM {$this->db_name} WHERE ( `date` BETWEEN '%s' AND '%s' ) AND `service_id` = {$service_id} GROUP BY DATE(date) ORDER BY date ASC", $from, $to);
		if ($wpdb->query($query))
		{
			$results = $wpdb->last_result;
			$ret = array();
			foreach ($results as $result) {
				$ret[$result->date] = $result->count;
			}
			return $ret;
		}
		else
			return null;
	}

	public function getAll()
	{
		global $wpdb;

		$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
		$limit = 10;
		$offset = ( $pagenum - 1 ) * $limit;
		$total = $wpdb->get_var( "SELECT COUNT(`booking_id`) FROM {$this->db_name} WHERE `app_id`={$this->app_id}" );
		$num_of_pages = ceil( $total / $limit );

		$all = $wpdb->get_results( 
			"
			SELECT * 
			FROM {$this->db_name}
			WHERE `app_id`={$this->app_id}
			ORDER BY `date` DESC, `hour` ASC
			LIMIT $offset, $limit
			", OBJECT
		);

		$page_links = paginate_links( array(
		    'base' => add_query_arg( 'pagenum', '%#%' ),
		    'format' => '',
		    'prev_text' => __( 'précédent', appBook()->slug ),
		    'next_text' => __( 'suivant', appBook()->slug ),
		    'total' => $num_of_pages,
		    'current' => $pagenum,
		    'type' => 'list',
		    'show_all' => false,
		    'end_size' => 3,
		    'mid_size' => 3
		) );
		return array('all' => $all, 'page_links' => $page_links, 'total' => $total);
	}

	public function getDashboard($from, $to)
	{
		global $wpdb;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND (`date` BETWEEN '{$from}' AND '$to') ORDER BY `date` ASC ";
		// return $query;
		return $wpdb->get_results($query);
	}

	public function delete($id)
	{
		global $wpdb;
		$booking_id = (int)$id;
		return $wpdb->delete($this->db_name, array('app_id' => $this->app_id, 'booking_id' => $booking_id), '%d');
	}

}