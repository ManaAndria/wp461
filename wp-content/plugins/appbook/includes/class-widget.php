<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AppWidget extends WP_Widget
{
	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$app = appBook();
		$widget_ops = array( 
			'classname' => $app->slug.'_widget',
			'description' => $app->slug.' widget menu',
		);
		parent::__construct( $app->slug.'_widget_menu', $app->slug.' widget menu', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$app = appBook();
		$redirect = home_url();
		$connexion = home_url();
		$account = home_url();

		if ($instance['redirection'] != '');
			$redirect = home_url($instance['redirection']);

		if ($instance['connexion_page'] != '');
			$connexion = home_url($instance['connexion_page']);

		if ($instance['account_page'] != '');
			$account = home_url($instance['account_page']);

		if (is_user_logged_in())
		{
			wp_nav_menu( array(
					'menu' =>__('comptes', $app->slug),
					'menu_class' => 'col-xs-12 row '.$app->slug.'-menu',
					'container' => 'ul',
				)
			);
			echo '<ul class="col-xs-12 row '.$app->slug.'-menu">';
			// echo '<li class="menu-item"><a href="'.$account.'">'.__('Compte', appBook()->slug).'</a></li>';
			echo '<li class="menu-item"><a href="'.wp_logout_url( $redirect ).'">'.__('Déconnexion', appBook()->slug).'</a></li></ul>';
		}
		else
			echo '<ul class="col-xs-12 row '.$app->slug.'-menu"><li class="menu-item"><a href="'.$connexion.'">'.__('Connexion', appBook()->slug).'</a></li></ul>';
		if (is_user_logged_in() && appBook()->app->app_id != null)
		{
			echo '<div class="nav-header">'.__('Planning', $app->slug).'</div>';
			wp_nav_menu( array(
					'menu' =>__('Planning', $app->slug),
					'menu_class' => 'col-xs-12 row '.$app->slug.'-menu',
					'container' => 'ul',
				)
			);
			
			echo '<div class="nav-header">'.__("Gestion de l'application", $app->slug).'</div>';
			wp_nav_menu( array(
					'menu' => __("Gestion de l'application", $app->slug), 
					'menu_class' => 'col-xs-12 row '.$app->slug.'-menu',
					'container' => 'ul',
				)
			);

			echo '<div class="nav-header">'.__('Module de rendez-vous', $app->slug).'</div>';
			wp_nav_menu( array(
					'menu' => __('Module de rendez-vous', $app->slug), 
					'menu_class' => 'col-xs-12 row '.$app->slug.'-menu',
					'container' => 'ul',
				)
			);
		}
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
		$redirection = !empty($instance['redirection']) ? $instance['redirection'] : '';
		$connexion_page = !empty($instance['connexion_page']) ? $instance['connexion_page'] : '';
		$account_page = !empty($instance['account_page']) ? $instance['account_page'] : '';
	?>
		<p>
			<label for="<?php echo appBook()->slug ?>-redirection"><?php echo __('Redirection', appBook()->slug) ?></label>
			<input id="<?php echo appBook()->slug ?>-redirection" type="text" name="<?php echo $this->get_field_name('redirection'); ?>" value="<?php echo esc_attr( $redirection ) ?>" />
		</p>
		<p>
			<label for="<?php echo appBook()->slug ?>-connexion"><?php echo __('Page de connexion', appBook()->slug) ?></label>
			<input id="<?php echo appBook()->slug ?>-connexion" type="text" name="<?php echo $this->get_field_name('connexion_page'); ?>" value="<?php echo esc_attr( $connexion_page ) ?>" />
		</p>
		<p>
			<label for="<?php echo appBook()->slug ?>-account"><?php echo __('Page de compte', appBook()->slug) ?></label>
			<input id="<?php echo appBook()->slug ?>-account" type="text" name="<?php echo $this->get_field_name('account_page'); ?>" value="<?php echo esc_attr( $account_page ) ?>" />
		</p>
	<?php 
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = array();
		$instance['redirection'] = ( !empty($new_instance['redirection']) ? strip_tags($new_instance['redirection']) : !empty($old_instance['redirection']) ? strip_tags($old_instance['redirection']) : '' ) ;
		$instance['connexion_page'] = ( !empty($new_instance['connexion_page']) ? strip_tags($new_instance['connexion_page']) : (!empty($old_instance['connexion_page']) ? strip_tags($old_instance['connexion_page']) : '') ) ;
		$instance['account_page'] = ( !empty($new_instance['account_page']) ? strip_tags($new_instance['account_page']) : (!empty($old_instance['account_page']) ? strip_tags($old_instance['account_page']) : '') ) ;
		return $instance;
	}
}