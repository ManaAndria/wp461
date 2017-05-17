<?php
if(isset($_POST)) {
	$_POST = json_decode(file_get_contents('php://input'), true);
	
	$username = $_POST['username'];
	$bookingdate = $_POST['date'];
	$usernumber = $_POST['usernumber'];
	$hoursel = $_POST['hour'];
	$service_id = $_POST['service_id'] = $_POST['id_service'];
	$data_dates = explode(' ', $_POST['date']);
	$app_day = $data_dates[1];
	$app_year = $data_dates[3];
	switch($data_dates[2]) {
		case 'janvier':
			$app_month = 1;
		break;
		case 'février':
			$app_month = 2;
		break;
		case 'mars':
			$app_month = 3;
		break;
		case 'avril':
			$app_month = 4;
		break;
		case 'mai':
			$app_month = 5;
		break;
		case 'juin':
			$app_month = 6;
		break;
		case 'juillet':
			$app_month = 7;
		break;
		case 'août':
			$app_month = 8;
		break;
		case 'septembre':
			$app_month = 9;
		break;
		case 'octobre':
			$app_month = 10;
		break;
		case 'novembre':
			$app_month = 11;
		break;
		case 'décembre':
			$app_month = 12;
		break;
	}
	$_POST['date'] = $app_year.'-'.$app_month.'-'.$app_day;
	$_POST['employee_id'] = $_POST['id_employee'];
	$app_id = $_POST['app_id'];

	require_once("wp-config.php");
	require_once("wp-content/plugins/appbook/includes/class-service.php");
	require_once("wp-content/plugins/appbook/includes/class-booking.php");

	$service = new AppService($app_id);

	$service_name = $service->getServiceName($service_id);

	$userfirstname = $_POST['userfirstname'];
	$useremail = $_POST['useremail'];
	$userphone = $_POST['userphone'];
	$usermessage = $_POST['usermessage'] ? $_POST['usermessage'] : "";

	$employeename = $_POST['employeename'];

	$app_name = $_POST['app_name'];

	$to      = $_POST['admineamil'];
	$subject = 'Prise de rendez-vous depuis APPLI Mobile - '.$app_name;
	
	$message = '
	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<title>Prise de rendez-vous depuis APPLI Mobile</title>
		
		
		<style>	@media only screen and (max-width: 300px){ 
				body {
					width:218px !important;
					margin:auto !important;
				}
				.table {width:195px !important;margin:auto !important;}
				.logo, .titleblock, .linkbelow, .box, .footer, .space_footer{width:auto !important;display: block !important;}		
				span.title{font-size:20px !important;line-height: 23px !important}
				span.subtitle{font-size: 14px !important;line-height: 18px !important;padding-top:10px !important;display:block !important;}		
				td.box p{font-size: 12px !important;font-weight: bold !important;}
				.table-recap table, .table-recap thead, .table-recap tbody, .table-recap th, .table-recap td, .table-recap tr { 
					display: block !important; 
				}
				.table-recap{width: 200px!important;}
				.table-recap tr td, .conf_body td{text-align:center !important;}	
				.address{display: block !important;margin-bottom: 10px !important;}
				.space_address{display: none !important;}	
			}
	@media only screen and (min-width: 301px) and (max-width: 500px) { 
				body {width:308px!important;margin:auto!important;}
				.table {width:285px!important;margin:auto!important;}	
				.logo, .titleblock, .linkbelow, .box, .footer, .space_footer{width:auto!important;display: block!important;}	
				.table-recap table, .table-recap thead, .table-recap tbody, .table-recap th, .table-recap td, .table-recap tr { 
					display: block !important; 
				}
				.table-recap{width: 295px !important;}
				.table-recap tr td, .conf_body td{text-align:center !important;}
				
			}
	@media only screen and (min-width: 501px) and (max-width: 768px) {
				body {width:478px!important;margin:auto!important;}
				.table {width:450px!important;margin:auto!important;}	
				.logo, .titleblock, .linkbelow, .box, .footer, .space_footer{width:auto!important;display: block!important;}			
			}
	@media only screen and (max-device-width: 480px) { 
				body {width:308px!important;margin:auto!important;}
				.table {width:285px;margin:auto!important;}	
				.logo, .titleblock, .linkbelow, .box, .footer, .space_footer{width:auto!important;display: block!important;}
				
				.table-recap{width: 295px!important;}
				.table-recap tr td, .conf_body td{text-align:center!important;}	
				.address{display: block !important;margin-bottom: 10px !important;}
				.space_address{display: none !important;}	
			}
</style>

	</head>
	<body style="-webkit-text-size-adjust:none;background-color:#fff;width:650px;font-family:Open-sans, sans-serif;color:#555454;font-size:13px;line-height:18px;margin:auto">
		<table class="table table-mail" style="width:100%;margin-top:10px;-moz-box-shadow:0 0 5px #afafaf;-webkit-box-shadow:0 0 5px #afafaf;-o-box-shadow:0 0 5px #afafaf;box-shadow:0 0 5px #afafaf;filter:progid:DXImageTransform.Microsoft.Shadow(color=#afafaf,Direction=134,Strength=5)">
			<tr>
				<td class="space" style="width:20px;padding:7px 0">&nbsp;</td>
				<td align="center" style="padding:7px 0">
					<table class="table" bgcolor="#ffffff" style="width:100%">

<tr>
	<td class="space_footer" style="padding:0!important">&nbsp;</td>
</tr>
<tr>
	<td class="box" style="border:1px solid #D6D4D4;background-color:#f8f8f8;padding:7px 0">
		<table class="table" style="width:100%">
			<tr>
				<td width="10" style="padding:7px 0">&nbsp;</td>
				<td style="padding:7px 0">
					Bonjour,<br />

					Une prise de rendez-vous a été effectuée via l\'application mobile.<br />
					Ci-dessous les informations concernant le rendez-vous:<br /><br />
					<strong>Employé(e) choisi(e) : </strong>'.$employeename.'<br />
					<strong>Type de service : </strong>'.$service_name.'<br />
					<strong>Date du rendez-vous : </strong>'.$bookingdate.'<br />
					<strong>Heure de rendez-vous : </strong>'.$hoursel.'<br />
					<strong>Nom du client : </strong>'.$username.'<br />
					<strong>Prénom du client : </strong>'.$userfirstname.'<br />
					<strong>E-mail du client: </strong>'.$useremail.'<br />
					<strong>Num téléphone du client : </strong>'.$userphone.'<br />
					<strong>Message du client : </strong>'.$usermessage.'<br /><br /><br />
					Bien cordialement
				</td>
				<td width="10" style="padding:7px 0">&nbsp;</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td class="space_footer" style="padding:0!important">&nbsp;</td>
</tr>

						<tr>
							<td class="space_footer" style="padding:0!important">&nbsp;</td>
						</tr>
					</table>
				</td>
				<td class="space" style="width:20px;padding:7px 0">&nbsp;</td>
			</tr>
		</table>
	</body>
</html>
     ';

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= 'From: Prise de rendez-vous <'.$to.'>' . "\r\n";
	//$headers .= 'To: Restaurant Golf du Rova <directeur.informatique@netunivers.com>' . "\r\n";

	$app_booking = new AppBooking($app_id);

	$data_create = array(
		'employee_id' => $_POST["employee_id"],
		'service_id' => $_POST["service_id"],
		'userfirstname' => $_POST["userfirstname"],
		'username' => $_POST["username"],
		'useremail' => $_POST["useremail"],
		'userphone' => $_POST["userphone"],
		'date' => $_POST["date"],
		'hour' => $_POST["hour"],
		'usermessage' => $_POST["usermessage"]
	);
	$save_data = $app_booking->create($data_create);

	$to2      = $useremail;
	$subject2 = 'Notification prise de rendez-vous';
	
	$message2 = '
	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<title>Réservation client au restaurant du Rova</title>
		
		
		<style>	@media only screen and (max-width: 300px){ 
				body {
					width:218px !important;
					margin:auto !important;
				}
				.table {width:195px !important;margin:auto !important;}
				.logo, .titleblock, .linkbelow, .box, .footer, .space_footer{width:auto !important;display: block !important;}		
				span.title{font-size:20px !important;line-height: 23px !important}
				span.subtitle{font-size: 14px !important;line-height: 18px !important;padding-top:10px !important;display:block !important;}		
				td.box p{font-size: 12px !important;font-weight: bold !important;}
				.table-recap table, .table-recap thead, .table-recap tbody, .table-recap th, .table-recap td, .table-recap tr { 
					display: block !important; 
				}
				.table-recap{width: 200px!important;}
				.table-recap tr td, .conf_body td{text-align:center !important;}	
				.address{display: block !important;margin-bottom: 10px !important;}
				.space_address{display: none !important;}	
			}
	@media only screen and (min-width: 301px) and (max-width: 500px) { 
				body {width:308px!important;margin:auto!important;}
				.table {width:285px!important;margin:auto!important;}	
				.logo, .titleblock, .linkbelow, .box, .footer, .space_footer{width:auto!important;display: block!important;}	
				.table-recap table, .table-recap thead, .table-recap tbody, .table-recap th, .table-recap td, .table-recap tr { 
					display: block !important; 
				}
				.table-recap{width: 295px !important;}
				.table-recap tr td, .conf_body td{text-align:center !important;}
				
			}
	@media only screen and (min-width: 501px) and (max-width: 768px) {
				body {width:478px!important;margin:auto!important;}
				.table {width:450px!important;margin:auto!important;}	
				.logo, .titleblock, .linkbelow, .box, .footer, .space_footer{width:auto!important;display: block!important;}			
			}
	@media only screen and (max-device-width: 480px) { 
				body {width:308px!important;margin:auto!important;}
				.table {width:285px;margin:auto!important;}	
				.logo, .titleblock, .linkbelow, .box, .footer, .space_footer{width:auto!important;display: block!important;}
				
				.table-recap{width: 295px!important;}
				.table-recap tr td, .conf_body td{text-align:center!important;}	
				.address{display: block !important;margin-bottom: 10px !important;}
				.space_address{display: none !important;}	
			}
</style>

	</head>
	<body style="-webkit-text-size-adjust:none;background-color:#fff;width:650px;font-family:Open-sans, sans-serif;color:#555454;font-size:13px;line-height:18px;margin:auto">
		<table class="table table-mail" style="width:100%;margin-top:10px;-moz-box-shadow:0 0 5px #afafaf;-webkit-box-shadow:0 0 5px #afafaf;-o-box-shadow:0 0 5px #afafaf;box-shadow:0 0 5px #afafaf;filter:progid:DXImageTransform.Microsoft.Shadow(color=#afafaf,Direction=134,Strength=5)">
			<tr>
				<td class="space" style="width:20px;padding:7px 0">&nbsp;</td>
				<td align="center" style="padding:7px 0">
					<table class="table" bgcolor="#ffffff" style="width:100%">

<tr>
	<td class="space_footer" style="padding:0!important">&nbsp;</td>
</tr>
<tr>
	<td class="box" style="border:1px solid #D6D4D4;background-color:#f8f8f8;padding:7px 0">
		<table class="table" style="width:100%">
			<tr>
				<td width="10" style="padding:7px 0">&nbsp;</td>
				<td style="padding:7px 0">
					Bonjour,<br />

					Votre rendez-vous a été bien envoyée au propriétaire<br />
					Ci-dessous les informations concernant votre rendez-vous:<br /><br />
					<strong>Employé(e) choisi(e) : </strong>'.$employeename.'<br />
					<strong>Type de service : </strong>'.$service_name.'<br />
					<strong>Date du rendez-vous : </strong>'.$bookingdate.'<br />
					<strong>Heure du rendez-vous : </strong>'.$hoursel.'<br />
					<strong>Nom : </strong>'.$username.'<br />
					<strong>Prénom(s) : </strong>'.$userfirstname.'<br />
					<strong>E-mail : </strong>'.$useremail.'<br />
					<strong>Num téléphone : </strong>'.$userphone.'<br />
					<strong>Message : </strong>'.$usermessage.'<br /><br /><br />
					Bien cordialement,<br />
					L\'équipe
				</td>
				<td width="10" style="padding:7px 0">&nbsp;</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td class="space_footer" style="padding:0!important">&nbsp;</td>
</tr>

						<tr>
							<td class="space_footer" style="padding:0!important">&nbsp;</td>
						</tr>
					</table>
				</td>
				<td class="space" style="width:20px;padding:7px 0">&nbsp;</td>
			</tr>
		</table>
	</body>
</html>
     ';

     // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
     $headers2  = 'MIME-Version: 1.0' . "\r\n";
     $headers2 .= 'Content-type: text/html; charset=utf-8' . "\r\n";

     // En-têtes additionnels
     $headers2 .= 'From: Prise de rendez-vous chez - ['.$app_name.'] <'.$to.'>' . "\r\n";
     //$headers2 .= 'To: '.$userfirstname.' '.$username.' <'.$useremail.'>' . "\r\n";
	if ($save_data) {
		$send2 = mail($to2, $subject2, $message2, $headers2);
		$send = mail($to, $subject, $message, $headers);
	}

	if($send && $send2 && $save_data)
		echo 1;
	else
		echo 0;
	exit();
}
?>