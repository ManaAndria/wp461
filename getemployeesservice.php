<?php
if (isset($_POST['app_id'])) {
	$app_id = (int)$_POST['app_id'];
	require_once("wp-config.php");
	require_once("wp-content/plugins/appbook/includes/class-employee.php");

	$employees = new AppEmployee($app_id);
	$l_employees = $employees->getByPoste($_POST['id_service']);
	foreach($l_employees as $data){
		$f_employees[] = array("employee_id" => $data->employee_id, "name" => $data->firstname." ".$data->lastname);
	}
	
	echo json_encode($f_employees);
	exit();

}

?>