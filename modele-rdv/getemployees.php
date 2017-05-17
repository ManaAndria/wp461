<?php
$employees = array(
	0 => array(
		"id" => "1",
		"name" => "Fabien",
		'poste' => "Comptable"
	),
	1 => array(
		"id" => "2",
		"name" => "Christelle",
		'poste' => "Masseuse"
	)
	);
echo json_encode($employees);//regen1
?>