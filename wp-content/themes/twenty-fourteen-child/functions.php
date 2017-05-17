<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

add_action('init', 'perso_session_start', 1);
 
function perso_session_start() {
   if ( ! session_id() ) {
      @session_start();
   }
}

add_action('wp_logout', 'perso_destroy_var_session');
 
function perso_destroy_var_session() {
   if ( isset( $_COOKIE['display_tooltip'] ) ) {
      unset( $_COOKIE['display_tooltip'] );
   }
}