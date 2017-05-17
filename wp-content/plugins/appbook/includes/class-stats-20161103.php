<?php
if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * AppBook AppStats class.
 *
 */
class AppStats
{
	public $app_id = null;

	public $booking = null;

	public $period = null;
	
	public $employee = null;

	public $service = null;

	private static $default_colors = array(
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(54, 190, 112, 0.2)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(112, 76, 161, 0.2)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(72, 183, 203, 0.2)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(238, 197, 106, 0.2)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(223, 97, 114, 0.2)')
	);

	public function __construct($app_id)
	{		
		global $wpdb;
		$this->app_id = (int)$app_id;
		$this->db_name_booking = $wpdb->prefix . appBook()->slug . '_booking';
		$this->booking = new AppBooking($this->app_id);
		$this->period = new AppPeriod($this->app_id);
		$this->employee = new AppEmployee($this->app_id);
		$this->service = new AppService($this->app_id);
	}

	public function getData($service_id = null, $from = null, $to = null ) 
	{
		global $wpdb;

		if ($to === null)
		{
			$to_time = '+1 month';
			$to = date('Y-m-d', strtotime($to_time) );
		}
		else
		{
			$to_time = strtotime($to);
			// $to = date('Y-m-d', strtotime($to) );
		}

		if ($from === null)
		{
			$from_time = '-1 month';
			$from = date('Y-m-d', strtotime($from_time));
		}
		else
		{
			$from_time = strtotime($from);
			// $from = date('Y-m-d', strtotime($from));
		}

		if ($service_id === null)
		{
			$periods = array();
			$services = $this->service->datas;
			if ($services === null)
				return null;
			foreach ($services as $service) {
				$_periods = $this->period->getByService($service->service_id);
				$p = array();
				if ($_periods !== null)
				{
					foreach ($_periods as $value) {
						$p[] = $value['period_id'];
					}
				}
				if(!empty($p))
				{
					$periods[$service->service_id] = $p;
				}
				else
					$periods[$service->service_id] = null;
			}
			$countByDates = array();
			foreach ($periods as $key => $period) {
				if($period !== null)
				{
					$countByDates[$key] = $this->booking->getCount($period);
				}
				else
					$countByDates[$key] = null;
			}
		}
		else
		{
			$services = $service_id;
			$periods = array();
			foreach ($services as $service) {
				$_periods = $this->period->getByService($service);
				$p = array();
				if ($_periods !== null)
				{
					foreach ($_periods as $value) {
						$p[] = $value['period_id'];
					}
				}
				if(!empty($p))
				{
					$periods[$service] = $p;
				}
				else
					$periods[$service] = null;
			}

			$countByDates = array();
			foreach ($periods as $key => $period) {
				if($period !== null)
					$countByDates[$key] = $this->booking->getCount($period, $from, $to);
				else
					$countByDates[$key] = array();
				
			}
		}

		$dates = self::range($from_time, $to_time, '+1 day', 'Y-m-d', array('date'=>0,'count'=> 0), 'date');

		$stats_daily = array();
		foreach ($dates as $date) 
        {
            $count_visits = (isset($visits[$date['date']]['count']))?$visits[$date['date']]['count']:0;
            $temp_daily = array('date'=>date('d-m-Y',strtotime($date['date'])));
            foreach ($countByDates as $_service_id => $val) {
            	if ( isset($val[$date['date']]) )
            	{
            		$temp_daily[$this->service->getServiceName($_service_id)] = $val[$date['date']];
            	}
            	else
            	{
            		$temp_daily[$this->service->getServiceName($_service_id)] = 0;
            	}
            }
            $stats_daily[] = $temp_daily;
        }

		foreach ($stats_daily as $j => $d)
		{
			$i = 0;
			foreach ($d as $k => $v)
			{
				if ($i == 0)
				{
					$chart_data['labels'][] = $v;
				}
				else
				{
					if ( ! isset($array_data_labels) OR ! in_array($k, $array_data_labels))
				        $array_data_labels[] = $k;

					$array_values[($i-1)][] = $v;
				}

				$i++;
			}
		}

		$count = 1;
		$totalColor = count(self::$default_colors);
		foreach ($array_values as $key => $value)
		{
			if (isset($colors[$key]))
				$chart_data['datasets'][$key] = $colors[$key];
			else
			{
				$colorIndex = $count % $totalColor ;
				$chart_data['datasets'][$key] = self::$default_colors[$colorIndex];
				$count++;
			}

			$chart_data['datasets'][$key]['data'] = $value;
			$chart_data['datasets'][$key]['label'] = $array_data_labels[$key];
		}
		// $chart_data["xLabels"][] = __('Date', appBook()->slug);
		// $chart_data["yLabels"][] = __('Rendez-vous', appBook()->slug);
        return $chart_data;
	}

	public static function range($start, $end, $step = '+1 day', $format = 'Y-m-d', $array_fill = NULL, $d_field = 'date') 
    {
        $range = array();

        if (is_string($start) === TRUE) 
            $start = strtotime($start);
        if (is_string($end) === TRUE) 
            $end   = strtotime($end);

        do 
        {
            $date = date($format, $start);

            if (is_array($array_fill))
            {
                $array_fill[$d_field]  = $date;
                $range[] = $array_fill;
            }   
            else
                $range[] = $date;
            
            $start  = strtotime($step, $start);//increase

        } while($start <= $end);

        return $range;
    }
}