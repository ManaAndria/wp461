<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class appShortcodes
{
	public static function init()
	{
		
		$shortcodes = array(
			'dashboard' => __CLASS__."::dashboard",
			'registration' => __CLASS__."::registration",
			'login' => __CLASS__."::login",
			'setting' => __CLASS__."::setting",
			'userinfo' => __CLASS__."::userinfo",
			'service' => __CLASS__."::service",
			'employee' => __CLASS__."::employee",
			'period' => __CLASS__."::period",
			'opening' => __CLASS__."::opening",
			'closing' => __CLASS__."::closing",
			'booking' => __CLASS__."::booking",
			'booking_list' => __CLASS__."::booking_list",
			'stats' => __CLASS__."::stats",
			'holiday' => __CLASS__."::holiday",
			'module' => __CLASS__."::module",
		);
		foreach ($shortcodes as $name => $function) {
			add_shortcode(appBook()->slug.'_'.$name,  $function);
		}
	}

	// DASHBOARD
	public static function dashboard($atts, $content='')
	{
		ob_start(); 
		load_template(appBook()->template_path."dashboard.php", false);
		return ob_get_clean();
	}

	// REGISTRATION
	public static function registration($atts, $content='')
	{
		if (is_user_logged_in())
		{
			return '';
		}
		$app = appBook();
		$app->form_action = "registration";
		$message = '';

		if (isset($_POST[$app->form_action]))
		{
			if ( !isset( $_POST[$app->slug.'_'.$app->form_action] ) || !wp_verify_nonce( $_POST[$app->slug.'_'.$app->form_action], $app->form_action ) )
			{

			   	$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.'Sorry, your nonce did not verify.'.'</div>';
			   	exit;

			}
			else
			{
				if ( $_POST[$app->form_action]['user_password'] == $_POST[$app->form_action]['user_confirm_password'] )
				{
					// User creation
					$user_id = wp_create_user( $_POST[$app->form_action]['user_login'], $_POST[$app->form_action]['user_password'], $_POST[$app->form_action]['email'] );
					if (is_wp_error($user_id))
					{
						$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$user_id->get_error_message().'</div>';
					}
					else
					{
						$user = new WP_User($user_id);
						// User role
						$user->set_role($app->role);

						$appli = new App($user_id);
						$create = $appli->create($user_id, $_POST[$app->form_action]);

						// send emails
						$datas = $_POST[$app->form_action];
						$site_name = get_bloginfo('name');
						$admin_email = get_bloginfo('admin_email');
						$user_name = $datas['firstname'].' '.$datas['lastname'];
						$user_email = $datas['email'];
						
						//// to admin
						$admin_to = $admin_email;
						$admin_subject = "Nouvelle inscription sur le site ".$site_name;

						$admin_message = "Un nouveau client s'est inscrit sur ".get_bloginfo('name')."."."\n\r"."\n\r";
						$admin_message .= "Ci-après les informations lui concernant: "."\n\r"."\n\r";
						$admin_message .= "Prénom: ".$datas['firstname']."\n\r";
						$admin_message .= "Nom: ".$datas['lastname']."\n\r";
						$admin_message .= "Email: ".$datas['email']."\n\r";
						$admin_message .= "Téléphone: ".$datas['phonenumber']."\n\r";

						$admin_headers[] = "From: $site_name <$admin_email>";

						$admin_mail = wp_mail( $admin_to, $admin_subject, $admin_message, $admin_headers );

						//// to user
						$user_notif_to = $user_email;
						$user_notif_subject = "Inscription sur le site ".$site_name;

						$user_notif_message = "Mme/Mlle/M. ".$user_name.", "."\n\r"."\n\r";
						$user_notif_message .= "L'équipe de ".get_bloginfo('name')." vous souhaite la bienvenu(e) et vous remercie pour votre confiance."."\n\r"."\n\r";
						$user_notif_message .= "Veuillez bien conserver les informations de votre compte: "."\n\r"."\n\r";
						$user_notif_message .= "Identifiant: ".$datas['user_login']."\n\r";
						$user_notif_message .= "Mot de passe: ".$datas['user_password']."\n\r"."\n\r";
						$user_notif_message .= "Cordialement"."\n\r"."\n\r";
						$user_notif_message .= $site_name;

						$user_notif_headers[] = "From: $site_name <$admin_email>";

						$user_notif_mail = wp_mail( $user_notif_to, $user_notif_subject, $user_notif_message, $user_notif_headers );

						if ($create)
							return '<div class="alert alert-success" role="alert">'.__("Inscription réussie", $app->slug).'</div>';
						else
							$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Une erreur s'est produit lors de l'inscription", $app->slug).'</div>';

					}
				}
				else
				{
					$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Veuillez vérifier la confirmation du mot de passe", $app->slug).'</div>';
				}
			}
		}
		ob_start(); 
		load_template($app->template_path."registration.php", false);
		return $message.ob_get_clean();
	}

	// LOGIN
	public static function login($atts, $content='')
	{
		if ( isset($_GET['login']) &&  $_GET['login'] =="failed")
		{
			$msg = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Votre identifiant et/ou mot de passe sont incorrects.",appBook()->slug).'</div>';
		}else
		{
			$msg = '';
		}
		if (is_user_logged_in())
		{
			return '';
		}
		if (!empty($atts['redirect']))
			$redirect = $atts['redirect'];
		else
			$redirect = '';

		$args = array(
			'echo'           => false,
			'remember'       => true,
			'redirect'       => site_url("/"),
			// 'redirect'       => ( $redirect != '' ? site_url($redirect) : site_url('/configuration-de-lapplication/') ),
			'form_id'        => 'loginform',
			'id_username'    => 'user_login',
			'id_password'    => 'user_pass',
			'id_remember'    => 'rememberme',
			'id_submit'      => 'wp-submit',
			'label_username' => __( 'Username' ),
			'label_password' => __( 'Password' ),
			'label_remember' => __( 'Remember Me' ),
			'label_log_in'   => __( 'Log In' ),
			'value_username' => '',
			'value_remember' => false
		);
		
		$content = '<div id="'.appBook()->slug.'_login" class="col-xs-12">{error-msg}';
		$content .= wp_login_form($args);
		// $content .= '<a href="'.wp_lostpassword_url( get_permalink() ).'" title="'.__('Mot de passe oublié', appBook()->slug).'">'.__('Mot de passe oublié', appBook()->slug).'</a>';
		$content .= '</div>';
		
		return str_replace('{error-msg}', $msg, $content);
	}

	// SETTING
	public static function setting($atts, $content='')
	{
		if (!is_user_logged_in())
			return '';
		if (appBook()->app->app_id == null)
			return '';
		
		$app = appBook();
		$app->form_action = "setting";
		$message = '';

		wp_enqueue_script( $app->slug.'_setting' );
		wp_localize_script($app->slug.'_setting', 'settingObject', array(
      		'fields' => json_encode(appBook()->app->getRequiredFields()),
      		'names' => site_url('/wp-content/plugins/appbook/assets/js/names.json'),
      		'phone' => site_url('/wp-content/plugins/appbook/assets/js/phone.json'),
      		)
    	);

		if (isset($_POST[$app->form_action]))
		{
			if ( !isset( $_POST[$app->slug.'_'.$app->form_action] ) || !wp_verify_nonce( $_POST[$app->slug.'_'.$app->form_action], $app->form_action ) )
			{

			   	$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.'Sorry, your nonce did not verify.'.'</div>';
			   	exit;

			}
			else{
				$datas = $_POST[$app->form_action];
				$res = $app->app->update($datas);
				if ($res)
				{
					$message = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Modification réussie", $app->slug).'</div>';
				}
				else
					$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__('Erreur lors de la modification', $app->slug).'.</div>';
			}
		}

		ob_start(); 
		load_template($app->template_path."setting.php", false);
		return $message.ob_get_clean();
	}

	// USERINFO
	public static function userinfo($atts, $content='')
	{
		if (!is_user_logged_in())
			return '';
		if (appBook()->app->app_id == null)
			return '';

		$app = appBook();
		$app->form_action = "userinfo";
		$app->form_action2 = "password";
		$message = '';

		wp_enqueue_script( $app->slug.'_userinfo' );

		if (isset($_POST[$app->form_action]))
		{
			if ( !isset( $_POST[$app->slug.'_'.$app->form_action] ) || !wp_verify_nonce( $_POST[$app->slug.'_'.$app->form_action], $app->form_action ) )
			{

			   	$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.'Sorry, your nonce did not verify.'.'</div>';
			   	exit;

			}
			else{
				$datas = $_POST[$app->form_action];
				$res = $app->app->userinfo->update($datas);
				if ($res)
				{
					$message = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Vos informations ont été modifiées avec succès", $app->slug).'</div>';
				}
				else
					$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.'Erreur lors de la modification.'.'</div>';
			}
		}
		elseif (isset($_POST[$app->form_action2])) {
			if ( !isset( $_POST[$app->slug.'_'.$app->form_action2] ) || !wp_verify_nonce( $_POST[$app->slug.'_'.$app->form_action2], $app->form_action2 ) )
			{
			   	$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.'Sorry, your nonce did not verify.'.'</div>';
			   	exit;
			}
			else{
				$datas = $_POST[$app->form_action2];

				$user_id = wp_get_current_user()->ID;
				$user = get_user_by('ID', $user_id);
				$res = wp_check_password( $datas['old_password'], $user->data->user_pass, $user_id );//---------------tsy mety------------

				if ($res)
				{
					if($datas['user_confirm_password'] == $datas['password'])
					{
						wp_set_password( $datas['password'], $user_id );
						$login = wp_authenticate($user->user_login, $datas['password']);
						if (is_wp_error($login))
							$message = '<div class="alert alert-success" alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("tsy mety ilay code", $app->slug).'</div>';
						else
							$message = '<div class="alert alert-success" alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Votre mot de pase a été modifié avec succès", $app->slug).'</div>';

					}
					else
						$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Veuillez vérifier la confirmation du mot de passe", $app->slug).'</div>';
				}
				else
					$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__('Veuillez saisir correctement votre mot de passe actuel', $app->slug).'.</div>';
			}
		}

		ob_start(); 
		load_template($app->template_path."userinfo.php", false);
		return $message.ob_get_clean();
	}

	// SERVICE
	public static function service($atts, $content='')
	{
		if (!is_user_logged_in())
			return '';
		if (appBook()->app->app_id == null)
			return '';

		$app = appBook();
		$app->form_action = "service";
		$app->form_action2 = 'service_new';
		$app->form_action3 = 'service_edit';
		$message = '';

		wp_enqueue_script( $app->slug.'_service' );
		wp_enqueue_script( $app->slug.'_bootstrap-toggle' );
		wp_localize_script($app->slug.'_service', 'serviceObject', array(
      		'ajaxurl' => admin_url( 'admin-ajax.php' ),
      		'action_new' => appBook()->slug.'_new_service',
      		'action_edit' => appBook()->slug.'_edit_service',
      		'action_delete' => appBook()->slug.'_delete_service',
      		)
    	);
    	wp_enqueue_style(appBook()->slug.'_bootstrap-toggle');

		if (isset($_POST[$app->form_action2]))
		{
			if ( !isset( $_POST[$app->slug.'_'.$app->form_action2] ) || !wp_verify_nonce( $_POST[$app->slug.'_'.$app->form_action2], $app->form_action2 ) )
			{

			   	$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.'Sorry, your nonce did not verify.'.'</div>';
			   	exit;

			}
			else{
				$datas = $_POST[$app->form_action2];
				if ($datas['display_price'] === null)
					unset($datas['price']);
				$res = $app->app->service->create($datas);
				if ($res)
				{
					$message = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Le service a été ajouté avec succès", $app->slug).'</div>';
				}
				else
					$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Erreur lors de l'ajout", $app->slug).'</div>';
			}
		}
		elseif (isset($_POST[$app->form_action3]))
		{
			if ( !isset( $_POST[$app->slug.'_'.$app->form_action3] ) || !wp_verify_nonce( $_POST[$app->slug.'_'.$app->form_action3], $app->form_action3 ) )
			{

			   	$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.'Sorry, your nonce did not verify.'.'</div>';
			   	exit;

			}
			else{
				$datas = $_POST[$app->form_action3];
				if ($datas['display_price'] === null)
					unset($datas['price']);
				$res = $app->app->service->update($datas);
				if ($res)
				{
					$message = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Le service a été modifié avec succès", $app->slug).'</div>';
				}
				else
					$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Erreur lors de la modification", $app->slug).'</div>';
			}
		}

		ob_start(); 
		load_template($app->template_path."service.php", false);
		return $message.ob_get_clean();
	}

	// EMPLOYEE
	public static function employee($atts, $content='')
	{
		if (!is_user_logged_in())
			return '';
		if (appBook()->app->app_id == null)
			return '';

		$app = appBook();
		$app->form_action = "employee";
		$app->form_action2 = 'employee_new';
		$app->form_action3 = 'employee_edit';
		$message = '';


		wp_enqueue_style($app->slug.'_multiselect-css');
		wp_enqueue_script( $app->slug.'_multiselect' );
		wp_enqueue_script( $app->slug.'_employee' );
		wp_localize_script($app->slug.'_employee', 'employeeObject', array(
      		'ajaxurl' => admin_url( 'admin-ajax.php' ),
      		'fields' => json_encode(appBook()->app->employee->getRequiredFields()),
      		'action_new' => appBook()->slug.'_new_employee',
      		'action_edit' => appBook()->slug.'_edit_employee',
      		'action_delete' => appBook()->slug.'_delete_employee',
      		)
    	);

		if (isset($_POST[$app->form_action2]))
		{
			if ( !isset( $_POST[$app->slug.'_'.$app->form_action2] ) || !wp_verify_nonce( $_POST[$app->slug.'_'.$app->form_action2], $app->form_action2 ) )
			{

			   	$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.'Sorry, your nonce did not verify.'.'</div>';
			   	exit;

			}
			else{
				$datas = $_POST[$app->form_action2];
				$res = $app->app->employee->create($datas);
				if ($res == "1")
				{
					$message = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("L'employé a été ajouté avec succès", $app->slug).'</div>';
				}
				elseif (is_array($res)) {
					$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$res[0].'</div>';
				}
				else
					$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Erreur lors de l'ajout", $app->slug).'</div>';
			}
		}
		elseif (isset($_POST[$app->form_action3]))
		{
			if ( !isset( $_POST[$app->slug.'_'.$app->form_action3] ) || !wp_verify_nonce( $_POST[$app->slug.'_'.$app->form_action3], $app->form_action3 ) )
			{

			   	$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.'Sorry, your nonce did not verify.'.'</div>';
			   	exit;

			}
			else{
				$datas = $_POST[$app->form_action3];
				$res = $app->app->employee->update($datas);
				if ($res)
				{
					$message = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("L'employé a été modifié avec succès", $app->slug).'</div>';
				}
				else
					$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Erreur lors de la modification", $app->slug).'</div>';
			}
		}

		ob_start(); 
		load_template($app->template_path."employee.php", false);
		return $message.ob_get_clean();
	}

	// PERIOD
	public static function period($atts, $content='')
	{
		if (!is_user_logged_in())
			return '';
		if (appBook()->app->app_id == null)
			return '';

		$app = appBook();
		$app->form_action = "period";
		$app->form_action2 = 'period_new';
		$app->form_action3 = 'period_edit';
		$message = '';

		wp_enqueue_style($app->slug.'_multiselect-css');
		wp_enqueue_script( $app->slug.'_multiselect' );
		wp_enqueue_script( $app->slug.'_period' );
		wp_localize_script($app->slug.'_period', 'periodObject', array(
      		'ajaxurl' => admin_url( 'admin-ajax.php' ),
      		'action_new' => appBook()->slug.'_new_period',
      		'action_edit' => appBook()->slug.'_edit_period',
      		'action_delete' => appBook()->slug.'_delete_period',
      		'action_checkperiod' => appBook()->slug.'_checkperiod',
      		)
    	);

		if (isset($_POST[$app->form_action2]))
		{
			if ( !isset( $_POST[$app->slug.'_'.$app->form_action2] ) || !wp_verify_nonce( $_POST[$app->slug.'_'.$app->form_action2], $app->form_action2 ) )
			{

			   	$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.'Sorry, your nonce did not verify.'.'</div>';
			   	exit;

			}
			else{
				$datas = $_POST[$app->form_action2];
				$res = $app->app->period->create($datas);

				if(count($res["success"]))
				{
					foreach ($res["success"] as $k => $day) {
						$message .= '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>'.ucfirst(__($day, $app->slug)).'!!</strong> '.__("La période pour ce jour a été ajoutée avec succès", $app->slug).'</div>';
					}
				}
				if(count($res["failed"]))
				{
					foreach ($res["failed"] as $day => $msg) {
						$message .= '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>'.ucfirst(__($day, $app->slug)).'!!!</strong> '.$msg.'</div>';
					}
				}
			}
		}
		elseif (isset($_POST[$app->form_action3]))
		{
			if ( !isset( $_POST[$app->slug.'_'.$app->form_action3] ) || !wp_verify_nonce( $_POST[$app->slug.'_'.$app->form_action3], $app->form_action3 ) )
			{

			   	$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.'Sorry, your nonce did not verify.'.'</div>';
			   	exit;

			}
			else{
				$datas = $_POST[$app->form_action3];
				$res = $app->app->period->update($datas);
				if ( $res !== false && is_int($res) )
				{
					$message = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("La période a été modifiée avec succès", $app->slug).'</div>';
				}
				else
					$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Erreur lors de la modification", $app->slug).'</div>';
			}
		}

		ob_start(); 
		load_template($app->template_path."period.php", false);
		return $message.ob_get_clean();
	}

	// OPENING
	public static function opening($atts, $content='')
	{
		if (!is_user_logged_in())
			return '';
		if (appBook()->app->app_id == null)
			return '';

		$app = appBook();
		$app->form_action = "opening";
		$app->form_action2 = 'opening_new';
		$app->form_action3 = 'opening_edit';
		$message = '';

		wp_enqueue_script( $app->slug.'_opening' );
		wp_localize_script($app->slug.'_opening', 'openingObject', array(
      		'ajaxurl' => admin_url( 'admin-ajax.php' ),
      		'action_new' => appBook()->slug.'_new_opening',
      		'action_edit' => appBook()->slug.'_edit_opening',
      		'action_delete' => appBook()->slug.'_delete_opening',
      		)
    	);

		if (isset($_POST[$app->form_action2]))
		{
			if ( !isset( $_POST[$app->slug.'_'.$app->form_action2] ) || !wp_verify_nonce( $_POST[$app->slug.'_'.$app->form_action2], $app->form_action2 ) )
			{

			   	$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.'Sorry, your nonce did not verify.'.'</div>';
			   	exit;

			}
			else{
				$datas = $_POST[$app->form_action2];
				$res = $app->app->opening->create($datas);
				if ($res == "1")
				{
					$message = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("L'ouverture a été ajoutée avec succès", $app->slug).'</div>';
				}
				elseif (is_array($res)) {
					$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$res[0].'</div>';
				}
				else
					$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Erreur lors de l'ajout", $app->slug).'</div>';
			}
		}
		elseif (isset($_POST[$app->form_action3]))
		{
			if ( !isset( $_POST[$app->slug.'_'.$app->form_action3] ) || !wp_verify_nonce( $_POST[$app->slug.'_'.$app->form_action3], $app->form_action3 ) )
			{

			   	$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.'Sorry, your nonce did not verify.'.'</div>';
			   	exit;

			}
			else{
				$datas = $_POST[$app->form_action3];
				$res = $app->app->opening->update($datas);
				if ($res)
				{
					$message = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("L'ouverture a été modifiée avec succès", $app->slug).'</div>';
				}
				else
					$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Erreur lors de la modification", $app->slug).'</div>';
			}
		}

		ob_start(); 
		load_template($app->template_path."opening.php", false);
		return $message.ob_get_clean();
	}

	// CLOSING
	public static function closing($atts, $content='')
	{
		if (!is_user_logged_in())
			return '';
		if (appBook()->app->app_id == null)
			return '';

		$app = appBook();
		$app->form_action = "closing";
		$app->form_action2 = 'closing_new';
		$app->form_action3 = 'closing_edit';
		$message = '';

		// wp_enqueue_script( $app->slug.'_bootstrap-toggle' );
		wp_enqueue_script( $app->slug.'_closing' );
		wp_localize_script($app->slug.'_closing', 'closingObject', array(
      		'ajaxurl' => admin_url( 'admin-ajax.php' ),
      		'action_new' => appBook()->slug.'_new_closing',
      		'action_edit' => appBook()->slug.'_edit_closing',
      		'action_delete' => appBook()->slug.'_delete_closing',
      		)
    	);
    	// wp_enqueue_style(appBook()->slug.'_bootstrap-toggle');
    	wp_enqueue_style($app->slug.'_multiselect-css');
    	wp_enqueue_style('css-ui', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');

		if (isset($_POST[$app->form_action2]))
		{
			$start = strtotime($_POST[$app->form_action2]['start']);
			$end = strtotime($_POST[$app->form_action2]['end']);

			$_POST[$app->form_action2]['start'] = date('Y-m-d', $start);
			$_POST[$app->form_action2]['end'] = date('Y-m-d', $end);

			if ($start > $end)
			{
				$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Erreur!! La date de début ne doit pas dépasser la date de fin", $app->slug).'</div>';
			}else{
				if ( !isset( $_POST[$app->slug.'_'.$app->form_action2] ) || !wp_verify_nonce( $_POST[$app->slug.'_'.$app->form_action2], $app->form_action2 ) )
				{

				   	$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.'Sorry, your nonce did not verify.'.'</div>';
				   	exit;

				}
				else{
					$datas = $_POST[$app->form_action2];
					$res = $app->app->closing->create($datas);
					if ($res == "1")
					{
						$message = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("La fermeture a été ajoutée avec succès", $app->slug).'</div>';
					}
					elseif (is_array($res)) {
						$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$res[0].'</div>';
					}
					else
						$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Erreur lors de l'ajout", $app->slug).'</div>';
				}
			}
		}
		elseif (isset($_POST[$app->form_action3]))
		{
			$start = strtotime($_POST[$app->form_action3]['start']);
			$end = strtotime($_POST[$app->form_action3]['end']);

			$_POST[$app->form_action3]['start'] = date('Y-m-d', $start);
			$_POST[$app->form_action3]['end'] = date('Y-m-d', $end);

			if ($start > $end)
			{
				$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Erreur!! La date de début ne doit pas dépasser la date de fin", $app->slug).'</div>';
			}else{
				if ( !isset( $_POST[$app->slug.'_'.$app->form_action3] ) || !wp_verify_nonce( $_POST[$app->slug.'_'.$app->form_action3], $app->form_action3 ) )
				{

				   	$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.'Sorry, your nonce did not verify.'.'</div>';
				   	exit;

				}
				else{
					$datas = $_POST[$app->form_action3];
					$res = $app->app->closing->update($datas);
					if ($res)
					{
						$message = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("La fermeture a été modifiée avec succès", $app->slug).'</div>';
					}
					else
						$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Erreur lors de la modification", $app->slug).'</div>';
				}
			}
		}

		ob_start(); 
		load_template($app->template_path."closing.php", false);
		return $message.ob_get_clean();
	}

	// BOOKING
	public static function booking($atts, $content='')
	{
		if (!is_user_logged_in())
			return '';
		if (appBook()->app->app_id == null)
			return '';

		$app = appBook();
		$message = '';

    	$booking_id = get_query_var( 'booking', false );

		wp_enqueue_style( $app->slug.'_fullcalendar' );
		wp_enqueue_style( $app->slug.'_fullcalendar_print' );

		wp_enqueue_script( $app->slug.'_moment_min' );
		// if ($booking_id === false)
		// 	wp_enqueue_script( $app->slug.'_jquery_min' );
		// wp_enqueue_script( 'jquery' );

		wp_enqueue_script( $app->slug.'_fullcalendar' );
		wp_enqueue_script( $app->slug.'_locale_fr' );
		if ($booking_id === false || isset($_POST['booking-new']))
			wp_enqueue_script( $app->slug.'_booking' );
		wp_localize_script($app->slug.'_booking', 'bookingObject', array(
      		'ajaxurl' => admin_url( 'admin-ajax.php' ),
      		'events' => $app->app->booking->getEvents(),
      		'defaultDate' => date('Y-m-d'),
      		'hiddenDays' => json_encode($app->app->opening->getDayOff()),
      		'businessHours' => json_encode($app->app->opening->getBusinessHours())
      		)
    	);
    	if ($booking_id !== false)
    	{
    		wp_enqueue_style('css-ui', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
    		if (isset($_POST['booking-edit'])) {
    			if ( !isset( $_POST[$app->slug.'_'.'booking-edit'] ) || !wp_verify_nonce( $_POST[$app->slug.'_'.'booking-edit'], 'booking-edit' ) ) {
    				$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.'Sorry, your nonce did not verify.'.'</div>';
    			} else {
    				$datas = $_POST['booking-edit'];
					$res = $app->app->booking->update($datas);
					if ($res)
					{
						$message = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Le rendez-vous a été modifié avec succès", $app->slug).'</div>';
					}
					else {
						$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Erreur lors de la modification", $app->slug).'</div>';
					}
    			}
    		}
    		ob_start(); 
			load_template($app->template_path."booking-single.php", false);
			return $message.ob_get_clean();
    	}
    	elseif (isset($_POST['booking-new'])) // nouveau rendez-vous
    	{
			if ( !isset( $_POST[$app->slug.'_'.'booking-new'] ) || !wp_verify_nonce( $_POST[$app->slug.'_'.'booking-new'], 'booking-new' ) ) {
				$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.'Sorry, your nonce did not verify.'.'</div>';
			} else {
				$datas = $_POST['booking-new'];
				$_date = explode('-', $datas['date']);
				$datas["date"] = $_date[2].'-'.$_date[1].'-'.$_date[0];
				$res = $app->app->booking->create($datas);
				if($res == 1) {
					$message = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Le rendez-vous a été ajouté avec succès", $app->slug).'</div>';
				} elseif (is_array($res)){
					$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$res[0].'</div>';
				} else {
					$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Erreur lors de l'ajout", $app->slug).'</div>';
				}
			}
		}
		ob_start(); 
		load_template($app->template_path."booking.php", false);
		return $message.ob_get_clean();
	}

	// STATS
	public static function booking_list($atts, $content='')
	{
		if (!is_user_logged_in())
			return '';
		if (appBook()->app->app_id == null)
			return '';
		$app = appBook();
		$message = '';

		wp_localize_script($app->slug.'_booking_list', 'bookingListObject', array(
      		'ajaxurl' => admin_url( 'admin-ajax.php' ),
      		'action' => $app->slug.'_action_delete'
      		)
    	);

		ob_start(); 
		load_template($app->template_path."booking-list.php", false);
		return $message.ob_get_clean();
	}

	// STATS
	public static function stats($atts, $content='')
	{
		if (!is_user_logged_in())
			return '';
		if (appBook()->app->app_id == null)
			return '';

		$app = appBook();
		$message = '';

		$data = $app->app->stats->getData();
		// return $data;

		wp_enqueue_style('css-ui', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
		wp_enqueue_style($app->slug.'_multiselect-css');
		wp_enqueue_script( $app->slug.'_chart' );
		wp_enqueue_script( $app->slug.'_multiselect' );
		wp_enqueue_script( $app->slug.'_stats' );
		wp_localize_script($app->slug.'_stats', 'statsObject', array(
      		'ajaxurl' => admin_url( 'admin-ajax.php' ),
      		'action' => $app->slug.'_action_stats',
      		'data' => ( $data === null ? array('0') : json_encode($data) ),
      		)
    	);

		ob_start(); 
		load_template($app->template_path."stats.php", false);
		return $message.ob_get_clean();
	}

	// HOLIDAY
	public static function holiday($atts, $content='')
	{
		if (!is_user_logged_in())
			return '';
		if (appBook()->app->app_id == null)
			return '';

		$app = appBook();
		$app->form_action = "holiday";
		$app->form_action2 = 'holiday_new';
		$app->form_action3 = 'holiday_edit';
		$message = '';

		wp_enqueue_script( $app->slug.'_holiday' );
		wp_enqueue_script( $app->slug.'_bootstrap-toggle' );
		wp_localize_script($app->slug.'_holiday', 'holidayObject', array(
      		'ajaxurl' => admin_url( 'admin-ajax.php' ),
      		'action_new' => appBook()->slug.'_new_holiday',
      		'action_edit' => appBook()->slug.'_edit_holiday',
      		'action_delete' => appBook()->slug.'_delete_holiday',
      		'action_employee' => appBook()->slug.'_employee_holiday',
      		'action_orderby' => appBook()->slug.'_orderby_holiday',
      		'action_validate' => appBook()->slug.'_holiday_validate',
      		)
    	);
    	wp_enqueue_style('css-ui', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
    	wp_enqueue_style(appBook()->slug.'_bootstrap-toggle');

		if (isset($_POST[$app->form_action2]))
		{
			if ( !isset( $_POST[$app->slug.'_'.$app->form_action2] ) || !wp_verify_nonce( $_POST[$app->slug.'_'.$app->form_action2], $app->form_action2 ) )
			{

			   	$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.'Sorry, your nonce did not verify.'.'</div>';
			   	exit;

			}
			else{
				$datas = $_POST[$app->form_action2];
				$res = $app->app->holiday->create($datas);
				if ($res == "1")
				{
					$message = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Le congé a été ajouté avec succès", $app->slug).'</div>';
				}
				elseif (is_array($res)) {
					$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$res[0].'</div>';
				}
				else
					$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Erreur lors de l'ajout", $app->slug).'</div>';
			}
		}
		elseif (isset($_POST[$app->form_action3]))
		{
			if ( !isset( $_POST[$app->slug.'_'.$app->form_action3] ) || !wp_verify_nonce( $_POST[$app->slug.'_'.$app->form_action3], $app->form_action3 ) )
			{

			   	$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.'Sorry, your nonce did not verify.'.'</div>';
			   	exit;

			}
			else{
				$datas = $_POST[$app->form_action3];
				$res = $app->app->holiday->update($datas);
				if ($res)
				{
					$message = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Le congé planifié a été modifié avec succès", $app->slug).'</div>';
				}
				else
					$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Erreur lors de la modification", $app->slug).'</div>';
			}
		}

		ob_start(); 
		load_template($app->template_path."holiday.php", false);
		return $message.ob_get_clean();
	}

	// MODULE
	public static function module($atts, $content='')
	{
		if (!is_user_logged_in())
			return '';

		$app = appBook();
		$app->form_action = "module";
		$app->form_action2 = 'module_new';
		$message = '';

		wp_enqueue_script( $app->slug.'_bootstrap-toggle' );
		wp_enqueue_script( $app->slug.'_bootstrap-colorpicker' );
		
		wp_enqueue_style(appBook()->slug.'_bootstrap-toggle');
		wp_enqueue_style(appBook()->slug.'_bootstrap-colorpicker');

		if (isset($_POST[$app->form_action2]))
		{
			if ( !isset( $_POST[$app->slug.'_'.$app->form_action2] ) || !wp_verify_nonce( $_POST[$app->slug.'_'.$app->form_action2], $app->form_action2 ) )
			{

			   	$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.'Sorry, your nonce did not verify.'.'</div>';
			}
			else{
				$datas = $_POST[$app->form_action2];
				if($app->app->datas->app_name !== '')
				{
					$generate = $app->app->module->generate($datas['folder']);
					if($generate !== false)
					{
						$datas['folder'] = $generate;
						$res = $app->app->module->create($datas);
						if ($res == "1")
						{
							//// to admin
							$site_name = get_bloginfo('name');
							$user_name = $app->app->userinfo->datas->firstname.' '.$app->app->userinfo->datas->lastname;
							$user_email = $app->app->datas->email;
							$admin_to = get_bloginfo('admin_email');
							$admin_subject = "Nouvelle génération de module de \"".$app->app->datas->app_name."\" sur le site ".$site_name;

							$admin_message = "Le client ".$app->app->datas->app_name." vient de générer son module sur ".get_bloginfo('name')."."."\n\r"."\n\r";
							$admin_message .= "Ci-après ses informations : "."\n\r"."\n\r";
							$admin_message .= "Nom: ".$user_name."\n\r";
							$admin_message .= "société: ".$app->app->datas->app_name."\n\r";
							$admin_message .= "Email: ".$app->app->datas->email_contact."\n\r";
							$admin_message .= "Téléphone: ".$app->app->datas->phonenumber."\n\r";
							$admin_message .= "Nom de dossier du module: ".$generate."\n\r";

							$admin_headers[] = "From: $site_name <$admin_to>";

							$admin_mail = wp_mail( $admin_to, $admin_subject, $admin_message, $admin_headers );

							$message = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Votre module a été généré avec succès", $app->slug).'</div>';
						}
						elseif (is_array($res)) {
							$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$res[0].'</div>';
						}
						else
							$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Une erreur est survenue lors de la génération de votre module", $app->slug).'</div>';
					}
					else
						$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Une erreur est survenue lors de la génération de votre module", $app->slug).'</div>';
				}else{
					return '<div class="alert alert-warning" role="alert">'.__("Veuillez d'abord remplir les informations concernant votre société ", $app->slug).'<a href="'.site_url('/configuration-de-lapplication/').'">'.__('ici', $app->slug).'</a>.</div>';
				}
			}
		}
		elseif($app->app->datas->app_name === '') {
			return '<div class="alert alert-warning" role="alert">'.__("Veuillez d'abord remplir les informations concernant votre société ", $app->slug).'<a href="'.site_url('/configuration-de-lapplication/').'">'.__('ici', $app->slug).'</a>.</div>';
		}
		ob_start(); 
		load_template($app->template_path."module.php", false);
		return $message.ob_get_clean();
	}
}