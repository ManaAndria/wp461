<?php
if (isset($_POST) && (int)$_POST['id_employee'] && (int)$_POST['id_service'] && (int)$_POST['num_day'] && (int)$_POST['app_id'] && $_POST['appointment_date']) {
	$app_id = (int)$_POST['app_id'];
	$id_service = (int)$_POST['id_service'];
	$num_day = (int)$_POST['num_day'];
	$id_employee = (int)$_POST['id_employee'];
	$appointment_date = $_POST['appointment_date'];

	require_once("wp-config.php");
	require_once("wp-content/plugins/appbook/includes/class-opening.php");
	require_once("wp-content/plugins/appbook/includes/class-closing.php");
	require_once("wp-content/plugins/appbook/includes/class-holiday.php");
	require_once("wp-content/plugins/appbook/includes/class-employee.php");
	require_once("wp-content/plugins/appbook/includes/class-service.php");
	require_once("wp-content/plugins/appbook/includes/class-period.php");
	require_once("wp-content/plugins/appbook/includes/class-booking.php");
	require_once("wp-content/plugins/appbook/helpers.php");

	$ob_day = new AppOpening($app_id);

	$is_open_day = $ob_day->getOpeningsByDay($num_day);
	if ($is_open_day) { // Test si date est dans la liste des dates ouvertures
		$employees = new AppEmployee($app_id);
		$f_employees = array();
		$close_day = new AppClosing($app_id);
		$not_closing_day = $close_day->checkIfCloseDay($num_day, $appointment_date);
		if ($not_closing_day) { // Test si date est dans la liste des dates fermetures
			$e_holiday = new AppHoliday($app_id);
			$is_holiday = $e_holiday->checkEmployeeIfHolidaybyDate($appointment_date, $id_employee);
			if (!$is_holiday) { // Test si employé(e) est en congé à la date sélectionnée
				return ;
				exit();
			} else {
				$services = new AppService($app_id);
				$app_service = $services->getSingle($id_service);
				$service_duration = (int)$app_service->duration;

				$periodes = new AppPeriod($app_id);
				$app_periodes = $periodes->getPeriodEmployeeService($id_employee, $id_service, $num_day);
				if (!$app_periodes) {
					return ;
					exit();
				} else {
					$hours_list = array();
					$x = 1;
					$holidays_one_day = $e_holiday->getEmployeeIfHolidayOneDay($appointment_date, $id_employee);
					$hol_one_day = 0;
					$hol_h = array();
					if ($holidays_one_day) {
						$hol_one_day = 1;
						$y = 0;
						foreach ($app_periodes as $app_periode) {
						$num_h = 0;
							foreach ($holidays_one_day as $holiday_one_day) {
								$inRef = isInRefTime($app_periode->period, $app_periode->end, $holiday_one_day->start, $holiday_one_day->end);
								if ($inRef) {
									$data_start = explode(':', $app_periode->period);
									$data_end = explode(':', $app_periode->end);
									$h_start = (int)$data_start[0];
									$m_start = (int)$data_start[1];
									$h_end = (int)$data_end[0];
									$m_end = (int)$data_end[1];

									$data_h_start = explode(':', $holiday_one_day->start);
									$data_h_end = explode(':', $holiday_one_day->end);
									$h_h_start = (int)$data_h_start[0];
									$h_m_start = (int)$data_h_start[1];
									$h_h_end = (int)$data_h_end[0];
									$h_m_end = (int)$data_h_end[1];

									if ($h_h_start > $h_start) {
										$hol_h[$y]['start'] = $app_periode->period;
										$hol_h[$y]['end'] = $holiday_one_day->start;
										$y++;
										$hol_h[$y]['start'] = $holiday_one_day->end;
										$hol_h[$y]['end'] = $app_periode->end;
									}
									$y++;
								} else {
									$num_h++;
								}
							}
							
							if ($num_h == count($holidays_one_day)) {
								$hol_h[$y+1]['start'] = $app_periode->period;
								$hol_h[$y+1]['end'] = $app_periode->end;
							}
						}
						foreach ($hol_h as $app_periode) {
							$d_f = getHoursList($app_periode['start'], $app_periode['end'], $service_duration);
							$hours_list = array_merge($hours_list, $d_f);
						}
					} else {
						foreach ($app_periodes as $app_periode) {
							$dd_f = getHoursList($app_periode->period, $app_periode->end, $service_duration);
							$hours_list = array_merge($hours_list, $dd_f);
						}
						$app_booking = new AppBooking($app_id);

						$check_day = $app_booking->isCheckedNoEmployee($id_service, $appointment_date);
						// if($check_day)
						// 	unset($hours_list[array_search($check_day, $hours_list)]);
						if( count($check_day) ){
							foreach ($check_day as $checked) {
								unset($hours_list[array_search($checked, $hours_list)]);
							}
						}
					}
					echo json_encode($hours_list);
				}
			}
		} else {
			return ;
		}
	} else {
		return ;
	}
	exit();
}

?>