<?php
if (isset($_POST['app_id'])) {
	$app_id = (int)$_POST['app_id'];
	require_once("wp-config.php");
	require_once("wp-content/plugins/appbook/includes/class-service.php");

	$services = new AppService($app_id);
	
	$new_services = array();
	foreach ($services->datas as $service) {
		$dur = (int)$service->duration;
		$sec = $dur * 60;
		$ref = new DateTime(gmdate("Y/m/j H:i:s", 0));
		$time = new DateTime(gmdate("Y/m/j H:i:s", $sec));
		$interval = date_diff( $ref, $time);
		if ($dur < 60)
		{
			$resu = $interval->format('%imin');
		}else{
			$_resu = $interval->format('%hh %imin');
			$expl = explode(' ', $_resu);
			if( strpos($expl[0], '0') === 0){
				$resu = $expl[1];
			}
			elseif(strpos($expl[1], '0') === 0){
				$resu = $expl[0];
			}else{
				$resu = $_resu;
			}
		}
		$service->description = stripslashes($service->description);
		$service->duration = $resu;
		$new_services[] = $service;
	}

	// echo json_encode($services->datas);
	echo json_encode($new_services);
	exit();

}

?>