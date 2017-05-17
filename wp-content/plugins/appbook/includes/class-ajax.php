<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AppResto AppRestoAjax class.
 *
 */
class AppRestoAjax 
{
	public static function init()
	{
		$ajax_actions = array(
			'new_service' => true,
			'new_employee' => true,
			'new_holiday' => true,
			'new_period' => true,
			'new_opening' => true,
			'new_closing' => true,

			'edit_service' => true,
			'edit_employee' => true,
			'edit_holiday' => true,
			'edit_period' => true,
			'edit_opening' => true,
			'edit_closing' => true,
			
			'delete_service' => true,
			'delete_employee' => true,
			'delete_holiday' => true,
			'delete_period' => true,
			'delete_opening' => true,
			'delete_closing' => true,

			'action_stats' => true,
			'employee_holiday' => true,
			'orderby_holiday' => true,
			'holiday_validate' => true,
			'get_employees' => true,
			'checkperiod' => true,
			'display_employee' => true,
			'update_color' => true,
			'delete_booking' => true,

			'regenerate_module' => false,
			'update_comment' => false,
			'delete_app' => false,

		);
		foreach ($ajax_actions as $ajax_action => $nopriv) {
			add_action( 'wp_ajax_'.appBook()->slug.'_' . $ajax_action, array( __CLASS__, $ajax_action ) );
			if ( $nopriv ) {
				add_action( 'wp_ajax_nopriv_'.appBook()->slug.'_' . $ajax_action, array( __CLASS__, $ajax_action ) );
			}
		}
	}
	public static function orderby_holiday() {

		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_orderby_holiday') )
		{
			$holidays = appBook()->app->holiday->loadDatasOrderBy((int)$_POST['orderby']);
			
			foreach ($holidays as $key => $holiday) { 
				echo '<tr id="'.$holiday->holiday_id .'">
					<td>';
				if ((int)$holiday->one_day) {
						echo dateEnToFr($holiday->date);
					} else {
						echo dateEnToFr($holiday->date_start);
					}
				echo '</td>
					<td>';
					if ((int)$holiday->one_day) {
						echo dateEnToFr($holiday->date);
					} else {
						echo dateEnToFr($holiday->date_end);
					}

				echo '</td>
					<td>';
					if (!(int)$holiday->one_day) {
						echo getNumDay($holiday->date_start, $holiday->date_end) .' '.__('jour(s)', $app->slug);

					} else if ((int)$holiday->all_day) {
						echo __('Toute la journée', $app->slug);
					} else {
						echo __('De ', $app->slug).$holiday->start.__(' à ', $app->slug).$holiday->end;
					}
				echo '</td>
					<td>'.$holiday->firstname.' '.$holiday->lastname.'</td>
					<td>
						<div class="pull-right">
							<button class="btn btn-large btn-default edit-holiday" autocomplete="off" data-toggle="tooltip" aria-pressed="false" data-id="'.$holiday->holiday_id.'" data-loading-text="'.__("Patientez", appBook()->slug).'  ...">
								<span class="glyphicon glyphicon-edit" aria-hidden="true" title="'.__('Modifier', appBook()->slug).'"></span>
							</button>
							<button class="btn btn-large btn-danger delete-holiday" autocomplete="off" data-toggle="modal" aria-pressed="false" data-id="'.$holiday->holiday_id.'" data-target="#confirmDelete">
								<span class="glyphicon glyphicon-remove" aria-hidden="true" title="'.__('Supprimer', appBook()->slug).'"></span>
							</button>
						</div>
					</td>
				</tr>';
			 }
		}
		die();
	}

	// NEW
	public static function new_service()
	{
		load_template(appBook()->template_path."service-new.php", false);
		die();
	}

	public static function new_employee()
	{
		load_template(appBook()->template_path."employee-new.php", false);
		die();
	}

	public static function new_holiday()
	{
		load_template(appBook()->template_path."holiday-new.php", false);
		die();
	}

	public static function new_period()
	{
		load_template(appBook()->template_path."period-new.php", false);
		die();
	}

	public static function new_opening()
	{
		load_template(appBook()->template_path."opening-new.php", false);
		die();
	}

	public static function new_closing()
	{
		load_template(appBook()->template_path."closing-new.php", false);
		die();
	}

