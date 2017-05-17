<?php
if (isset($_POST['app_id'])) {
	$app_id = (int)$_POST['app_id'];
	require_once("wp-config.php");
	require_once("wp-content/plugins/appbook/includes/class-service.php");

	$services = new AppService($app_id);
	
	echo json_encode($services->datas);
	exit();

}

?>