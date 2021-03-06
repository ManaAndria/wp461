<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class appShortcodes
{
	public static function init()
	{
		
		$shortcodes = array(
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
			'stats' => __CLASS__."::stats",
			'holiday' => __CLASS__."::holiday",
		);
		foreach ($shortcodes as $name => $function) {
			add_shortcode(appBook()->slug.'_'.$name,  $function);
		}
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
			'redirect'       => ( $redirect != '' ? site_url($redirect) : site_url() ),
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
		
		$content = '<div id="'.appBook()->slug.'_login" class="col-xs-12">';
		$content .= wp_login_form($args);
		// $content .= '<a href="'.wp_lostpassword_url( get_permalink() ).'" title="'.__('Mot de passe oublié', appBook()->slug).'">'.__('Mot de passe oublié', appBook()->slug).'</a>';
		$content .= '</div>';
		
		return $content;
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
		wp_localize_script($app->slug.'_service', 'serviceObject', array(
      		'ajaxurl' => admin_url( 'admin-ajax.php' ),
      		'action_new' => appBook()->slug.'_new_service',
      		'action_edit' => appBook()->slug.'_edit_service',
      		'action_delete' => appBook()->slug.'_delete_service',
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
				// var_dump($datas);exit;
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
				// if ($res == "1")
				// {
				// 	$message = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("La période a été ajoutée avec succès", $app->slug).'</div>';
				// }
				// elseif (is_array($res)) {
				// 	$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$res[0].'</div>';
				// }
				// else
				// 	$message = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.__("Erreur lors de l'ajout", $app->slug).'</div>';
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
				if ($res)
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

		wp_enqueue_script( $app->slug.'_closing' );
		wp_localize_script($app->slug.'_closing', 'closingObject', array(
      		'ajaxurl' => admin_url( 'admin-ajax.php' ),
      		'action_new' => appBook()->slug.'_new_closing',
      		'action_edit' => appBook()->slug.'_edit_closing',
      		'action_delete' => appBook()->slug.'_delete_closing',
      		)
    	);
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

		wp_enqueue_style( $app->slug.'_fullcalendar' );
		wp_enqueue_style( $app->slug.'_fullcalendar_print' );

		wp_enqueue_script( $app->slug.'_moment_min' );
		wp_enqueue_script( $app->slug.'_jquery_min' );
		wp_enqueue_script( $app->slug.'_fullcalendar' );
		wp_enqueue_script( $app->slug.'_locale_fr' );
		wp_enqueue_script( $app->slug.'_booking' );
		wp_localize_script($app->slug.'_booking', 'bookingObject', array(
      		'ajaxurl' => admin_url( 'admin-ajax.php' ),
      		'events' => $app->app->booking->getEvents(),
      		'defaultDate' => date('Y-m-d'),
      		'hiddenDays' => json_encode($app->app->opening->getDayOff()),
      		'businessHours' => json_encode($app->app->opening->getBusinessHours())
      		)
    	);
		ob_start(); 
		load_template($app->template_path."booking.php", false);
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
      		'data' => json_encode($data),
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
}