	// EDIT
	public static function edit_service()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_edit_service') && isset($_POST['data']) )
		{
			load_template( appBook()->template_path."service-new.php", false);
		}
		die();
	}
	
	public static function edit_employee()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_edit_employee') && isset($_POST['data']) )
		{
			load_template( appBook()->template_path."employee-new.php", false);
		}
		die();
	}

	public static function edit_holiday()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_edit_holiday') && isset($_POST['data']) )
		{
			load_template( appBook()->template_path."holiday-new.php", false);
		}
		die();
	}

	public static function edit_period()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_edit_period') && isset($_POST['data']) )
		{
			load_template( appBook()->template_path."period-new.php", false);
		}
		die();
	}

	public static function edit_opening()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_edit_opening') && isset($_POST['data']) )
		{
			load_template( appBook()->template_path."opening-new.php", false);
		}
		die();
	}

	public static function edit_closing()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_edit_closing') && isset($_POST['data']) )
		{
			load_template( appBook()->template_path."closing-new.php", false);
		}
		die();
	}

	// DELETE
	public static function delete_service()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_delete_service') && isset($_POST['data']) )
		{
			$res = appBook()->app->service->delete($_POST['data']);
		}
		if (!$res)
			exit('0');
		else
			exit('1');
	}
	
	public static function delete_employee()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_delete_employee') && isset($_POST['data']) )
		{
			$res = appBook()->app->employee->delete($_POST['data']);
		}
		if (!$res)
			exit('0');
		else
			exit('1');
	}

	public static function delete_holiday()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_delete_holiday') && isset($_POST['data']) )
		{
			$res = appBook()->app->holiday->delete($_POST['data']);
		}
		if (!$res)
			exit('0');
		else
			exit('1');
	}

	public static function delete_period()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_delete_period') && isset($_POST['data']) )
		{
			$res = appBook()->app->period->delete($_POST['data']);
		}
		if (!$res)
			exit('0');
		else
			exit('1');
	}

	public static function delete_opening()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_delete_opening') && isset($_POST['data']) )
		{
			$res = appBook()->app->opening->delete($_POST['data']);
		}
		if (!$res)
			exit('0');
		else
			exit('1');
	}

	public static function delete_closing()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_delete_closing') && isset($_POST['data']) )
		{
			$res = appBook()->app->closing->delete($_POST['data']);
		}
		if (!$res)
			exit('0');
		else
			exit('1');
	}

	// STATS
	public static function action_stats()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_action_stats') )
		{
			$res = appBook()->app->stats->getData( $_POST['services'], $_POST['start'], $_POST['end'] );
		}
		if (!$res)
			exit('0');
		else
			exit(json_encode($res));
	}

	public static function employee_holiday()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_employee_holiday') && isset($_POST['employee_id']) )
		{
			$postes = json_decode(appBook()->app->employee->getSingle((int)$_POST['employee_id'])->poste);
			for($i=0; $i < count($postes); $i++) {
				echo '<option value="'.$postes[$i].'">'.appBook()->app->service->getServiceName($postes[$i]).'</option>';
			}


		}
	}

	public static function holiday_validate()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_holiday_validate') && isset($_POST['app_id']) && isset($_POST['date']) && isset($_POST['start']) && isset($_POST['end']) )
		{
			$tab_date = explode('-', $_POST['date']);
			$date = $tab_date[2].'-'.$tab_date[1].'-'.$tab_date[0];
			$day = (int)date('w', strtotime($date));
			$isClosingDay = appBook()->app->closing->checkIfCloseDay($day, $date);
			if (!$isClosingDay)
			{
				exit(__('Ce jour est déjà férié.', appBook()->slug));
			}
			$openings = appBook()->app->opening->getOpenings($day);
			$isOut = 0;
			foreach ($openings[$day] as $value) {
				$start = $value["start"];
				$end = $value["end"];
				$isInOpening = isInRefTime( $start, $end, $_POST['start'], $_POST['end'] );
				if (!$isInOpening) {
					$isOut++;
				}
			}
			if ($isOut == count($openings[$day]))
				exit(__("Les heures choisies sont hors des heures d'ouverture du jour"));
			else
				exit('1');
		}
	}

	public static function regenerate_module()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_regenerate_module') && isset($_POST['data']) )
		{
			require_once( dirname(__FILE__).'/class-module.php' );
			$res = AppModule::regenerate($_POST['data']);
			if($res === true) {
				exit('1');
			}
			else
				exit('0');
		}
	}

	public static function get_employees()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_get_employees') && isset($_POST['id_service']) )
		{
			$employees = appBook()->app->employee->getByPoste($_POST['id_service']);
			if($employees !== null) {
				$options = '<option value="0"></option>';
				foreach ($employees as $key => $employee) {
					$options .= '<option value="'.$employee->employee_id.'"'.'>'.$employee->firstname.' '.$employee->lastname.'</option>';
					// $options .= '<option value="'.$employee->employee_id.'"'.(!$key ? " selected" : "").'>'.$employee->firstname.' '.$employee->lastname.'</option>';
				}
				echo $options;
				exit();
			}
			else{
				echo '<option value="0">'.__('Aucun', appBook()->slug).'</option>';
				exit();
			}
		}
	}

	public static function update_comment()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_update_comment') && isset($_POST["app_id"]) && isset($_POST["module_id"]) && isset($_POST["comment"]) )
		{
			$app_id = (int)$_POST["app_id"];
			$module_id = (int)$_POST["module_id"];
			$comment = $_POST["comment"];
			require_once( dirname(__FILE__).'/class-module.php' );
			$res = AppModule::updateComment($app_id, $module_id, $comment);
			if($res == 1) {
				exit('1');
			}
			else{
				exit('0');
			}
		}
	}

	public static function delete_app()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_delete_app') && isset($_POST["app_id"]) )
		{
			$app_id = (int)$_POST["app_id"];
			
			require_once( dirname(__FILE__).'/class-userinfo.php' );
			require_once( dirname(__FILE__).'/class-app.php' );
			require_once( dirname(__FILE__).'/class-booking.php' );
			require_once( dirname(__FILE__).'/class-closing.php' );
			require_once( dirname(__FILE__).'/class-employee.php' );
			require_once( dirname(__FILE__).'/class-holiday.php' );
			require_once( dirname(__FILE__).'/class-module.php' );
			require_once( dirname(__FILE__).'/class-opening.php' );
			require_once( dirname(__FILE__).'/class-period.php' );
			require_once( dirname(__FILE__).'/class-service.php' );

			$user = new AppUserInfo($app_id);

			if($user->app_id === null){
				exit('0');
			}
			else
			{
				$user_id = (int)$user->datas->user_id;
				$app = new App($user_id);
				// var_dump($app->service);exit;

				$folder = AppModule::getFolder($app_id); // folder
				
				$appli = $app->deleteAll($app_id);
				// echo $appli;exit();
				if ($appli === true)
				{
					if ($folder !== null) // folder
					{
						$delete_folder_contents = AppModule::recursuveDeleteFolderContent($_SERVER['DOCUMENT_ROOT'].'/'.$folder);
						if($delete_folder_contents === true)
							rmdir($_SERVER['DOCUMENT_ROOT'].'/'.$folder);
					}
					$res = wp_delete_user($user_id);
					if($res === true) {
						exit('1');
					}
					else{
						echo __("Son compte utilisateur n'a pas été supprimé.", appBook()->slug);
						exit();
					}
				}
				elseif ($appli === false) {
					echo '0';
					exit();
				}
				else
				{
					echo $appli;
					exit();
				}
				
			}
		}
	}

	public static function checkperiod()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_checkperiod') && isset($_POST["employee_id"]) && isset($_POST["start"]) && isset($_POST["end"]) && isset($_POST["days"]) )
		{
			$employee_id = (int)$_POST["employee_id"];
			if (isset($_POST['period_id']))
				$res = appBook()->app->period->checkPeriodByEmployee( $employee_id, $_POST["start"], $_POST["end"], $_POST["days"], $_POST['period_id'] );
			else
				$res = appBook()->app->period->checkPeriodByEmployee( $employee_id, $_POST["start"], $_POST["end"], $_POST["days"] );
			if($res === true) {
				exit('1');
			}
			else{
				exit('0');
			}
		}
	}

	public static function display_employee()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_display_employee') && isset($_POST["display_employee"]) )
		{
			$display_employee = (int)$_POST["display_employee"];
			$res = appBook()->app->updateDisplayEmployee( $display_employee );
			if($res == 1) {
				exit('1');
			}
			else{
				exit('0');
			}
		}
	}

	public static function update_color()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_update_color') && isset($_POST["update_color"]) )
		{
			$update_color = json_encode($_POST["update_color"]);
			$res = appBook()->app->updateColor( $update_color );
			if($res == 1) {
				exit('1');
			}
			else{
				exit('0');
			}
		}
	}

	public static function delete_booking()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_delete_booking') && isset($_POST["id"]) )
		{
			$booking_id = (int)$_POST["id"];
			$res = appBook()->app->booking->delete( $booking_id );
			if($res == 1) {
				exit('1');
			}
			else{
				exit('0');
			}
		}
	}

}
AppRestoAjax::init();