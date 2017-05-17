<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (is_user_logged_in())
{
	$app = appBook();
	$appDatas = $app->app->datas;
	$form_action = $app->form_action;
	?>
	<?php 
$wp_session = WP_Session::get_instance();
if (isset($wp_session['display_tooltip'])): ?>
<div class="alert alert-info" style="display: inline-block;width: 100%;">
	<div class="pull-left" style="font-size: 32px;margin-right: 10px"><div class="glyphicon glyphicon-info-sign"></div></div>
	<div>Sur cette page, vous avez un formulaire sur lequel vous pouvez mettre à jour les informations concernant votre entreprise.</div>
</div>
<?php endif; ?>
	<div class="col-xs-12">
		<form id="<?php echo $app->slug; ?>_app"  class="<?php echo $app->slug; ?>_form form-horizontal col-xs-12 col-sm-8" method="POST" action="">
			<div class="form-group">
			    <label for="app_name" class="col-xs-12 col-sm-4 control-label"><?php echo __('Nom de la société', $app->slug) ?> *</label>
			    <div class="col-xs-12 col-sm-8">
			    	<input type="text" class="form-control" id="app_name" name="<?php echo $form_action; ?>[app_name]" placeholder="<?php echo __('Nom de la société', $app->slug) ?>" value="<?php echo stripslashes($appDatas->app_name) ?>" required />
			    </div>
		  	</div>
		  	<div class="form-group">
			    <label for="address" class="col-xs-12 col-sm-4 control-label"><?php echo __('Adresse', $app->slug) ?> *</label>
			    <div class="col-xs-12 col-sm-8">
			    	<input type="text" class="form-control" id="address" name="<?php echo $form_action; ?>[address]" placeholder="<?php echo __('Adresse', $app->slug) ?>" value="<?php echo stripslashes($appDatas->address) ?>" required />
		    	</div>
		  	</div>
		  	<div class="form-group">
			    <label for="city" class="col-xs-12 col-sm-4 control-label"><?php echo __('Ville', $app->slug) ?> *</label>
			    <div class="col-xs-12 col-sm-8">
			    	<input type="text" class="form-control" id="city" name="<?php echo $form_action; ?>[city]" placeholder="<?php echo __('Ville', $app->slug) ?>" value="<?php echo stripslashes($appDatas->city) ?>" required />
		    	</div>
		  	</div>
		  	<div class="form-group">
			    <label for="zip" class="col-xs-12 col-sm-4 control-label"><?php echo __('Code postal', $app->slug) ?> *</label>
			    <div class="col-xs-12 col-sm-8">
			    	<input type="text" class="form-control" id="zip" name="<?php echo $form_action; ?>[zip]" placeholder="<?php echo __('Code postal', $app->slug) ?>" value="<?php echo $appDatas->zip ?>" required />
		    	</div>
		  	</div>
		  	<div class="form-group">
			    <label for="hour_zone" class="col-xs-12 col-sm-4 control-label"><?php echo __('Fuseau horaire', $app->slug) ?> *</label>
			    <div class="col-xs-12 col-sm-8">
			    	<select class="form-control" id="hour_zone" name="<?php echo $form_action; ?>[hour_zone]">
			    		<option value=""></option>
						<option value="Africa/Abidjan"<?php echo ($appDatas->hour_zone == 'Africa/Abidjan' ? ' selected' : ''); ?>>(GMT +00:00) Africa/Abidjan</option>
						<option value="Africa/Accra"<?php echo ($appDatas->hour_zone == 'Africa/Accra' ? ' selected' : ''); ?>>(GMT +00:00) Africa/Accra</option>
						<option value="Africa/Bamako"<?php echo ($appDatas->hour_zone == 'Africa/Bamako' ? ' selected' : ''); ?>>(GMT +00:00) Africa/Bamako</option>
						<option value="Africa/Banjul"<?php echo ($appDatas->hour_zone == 'Africa/Banjul' ? ' selected' : ''); ?>>(GMT +00:00) Africa/Banjul</option>
						<option value="Africa/Bissau"<?php echo ($appDatas->hour_zone == 'Africa/Bissau' ? ' selected' : ''); ?>>(GMT +00:00) Africa/Bissau</option>
						<option value="Africa/Conakry"<?php echo ($appDatas->hour_zone == 'Africa/Conakry' ? ' selected' : ''); ?>>(GMT +00:00) Africa/Conakry</option>
						<option value="Africa/Dakar"<?php echo ($appDatas->hour_zone == 'Africa/Dakar' ? ' selected' : ''); ?>>(GMT +00:00) Africa/Dakar</option>
						<option value="Africa/Freetown"<?php echo ($appDatas->hour_zone == 'Africa/Freetown' ? ' selected' : ''); ?>>(GMT +00:00) Africa/Freetown</option>
						<option value="Africa/Lome"<?php echo ($appDatas->hour_zone == 'Africa/Lome' ? ' selected' : ''); ?>>(GMT +00:00) Africa/Lome</option>
						<option value="Africa/Monrovia"<?php echo ($appDatas->hour_zone == 'Africa/Monrovia' ? ' selected' : ''); ?>>(GMT +00:00) Africa/Monrovia</option>
						<option value="Africa/Nouakchott"<?php echo ($appDatas->hour_zone == 'Africa/Nouakchott' ? ' selected' : ''); ?>>(GMT +00:00) Africa/Nouakchott</option>
						<option value="Africa/Ouagadougou"<?php echo ($appDatas->hour_zone == 'Africa/Ouagadougou' ? ' selected' : ''); ?>>(GMT +00:00) Africa/Ouagadougou</option>
						<option value="Africa/Sao_Tome"<?php echo ($appDatas->hour_zone == 'Africa/Sao_Tome' ? ' selected' : ''); ?>>(GMT +00:00) Africa/Sao_Tome</option>
						<option value="Africa/Timbuktu"<?php echo ($appDatas->hour_zone == 'Africa/Timbuktu' ? ' selected' : ''); ?>>(GMT +00:00) Africa/Timbuktu</option>
						<option value="America/Danmarkshavn"<?php echo ($appDatas->hour_zone == 'America/Danmarkshavn' ? ' selected' : ''); ?>>(GMT +00:00) America/Danmarkshavn</option>
						<option value="America/Scoresbysund"<?php echo ($appDatas->hour_zone == 'America/Scoresbysund' ? ' selected' : ''); ?>>(GMT +00:00) America/Scoresbysund</option>
						<option value="Atlantic/Azores"<?php echo ($appDatas->hour_zone == 'Atlantic/Azores' ? ' selected' : ''); ?>>(GMT +00:00) Atlantic/Azores</option>
						<option value="Atlantic/Reykjavik"<?php echo ($appDatas->hour_zone == 'Atlantic/Reykjavik' ? ' selected' : ''); ?>>(GMT +00:00) Atlantic/Reykjavik</option>
						<option value="Atlantic/St_Helena"<?php echo ($appDatas->hour_zone == 'Atlantic/St_Helena' ? ' selected' : ''); ?>>(GMT +00:00) Atlantic/St_Helena</option>
						<option value="Etc/GMT"<?php echo ($appDatas->hour_zone == 'Etc/GMT' ? ' selected' : ''); ?>>(GMT +00:00) Etc/GMT</option>
						<option value="Etc/GMT+0"<?php echo ($appDatas->hour_zone == 'Etc/GMT+0' ? ' selected' : ''); ?>>(GMT +00:00) Etc/GMT+0</option>
						<option value="Etc/GMT-0"<?php echo ($appDatas->hour_zone == 'Etc/GMT-0' ? ' selected' : ''); ?>>(GMT +00:00) Etc/GMT-0</option>
						<option value="Etc/GMT0"<?php echo ($appDatas->hour_zone == 'Etc/GMT0' ? ' selected' : ''); ?>>(GMT +00:00) Etc/GMT0</option>
						<option value="Etc/Greenwich"<?php echo ($appDatas->hour_zone == 'Etc/Greenwich' ? ' selected' : ''); ?>>(GMT +00:00) Etc/Greenwich</option>
						<option value="Etc/UCT"<?php echo ($appDatas->hour_zone == 'Etc/UCT' ? ' selected' : ''); ?>>(GMT +00:00) Etc/UCT</option>
						<option value="Etc/UTC"<?php echo ($appDatas->hour_zone == 'Etc/UTC' ? ' selected' : ''); ?>>(GMT +00:00) Etc/UTC</option>
						<option value="Etc/Universal"<?php echo ($appDatas->hour_zone == 'Etc/Universal' ? ' selected' : ''); ?>>(GMT +00:00) Etc/Universal</option>
						<option value="Etc/Zulu"<?php echo ($appDatas->hour_zone == 'Etc/Zulu' ? ' selected' : ''); ?>>(GMT +00:00) Etc/Zulu</option>
						<option value="GMT"<?php echo ($appDatas->hour_zone == 'GMT' ? ' selected' : ''); ?>>(GMT +00:00) GMT</option>
						<option value="GMT+0"<?php echo ($appDatas->hour_zone == 'GMT+0' ? ' selected' : ''); ?>>(GMT +00:00) GMT+0</option>
						<option value="GMT-0"<?php echo ($appDatas->hour_zone == 'GMT-0' ? ' selected' : ''); ?>>(GMT +00:00) GMT-0</option>
						<option value="GMT0"<?php echo ($appDatas->hour_zone == 'GMT0' ? ' selected' : ''); ?>>(GMT +00:00) GMT0</option>
						<option value="Greenwich"<?php echo ($appDatas->hour_zone == 'Greenwich' ? ' selected' : ''); ?>>(GMT +00:00) Greenwich</option>
						<option value="Iceland"<?php echo ($appDatas->hour_zone == 'Iceland' ? ' selected' : ''); ?>>(GMT +00:00) Iceland</option>
						<option value="UCT"<?php echo ($appDatas->hour_zone == 'UCT' ? ' selected' : ''); ?>>(GMT +00:00) UCT</option>
						<option value="UTC"<?php echo ($appDatas->hour_zone == 'UTC' ? ' selected' : ''); ?>>(GMT +00:00) UTC</option>
						<option value="Universal"<?php echo ($appDatas->hour_zone == 'Universal' ? ' selected' : ''); ?>>(GMT +00:00) Universal</option>
						<option value="Zulu"<?php echo ($appDatas->hour_zone == 'Zulu' ? ' selected' : ''); ?>>(GMT +00:00) Zulu</option>
						<option value="Africa/Algiers"<?php echo ($appDatas->hour_zone == 'Africa/Algiers' ? ' selected' : ''); ?>>(GMT +01:00) Africa/Algiers</option>
						<option value="Africa/Bangui"<?php echo ($appDatas->hour_zone == 'Africa/Bangui' ? ' selected' : ''); ?>>(GMT +01:00) Africa/Bangui</option>
						<option value="Africa/Brazzaville"<?php echo ($appDatas->hour_zone == 'Africa/Brazzaville' ? ' selected' : ''); ?>>(GMT +01:00) Africa/Brazzaville</option>
						<option value="Africa/Casablanca"<?php echo ($appDatas->hour_zone == 'Africa/Casablanca' ? ' selected' : ''); ?>>(GMT +01:00) Africa/Casablanca</option>
						<option value="Africa/Douala"<?php echo ($appDatas->hour_zone == 'Africa/Douala' ? ' selected' : ''); ?>>(GMT +01:00) Africa/Douala</option>
						<option value="Africa/El_Aaiun"<?php echo ($appDatas->hour_zone == 'Africa/El_Aaiun' ? ' selected' : ''); ?>>(GMT +01:00) Africa/El_Aaiun</option>
						<option value="Africa/Kinshasa"<?php echo ($appDatas->hour_zone == 'Africa/Kinshasa' ? ' selected' : ''); ?>>(GMT +01:00) Africa/Kinshasa</option>
						<option value="Africa/Lagos"<?php echo ($appDatas->hour_zone == 'Africa/Lagos' ? ' selected' : ''); ?>>(GMT +01:00) Africa/Lagos</option>
						<option value="Africa/Libreville"<?php echo ($appDatas->hour_zone == 'Africa/Libreville' ? ' selected' : ''); ?>>(GMT +01:00) Africa/Libreville</option>
						<option value="Africa/Luanda"<?php echo ($appDatas->hour_zone == 'Africa/Luanda' ? ' selected' : ''); ?>>(GMT +01:00) Africa/Luanda</option>
						<option value="Africa/Malabo"<?php echo ($appDatas->hour_zone == 'Africa/Malabo' ? ' selected' : ''); ?>>(GMT +01:00) Africa/Malabo</option>
						<option value="Africa/Ndjamena"<?php echo ($appDatas->hour_zone == 'Africa/Ndjamena' ? ' selected' : ''); ?>>(GMT +01:00) Africa/Ndjamena</option>
						<option value="Africa/Niamey"<?php echo ($appDatas->hour_zone == 'Africa/Niamey' ? ' selected' : ''); ?>>(GMT +01:00) Africa/Niamey</option>
						<option value="Africa/Porto-Novo"<?php echo ($appDatas->hour_zone == 'Africa/Porto-Novo' ? ' selected' : ''); ?>>(GMT +01:00) Africa/Porto-Novo</option>
						<option value="Africa/Tunis"<?php echo ($appDatas->hour_zone == 'Africa/Tunis' ? ' selected' : ''); ?>>(GMT +01:00) Africa/Tunis</option>
						<option value="Atlantic/Canary"<?php echo ($appDatas->hour_zone == 'Atlantic/Canary' ? ' selected' : ''); ?>>(GMT +01:00) Atlantic/Canary</option>
						<option value="Atlantic/Faeroe"<?php echo ($appDatas->hour_zone == 'Atlantic/Faeroe' ? ' selected' : ''); ?>>(GMT +01:00) Atlantic/Faeroe</option>
						<option value="Atlantic/Faroe"<?php echo ($appDatas->hour_zone == 'Atlantic/Faroe' ? ' selected' : ''); ?>>(GMT +01:00) Atlantic/Faroe</option>
						<option value="Atlantic/Madeira"<?php echo ($appDatas->hour_zone == 'Atlantic/Madeira' ? ' selected' : ''); ?>>(GMT +01:00) Atlantic/Madeira</option>
						<option value="Eire"<?php echo ($appDatas->hour_zone == 'Eire' ? ' selected' : ''); ?>>(GMT +01:00) Eire</option>
						<option value="Etc/GMT-1"<?php echo ($appDatas->hour_zone == 'Etc/GMT-1' ? ' selected' : ''); ?>>(GMT +01:00) Etc/GMT-1</option>
						<option value="Europe/Belfast"<?php echo ($appDatas->hour_zone == 'Europe/Belfast' ? ' selected' : ''); ?>>(GMT +01:00) Europe/Belfast</option>
						<option value="Europe/Dublin"<?php echo ($appDatas->hour_zone == 'Europe/Dublin' ? ' selected' : ''); ?>>(GMT +01:00) Europe/Dublin</option>
						<option value="Europe/Guernsey"<?php echo ($appDatas->hour_zone == 'Europe/Guernsey' ? ' selected' : ''); ?>>(GMT +01:00) Europe/Guernsey</option>
						<option value="Europe/Isle_of_Man"<?php echo ($appDatas->hour_zone == 'Europe/Isle_of_Man' ? ' selected' : ''); ?>>(GMT +01:00) Europe/Isle_of_Man</option>
						<option value="Europe/Jersey"<?php echo ($appDatas->hour_zone == 'Europe/Jersey' ? ' selected' : ''); ?>>(GMT +01:00) Europe/Jersey</option>
						<option value="Europe/Lisbon"<?php echo ($appDatas->hour_zone == 'Europe/Lisbon' ? ' selected' : ''); ?>>(GMT +01:00) Europe/Lisbon</option>
						<option value="Europe/London"<?php echo ($appDatas->hour_zone == 'Europe/London' ? ' selected' : ''); ?>>(GMT +01:00) Europe/London</option>
						<option value="GB"<?php echo ($appDatas->hour_zone == 'GB' ? ' selected' : ''); ?>>(GMT +01:00) GB</option>
						<option value="GB-Eire"<?php echo ($appDatas->hour_zone == 'GB-Eire' ? ' selected' : ''); ?>>(GMT +01:00) GB-Eire</option>
						<option value="Portugal"<?php echo ($appDatas->hour_zone == 'Portugal' ? ' selected' : ''); ?>>(GMT +01:00) Portugal</option>
						<option value="WET"<?php echo ($appDatas->hour_zone == 'WET' ? ' selected' : ''); ?>>(GMT +01:00) WET</option>
						<option value="Africa/Blantyre"<?php echo ($appDatas->hour_zone == 'Africa/Blantyre' ? ' selected' : ''); ?>>(GMT +02:00) Africa/Blantyre</option>
						<option value="Africa/Bujumbura"<?php echo ($appDatas->hour_zone == 'Africa/Bujumbura' ? ' selected' : ''); ?>>(GMT +02:00) Africa/Bujumbura</option>
						<option value="Africa/Cairo"<?php echo ($appDatas->hour_zone == 'Africa/Cairo' ? ' selected' : ''); ?>>(GMT +02:00) Africa/Cairo</option>
						<option value="Africa/Ceuta"<?php echo ($appDatas->hour_zone == 'Africa/Ceuta' ? ' selected' : ''); ?>>(GMT +02:00) Africa/Ceuta</option>
						<option value="Africa/Gaborone"<?php echo ($appDatas->hour_zone == 'Africa/Gaborone' ? ' selected' : ''); ?>>(GMT +02:00) Africa/Gaborone</option>
						<option value="Africa/Harare"<?php echo ($appDatas->hour_zone == 'Africa/Harare' ? ' selected' : ''); ?>>(GMT +02:00) Africa/Harare</option>
						<option value="Africa/Johannesburg"<?php echo ($appDatas->hour_zone == 'Africa/Johannesburg' ? ' selected' : ''); ?>>(GMT +02:00) Africa/Johannesburg</option>
						<option value="Africa/Kigali"<?php echo ($appDatas->hour_zone == 'Africa/Kigali' ? ' selected' : ''); ?>>(GMT +02:00) Africa/Kigali</option>
						<option value="Africa/Lubumbashi"<?php echo ($appDatas->hour_zone == 'Africa/Lubumbashi' ? ' selected' : ''); ?>>(GMT +02:00) Africa/Lubumbashi</option>
						<option value="Africa/Lusaka"<?php echo ($appDatas->hour_zone == 'Africa/Lusaka' ? ' selected' : ''); ?>>(GMT +02:00) Africa/Lusaka</option>
						<option value="Africa/Maputo"<?php echo ($appDatas->hour_zone == 'Africa/Maputo' ? ' selected' : ''); ?>>(GMT +02:00) Africa/Maputo</option>
						<option value="Africa/Maseru"<?php echo ($appDatas->hour_zone == 'Africa/Maseru' ? ' selected' : ''); ?>>(GMT +02:00) Africa/Maseru</option>
						<option value="Africa/Mbabane"<?php echo ($appDatas->hour_zone == 'Africa/Mbabane' ? ' selected' : ''); ?>>(GMT +02:00) Africa/Mbabane</option>
						<option value="Africa/Tripoli"<?php echo ($appDatas->hour_zone == 'Africa/Tripoli' ? ' selected' : ''); ?>>(GMT +02:00) Africa/Tripoli</option>
						<option value="Africa/Windhoek"<?php echo ($appDatas->hour_zone == 'Africa/Windhoek' ? ' selected' : ''); ?>>(GMT +02:00) Africa/Windhoek</option>
						<option value="Antarctica/Troll"<?php echo ($appDatas->hour_zone == 'Antarctica/Troll' ? ' selected' : ''); ?>>(GMT +02:00) Antarctica/Troll</option>
						<option value="Arctic/Longyearbyen"<?php echo ($appDatas->hour_zone == 'Arctic/Longyearbyen' ? ' selected' : ''); ?>>(GMT +02:00) Arctic/Longyearbyen</option>
						<option value="Atlantic/Jan_Mayen"<?php echo ($appDatas->hour_zone == 'Atlantic/Jan_Mayen' ? ' selected' : ''); ?>>(GMT +02:00) Atlantic/Jan_Mayen</option>
						<option value="CET"<?php echo ($appDatas->hour_zone == 'CET' ? ' selected' : ''); ?>>(GMT +02:00) CET</option>
						<option value="Egypt"<?php echo ($appDatas->hour_zone == 'Egypt' ? ' selected' : ''); ?>>(GMT +02:00) Egypt</option>
						<option value="Etc/GMT-2"<?php echo ($appDatas->hour_zone == 'Etc/GMT-2' ? ' selected' : ''); ?>>(GMT +02:00) Etc/GMT-2</option>
						<option value="Europe/Amsterdam"<?php echo ($appDatas->hour_zone == 'Europe/Amsterdam' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Amsterdam</option>
						<option value="Europe/Andorra"<?php echo ($appDatas->hour_zone == 'Europe/Andorra' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Andorra</option>
						<option value="Europe/Belgrade"<?php echo ($appDatas->hour_zone == 'Europe/Belgrade' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Belgrade</option>
						<option value="Europe/Berlin"<?php echo ($appDatas->hour_zone == 'Europe/Berlin' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Berlin</option>
						<option value="Europe/Bratislava"<?php echo ($appDatas->hour_zone == 'Europe/Bratislava' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Bratislava</option>
						<option value="Europe/Brussels"<?php echo ($appDatas->hour_zone == 'Europe/Brussels' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Brussels</option>
						<option value="Europe/Budapest"<?php echo ($appDatas->hour_zone == 'Europe/Budapest' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Budapest</option>
						<option value="Europe/Busingen"<?php echo ($appDatas->hour_zone == 'Europe/Busingen' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Busingen</option>
						<option value="Europe/Copenhagen"<?php echo ($appDatas->hour_zone == 'Europe/Copenhagen' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Copenhagen</option>
						<option value="Europe/Gibraltar"<?php echo ($appDatas->hour_zone == 'Europe/Gibraltar' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Gibraltar</option>
						<option value="Europe/Kaliningrad"<?php echo ($appDatas->hour_zone == 'Europe/Kaliningrad' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Kaliningrad</option>
						<option value="Europe/Ljubljana"<?php echo ($appDatas->hour_zone == 'Europe/Ljubljana' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Ljubljana</option>
						<option value="Europe/Luxembourg"<?php echo ($appDatas->hour_zone == 'Europe/Luxembourg' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Luxembourg</option>
						<option value="Europe/Madrid"<?php echo ($appDatas->hour_zone == 'Europe/Madrid' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Madrid</option>
						<option value="Europe/Malta"<?php echo ($appDatas->hour_zone == 'Europe/Malta' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Malta</option>
						<option value="Europe/Monaco"<?php echo ($appDatas->hour_zone == 'Europe/Monaco' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Monaco</option>
						<option value="Europe/Oslo"<?php echo ($appDatas->hour_zone == 'Europe/Oslo' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Oslo</option>
						<option value="Europe/Paris"<?php echo ($appDatas->hour_zone == 'Europe/Paris' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Paris</option>
						<option value="Europe/Podgorica"<?php echo ($appDatas->hour_zone == 'Europe/Podgorica' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Podgorica</option>
						<option value="Europe/Prague"<?php echo ($appDatas->hour_zone == 'Europe/Prague' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Prague</option>
						<option value="Europe/Rome"<?php echo ($appDatas->hour_zone == 'Europe/Rome' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Rome</option>
						<option value="Europe/San_Marino"<?php echo ($appDatas->hour_zone == 'Europe/San_Marino' ? ' selected' : ''); ?>>(GMT +02:00) Europe/San_Marino</option>
						<option value="Europe/Sarajevo"<?php echo ($appDatas->hour_zone == 'Europe/Sarajevo' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Sarajevo</option>
						<option value="Europe/Skopje"<?php echo ($appDatas->hour_zone == 'Europe/Skopje' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Skopje</option>
						<option value="Europe/Stockholm"<?php echo ($appDatas->hour_zone == 'Europe/Stockholm' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Stockholm</option>
						<option value="Europe/Tirane"<?php echo ($appDatas->hour_zone == 'Europe/Tirane' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Tirane</option>
						<option value="Europe/Vaduz"<?php echo ($appDatas->hour_zone == 'Europe/Vaduz' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Vaduz</option>
						<option value="Europe/Vatican"<?php echo ($appDatas->hour_zone == 'Europe/Vatican' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Vatican</option>
						<option value="Europe/Vienna"<?php echo ($appDatas->hour_zone == 'Europe/Vienna' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Vienna</option>
						<option value="Europe/Warsaw"<?php echo ($appDatas->hour_zone == 'Europe/Warsaw' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Warsaw</option>
						<option value="Europe/Zagreb"<?php echo ($appDatas->hour_zone == 'Europe/Zagreb' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Zagreb</option>
						<option value="Europe/Zurich"<?php echo ($appDatas->hour_zone == 'Europe/Zurich' ? ' selected' : ''); ?>>(GMT +02:00) Europe/Zurich</option>
						<option value="Libya"<?php echo ($appDatas->hour_zone == 'Libya' ? ' selected' : ''); ?>>(GMT +02:00) Libya</option>
						<option value="MET"<?php echo ($appDatas->hour_zone == 'MET' ? ' selected' : ''); ?>>(GMT +02:00) MET</option>
						<option value="Poland"<?php echo ($appDatas->hour_zone == 'Poland' ? ' selected' : ''); ?>>(GMT +02:00) Poland</option>
						<option value="Africa/Addis_Ababa"<?php echo ($appDatas->hour_zone == 'Addis_Ababa' ? ' selected' : ''); ?>>(GMT +03:00) Africa/Addis_Ababa</option>
						<option value="Africa/Asmara"<?php echo ($appDatas->hour_zone == 'Asmara' ? ' selected' : ''); ?>>(GMT +03:00) Africa/Asmara</option>
						<option value="Africa/Asmera"<?php echo ($appDatas->hour_zone == 'Asmera' ? ' selected' : ''); ?>>(GMT +03:00) Africa/Asmera</option>
						<option value="Africa/Dar_es_Salaam"<?php echo ($appDatas->hour_zone == 'Dar_es_Salaam' ? ' selected' : ''); ?>>(GMT +03:00) Africa/Dar_es_Salaam</option>
						<option value="Africa/Djibouti"<?php echo ($appDatas->hour_zone == 'Africa/Djibouti' ? ' selected' : ''); ?>>(GMT +03:00) Africa/Djibouti</option>
						<option value="Africa/Juba"<?php echo ($appDatas->hour_zone == 'Africa/Juba' ? ' selected' : ''); ?>>(GMT +03:00) Africa/Juba</option>
						<option value="Africa/Kampala"<?php echo ($appDatas->hour_zone == 'Africa/Kampala' ? ' selected' : ''); ?>>(GMT +03:00) Africa/Kampala</option>
						<option value="Africa/Khartoum"<?php echo ($appDatas->hour_zone == 'Africa/Khartoum' ? ' selected' : ''); ?>>(GMT +03:00) Africa/Khartoum</option>
						<option value="Africa/Mogadishu"<?php echo ($appDatas->hour_zone == 'Africa/Mogadishu' ? ' selected' : ''); ?>>(GMT +03:00) Africa/Mogadishu</option>
						<option value="Africa/Nairobi"<?php echo ($appDatas->hour_zone == 'Africa/Nairobi' ? ' selected' : ''); ?>>(GMT +03:00) Africa/Nairobi</option>
						<option value="Antarctica/Syowa"<?php echo ($appDatas->hour_zone == 'Antarctica/Syowa' ? ' selected' : ''); ?>>(GMT +03:00) Antarctica/Syowa</option>
						<option value="Asia/Aden"<?php echo ($appDatas->hour_zone == 'Asia/Aden' ? ' selected' : ''); ?>>(GMT +03:00) Asia/Aden</option>
						<option value="Asia/Amman"<?php echo ($appDatas->hour_zone == 'Asia/Amman' ? ' selected' : ''); ?>>(GMT +03:00) Asia/Amman</option>
						<option value="Asia/Baghdad"<?php echo ($appDatas->hour_zone == 'Asia/Baghdad' ? ' selected' : ''); ?>>(GMT +03:00) Asia/Baghdad</option>
						<option value="Asia/Bahrain"<?php echo ($appDatas->hour_zone == 'Asia/Bahrain' ? ' selected' : ''); ?>>(GMT +03:00) Asia/Bahrain</option>
						<option value="Asia/Beirut"<?php echo ($appDatas->hour_zone == 'Asia/Beirut' ? ' selected' : ''); ?>>(GMT +03:00) Asia/Beirut</option>
						<option value="Asia/Damascus"<?php echo ($appDatas->hour_zone == 'Asia/Damascus' ? ' selected' : ''); ?>>(GMT +03:00) Asia/Damascus</option>
						<option value="Asia/Gaza"<?php echo ($appDatas->hour_zone == 'Asia/Gaza' ? ' selected' : ''); ?>>(GMT +03:00) Asia/Gaza</option>
						<option value="Asia/Hebron"<?php echo ($appDatas->hour_zone == 'Asia/Hebron' ? ' selected' : ''); ?>>(GMT +03:00) Asia/Hebron</option>
						<option value="Asia/Istanbul"<?php echo ($appDatas->hour_zone == 'Asia/Istanbul' ? ' selected' : ''); ?>>(GMT +03:00) Asia/Istanbul</option>
						<option value="Asia/Jerusalem"<?php echo ($appDatas->hour_zone == 'Asia/Jerusalem' ? ' selected' : ''); ?>>(GMT +03:00) Asia/Jerusalem</option>
						<option value="Asia/Kuwait"<?php echo ($appDatas->hour_zone == 'Asia/Kuwait' ? ' selected' : ''); ?>>(GMT +03:00) Asia/Kuwait</option>
						<option value="Asia/Nicosia"<?php echo ($appDatas->hour_zone == 'Asia/Nicosia' ? ' selected' : ''); ?>>(GMT +03:00) Asia/Nicosia</option>
						<option value="Asia/Qatar"<?php echo ($appDatas->hour_zone == 'Asia/Qatar' ? ' selected' : ''); ?>>(GMT +03:00) Asia/Qatar</option>
						<option value="Asia/Riyadh"<?php echo ($appDatas->hour_zone == 'Asia/Riyadh' ? ' selected' : ''); ?>>(GMT +03:00) Asia/Riyadh</option>
						<option value="Asia/Tel_Aviv"<?php echo ($appDatas->hour_zone == 'Asia/Tel_Aviv' ? ' selected' : ''); ?>>(GMT +03:00) Asia/Tel_Aviv</option>
						<option value="EET"<?php echo ($appDatas->hour_zone == 'EET' ? ' selected' : ''); ?>>(GMT +03:00) EET</option>
						<option value="Etc/GMT-3"<?php echo ($appDatas->hour_zone == 'Etc/GMT-3' ? ' selected' : ''); ?>>(GMT +03:00) Etc/GMT-3</option>
						<option value="Europe/Athens"<?php echo ($appDatas->hour_zone == 'Europe/Athens' ? ' selected' : ''); ?>>(GMT +03:00) Europe/Athens</option>
						<option value="Europe/Bucharest"<?php echo ($appDatas->hour_zone == 'Europe/Bucharest' ? ' selected' : ''); ?>>(GMT +03:00) Europe/Bucharest</option>
						<option value="Europe/Chisinau"<?php echo ($appDatas->hour_zone == 'Europe/Chisinau' ? ' selected' : ''); ?>>(GMT +03:00) Europe/Chisinau</option>
						<option value="Europe/Helsinki"<?php echo ($appDatas->hour_zone == 'Europe/Helsinki' ? ' selected' : ''); ?>>(GMT +03:00) Europe/Helsinki</option>
						<option value="Europe/Istanbul"<?php echo ($appDatas->hour_zone == 'Europe/Istanbul' ? ' selected' : ''); ?>>(GMT +03:00) Europe/Istanbul</option>
						<option value="Europe/Kiev"<?php echo ($appDatas->hour_zone == 'Europe/Kiev' ? ' selected' : ''); ?>>(GMT +03:00) Europe/Kiev</option>
						<option value="Europe/Mariehamn"<?php echo ($appDatas->hour_zone == 'Europe/Mariehamn' ? ' selected' : ''); ?>>(GMT +03:00) Europe/Mariehamn</option>
						<option value="Europe/Minsk"<?php echo ($appDatas->hour_zone == 'Europe/Minsk' ? ' selected' : ''); ?>>(GMT +03:00) Europe/Minsk</option>
						<option value="Europe/Moscow"<?php echo ($appDatas->hour_zone == 'Europe/Moscow' ? ' selected' : ''); ?>>(GMT +03:00) Europe/Moscow</option>
						<option value="Europe/Nicosia"<?php echo ($appDatas->hour_zone == 'Europe/Nicosia' ? ' selected' : ''); ?>>(GMT +03:00) Europe/Nicosia</option>
						<option value="Europe/Riga"<?php echo ($appDatas->hour_zone == 'Europe/Riga' ? ' selected' : ''); ?>>(GMT +03:00) Europe/Riga</option>
						<option value="Europe/Simferopol"<?php echo ($appDatas->hour_zone == 'Europe/Simferopol' ? ' selected' : ''); ?>>(GMT +03:00) Europe/Simferopol</option>
						<option value="Europe/Sofia"<?php echo ($appDatas->hour_zone == 'Europe/Sofia' ? ' selected' : ''); ?>>(GMT +03:00) Europe/Sofia</option>
						<option value="Europe/Tallinn"<?php echo ($appDatas->hour_zone == 'Europe/Tallinn' ? ' selected' : ''); ?>>(GMT +03:00) Europe/Tallinn</option>
						<option value="Europe/Tiraspol"<?php echo ($appDatas->hour_zone == 'Europe/Tiraspol' ? ' selected' : ''); ?>>(GMT +03:00) Europe/Tiraspol</option>
						<option value="Europe/Uzhgorod"<?php echo ($appDatas->hour_zone == 'Europe/Uzhgorod' ? ' selected' : ''); ?>>(GMT +03:00) Europe/Uzhgorod</option>
						<option value="Europe/Vilnius"<?php echo ($appDatas->hour_zone == 'Europe/Vilnius' ? ' selected' : ''); ?>>(GMT +03:00) Europe/Vilnius</option>
						<option value="Europe/Volgograd"<?php echo ($appDatas->hour_zone == 'Europe/Volgograd' ? ' selected' : ''); ?>>(GMT +03:00) Europe/Volgograd</option>
						<option value="Europe/Zaporozhye"<?php echo ($appDatas->hour_zone == 'Europe/Zaporozhye' ? ' selected' : ''); ?>>(GMT +03:00) Europe/Zaporozhye</option>
						<option value="Indian/Antananarivo"<?php echo ($appDatas->hour_zone == 'Indian/Antananarivo' ? ' selected' : ''); ?>>(GMT +03:00) Indian/Antananarivo</option>
						<option value="Indian/Comoro"<?php echo ($appDatas->hour_zone == 'Indian/Comoro' ? ' selected' : ''); ?>>(GMT +03:00) Indian/Comoro</option>
						<option value="Indian/Mayotte"<?php echo ($appDatas->hour_zone == 'Indian/Mayotte' ? ' selected' : ''); ?>>(GMT +03:00) Indian/Mayotte</option>
						<option value="Israel"<?php echo ($appDatas->hour_zone == 'Israel' ? ' selected' : ''); ?>>(GMT +03:00) Israel</option>
						<option value="Turkey"<?php echo ($appDatas->hour_zone == 'Turkey' ? ' selected' : ''); ?>>(GMT +03:00) Turkey</option>
						<option value="W-SU"<?php echo ($appDatas->hour_zone == 'W-SU' ? ' selected' : ''); ?>>(GMT +03:00) W-SU</option>
						<option value="Asia/Tehran"<?php echo ($appDatas->hour_zone == 'Asia/Tehran' ? ' selected' : ''); ?>>(GMT +03:30) Asia/Tehran</option>
						<option value="Iran"<?php echo ($appDatas->hour_zone == 'Iran' ? ' selected' : ''); ?>>(GMT +03:30) Iran</option>
						<option value="Asia/Dubai"<?php echo ($appDatas->hour_zone == 'Asia/Dubai' ? ' selected' : ''); ?>>(GMT +04:00) Asia/Dubai</option>
						<option value="Asia/Muscat"<?php echo ($appDatas->hour_zone == 'Asia/Muscat' ? ' selected' : ''); ?>>(GMT +04:00) Asia/Muscat</option>
						<option value="Asia/Tbilisi"<?php echo ($appDatas->hour_zone == 'Asia/Tbilisi' ? ' selected' : ''); ?>>(GMT +04:00) Asia/Tbilisi</option>
						<option value="Asia/Yerevan"<?php echo ($appDatas->hour_zone == 'Asia/Yerevan' ? ' selected' : ''); ?>>(GMT +04:00) Asia/Yerevan</option>
						<option value="Etc/GMT-4"<?php echo ($appDatas->hour_zone == 'Etc/GMT-4' ? ' selected' : ''); ?>>(GMT +04:00) Etc/GMT-4</option>
						<option value="Europe/Samara"<?php echo ($appDatas->hour_zone == 'Europe/Samara' ? ' selected' : ''); ?>>(GMT +04:00) Europe/Samara</option>
						<option value="Indian/Mahe"<?php echo ($appDatas->hour_zone == 'Indian/Mahe' ? ' selected' : ''); ?>>(GMT +04:00) Indian/Mahe</option>
						<option value="Indian/Mauritius"<?php echo ($appDatas->hour_zone == 'Indian/Mauritius' ? ' selected' : ''); ?>>(GMT +04:00) Indian/Mauritius</option>
						<option value="Indian/Reunion"<?php echo ($appDatas->hour_zone == 'Indian/Reunion' ? ' selected' : ''); ?>>(GMT +04:00) Indian/Reunion</option>
						<option value="Asia/Kabul"<?php echo ($appDatas->hour_zone == 'Asia/Kabul' ? ' selected' : ''); ?>>(GMT +04:30) Asia/Kabul</option>
						<option value="Antarctica/Mawson"<?php echo ($appDatas->hour_zone == 'Antarctica/Mawson' ? ' selected' : ''); ?>>(GMT +05:00) Antarctica/Mawson</option>
						<option value="Asia/Aqtau"<?php echo ($appDatas->hour_zone == 'Asia/Aqtau' ? ' selected' : ''); ?>>(GMT +05:00) Asia/Aqtau</option>
						<option value="Asia/Aqtobe"<?php echo ($appDatas->hour_zone == 'Asia/Aqtobe' ? ' selected' : ''); ?>>(GMT +05:00) Asia/Aqtobe</option>
						<option value="Asia/Ashgabat"<?php echo ($appDatas->hour_zone == 'Asia/Ashgabat' ? ' selected' : ''); ?>>(GMT +05:00) Asia/Ashgabat</option>
						<option value="Asia/Ashkhabad"<?php echo ($appDatas->hour_zone == 'Asia/Ashkhabad' ? ' selected' : ''); ?>>(GMT +05:00) Asia/Ashkhabad</option>
						<option value="Asia/Baku"<?php echo ($appDatas->hour_zone == 'Asia/Baku' ? ' selected' : ''); ?>>(GMT +05:00) Asia/Baku</option>
						<option value="Asia/Dushanbe"<?php echo ($appDatas->hour_zone == 'Asia/Dushanbe' ? ' selected' : ''); ?>>(GMT +05:00) Asia/Dushanbe</option>
						<option value="Asia/Karachi"<?php echo ($appDatas->hour_zone == 'Asia/Karachi' ? ' selected' : ''); ?>>(GMT +05:00) Asia/Karachi</option>
						<option value="Asia/Oral"<?php echo ($appDatas->hour_zone == 'Asia/Oral' ? ' selected' : ''); ?>>(GMT +05:00) Asia/Oral</option>
						<option value="Asia/Samarkand"<?php echo ($appDatas->hour_zone == 'Asia/Samarkand' ? ' selected' : ''); ?>>(GMT +05:00) Asia/Samarkand</option>
						<option value="Asia/Tashkent"<?php echo ($appDatas->hour_zone == 'Asia/Tashkent' ? ' selected' : ''); ?>>(GMT +05:00) Asia/Tashkent</option>
						<option value="Asia/Yekaterinburg"<?php echo ($appDatas->hour_zone == 'Asia/Yekaterinburg' ? ' selected' : ''); ?>>(GMT +05:00) Asia/Yekaterinburg</option>
						<option value="Etc/GMT-5"<?php echo ($appDatas->hour_zone == 'Etc/GMT-5' ? ' selected' : ''); ?>>(GMT +05:00) Etc/GMT-5</option>
						<option value="Indian/Kerguelen"<?php echo ($appDatas->hour_zone == 'Indian/Kerguelen' ? ' selected' : ''); ?>>(GMT +05:00) Indian/Kerguelen</option>
						<option value="Indian/Maldives"<?php echo ($appDatas->hour_zone == 'Indian/Maldives' ? ' selected' : ''); ?>>(GMT +05:00) Indian/Maldives</option>
						<option value="Asia/Calcutta"<?php echo ($appDatas->hour_zone == 'Asia/Calcutta' ? ' selected' : ''); ?>>(GMT +05:30) Asia/Calcutta</option>
						<option value="Asia/Colombo"<?php echo ($appDatas->hour_zone == 'Asia/Colombo' ? ' selected' : ''); ?>>(GMT +05:30) Asia/Colombo</option>
						<option value="Asia/Kolkata"<?php echo ($appDatas->hour_zone == 'Asia/Kolkata' ? ' selected' : ''); ?>>(GMT +05:30) Asia/Kolkata</option>
						<option value="Asia/Kathmandu"<?php echo ($appDatas->hour_zone == 'Asia/Kathmandu' ? ' selected' : ''); ?>>(GMT +05:45) Asia/Kathmandu</option>
						<option value="Asia/Katmandu"<?php echo ($appDatas->hour_zone == 'Asia/Katmandu' ? ' selected' : ''); ?>>(GMT +05:45) Asia/Katmandu</option>
						<option value="Antarctica/Vostok"<?php echo ($appDatas->hour_zone == 'Antarctica/Vostok' ? ' selected' : ''); ?>>(GMT +06:00) Antarctica/Vostok</option>
						<option value="Asia/Almaty"<?php echo ($appDatas->hour_zone == 'Asia/Almaty' ? ' selected' : ''); ?>>(GMT +06:00) Asia/Almaty</option>
						<option value="Asia/Bishkek"<?php echo ($appDatas->hour_zone == 'Asia/Bishkek' ? ' selected' : ''); ?>>(GMT +06:00) Asia/Bishkek</option>
						<option value="Asia/Dacca"<?php echo ($appDatas->hour_zone == 'Asia/Dacca' ? ' selected' : ''); ?>>(GMT +06:00) Asia/Dacca</option>
						<option value="Asia/Dhaka"<?php echo ($appDatas->hour_zone == 'Asia/Dhaka' ? ' selected' : ''); ?>>(GMT +06:00) Asia/Dhaka</option>
						<option value="Asia/Kashgar"<?php echo ($appDatas->hour_zone == 'Asia/Kashgar' ? ' selected' : ''); ?>>(GMT +06:00) Asia/Kashgar</option>
						<option value="Asia/Novosibirsk"<?php echo ($appDatas->hour_zone == 'Asia/Novosibirsk' ? ' selected' : ''); ?>>(GMT +06:00) Asia/Novosibirsk</option>
						<option value="Asia/Omsk"<?php echo ($appDatas->hour_zone == 'Asia/Omsk' ? ' selected' : ''); ?>>(GMT +06:00) Asia/Omsk</option>
						<option value="Asia/Qyzylorda"<?php echo ($appDatas->hour_zone == 'Asia/Qyzylorda' ? ' selected' : ''); ?>>(GMT +06:00) Asia/Qyzylorda</option>
						<option value="Asia/Thimbu"<?php echo ($appDatas->hour_zone == 'Asia/Thimbu' ? ' selected' : ''); ?>>(GMT +06:00) Asia/Thimbu</option>
						<option value="Asia/Thimphu"<?php echo ($appDatas->hour_zone == 'Asia/Thimphu' ? ' selected' : ''); ?>>(GMT +06:00) Asia/Thimphu</option>
						<option value="Asia/Urumqi"<?php echo ($appDatas->hour_zone == 'Asia/Urumqi' ? ' selected' : ''); ?>>(GMT +06:00) Asia/Urumqi</option>
						<option value="Etc/GMT-6"<?php echo ($appDatas->hour_zone == 'Etc/GMT-6' ? ' selected' : ''); ?>>(GMT +06:00) Etc/GMT-6</option>
						<option value="Indian/Chagos"<?php echo ($appDatas->hour_zone == 'Indian/Chagos' ? ' selected' : ''); ?>>(GMT +06:00) Indian/Chagos</option>
						<option value="Asia/Rangoon"<?php echo ($appDatas->hour_zone == 'Asia/Rangoon' ? ' selected' : ''); ?>>(GMT +06:30) Asia/Rangoon</option>
						<option value="Indian/Cocos"<?php echo ($appDatas->hour_zone == 'Indian/Cocos' ? ' selected' : ''); ?>>(GMT +06:30) Indian/Cocos</option>
						<option value="Antarctica/Davis"<?php echo ($appDatas->hour_zone == 'Antarctica/Davis' ? ' selected' : ''); ?>>(GMT +07:00) Antarctica/Davis</option>
						<option value="Asia/Bangkok"<?php echo ($appDatas->hour_zone == 'Asia/Bangkok' ? ' selected' : ''); ?>>(GMT +07:00) Asia/Bangkok</option>
						<option value="Asia/Ho_Chi_Minh"<?php echo ($appDatas->hour_zone == 'Asia/Ho_Chi_Minh' ? ' selected' : ''); ?>>(GMT +07:00) Asia/Ho_Chi_Minh</option>
						<option value="Asia/Hovd"<?php echo ($appDatas->hour_zone == 'Asia/Hovd' ? ' selected' : ''); ?>>(GMT +07:00) Asia/Hovd</option>
						<option value="Asia/Jakarta"<?php echo ($appDatas->hour_zone == 'Asia/Jakarta' ? ' selected' : ''); ?>>(GMT +07:00) Asia/Jakarta</option>
						<option value="Asia/Krasnoyarsk"<?php echo ($appDatas->hour_zone == 'Asia/Krasnoyarsk' ? ' selected' : ''); ?>>(GMT +07:00) Asia/Krasnoyarsk</option>
						<option value="Asia/Novokuznetsk"<?php echo ($appDatas->hour_zone == 'Asia/Novokuznetsk' ? ' selected' : ''); ?>>(GMT +07:00) Asia/Novokuznetsk</option>
						<option value="Asia/Phnom_Penh"<?php echo ($appDatas->hour_zone == 'Asia/Phnom_Penh' ? ' selected' : ''); ?>>(GMT +07:00) Asia/Phnom_Penh</option>
						<option value="Asia/Pontianak"<?php echo ($appDatas->hour_zone == 'Asia/Pontianak' ? ' selected' : ''); ?>>(GMT +07:00) Asia/Pontianak</option>
						<option value="Asia/Saigon"<?php echo ($appDatas->hour_zone == 'Asia/Saigon' ? ' selected' : ''); ?>>(GMT +07:00) Asia/Saigon</option>
						<option value="Asia/Vientiane"<?php echo ($appDatas->hour_zone == 'Asia/Vientiane' ? ' selected' : ''); ?>>(GMT +07:00) Asia/Vientiane</option>
						<option value="Etc/GMT-7"<?php echo ($appDatas->hour_zone == 'Etc/GMT-7' ? ' selected' : ''); ?>>(GMT +07:00) Etc/GMT-7</option>
						<option value="Indian/Christmas"<?php echo ($appDatas->hour_zone == 'Indian/Christmas' ? ' selected' : ''); ?>>(GMT +07:00) Indian/Christmas</option>
						<option value="Antarctica/Casey"<?php echo ($appDatas->hour_zone == 'Antarctica/Casey' ? ' selected' : ''); ?>>(GMT +08:00) Antarctica/Casey</option>
						<option value="Asia/Brunei"<?php echo ($appDatas->hour_zone == 'Asia/Brunei' ? ' selected' : ''); ?>>(GMT +08:00) Asia/Brunei</option>
						<option value="Asia/Chita"<?php echo ($appDatas->hour_zone == 'Asia/Chita' ? ' selected' : ''); ?>>(GMT +08:00) Asia/Chita</option>
						<option value="Asia/Choibalsan"<?php echo ($appDatas->hour_zone == 'Asia/Choibalsan' ? ' selected' : ''); ?>>(GMT +08:00) Asia/Choibalsan</option>
						<option value="Asia/Chongqing"<?php echo ($appDatas->hour_zone == 'Asia/Chongqing' ? ' selected' : ''); ?>>(GMT +08:00) Asia/Chongqing</option>
						<option value="Asia/Chungking"<?php echo ($appDatas->hour_zone == 'Asia/Chungking' ? ' selected' : ''); ?>>(GMT +08:00) Asia/Chungking</option>
						<option value="Asia/Harbin"<?php echo ($appDatas->hour_zone == 'Asia/Harbin' ? ' selected' : ''); ?>>(GMT +08:00) Asia/Harbin</option>
						<option value="Asia/Hong_Kong"<?php echo ($appDatas->hour_zone == 'Asia/Hong_Kong' ? ' selected' : ''); ?>>(GMT +08:00) Asia/Hong_Kong</option>
						<option value="Asia/Irkutsk"<?php echo ($appDatas->hour_zone == 'Asia/Irkutsk' ? ' selected' : ''); ?>>(GMT +08:00) Asia/Irkutsk</option>
						<option value="Asia/Kuala_Lumpur"<?php echo ($appDatas->hour_zone == 'Asia/Kuala_Lumpur' ? ' selected' : ''); ?>>(GMT +08:00) Asia/Kuala_Lumpur</option>
						<option value="Asia/Kuching"<?php echo ($appDatas->hour_zone == 'Asia/Kuching' ? ' selected' : ''); ?>>(GMT +08:00) Asia/Kuching</option>
						<option value="Asia/Macao"<?php echo ($appDatas->hour_zone == 'Asia/Macao' ? ' selected' : ''); ?>>(GMT +08:00) Asia/Macao</option>
						<option value="Asia/Macau"<?php echo ($appDatas->hour_zone == 'Asia/Macau' ? ' selected' : ''); ?>>(GMT +08:00) Asia/Macau</option>
						<option value="Asia/Makassar"<?php echo ($appDatas->hour_zone == 'Asia/Makassar' ? ' selected' : ''); ?>>(GMT +08:00) Asia/Makassar</option>
						<option value="Asia/Manila"<?php echo ($appDatas->hour_zone == 'Asia/Manila"' ? ' selected' : ''); ?>>(GMT +08:00) Asia/Manila</option>
						<option value="Asia/Shanghai"<?php echo ($appDatas->hour_zone == 'Asia/Shanghai' ? ' selected' : ''); ?>>(GMT +08:00) Asia/Shanghai</option>
						<option value="Asia/Singapore"<?php echo ($appDatas->hour_zone == 'Asia/Singapore' ? ' selected' : ''); ?>>(GMT +08:00) Asia/Singapore</option>
						<option value="Asia/Taipei"<?php echo ($appDatas->hour_zone == 'Asia/Taipei' ? ' selected' : ''); ?>>(GMT +08:00) Asia/Taipei</option>
						<option value="Asia/Ujung_Pandang"<?php echo ($appDatas->hour_zone == 'Asia/Ujung_Pandang' ? ' selected' : ''); ?>>(GMT +08:00) Asia/Ujung_Pandang</option>
						<option value="Asia/Ulaanbaatar"<?php echo ($appDatas->hour_zone == 'Asia/Ulaanbaatar' ? ' selected' : ''); ?>>(GMT +08:00) Asia/Ulaanbaatar</option>
						<option value="Asia/Ulan_Bator"<?php echo ($appDatas->hour_zone == 'Asia/Ulan_Bator' ? ' selected' : ''); ?>>(GMT +08:00) Asia/Ulan_Bator</option>
						<option value="Australia/Perth"<?php echo ($appDatas->hour_zone == 'Australia/Perth' ? ' selected' : ''); ?>>(GMT +08:00) Australia/Perth</option>
						<option value="Australia/West"<?php echo ($appDatas->hour_zone == 'Australia/West' ? ' selected' : ''); ?>>(GMT +08:00) Australia/West</option>
						<option value="Etc/GMT-8"<?php echo ($appDatas->hour_zone == 'Etc/GMT-8' ? ' selected' : ''); ?>>(GMT +08:00) Etc/GMT-8</option>
						<option value="Hongkong"<?php echo ($appDatas->hour_zone == 'Hongkong' ? ' selected' : ''); ?>>(GMT +08:00) Hongkong</option>
						<option value="PRC"<?php echo ($appDatas->hour_zone == 'PRC' ? ' selected' : ''); ?>>(GMT +08:00) PRC</option>
						<option value="ROC"<?php echo ($appDatas->hour_zone == 'ROC' ? ' selected' : ''); ?>>(GMT +08:00) ROC</option>
						<option value="Singapore"<?php echo ($appDatas->hour_zone == 'Singapore' ? ' selected' : ''); ?>>(GMT +08:00) Singapore</option>
						<option value="Asia/Pyongyang"<?php echo ($appDatas->hour_zone == 'Asia/Pyongyang' ? ' selected' : ''); ?>>(GMT +08:30) Asia/Pyongyang</option>
						<option value="Australia/Eucla"<?php echo ($appDatas->hour_zone == 'Australia/Eucla' ? ' selected' : ''); ?>>(GMT +08:45) Australia/Eucla</option>
						<option value="Asia/Dili"<?php echo ($appDatas->hour_zone == 'Asia/Dili' ? ' selected' : ''); ?>>(GMT +09:00) Asia/Dili</option>
						<option value="Asia/Jayapura"<?php echo ($appDatas->hour_zone == 'Asia/Jayapura' ? ' selected' : ''); ?>>(GMT +09:00) Asia/Jayapura</option>
						<option value="Asia/Khandyga"<?php echo ($appDatas->hour_zone == 'Asia/Khandyga' ? ' selected' : ''); ?>>(GMT +09:00) Asia/Khandyga</option>
						<option value="Asia/Seoul"<?php echo ($appDatas->hour_zone == 'Asia/Seoul' ? ' selected' : ''); ?>>(GMT +09:00) Asia/Seoul</option>
						<option value="Asia/Tokyo"<?php echo ($appDatas->hour_zone == 'Asia/Tokyo' ? ' selected' : ''); ?>>(GMT +09:00) Asia/Tokyo</option>
						<option value="Asia/Yakutsk"<?php echo ($appDatas->hour_zone == 'Asia/Yakutsk' ? ' selected' : ''); ?>>(GMT +09:00) Asia/Yakutsk</option>
						<option value="Etc/GMT-9"<?php echo ($appDatas->hour_zone == 'Etc/GMT-9' ? ' selected' : ''); ?>>(GMT +09:00) Etc/GMT-9</option>
						<option value="Japan"<?php echo ($appDatas->hour_zone == 'Japan' ? ' selected' : ''); ?>>(GMT +09:00) Japan</option>
						<option value="Pacific/Palau"<?php echo ($appDatas->hour_zone == 'Pacific/Palau' ? ' selected' : ''); ?>>(GMT +09:00) Pacific/Palau</option>
						<option value="ROK"<?php echo ($appDatas->hour_zone == 'ROK' ? ' selected' : ''); ?>>(GMT +09:00) ROK</option>
						<option value="Australia/Adelaide"<?php echo ($appDatas->hour_zone == 'Australia/Adelaide' ? ' selected' : ''); ?>>(GMT +09:30) Australia/Adelaide</option>
						<option value="Australia/Broken_Hill"<?php echo ($appDatas->hour_zone == 'Australia/Broken_Hill' ? ' selected' : ''); ?>>(GMT +09:30) Australia/Broken_Hill</option>
						<option value="Australia/Darwin"<?php echo ($appDatas->hour_zone == 'Australia/Darwin' ? ' selected' : ''); ?>>(GMT +09:30) Australia/Darwin</option>
						<option value="Australia/North"<?php echo ($appDatas->hour_zone == 'Australia/North' ? ' selected' : ''); ?>>(GMT +09:30) Australia/North</option>
						<option value="Australia/South"<?php echo ($appDatas->hour_zone == 'Australia/South' ? ' selected' : ''); ?>>(GMT +09:30) Australia/South</option>
						<option value="Australia/Yancowinna"<?php echo ($appDatas->hour_zone == 'Australia/Yancowinna' ? ' selected' : ''); ?>>(GMT +09:30) Australia/Yancowinna</option>
						<option value="Antarctica/DumontDUrville"<?php echo ($appDatas->hour_zone == 'Antarctica/DumontDUrville' ? ' selected' : ''); ?>>(GMT +10:00) Antarctica/DumontDUrville</option>
						<option value="Asia/Magadan"<?php echo ($appDatas->hour_zone == 'Asia/Magadan' ? ' selected' : ''); ?>>(GMT +10:00) Asia/Magadan</option>
						<option value="Asia/Sakhalin"<?php echo ($appDatas->hour_zone == 'Asia/Sakhalin' ? ' selected' : ''); ?>>(GMT +10:00) Asia/Sakhalin</option>
						<option value="Asia/Ust-Nera"<?php echo ($appDatas->hour_zone == 'Asia/Ust-Nera' ? ' selected' : ''); ?>>(GMT +10:00) Asia/Ust-Nera</option>
						<option value="Asia/Vladivostok"<?php echo ($appDatas->hour_zone == 'Asia/Vladivostok' ? ' selected' : ''); ?>>(GMT +10:00) Asia/Vladivostok</option>
						<option value="Australia/ACT"<?php echo ($appDatas->hour_zone == 'Australia/ACT' ? ' selected' : ''); ?>>(GMT +10:00) Australia/ACT</option>
						<option value="Australia/Brisbane"<?php echo ($appDatas->hour_zone == 'Australia/Brisbane' ? ' selected' : ''); ?>>(GMT +10:00) Australia/Brisbane</option>
						<option value="Australia/Canberra"<?php echo ($appDatas->hour_zone == 'Australia/Canberra' ? ' selected' : ''); ?>>(GMT +10:00) Australia/Canberra</option>
						<option value="Australia/Currie"<?php echo ($appDatas->hour_zone == 'Australia/Currie' ? ' selected' : ''); ?>>(GMT +10:00) Australia/Currie</option>
						<option value="Australia/Hobart"<?php echo ($appDatas->hour_zone == 'Australia/Hobart' ? ' selected' : ''); ?>>(GMT +10:00) Australia/Hobart</option>
						<option value="Australia/Lindeman"<?php echo ($appDatas->hour_zone == 'Australia/Lindeman' ? ' selected' : ''); ?>>(GMT +10:00) Australia/Lindeman</option>
						<option value="Australia/Melbourne"<?php echo ($appDatas->hour_zone == 'Australia/Melbourne' ? ' selected' : ''); ?>>(GMT +10:00) Australia/Melbourne</option>
						<option value="Australia/NSW"<?php echo ($appDatas->hour_zone == 'Australia/NSW' ? ' selected' : ''); ?>>(GMT +10:00) Australia/NSW</option>
						<option value="Australia/Queensland"<?php echo ($appDatas->hour_zone == 'Australia/Queensland' ? ' selected' : ''); ?>>(GMT +10:00) Australia/Queensland</option>
						<option value="Australia/Sydney"<?php echo ($appDatas->hour_zone == 'Australia/Sydney' ? ' selected' : ''); ?>>(GMT +10:00) Australia/Sydney</option>
						<option value="Australia/Tasmania"<?php echo ($appDatas->hour_zone == 'Australia/Australia' ? ' selected' : ''); ?>>(GMT +10:00) Australia/Tasmania</option>
						<option value="Australia/Victoria"<?php echo ($appDatas->hour_zone == 'Australia/Victoria' ? ' selected' : ''); ?>>(GMT +10:00) Australia/Victoria</option>
						<option value="Etc/GMT-10"<?php echo ($appDatas->hour_zone == 'Etc/GMT-10' ? ' selected' : ''); ?>>(GMT +10:00) Etc/GMT-10</option>
						<option value="Pacific/Chuuk"<?php echo ($appDatas->hour_zone == 'Pacific/Chuuk' ? ' selected' : ''); ?>>(GMT +10:00) Pacific/Chuuk</option>
						<option value="Pacific/Guam"<?php echo ($appDatas->hour_zone == 'Pacific/Guam' ? ' selected' : ''); ?>>(GMT +10:00) Pacific/Guam</option>
						<option value="Pacific/Port_Moresby"<?php echo ($appDatas->hour_zone == 'Pacific/Port_Moresby' ? ' selected' : ''); ?>>(GMT +10:00) Pacific/Port_Moresby</option>
						<option value="Pacific/Saipan"<?php echo ($appDatas->hour_zone == 'Pacific/Saipan' ? ' selected' : ''); ?>>(GMT +10:00) Pacific/Saipan</option>
						<option value="Pacific/Truk"<?php echo ($appDatas->hour_zone == 'Pacific/Truk' ? ' selected' : ''); ?>>(GMT +10:00) Pacific/Truk</option>
						<option value="Pacific/Yap"<?php echo ($appDatas->hour_zone == 'Pacific/Yap' ? ' selected' : ''); ?>>(GMT +10:00) Pacific/Yap</option>
						<option value="Australia/LHI"<?php echo ($appDatas->hour_zone == 'Australia/LHI' ? ' selected' : ''); ?>>(GMT +10:30) Australia/LHI</option>
						<option value="Australia/Lord_Howe"<?php echo ($appDatas->hour_zone == 'Australia/Lord_Howe' ? ' selected' : ''); ?>>(GMT +10:30) Australia/Lord_Howe</option>
						<option value="Antarctica/Macquarie"<?php echo ($appDatas->hour_zone == 'Antarctica/Macquarie' ? ' selected' : ''); ?>>(GMT +11:00) Antarctica/Macquarie</option>
						<option value="Asia/Srednekolymsk"<?php echo ($appDatas->hour_zone == 'Asia/Srednekolymsk' ? ' selected' : ''); ?>>(GMT +11:00) Asia/Srednekolymsk</option>
						<option value="Etc/GMT-11"<?php echo ($appDatas->hour_zone == 'Etc/GMT-11' ? ' selected' : ''); ?>>(GMT +11:00) Etc/GMT-11</option>
						<option value="Pacific/Bougainville"<?php echo ($appDatas->hour_zone == 'Pacific/Bougainville' ? ' selected' : ''); ?>>(GMT +11:00) Pacific/Bougainville</option>
						<option value="Pacific/Efate"<?php echo ($appDatas->hour_zone == 'Pacific/Efate' ? ' selected' : ''); ?>>(GMT +11:00) Pacific/Efate</option>
						<option value="Pacific/Guadalcanal"<?php echo ($appDatas->hour_zone == 'Pacific/Guadalcanal' ? ' selected' : ''); ?>>(GMT +11:00) Pacific/Guadalcanal</option>
						<option value="Pacific/Kosrae"<?php echo ($appDatas->hour_zone == 'Pacific/Kosrae' ? ' selected' : ''); ?>>(GMT +11:00) Pacific/Kosrae</option>
						<option value="Pacific/Norfolk"<?php echo ($appDatas->hour_zone == 'Pacific/Norfolk' ? ' selected' : ''); ?>>(GMT +11:00) Pacific/Norfolk</option>
						<option value="Pacific/Noumea"<?php echo ($appDatas->hour_zone == 'Pacific/Noumea' ? ' selected' : ''); ?>>(GMT +11:00) Pacific/Noumea</option>
						<option value="Pacific/Pohnpei"<?php echo ($appDatas->hour_zone == 'Pacific/Pohnpei' ? ' selected' : ''); ?>>(GMT +11:00) Pacific/Pohnpei</option>
						<option value="Pacific/Ponape"<?php echo ($appDatas->hour_zone == 'Pacific/Ponape' ? ' selected' : ''); ?>>(GMT +11:00) Pacific/Ponape</option>
						<option value="Asia/Anadyr"<?php echo ($appDatas->hour_zone == 'Asia/Anadyr' ? ' selected' : ''); ?>>(GMT +12:00) Asia/Anadyr</option>
						<option value="Asia/Kamchatka"<?php echo ($appDatas->hour_zone == 'Asia/Kamchatka' ? ' selected' : ''); ?>>(GMT +12:00) Asia/Kamchatka</option>
						<option value="Etc/GMT-12"<?php echo ($appDatas->hour_zone == 'Etc/GMT-12' ? ' selected' : ''); ?>>(GMT +12:00) Etc/GMT-12</option>
						<option value="Kwajalein"<?php echo ($appDatas->hour_zone == 'Kwajalein' ? ' selected' : ''); ?>>(GMT +12:00) Kwajalein</option>
						<option value="Pacific/Fiji"<?php echo ($appDatas->hour_zone == 'Pacific/Fiji' ? ' selected' : ''); ?>>(GMT +12:00) Pacific/Fiji</option>
						<option value="Pacific/Funafuti"<?php echo ($appDatas->hour_zone == 'Pacific/Funafuti' ? ' selected' : ''); ?>>(GMT +12:00) Pacific/Funafuti</option>
						<option value="Pacific/Kwajalein"<?php echo ($appDatas->hour_zone == 'Pacific/Kwajalein' ? ' selected' : ''); ?>>(GMT +12:00) Pacific/Kwajalein</option>
						<option value="Pacific/Majuro"<?php echo ($appDatas->hour_zone == 'Pacific/Majuro' ? ' selected' : ''); ?>>(GMT +12:00) Pacific/Majuro</option>
						<option value="Pacific/Nauru"<?php echo ($appDatas->hour_zone == 'Pacific/Nauru' ? ' selected' : ''); ?>>(GMT +12:00) Pacific/Nauru</option>
						<option value="Pacific/Tarawa"<?php echo ($appDatas->hour_zone == 'Pacific/Tarawa' ? ' selected' : ''); ?>>(GMT +12:00) Pacific/Tarawa</option>
						<option value="Pacific/Wake"<?php echo ($appDatas->hour_zone == 'Pacific/Wake' ? ' selected' : ''); ?>>(GMT +12:00) Pacific/Wake</option>
						<option value="Pacific/Wallis"<?php echo ($appDatas->hour_zone == 'Pacific/Wallis' ? ' selected' : ''); ?>>(GMT +12:00) Pacific/Wallis</option>
						<option value="Antarctica/McMurdo"<?php echo ($appDatas->hour_zone == 'Antarctica/McMurdo' ? ' selected' : ''); ?>>(GMT +13:00) Antarctica/McMurdo</option>
						<option value="Antarctica/South_Pole"<?php echo ($appDatas->hour_zone == 'Antarctica/South_Pole' ? ' selected' : ''); ?>>(GMT +13:00) Antarctica/South_Pole</option>
						<option value="Etc/GMT-13"<?php echo ($appDatas->hour_zone == 'Etc/GMT-13' ? ' selected' : ''); ?>>(GMT +13:00) Etc/GMT-13</option>
						<option value="NZ"<?php echo ($appDatas->hour_zone == 'NZ' ? ' selected' : ''); ?>>(GMT +13:00) NZ</option>
						<option value="Pacific/Auckland"<?php echo ($appDatas->hour_zone == 'Pacific/Auckland' ? ' selected' : ''); ?>>(GMT +13:00) Pacific/Auckland</option>
						<option value="Pacific/Enderbury"<?php echo ($appDatas->hour_zone == 'Pacific/Enderbury' ? ' selected' : ''); ?>>(GMT +13:00) Pacific/Enderbury</option>
						<option value="Pacific/Fakaofo"<?php echo ($appDatas->hour_zone == 'Pacific/Fakaofo' ? ' selected' : ''); ?>>(GMT +13:00) Pacific/Fakaofo</option>
						<option value="Pacific/Tongatapu"<?php echo ($appDatas->hour_zone == 'Pacific/Tongatapu' ? ' selected' : ''); ?>>(GMT +13:00) Pacific/Tongatapu</option>
						<option value="NZ-CHAT"<?php echo ($appDatas->hour_zone == 'NZ-CHAT' ? ' selected' : ''); ?>>(GMT +13:45) NZ-CHAT</option>
						<option value="Pacific/Chatham"<?php echo ($appDatas->hour_zone == 'Pacific/Chatham' ? ' selected' : ''); ?>>(GMT +13:45) Pacific/Chatham</option>
						<option value="Etc/GMT-14"<?php echo ($appDatas->hour_zone == 'Etc/GMT-14' ? ' selected' : ''); ?>>(GMT +14:00) Etc/GMT-14</option>
						<option value="Pacific/Apia"<?php echo ($appDatas->hour_zone == 'Pacific/Chatham' ? ' selected' : ''); ?>>(GMT +14:00) Pacific/Apia</option>
						<option value="Pacific/Kiritimati"<?php echo ($appDatas->hour_zone == 'Pacific/Kiritimati' ? ' selected' : ''); ?>>(GMT +14:00) Pacific/Kiritimati</option>
						<option value="Atlantic/Cape_Verde"<?php echo ($appDatas->hour_zone == 'Atlantic/Cape_Verde' ? ' selected' : ''); ?>>(GMT -01:00) Atlantic/Cape_Verde</option>
						<option value="Etc/GMT+1"<?php echo ($appDatas->hour_zone == 'Etc/GMT+1' ? ' selected' : ''); ?>>(GMT -01:00) Etc/GMT+1</option>
						<option value="America/Godthab"<?php echo ($appDatas->hour_zone == 'America/Godthab' ? ' selected' : ''); ?>>(GMT -02:00) America/Godthab</option>
						<option value="America/Miquelon"<?php echo ($appDatas->hour_zone == 'America/Miquelon' ? ' selected' : ''); ?>>(GMT -02:00) America/Miquelon</option>
						<option value="America/Noronha"<?php echo ($appDatas->hour_zone == 'America/Noronha' ? ' selected' : ''); ?>>(GMT -02:00) America/Noronha</option>
						<option value="Atlantic/South_Georgia"<?php echo ($appDatas->hour_zone == 'Atlantic/South_Georgia' ? ' selected' : ''); ?>>(GMT -02:00) Atlantic/South_Georgia</option>
						<option value="Brazil/DeNoronha"<?php echo ($appDatas->hour_zone == 'Brazil/DeNoronha' ? ' selected' : ''); ?>>(GMT -02:00) Brazil/DeNoronha</option>
						<option value="Etc/GMT+2"<?php echo ($appDatas->hour_zone == 'Etc/GMT+2' ? ' selected' : ''); ?>>(GMT -02:00) Etc/GMT+2</option>
						<option value="America/St_Johns"<?php echo ($appDatas->hour_zone == 'America/St_Johns' ? ' selected' : ''); ?>>(GMT -02:30) America/St_Johns</option>
						<option value="Canada/Newfoundland"<?php echo ($appDatas->hour_zone == 'Canada/Newfoundland' ? ' selected' : ''); ?>>(GMT -02:30) Canada/Newfoundland</option>
						<option value="America/Araguaina"<?php echo ($appDatas->hour_zone == 'America/Araguaina' ? ' selected' : ''); ?>>(GMT -03:00) America/Araguaina</option>
						<option value="America/Argentina/Buenos_Aires"<?php echo ($appDatas->hour_zone == 'America/Argentina/Buenos_Aires' ? ' selected' : ''); ?>>(GMT -03:00) America/Argentina/Buenos_Aires</option>
						<option value="America/Argentina/Catamarca"<?php echo ($appDatas->hour_zone == 'America/Argentina/Catamarca' ? ' selected' : ''); ?>>(GMT -03:00) America/Argentina/Catamarca</option>
						<option value="America/Argentina/ComodRivadavia"<?php echo ($appDatas->hour_zone == 'America/Argentina/ComodRivadavia' ? ' selected' : ''); ?>>(GMT -03:00) America/Argentina/ComodRivadavia</option>
						<option value="America/Argentina/Cordoba"<?php echo ($appDatas->hour_zone == 'America/Argentina/Cordoba' ? ' selected' : ''); ?>>(GMT -03:00) America/Argentina/Cordoba</option>
						<option value="America/Argentina/Jujuy"<?php echo ($appDatas->hour_zone == 'America/Argentina/Jujuy' ? ' selected' : ''); ?>>(GMT -03:00) America/Argentina/Jujuy</option>
						<option value="America/Argentina/La_Rioja"<?php echo ($appDatas->hour_zone == 'America/Argentina/La_Rioja' ? ' selected' : ''); ?>>(GMT -03:00) America/Argentina/La_Rioja</option>
						<option value="America/Argentina/Mendoza"<?php echo ($appDatas->hour_zone == 'America/Argentina/Mendoza' ? ' selected' : ''); ?>>(GMT -03:00) America/Argentina/Mendoza</option>
						<option value="America/Argentina/Rio_Gallegos"<?php echo ($appDatas->hour_zone == 'America/Argentina/Rio_Gallegos' ? ' selected' : ''); ?>>(GMT -03:00) America/Argentina/Rio_Gallegos</option>
						<option value="America/Argentina/Salta"<?php echo ($appDatas->hour_zone == 'America/Argentina/Salta' ? ' selected' : ''); ?>>(GMT -03:00) America/Argentina/Salta</option>
						<option value="America/Argentina/San_Juan"<?php echo ($appDatas->hour_zone == 'America/Argentina/San_Juan' ? ' selected' : ''); ?>>(GMT -03:00) America/Argentina/San_Juan</option>
						<option value="America/Argentina/San_Luis"<?php echo ($appDatas->hour_zone == 'America/Argentina/San_Luis' ? ' selected' : ''); ?>>(GMT -03:00) America/Argentina/San_Luis</option>
						<option value="America/Argentina/Tucuman"<?php echo ($appDatas->hour_zone == 'America/Argentina/Tucuman' ? ' selected' : ''); ?>>(GMT -03:00) America/Argentina/Tucuman</option>
						<option value="America/Argentina/Ushuaia"<?php echo ($appDatas->hour_zone == 'America/Argentina/Ushuaia' ? ' selected' : ''); ?>>(GMT -03:00) America/Argentina/Ushuaia</option>
						<option value="America/Bahia"<?php echo ($appDatas->hour_zone == 'America/Bahia' ? ' selected' : ''); ?>>(GMT -03:00) America/Bahia</option>
						<option value="America/Belem"<?php echo ($appDatas->hour_zone == 'America/Belem' ? ' selected' : ''); ?>>(GMT -03:00) America/Belem</option>
						<option value="America/Buenos_Aires"<?php echo ($appDatas->hour_zone == 'America/Buenos_Aires' ? ' selected' : ''); ?>>(GMT -03:00) America/Buenos_Aires</option>
						<option value="America/Catamarca"<?php echo ($appDatas->hour_zone == 'America/Catamarca' ? ' selected' : ''); ?>>(GMT -03:00) America/Catamarca</option>
						<option value="America/Cayenne"<?php echo ($appDatas->hour_zone == 'America/Cayenne' ? ' selected' : ''); ?>>(GMT -03:00) America/Cayenne</option>
						<option value="America/Cordoba"<?php echo ($appDatas->hour_zone == 'America/Cordoba' ? ' selected' : ''); ?>>(GMT -03:00) America/Cordoba</option>
						<option value="America/Fortaleza"<?php echo ($appDatas->hour_zone == 'America/Fortaleza' ? ' selected' : ''); ?>>(GMT -03:00) America/Fortaleza</option>
						<option value="America/Glace_Bay"<?php echo ($appDatas->hour_zone == 'America/Glace_Bay' ? ' selected' : ''); ?>>(GMT -03:00) America/Glace_Bay</option>
						<option value="America/Goose_Bay"<?php echo ($appDatas->hour_zone == 'America/Goose_Bay' ? ' selected' : ''); ?>>(GMT -03:00) America/Goose_Bay</option>
						<option value="America/Halifax"<?php echo ($appDatas->hour_zone == 'America/Halifax' ? ' selected' : ''); ?>>(GMT -03:00) America/Halifax</option>
						<option value="America/Jujuy"<?php echo ($appDatas->hour_zone == 'America/Jujuy' ? ' selected' : ''); ?>>(GMT -03:00) America/Jujuy</option>
						<option value="America/Maceio"<?php echo ($appDatas->hour_zone == 'America/Maceio' ? ' selected' : ''); ?>>(GMT -03:00) America/Maceio</option>
						<option value="America/Mendoza"<?php echo ($appDatas->hour_zone == 'America/Mendoza' ? ' selected' : ''); ?>>(GMT -03:00) America/Mendoza</option>
						<option value="America/Moncton"<?php echo ($appDatas->hour_zone == 'America/Moncton' ? ' selected' : ''); ?>>(GMT -03:00) America/Moncton</option>
						<option value="America/Montevideo"<?php echo ($appDatas->hour_zone == 'America/Montevideo' ? ' selected' : ''); ?>>(GMT -03:00) America/Montevideo</option>
						<option value="America/Paramaribo"<?php echo ($appDatas->hour_zone == 'America/Paramaribo' ? ' selected' : ''); ?>>(GMT -03:00) America/Paramaribo</option>
						<option value="America/Recife"<?php echo ($appDatas->hour_zone == 'America/Recife' ? ' selected' : ''); ?>>(GMT -03:00) America/Recife</option>
						<option value="America/Rosario"<?php echo ($appDatas->hour_zone == 'America/Rosario' ? ' selected' : ''); ?>>(GMT -03:00) America/Rosario</option>
						<option value="America/Santarem"<?php echo ($appDatas->hour_zone == 'America/Santarem' ? ' selected' : ''); ?>>(GMT -03:00) America/Santarem</option>
						<option value="America/Santiago"<?php echo ($appDatas->hour_zone == 'America/Santiago' ? ' selected' : ''); ?>>(GMT -03:00) America/Santiago</option>
						<option value="America/Sao_Paulo"<?php echo ($appDatas->hour_zone == 'America/Sao_Paulo' ? ' selected' : ''); ?>>(GMT -03:00) America/Sao_Paulo</option>
						<option value="America/Thule"<?php echo ($appDatas->hour_zone == 'America/Thule' ? ' selected' : ''); ?>>(GMT -03:00) America/Thule</option>
						<option value="Antarctica/Palmer"<?php echo ($appDatas->hour_zone == 'Antarctica/Palmer' ? ' selected' : ''); ?>>(GMT -03:00) Antarctica/Palmer</option>
						<option value="Antarctica/Rothera"<?php echo ($appDatas->hour_zone == 'Antarctica/Rothera' ? ' selected' : ''); ?>>(GMT -03:00) Antarctica/Rothera</option>
						<option value="Atlantic/Bermuda"<?php echo ($appDatas->hour_zone == 'Atlantic/Bermuda' ? ' selected' : ''); ?>>(GMT -03:00) Atlantic/Bermuda</option>
						<option value="Atlantic/Stanley"<?php echo ($appDatas->hour_zone == 'Atlantic/Stanley' ? ' selected' : ''); ?>>(GMT -03:00) Atlantic/Stanley</option>
						<option value="Brazil/East"<?php echo ($appDatas->hour_zone == 'Brazil/East' ? ' selected' : ''); ?>>(GMT -03:00) Brazil/East</option>
						<option value="Canada/Atlantic"<?php echo ($appDatas->hour_zone == 'America/Thule' ? ' selected' : ''); ?>>(GMT -03:00) Canada/Atlantic</option>
						<option value="Chile/Continental"<?php echo ($appDatas->hour_zone == 'Chile/Continental' ? ' selected' : ''); ?>>(GMT -03:00) Chile/Continental</option>
						<option value="Etc/GMT+3"<?php echo ($appDatas->hour_zone == 'Etc/GMT+3' ? ' selected' : ''); ?>>(GMT -03:00) Etc/GMT+3</option>
						<option value="America/Anguilla"<?php echo ($appDatas->hour_zone == 'America/Anguilla' ? ' selected' : ''); ?>>(GMT -04:00) America/Anguilla</option>
						<option value="America/Antigua"<?php echo ($appDatas->hour_zone == 'America/Antigua' ? ' selected' : ''); ?>>(GMT -04:00) America/Antigua</option>
						<option value="America/Aruba"<?php echo ($appDatas->hour_zone == 'America/Aruba' ? ' selected' : ''); ?>>(GMT -04:00) America/Aruba</option>
						<option value="America/Asuncion"<?php echo ($appDatas->hour_zone == 'America/Asuncion' ? ' selected' : ''); ?>>(GMT -04:00) America/Asuncion</option>
						<option value="America/Barbados"<?php echo ($appDatas->hour_zone == 'America/Barbados' ? ' selected' : ''); ?>>(GMT -04:00) America/Barbados</option>
						<option value="America/Blanc-Sablon"<?php echo ($appDatas->hour_zone == 'America/Blanc-Sablon' ? ' selected' : ''); ?>>(GMT -04:00) America/Blanc-Sablon</option>
						<option value="America/Boa_Vista"<?php echo ($appDatas->hour_zone == 'America/Boa_Vista' ? ' selected' : ''); ?>>(GMT -04:00) America/Boa_Vista</option>
						<option value="America/Campo_Grande"<?php echo ($appDatas->hour_zone == 'America/Campo_Grande' ? ' selected' : ''); ?>>(GMT -04:00) America/Campo_Grande</option>
						<option value="America/Cayman"<?php echo ($appDatas->hour_zone == 'America/Cayman' ? ' selected' : ''); ?>>(GMT -04:00) America/Cayman</option>
						<option value="America/Cuiaba"<?php echo ($appDatas->hour_zone == 'America/Cuiaba' ? ' selected' : ''); ?>>(GMT -04:00) America/Cuiaba</option>
						<option value="America/Curacao"<?php echo ($appDatas->hour_zone == 'America/Curacao' ? ' selected' : ''); ?>>(GMT -04:00) America/Curacao</option>
						<option value="America/Detroit"<?php echo ($appDatas->hour_zone == 'America/Detroit' ? ' selected' : ''); ?>>(GMT -04:00) America/Detroit</option>
						<option value="America/Dominica"<?php echo ($appDatas->hour_zone == 'America/Dominica' ? ' selected' : ''); ?>>(GMT -04:00) America/Dominica</option>
						<option value="America/Fort_Wayne"<?php echo ($appDatas->hour_zone == 'America/Fort_Wayne' ? ' selected' : ''); ?>>(GMT -04:00) America/Fort_Wayne</option>
						<option value="America/Grand_Turk"<?php echo ($appDatas->hour_zone == 'America/Grand_Turk' ? ' selected' : ''); ?>>(GMT -04:00) America/Grand_Turk</option>
						<option value="America/Grenada"<?php echo ($appDatas->hour_zone == 'America/Grenada' ? ' selected' : ''); ?>>(GMT -04:00) America/Grenada</option>
						<option value="America/Guadeloupe"<?php echo ($appDatas->hour_zone == 'America/Guadeloupe' ? ' selected' : ''); ?>>(GMT -04:00) America/Guadeloupe</option>
						<option value="America/Guyana"<?php echo ($appDatas->hour_zone == 'America/Guyana' ? ' selected' : ''); ?>>(GMT -04:00) America/Guyana</option>
						<option value="America/Havana"<?php echo ($appDatas->hour_zone == 'America/Havana' ? ' selected' : ''); ?>>(GMT -04:00) America/Havana</option>
						<option value="America/Indiana/Indianapolis"<?php echo ($appDatas->hour_zone == 'America/Indiana/Indianapolis' ? ' selected' : ''); ?>>(GMT -04:00) America/Indiana/Indianapolis</option>
						<option value="America/Indiana/Marengo"<?php echo ($appDatas->hour_zone == 'America/Indiana/Marengo' ? ' selected' : ''); ?>>(GMT -04:00) America/Indiana/Marengo</option>
						<option value="America/Indiana/Petersburg"<?php echo ($appDatas->hour_zone == 'America/Indiana/Petersburg' ? ' selected' : ''); ?>>(GMT -04:00) America/Indiana/Petersburg</option>
						<option value="America/Indiana/Vevay"<?php echo ($appDatas->hour_zone == 'America/Indiana/Vevay' ? ' selected' : ''); ?>>(GMT -04:00) America/Indiana/Vevay</option>
						<option value="America/Indiana/Vincennes"<?php echo ($appDatas->hour_zone == 'America/Indiana/Vincennes' ? ' selected' : ''); ?>>(GMT -04:00) America/Indiana/Vincennes</option>
						<option value="America/Indiana/Winamac"<?php echo ($appDatas->hour_zone == 'America/Indiana/Winamac' ? ' selected' : ''); ?>>(GMT -04:00) America/Indiana/Winamac</option>
						<option value="America/Indianapolis"<?php echo ($appDatas->hour_zone == 'America/Indianapolis' ? ' selected' : ''); ?>>(GMT -04:00) America/Indianapolis</option>
						<option value="America/Iqaluit"<?php echo ($appDatas->hour_zone == 'America/Iqaluit' ? ' selected' : ''); ?>>(GMT -04:00) America/Iqaluit</option>
						<option value="America/Kentucky/Louisville"<?php echo ($appDatas->hour_zone == 'America/Kentucky/Louisville' ? ' selected' : ''); ?>>(GMT -04:00) America/Kentucky/Louisville</option>
						<option value="America/Kentucky/Monticello"<?php echo ($appDatas->hour_zone == 'America/Kentucky/Monticello' ? ' selected' : ''); ?>>(GMT -04:00) America/Kentucky/Monticello</option>
						<option value="America/Kralendijk"<?php echo ($appDatas->hour_zone == 'America/Kralendijk' ? ' selected' : ''); ?>>(GMT -04:00) America/Kralendijk</option>
						<option value="America/La_Paz"<?php echo ($appDatas->hour_zone == 'America/La_Paz' ? ' selected' : ''); ?>>(GMT -04:00) America/La_Paz</option>
						<option value="America/Louisville"<?php echo ($appDatas->hour_zone == 'America/Louisville' ? ' selected' : ''); ?>>(GMT -04:00) America/Louisville</option>
						<option value="America/Lower_Princes"<?php echo ($appDatas->hour_zone == 'America/Lower_Princes' ? ' selected' : ''); ?>>(GMT -04:00) America/Lower_Princes</option>
						<option value="America/Manaus"<?php echo ($appDatas->hour_zone == 'America/Manaus' ? ' selected' : ''); ?>>(GMT -04:00) America/Manaus</option>
						<option value="America/Marigot"<?php echo ($appDatas->hour_zone == 'America/Marigot' ? ' selected' : ''); ?>>(GMT -04:00) America/Marigot</option>
						<option value="America/Martinique"<?php echo ($appDatas->hour_zone == 'America/Martinique' ? ' selected' : ''); ?>>(GMT -04:00) America/Martinique</option>
						<option value="America/Montreal"<?php echo ($appDatas->hour_zone == 'America/Montreal' ? ' selected' : ''); ?>>(GMT -04:00) America/Montreal</option>
						<option value="America/Montserrat"<?php echo ($appDatas->hour_zone == 'America/Montserrat' ? ' selected' : ''); ?>>(GMT -04:00) America/Montserrat</option>
						<option value="America/Nassau"<?php echo ($appDatas->hour_zone == 'America/Nassau' ? ' selected' : ''); ?>>(GMT -04:00) America/Nassau</option>
						<option value="America/New_York"<?php echo ($appDatas->hour_zone == 'America/New_York' ? ' selected' : ''); ?>>(GMT -04:00) America/New_York</option>
						<option value="America/Nipigon"<?php echo ($appDatas->hour_zone == 'America/Nipigon' ? ' selected' : ''); ?>>(GMT -04:00) America/Nipigon</option>
						<option value="America/Pangnirtung"<?php echo ($appDatas->hour_zone == 'America/Pangnirtung' ? ' selected' : ''); ?>>(GMT -04:00) America/Pangnirtung</option>
						<option value="America/Port-au-Prince"<?php echo ($appDatas->hour_zone == 'America/Port-au-Prince' ? ' selected' : ''); ?>>(GMT -04:00) America/Port-au-Prince</option>
						<option value="America/Port_of_Spain"<?php echo ($appDatas->hour_zone == 'America/Port_of_Spain' ? ' selected' : ''); ?>>(GMT -04:00) America/Port_of_Spain</option>
						<option value="America/Porto_Velho"<?php echo ($appDatas->hour_zone == 'America/Porto_Velho' ? ' selected' : ''); ?>>(GMT -04:00) America/Porto_Velho</option>
						<option value="America/Puerto_Rico"<?php echo ($appDatas->hour_zone == 'America/Puerto_Rico' ? ' selected' : ''); ?>>(GMT -04:00) America/Puerto_Rico</option>
						<option value="America/Santo_Domingo"<?php echo ($appDatas->hour_zone == 'America/Santo_Domingo' ? ' selected' : ''); ?>>(GMT -04:00) America/Santo_Domingo</option>
						<option value="America/St_Barthelemy"<?php echo ($appDatas->hour_zone == 'America/St_Barthelemy' ? ' selected' : ''); ?>>(GMT -04:00) America/St_Barthelemy</option>
						<option value="America/St_Kitts"<?php echo ($appDatas->hour_zone == 'America/St_Kitts' ? ' selected' : ''); ?>>(GMT -04:00) America/St_Kitts</option>
						<option value="America/St_Lucia"<?php echo ($appDatas->hour_zone == 'America/St_Lucia' ? ' selected' : ''); ?>>(GMT -04:00) America/St_Lucia</option>
						<option value="America/St_Thomas"<?php echo ($appDatas->hour_zone == 'America/St_Thomas' ? ' selected' : ''); ?>>(GMT -04:00) America/St_Thomas</option>
						<option value="America/St_Vincent"<?php echo ($appDatas->hour_zone == 'America/St_Vincent' ? ' selected' : ''); ?>>(GMT -04:00) America/St_Vincent</option>
						<option value="America/Thunder_Bay"<?php echo ($appDatas->hour_zone == 'America/Thunder_Bay' ? ' selected' : ''); ?>>(GMT -04:00) America/Thunder_Bay</option>
						<option value="America/Toronto"<?php echo ($appDatas->hour_zone == 'America/Toronto' ? ' selected' : ''); ?>>(GMT -04:00) America/Toronto</option>
						<option value="America/Tortola"<?php echo ($appDatas->hour_zone == 'America/Tortola' ? ' selected' : ''); ?>>(GMT -04:00) America/Tortola</option>
						<option value="America/Virgin"<?php echo ($appDatas->hour_zone == 'America/Virgin' ? ' selected' : ''); ?>>(GMT -04:00) America/Virgin</option>
						<option value="Brazil/West"<?php echo ($appDatas->hour_zone == 'America/West' ? ' selected' : ''); ?>>(GMT -04:00) Brazil/West</option>
						<option value="Canada/Eastern"<?php echo ($appDatas->hour_zone == 'Canada/Eastern' ? ' selected' : ''); ?>>(GMT -04:00) Canada/Eastern</option>
						<option value="Cuba"<?php echo ($appDatas->hour_zone == 'Cuba' ? ' selected' : ''); ?>>(GMT -04:00) Cuba</option>
						<option value="EST5EDT"<?php echo ($appDatas->hour_zone == 'EST5EDT' ? ' selected' : ''); ?>>(GMT -04:00) EST5EDT</option>
						<option value="Etc/GMT+4"<?php echo ($appDatas->hour_zone == 'Etc/GMT+4' ? ' selected' : ''); ?>>(GMT -04:00) Etc/GMT+4</option>
						<option value="US/East-Indiana"<?php echo ($appDatas->hour_zone == 'US/East-Indiana' ? ' selected' : ''); ?>>(GMT -04:00) US/East-Indiana</option>
						<option value="US/Eastern"<?php echo ($appDatas->hour_zone == 'US/Eastern' ? ' selected' : ''); ?>>(GMT -04:00) US/Eastern</option>
						<option value="US/Michigan"<?php echo ($appDatas->hour_zone == 'US/Michigan' ? ' selected' : ''); ?>>(GMT -04:00) US/Michigan</option>
						<option value="America/Caracas"<?php echo ($appDatas->hour_zone == 'America/Caracas' ? ' selected' : ''); ?>>(GMT -04:30) America/Caracas</option>
						<option value="America/Atikokan"<?php echo ($appDatas->hour_zone == 'America/Atikokan' ? ' selected' : ''); ?>>(GMT -05:00) America/Atikokan</option>
						<option value="America/Bahia_Banderas"<?php echo ($appDatas->hour_zone == 'America/Bahia_Banderas' ? ' selected' : ''); ?>>(GMT -05:00) America/Bahia_Banderas</option>
						<option value="America/Bogota"<?php echo ($appDatas->hour_zone == 'America/Bogota' ? ' selected' : ''); ?>>(GMT -05:00) America/Bogota</option>
						<option value="America/Cancun"<?php echo ($appDatas->hour_zone == 'America/Cancun' ? ' selected' : ''); ?>>(GMT -05:00) America/Cancun</option>
						<option value="America/Chicago"<?php echo ($appDatas->hour_zone == 'America/Chicago' ? ' selected' : ''); ?>>(GMT -05:00) America/Chicago</option>
						<option value="America/Coral_Harbour"<?php echo ($appDatas->hour_zone == 'America/Coral_Harbour' ? ' selected' : ''); ?>>(GMT -05:00) America/Coral_Harbour</option>
						<option value="America/Eirunepe"<?php echo ($appDatas->hour_zone == 'America/Eirunepe' ? ' selected' : ''); ?>>(GMT -05:00) America/Eirunepe</option>
						<option value="America/Guayaquil"<?php echo ($appDatas->hour_zone == 'America/Guayaquil' ? ' selected' : ''); ?>>(GMT -05:00) America/Guayaquil</option>
						<option value="America/Indiana/Knox"<?php echo ($appDatas->hour_zone == 'America/Indiana/Knox' ? ' selected' : ''); ?>>(GMT -05:00) America/Indiana/Knox</option>
						<option value="America/Indiana/Tell_City"<?php echo ($appDatas->hour_zone == 'America/Indiana/Tell_City' ? ' selected' : ''); ?>>(GMT -05:00) America/Indiana/Tell_City</option>
						<option value="America/Jamaica"<?php echo ($appDatas->hour_zone == 'America/Jamaica' ? ' selected' : ''); ?>>(GMT -05:00) America/Jamaica</option>
						<option value="America/Knox_IN"<?php echo ($appDatas->hour_zone == 'America/Knox_IN' ? ' selected' : ''); ?>>(GMT -05:00) America/Knox_IN</option>
						<option value="America/Lima"<?php echo ($appDatas->hour_zone == 'America/Lima' ? ' selected' : ''); ?>>(GMT -05:00) America/Lima</option>
						<option value="America/Matamoros"<?php echo ($appDatas->hour_zone == 'America/Matamoros' ? ' selected' : ''); ?>>(GMT -05:00) America/Matamoros</option>
						<option value="America/Menominee"<?php echo ($appDatas->hour_zone == 'America/Menominee' ? ' selected' : ''); ?>>(GMT -05:00) America/Menominee</option>
						<option value="America/Merida"<?php echo ($appDatas->hour_zone == 'America/Merida' ? ' selected' : ''); ?>>(GMT -05:00) America/Merida</option>
						<option value="America/Mexico_City"<?php echo ($appDatas->hour_zone == 'America/Mexico_City' ? ' selected' : ''); ?>>(GMT -05:00) America/Mexico_City</option>
						<option value="America/Monterrey"<?php echo ($appDatas->hour_zone == 'America/Monterrey' ? ' selected' : ''); ?>>(GMT -05:00) America/Monterrey</option>
						<option value="America/North_Dakota/Beulah"<?php echo ($appDatas->hour_zone == 'America/North_Dakota/Beulah' ? ' selected' : ''); ?>>(GMT -05:00) America/North_Dakota/Beulah</option>
						<option value="America/North_Dakota/Center"<?php echo ($appDatas->hour_zone == 'America/North_Dakota/Center' ? ' selected' : ''); ?>>(GMT -05:00) America/North_Dakota/Center</option>
						<option value="America/North_Dakota/New_Salem"<?php echo ($appDatas->hour_zone == 'America/North_Dakota/New_Salem' ? ' selected' : ''); ?>>(GMT -05:00) America/North_Dakota/New_Salem</option>
						<option value="America/Panama"<?php echo ($appDatas->hour_zone == 'America/Panama' ? ' selected' : ''); ?>>(GMT -05:00) America/Panama</option>
						<option value="America/Porto_Acre"<?php echo ($appDatas->hour_zone == 'America/Porto_Acre' ? ' selected' : ''); ?>>(GMT -05:00) America/Porto_Acre</option>
						<option value="America/Rainy_River"<?php echo ($appDatas->hour_zone == 'America/Rainy_River' ? ' selected' : ''); ?>>(GMT -05:00) America/Rainy_River</option>
						<option value="America/Rankin_Inlet"<?php echo ($appDatas->hour_zone == 'America/Rankin_Inlet' ? ' selected' : ''); ?>>(GMT -05:00) America/Rankin_Inlet</option>
						<option value="America/Resolute"<?php echo ($appDatas->hour_zone == 'America/Resolute' ? ' selected' : ''); ?>>(GMT -05:00) America/Resolute</option>
						<option value="America/Rio_Branco"<?php echo ($appDatas->hour_zone == 'America/Rio_Branco' ? ' selected' : ''); ?>>(GMT -05:00) America/Rio_Branco</option>
						<option value="America/Winnipeg"<?php echo ($appDatas->hour_zone == 'America/Winnipeg' ? ' selected' : ''); ?>>(GMT -05:00) America/Winnipeg</option>
						<option value="Brazil/Acre"<?php echo ($appDatas->hour_zone == 'Brazil/Acre' ? ' selected' : ''); ?>>(GMT -05:00) Brazil/Acre</option>
						<option value="CST6CDT"<?php echo ($appDatas->hour_zone == 'CST6CDT' ? ' selected' : ''); ?>>(GMT -05:00) CST6CDT</option>
						<option value="Canada/Central"<?php echo ($appDatas->hour_zone == 'Canada/Central' ? ' selected' : ''); ?>>(GMT -05:00) Canada/Central</option>
						<option value="Chile/EasterIsland"<?php echo ($appDatas->hour_zone == 'Chile/EasterIsland' ? ' selected' : ''); ?>>(GMT -05:00) Chile/EasterIsland</option>
						<option value="EST"<?php echo ($appDatas->hour_zone == 'EST' ? ' selected' : ''); ?>>(GMT -05:00) EST</option>
						<option value="Etc/GMT+5"<?php echo ($appDatas->hour_zone == 'Etc/GMT+5' ? ' selected' : ''); ?>>(GMT -05:00) Etc/GMT+5</option>
						<option value="Jamaica"<?php echo ($appDatas->hour_zone == 'Jamaica' ? ' selected' : ''); ?>>(GMT -05:00) Jamaica</option>
						<option value="Mexico/General"<?php echo ($appDatas->hour_zone == 'Mexico/General' ? ' selected' : ''); ?>>(GMT -05:00) Mexico/General</option>
						<option value="Pacific/Easter"<?php echo ($appDatas->hour_zone == 'Pacific/Easter' ? ' selected' : ''); ?>>(GMT -05:00) Pacific/Easter</option>
						<option value="US/Central"<?php echo ($appDatas->hour_zone == 'US/Central' ? ' selected' : ''); ?>>(GMT -05:00) US/Central</option>
						<option value="US/Indiana-Starke"<?php echo ($appDatas->hour_zone == 'US/Indiana-Starke' ? ' selected' : ''); ?>>(GMT -05:00) US/Indiana-Starke</option>
						<option value="America/Belize"<?php echo ($appDatas->hour_zone == 'America/Belize' ? ' selected' : ''); ?>>(GMT -06:00) America/Belize</option>
						<option value="America/Boise"<?php echo ($appDatas->hour_zone == 'America/Boise' ? ' selected' : ''); ?>>(GMT -06:00) America/Boise</option>
						<option value="America/Cambridge_Bay"<?php echo ($appDatas->hour_zone == 'America/Cambridge_Bay' ? ' selected' : ''); ?>>(GMT -06:00) America/Cambridge_Bay</option>
						<option value="America/Chihuahua"<?php echo ($appDatas->hour_zone == 'America/Chihuahua' ? ' selected' : ''); ?>>(GMT -06:00) America/Chihuahua</option>
						<option value="America/Costa_Rica"<?php echo ($appDatas->hour_zone == 'America/Costa_Rica' ? ' selected' : ''); ?>>(GMT -06:00) America/Costa_Rica</option>
						<option value="America/Denver"<?php echo ($appDatas->hour_zone == 'America/Denver' ? ' selected' : ''); ?>>(GMT -06:00) America/Denver</option>
						<option value="America/Edmonton"<?php echo ($appDatas->hour_zone == 'America/Edmonton' ? ' selected' : ''); ?>>(GMT -06:00) America/Edmonton</option>
						<option value="America/El_Salvador"<?php echo ($appDatas->hour_zone == 'America/El_Salvador' ? ' selected' : ''); ?>>(GMT -06:00) America/El_Salvador</option>
						<option value="America/Guatemala"<?php echo ($appDatas->hour_zone == 'America/Guatemala' ? ' selected' : ''); ?>>(GMT -06:00) America/Guatemala</option>
						<option value="America/Inuvik"<?php echo ($appDatas->hour_zone == 'America/Inuvik' ? ' selected' : ''); ?>>(GMT -06:00) America/Inuvik</option>
						<option value="America/Managua"<?php echo ($appDatas->hour_zone == 'America/Managua' ? ' selected' : ''); ?>>(GMT -06:00) America/Managua</option>
						<option value="America/Mazatlan"<?php echo ($appDatas->hour_zone == 'America/Mazatlan' ? ' selected' : ''); ?>>(GMT -06:00) America/Mazatlan</option>
						<option value="America/Ojinaga"<?php echo ($appDatas->hour_zone == 'America/Ojinaga' ? ' selected' : ''); ?>>(GMT -06:00) America/Ojinaga</option>
						<option value="America/Regina"<?php echo ($appDatas->hour_zone == 'America/Regina' ? ' selected' : ''); ?>>(GMT -06:00) America/Regina</option>
						<option value="America/Shiprock"<?php echo ($appDatas->hour_zone == 'America/Shiprock' ? ' selected' : ''); ?>>(GMT -06:00) America/Shiprock</option>
						<option value="America/Swift_Current"<?php echo ($appDatas->hour_zone == 'America/Swift_Current' ? ' selected' : ''); ?>>(GMT -06:00) America/Swift_Current</option>
						<option value="America/Tegucigalpa"<?php echo ($appDatas->hour_zone == 'America/Tegucigalpa' ? ' selected' : ''); ?>>(GMT -06:00) America/Tegucigalpa</option>
						<option value="America/Yellowknife"<?php echo ($appDatas->hour_zone == 'America/Yellowknife' ? ' selected' : ''); ?>>(GMT -06:00) America/Yellowknife</option>
						<option value="Canada/East-Saskatchewan"<?php echo ($appDatas->hour_zone == 'Canada/East-Saskatchewan' ? ' selected' : ''); ?>>(GMT -06:00) Canada/East-Saskatchewan</option>
						<option value="Canada/Mountain"<?php echo ($appDatas->hour_zone == 'Canada/Mountain' ? ' selected' : ''); ?>>(GMT -06:00) Canada/Mountain</option>
						<option value="Canada/Saskatchewan"<?php echo ($appDatas->hour_zone == 'Canada/Saskatchewan' ? ' selected' : ''); ?>>(GMT -06:00) Canada/Saskatchewan</option>
						<option value="Etc/GMT+6"<?php echo ($appDatas->hour_zone == 'Etc/GMT+6' ? ' selected' : ''); ?>>(GMT -06:00) Etc/GMT+6</option>
						<option value="MST7MDT"<?php echo ($appDatas->hour_zone == 'MST7MDT' ? ' selected' : ''); ?>>(GMT -06:00) MST7MDT</option>
						<option value="Mexico/BajaSur"<?php echo ($appDatas->hour_zone == 'Mexico/BajaSur' ? ' selected' : ''); ?>>(GMT -06:00) Mexico/BajaSur</option>
						<option value="Navajo"<?php echo ($appDatas->hour_zone == 'Navajo' ? ' selected' : ''); ?>>(GMT -06:00) Navajo</option>
						<option value="Pacific/Galapagos"<?php echo ($appDatas->hour_zone == 'Pacific/Galapagos' ? ' selected' : ''); ?>>(GMT -06:00) Pacific/Galapagos</option>
						<option value="US/Mountain"<?php echo ($appDatas->hour_zone == 'US/Mountain' ? ' selected' : ''); ?>>(GMT -06:00) US/Mountain</option>
						<option value="America/Creston"<?php echo ($appDatas->hour_zone == 'America/Creston' ? ' selected' : ''); ?>>(GMT -07:00) America/Creston</option>
						<option value="America/Dawson"<?php echo ($appDatas->hour_zone == 'America/Dawson' ? ' selected' : ''); ?>>(GMT -07:00) America/Dawson</option>
						<option value="America/Dawson_Creek"<?php echo ($appDatas->hour_zone == 'America/Dawson_Creek' ? ' selected' : ''); ?>>(GMT -07:00) America/Dawson_Creek</option>
						<option value="America/Ensenada"<?php echo ($appDatas->hour_zone == 'America/Ensenada' ? ' selected' : ''); ?>>(GMT -07:00) America/Ensenada</option>
						<option value="America/Fort_Nelson"<?php echo ($appDatas->hour_zone == 'America/Fort_Nelson' ? ' selected' : ''); ?>>(GMT -07:00) America/Fort_Nelson</option>
						<option value="America/Hermosillo"<?php echo ($appDatas->hour_zone == 'America/EnsHermosilloenada' ? ' selected' : ''); ?>>(GMT -07:00) America/Hermosillo</option>
						<option value="America/Los_Angeles"<?php echo ($appDatas->hour_zone == 'America/Los_Angeles' ? ' selected' : ''); ?>>(GMT -07:00) America/Los_Angeles</option>
						<option value="America/Phoenix"<?php echo ($appDatas->hour_zone == 'America/Phoenix' ? ' selected' : ''); ?>>(GMT -07:00) America/Phoenix</option>
						<option value="America/Santa_Isabel"<?php echo ($appDatas->hour_zone == 'America/Santa_Isabel' ? ' selected' : ''); ?>>(GMT -07:00) America/Santa_Isabel</option>
						<option value="America/Tijuana"<?php echo ($appDatas->hour_zone == 'America/Tijuana' ? ' selected' : ''); ?>>(GMT -07:00) America/Tijuana</option>
						<option value="America/Vancouver"<?php echo ($appDatas->hour_zone == 'America/Vancouver' ? ' selected' : ''); ?>>(GMT -07:00) America/Vancouver</option>
						<option value="America/Whitehorse"<?php echo ($appDatas->hour_zone == 'America/Whitehorse' ? ' selected' : ''); ?>>(GMT -07:00) America/Whitehorse</option>
						<option value="Canada/Pacific"<?php echo ($appDatas->hour_zone == 'America/Pacific' ? ' selected' : ''); ?>>(GMT -07:00) Canada/Pacific</option>
						<option value="Canada/Yukon"<?php echo ($appDatas->hour_zone == 'Canada/Yukon' ? ' selected' : ''); ?>>(GMT -07:00) Canada/Yukon</option>
						<option value="Etc/GMT+7"<?php echo ($appDatas->hour_zone == 'Etc/GMT+7' ? ' selected' : ''); ?>>(GMT -07:00) Etc/GMT+7</option>
						<option value="MST"<?php echo ($appDatas->hour_zone == 'MST' ? ' selected' : ''); ?>>(GMT -07:00) MST</option>
						<option value="Mexico/BajaNorte"<?php echo ($appDatas->hour_zone == 'Mexico/BajaNorte' ? ' selected' : ''); ?>>(GMT -07:00) Mexico/BajaNorte</option>
						<option value="PST8PDT"<?php echo ($appDatas->hour_zone == 'PST8PDT' ? ' selected' : ''); ?>>(GMT -07:00) PST8PDT</option>
						<option value="US/Arizona"<?php echo ($appDatas->hour_zone == 'US/Arizona' ? ' selected' : ''); ?>>(GMT -07:00) US/Arizona</option>
						<option value="US/Pacific"<?php echo ($appDatas->hour_zone == 'US/Pacific' ? ' selected' : ''); ?>>(GMT -07:00) US/Pacific</option>
						<option value="US/Pacific-New"<?php echo ($appDatas->hour_zone == 'US/Pacific-New' ? ' selected' : ''); ?>>(GMT -07:00) US/Pacific-New</option>
						<option value="America/Anchorage"<?php echo ($appDatas->hour_zone == 'America/Anchorage' ? ' selected' : ''); ?>>(GMT -08:00) America/Anchorage</option>
						<option value="America/Juneau"<?php echo ($appDatas->hour_zone == 'America/Juneau' ? ' selected' : ''); ?>>(GMT -08:00) America/Juneau</option>
						<option value="America/Metlakatla"<?php echo ($appDatas->hour_zone == 'America/Metlakatla' ? ' selected' : ''); ?>>(GMT -08:00) America/Metlakatla</option>
						<option value="America/Nome"<?php echo ($appDatas->hour_zone == 'America/Nome' ? ' selected' : ''); ?>>(GMT -08:00) America/Nome</option>
						<option value="America/Sitka"<?php echo ($appDatas->hour_zone == 'America/Sitka' ? ' selected' : ''); ?>>(GMT -08:00) America/Sitka</option>
						<option value="America/Yakutat"<?php echo ($appDatas->hour_zone == 'America/Yakutat' ? ' selected' : ''); ?>>(GMT -08:00) America/Yakutat</option>
						<option value="Etc/GMT+8"<?php echo ($appDatas->hour_zone == 'Etc/GMT+8' ? ' selected' : ''); ?>>(GMT -08:00) Etc/GMT+8</option>
						<option value="Pacific/Pitcairn"<?php echo ($appDatas->hour_zone == 'Pacific/Pitcairn' ? ' selected' : ''); ?>>(GMT -08:00) Pacific/Pitcairn</option>
						<option value="US/Alaska"<?php echo ($appDatas->hour_zone == 'US/Alaska' ? ' selected' : ''); ?>>(GMT -08:00) US/Alaska</option>
						<option value="America/Adak"<?php echo ($appDatas->hour_zone == 'America/Adak' ? ' selected' : ''); ?>>(GMT -09:00) America/Adak</option>
						<option value="America/Atka"<?php echo ($appDatas->hour_zone == 'America/Atka' ? ' selected' : ''); ?>>(GMT -09:00) America/Atka</option>
						<option value="Etc/GMT+9"<?php echo ($appDatas->hour_zone == 'Etc/GMT+9' ? ' selected' : ''); ?>>(GMT -09:00) Etc/GMT+9</option>
						<option value="Pacific/Gambier"<?php echo ($appDatas->hour_zone == 'Pacific/Gambier' ? ' selected' : ''); ?>>(GMT -09:00) Pacific/Gambier</option>
						<option value="US/Aleutian"<?php echo ($appDatas->hour_zone == 'US/Aleutian' ? ' selected' : ''); ?>>(GMT -09:00) US/Aleutian</option>
						<option value="Pacific/Marquesas"<?php echo ($appDatas->hour_zone == 'Pacific/Marquesas' ? ' selected' : ''); ?>>(GMT -09:30) Pacific/Marquesas</option>
						<option value="Etc/GMT+10"<?php echo ($appDatas->hour_zone == 'Etc/GMT+10' ? ' selected' : ''); ?>>(GMT -10:00) Etc/GMT+10</option>
						<option value="HST"<?php echo ($appDatas->hour_zone == 'HST' ? ' selected' : ''); ?>>(GMT -10:00) HST</option>
						<option value="Pacific/Honolulu"<?php echo ($appDatas->hour_zone == 'Pacific/Honolulu' ? ' selected' : ''); ?>>(GMT -10:00) Pacific/Honolulu</option>
						<option value="Pacific/Johnston"<?php echo ($appDatas->hour_zone == 'Pacific/Johnston' ? ' selected' : ''); ?>>(GMT -10:00) Pacific/Johnston</option>
						<option value="Pacific/Rarotonga"<?php echo ($appDatas->hour_zone == 'Pacific/Rarotonga' ? ' selected' : ''); ?>>(GMT -10:00) Pacific/Rarotonga</option>
						<option value="Pacific/Tahiti"<?php echo ($appDatas->hour_zone == 'Pacific/Tahiti' ? ' selected' : ''); ?>>(GMT -10:00) Pacific/Tahiti</option>
						<option value="US/Hawaii"<?php echo ($appDatas->hour_zone == 'US/Hawaii' ? ' selected' : ''); ?>>(GMT -10:00) US/Hawaii</option>
						<option value="Etc/GMT+11"<?php echo ($appDatas->hour_zone == 'Etc/GMT+11' ? ' selected' : ''); ?>>(GMT -11:00) Etc/GMT+11</option>
						<option value="Pacific/Midway"<?php echo ($appDatas->hour_zone == 'Pacific/Midway' ? ' selected' : ''); ?>>(GMT -11:00) Pacific/Midway</option>
						<option value="Pacific/Niue"<?php echo ($appDatas->hour_zone == 'Pacific/Niue' ? ' selected' : ''); ?>>(GMT -11:00) Pacific/Niue</option>
						<option value="Pacific/Pago_Pago"<?php echo ($appDatas->hour_zone == 'Pacific/Pago_Pago' ? ' selected' : ''); ?>>(GMT -11:00) Pacific/Pago_Pago</option>
						<option value="Pacific/Samoa"<?php echo ($appDatas->hour_zone == 'US/Aleutian' ? ' selected' : ''); ?>>(GMT -11:00) Pacific/Samoa</option>
						<option value="US/Samoa"<?php echo ($appDatas->hour_zone == 'US/Samoa' ? ' selected' : ''); ?>>(GMT -11:00) US/Samoa</option>
						<option value="Etc/GMT+12"<?php echo ($appDatas->hour_zone == 'Etc/GMT+12' ? ' selected' : ''); ?>>(GMT -12:00) Etc/GMT+12</option>
					</select>
		    	</div>
		  	</div>
		  	<div class="form-group">
			    <label for="country_code" class="col-xs-12 col-sm-4 control-label"><?php echo __('Code pays', $app->slug) ?> *</label>
			    <div class="col-xs-12 col-sm-8">
			    	<!-- <input type="text" class="form-control" id="country_code" name="<?php echo $form_action; ?>[country_code]" placeholder="<?php echo __('Code pays', $app->slug) ?>" value="<?php echo $appDatas->country_code ?>" /> -->
			    	<select class="form-control" id="country_code" name="<?php echo $form_action; ?>[country_code]">
		    			<option value="<?php echo $appDatas->country_code ?>" data-name="<?php echo $appDatas->country_name ?>" selected><?php echo $appDatas->country_name.($appDatas->country_name ? ' ('.$appDatas->country_code.')' : ""); ?></option>
			    	</select>
			    	<input type="hidden" id="country_name" name="<?php echo $form_action; ?>[country_name]" value="<?php echo $appDatas->country_name ?>" />
		    	</div>
		  	</div>
		  	<div class="form-group">
			    <label for="phonenumber" class="col-xs-12 col-sm-4 control-label"><?php echo __('Téléphone', $app->slug) ?> *</label>
			    <div class="col-xs-12 col-sm-8">
			    	<input type="text" class="form-control" id="phonenumber" name="<?php echo $form_action; ?>[phonenumber]" placeholder="<?php echo __('Téléphone', $app->slug) ?>" value="<?php echo $appDatas->phonenumber ?>" required />
		    	</div>
		  	</div>
		  	<div class="form-group">
			    <label for="email_contact" class="col-xs-12 col-sm-4 control-label"><?php echo __('Email de contact', $app->slug) ?> *</label>
			    <div class="col-xs-12 col-sm-8">
			    	<input type="email" class="form-control" id="email_contact" name="<?php echo $form_action; ?>[email_contact]" placeholder="<?php echo __('Email de contact', $app->slug) ?>" value="<?php echo $appDatas->email_contact ?>" required />
		    	</div>
		  	</div>
		  	<div class="form-group">
			    <label for="currency" class="col-xs-12 col-sm-4 control-label"><?php echo __('Devise', $app->slug) ?> *</label>
			    <div class="col-xs-12 col-sm-2">
			    	<input type="text" class="form-control" id="currency" name="<?php echo $form_action; ?>[currency]" value="<?php echo $appDatas->currency ?>" required />
		    	</div>
		  	</div>
		  	<!-- <div class="form-group">
			    <label for="days_last_booking" class="col-xs-12 col-sm-4 control-label"><?php echo __('Periode disponible pour les rendez-vous (j)', $app->slug) ?> *</label>
			    <div class="col-xs-12 col-sm-8">
			    	<input type="number" class="form-control numeric" id="days_last_booking" name="<?php echo $form_action; ?>[days_last_booking]" step="1" value="<?php echo $appDatas->days_last_booking ?>" />
		    	</div>
		  	</div>
		  	<div class="form-group">
			    <label for="capacity" class="col-xs-12 col-sm-4 control-label"><?php echo __('Capacité', $app->slug) ?> *</label>
			    <div class="col-xs-12 col-sm-8">
			    	<input type="number" class="form-control" id="capacity" name="<?php echo $form_action; ?>[capacity]" placeholder="<?php echo __('Capacité', $app->slug) ?>" value="<?php echo $appDatas->capacity ?>" step="1" required />
		    	</div>
		  	</div>
		  	<div class="form-group">
			    <label for="message" class="col-xs-12 col-sm-4 control-label"><?php echo __('Message', $app->slug) ?></label>
			    <div class="col-xs-12 col-sm-8">
			    	<textarea class="form-control" rows="3" id="message" name="<?php echo $form_action; ?>[message]" placeholder="<?php echo __('Message pour le client', $app->slug) ?>"><?php echo stripslashes($appDatas->message) ?></textarea>
		    	</div>
		  	</div> -->
		  	<div class="clearfix"></div><hr />
		  	<div class="control-group">
				<div class="col-xs-12 col-sm-offset-4 col-sm-8">
					<input class="btn btn btn-primary" name="<?php echo $app->slug; ?>_app" type="submit" value="<?php echo __('Enregistrer', $app->slug) ?>">
				</div>
			</div>
			<?php wp_nonce_field( $app->form_action, $app->slug.'_'.$app->form_action ) ?>
		</form>
	</div>
<?php } ?>