<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php if ( get_header_image() ) : ?>
	<div id="site-header">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
		</a>
	</div>
	<?php endif; ?>

	<header id="masthead" class="site-header" role="banner">
		<div class="header-main">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<nav id="primary-navigation" class="site-navigation primary-navigation" role="navigation">
				<button class="menu-toggle"><?php _e( 'Primary Menu', 'twentyfourteen' ); ?></button>
				<a class="screen-reader-text skip-link" href="#content"><?php _e( 'Skip to content', 'twentyfourteen' ); ?></a>
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu', 'menu_id' => 'primary-menu' ) ); ?>
			</nav>
		</div>

	</header><!-- #masthead -->

	<div id="main" class="site-main">
	<?php
	$user_login = wp_get_current_user()->user_login;
	if ($user_login) {
		$checked = '';
		$wp_session = WP_Session::get_instance();
		if (isset($wp_session['display_tooltip'])) {
			$checked = 'checked="checked"';
		}
		echo '
	<div class="stats-loading" style="display: none;"><div class="stats-loading-anim"></div></div>
	<div class="col-xs-12" style="
    position: fixed;
    top: 50px;
    right: 0;
    width: auto;
    text-align: right;
    z-index: 9;
    padding-top: 10px;
    border-radius: 0 0 0 10px;
    background: #d9edf7;
    border-left: 1px solid #31708f;
    border-bottom: 1px solid #31708f;
	">	<form name="frm_display_tooltip" id="frm_display_tooltip" method="POST">
		    <div class="form-group">
		        <label class="control-label">Afficher les bulles d\'aide ?</label>
		        <input id="display_tooltip" class="switch-checkbox" value="1" '.$checked.' type="checkbox" name="display_tooltip" />
		        <input type="hidden" id="tooltip_value" name="tooltip_value" value="0" />
		    </div>
		</form>
	</div>';
	echo '<script type="text/javascript">
	jQuery(function(){
	    jQuery("#display_tooltip").bootstrapToggle({
	        on: "'.__("OUI").'",
	          off: "'.__("NON").'",
	          onstyle: "success",
	          offstyle: "danger"
	    });
	    jQuery("#display_tooltip").change(function() {
	    	jQuery(".stats-loading").show();
			jQuery.ajax({
				type: "POST",
				url: "'.home_url( '/' ).'checkSession.php",
				data: "data="+jQuery(this).prop("checked"),
				success: function(msg){
					location.reload();
				}
			});
	    })
	});
</script>';
	}
	?>