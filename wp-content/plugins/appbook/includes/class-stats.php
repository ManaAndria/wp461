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
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(54, 190, 112, 1)', 'backgroundColor' => 'rgba(54, 190, 112, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(105, 105, 105, 1)', 'backgroundColor' => 'rgba(105, 105, 105, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(112, 76, 161, 1)', 'backgroundColor' => 'rgba(112, 76, 161, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(128, 0, 0, 1)', 'backgroundColor' => 'rgba(128, 0, 0, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(72, 183, 203, 1)', 'backgroundColor' => 'rgba(72, 183, 203, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(188, 143, 143, 1)', 'backgroundColor' => 'rgba(188, 143, 143, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(223, 97, 114, 1)', 'backgroundColor' => 'rgba(223, 97, 114, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(0, 0, 0, 1)', 'backgroundColor' => 'rgba(0, 0, 0, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(184, 134, 11, 1)', 'backgroundColor' => 'rgba(184, 134, 11, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(255, 20, 147, 1)', 'backgroundColor' => 'rgba(255, 20, 147, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(75, 0, 130, 1)', 'backgroundColor' => 'rgba(75, 0, 130, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(47, 79, 79, 1)', 'backgroundColor' => 'rgba(47, 79, 79, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(255, 0, 0, 1)', 'backgroundColor' => 'rgba(255, 0, 0, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(255, 165, 0, 1)', 'backgroundColor' => 'rgba(255, 165, 0, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(238, 197, 106, 1)', 'backgroundColor' => 'rgba(238, 197, 106, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(70, 130, 180, 1)', 'backgroundColor' => 'rgba(70, 130, 180, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(255, 255, 0, 1)', 'backgroundColor' => 'rgba(255, 255, 0, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(0, 255, 0, 1)', 'backgroundColor' => 'rgba(0, 255, 0, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(0, 100, 0, 1)', 'backgroundColor' => 'rgba(0, 100, 0, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(0, 255, 255, 1)', 'backgroundColor' => 'rgba(0, 255, 255, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(0, 0, 255, 1)', 'backgroundColor' => 'rgba(0, 0, 255, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(205, 92, 92, 1)', 'backgroundColor' => 'rgba(205, 92, 92, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(102, 205, 170, 1)', 'backgroundColor' => 'rgba(102, 205, 170, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(169, 169, 170, 1)', 'backgroundColor' => 'rgba(169, 169, 169, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(255, 105, 180, 1)', 'backgroundColor' => 'rgba(255, 105, 180, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(0, 0, 0, 1)', 'backgroundColor' => 'rgba(0, 0, 0, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(139, 69, 19, 1)', 'backgroundColor' => 'rgba(139, 69, 19, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(210, 105, 30, 1)', 'backgroundColor' => 'rgba(210, 105, 30, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(255, 0, 255, 1)', 'backgroundColor' => 'rgba(255, 0, 255, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(240, 128, 128, 1)', 'backgroundColor' => 'rgba(240, 128, 128, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(186, 85, 211, 1)', 'backgroundColor' => 'rgba(186, 85, 211, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(189, 183, 107, 1)', 'backgroundColor' => 'rgba(189, 183, 107, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(127, 255, 212, 1)', 'backgroundColor' => 'rgba(127, 255, 212, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(176, 196, 222, 1)', 'backgroundColor' => 'rgba(176, 196, 222, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(49, 79, 79, 1)', 'backgroundColor' => 'rgba(49, 79, 79, 1)'),
		array('width' => 400, 'height' => 200, 'fill' => false, 'borderColor' => 'rgba(199, 21, 133)', 'backgroundColor' => 'rgba(199, 21, 133, 1)'),
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
			$countByDates = array();
			foreach ($services as $service) {
				$countByDates[$service->service_id] = $this->booking->getCount($service->service_id);
			}
		}
		else
		{
			$services = $service_id;
			$periods = array();
			$countByDates = array();
			foreach ($services as $service) {
				$countByDates[$service] = $this->booking->getCount($service, $from, $to);
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