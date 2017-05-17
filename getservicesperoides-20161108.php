<?php
if (isset($_POST) && (int)$_POST['id_service'] && (int)$_POST['num_day'] && (int)$_POST['app_id'] && $_POST['appointment_date']) {
	$app_id = (int)$_POST['app_id'];
	$id_service = (int)$_POST['id_service'];
	$num_day = (int)$_POST['num_day'];
	$appointment_date = $_POST['appointment_date'];

	require_once("wp-config.php");
	require_once("wp-content/plugins/appbook/includes/class-opening.php");
	require_once("wp-content/plugins/appbook/includes/class-closing.php");
	require_once("wp-content/plugins/appbook/includes/class-service.php");
	require_once("wp-content/plugins/appbook/includes/class-period.php");
	require_once("wp-content/plugins/appbook/includes/class-booking.php");
	require_once("wp-content/plugins/appbook/helpers.php");

	$ob_day = new AppOpening($app_id);

	$is_open_day = $ob_day->getOpeningsByDay($num_day);
	if ($is_open_day) { // Test si date est dans la liste des dates ouvertures
		$close_day = new AppClosing($app_id);
		$not_closing_day = $close_day->checkIfCloseDay($num_day, $appointment_date);
		if ($not_closing_day) { // Test si date est dans la liste des dates fermetures
			$services = new AppService($app_id);
			$app_service = $services->getSingle($id_service);
			$service_duration = (int)$app_service->duration;

			$periodes = new AppPeriod($app_id);
			$app_periodes = $periodes->getByServiceDate($id_service, $num_day);
			
			if (!$app_periodes) {
				return ;
				exit();
			} else {
				$hours_list = array();
				$x = 1;
				foreach ($app_periodes as $app_periode) {
					$hours_list = array_merge($hours_list, getHoursList($app_periode->period, $app_periode->end, $service_duration));
				}

				$app_booking = new AppBooking($app_id);

				$check_day = $app_booking->isCheckedNoEmployee($id_service, $appointment_date);
				if($check_day)
					unset($hours_list[array_search($check_day, $hours_list)]);
				sort($hours_list);
				echo json_encode($hours_list);
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