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
		if (is_user_logged_in())
		{
			echo '<div class="nav-header">'.__('Planning', $app->slug).'</div>';
			wp_nav_menu( array(
					'menu' =>__('Planning', $app->slug),
					'menu_class' => 'col-xs-12 row '.$app->slug.'-menu',
					'container' => 'ul',
				)
			);
			
			/*echo '<div class="nav-header">'.__('Evènementiels', $this->slug).'</div>';
			wp_nav_menu( array(
					'menu' => __('Evènementiels', $this->slug),
					'menu_class' => 'col-xs-12 row '.$app->slug.'-menu',
					'container' => 'ul',
			  	) 
			);*/
			
			echo '<div class="nav-header">'.__("Gestion de l'application", $app->slug).'</div>';
			wp_nav_menu( array(
					'menu' => __('Gestion du restaurant', $app->slug), 
					'menu_class' => 'col-xs-12 row '.$app->slug.'-menu',
					'container' => 'ul',
				)
			);

			echo '<div class="nav-header">'.__('Module de réservation', $app->slug).'</div>';
			wp_nav_menu( array(
					'menu' => __('Module de réservation', $app->slug), 
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
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
	}
}