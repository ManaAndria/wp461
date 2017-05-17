<?php
if (isset($_POST['app_id'])) {
	$app_id = (int)$_POST['app_id'];
	require_once("wp-config.php");
	require_once("wp-content/plugins/appbook/includes/class-app.php");
	$infos = App::getInformations($app_id);
	echo json_encode((array)$infos);
	exit();

}


/*$hours = array(
			"07:30",
			"08:30",
			
	);
echo json_encode($hours);*/
?>