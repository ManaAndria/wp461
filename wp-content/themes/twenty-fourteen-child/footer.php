<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>

		</div><!-- #main -->

		<footer id="colophon" class="site-footer" role="contentinfo">

			<?php get_sidebar( 'footer' ); ?>

			<div class="site-info">
				<?php do_action( 'twentyfourteen_credits' ); ?>
				<a href="<?php echo esc_url( __( 'https://www.monrdv.online/', '' ) ); ?>"><?php printf( __( 'Propriété de %s', '' ), 'MonRDV.online' ); ?></a>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>
	<?php
		$user_login = wp_get_current_user()->user_login;
		if ($user_login) {
			$wp_session = WP_Session::get_instance();
			
			if (isset($wp_session['display_tooltip'])) { 
				?>
				<script type="text/javascript">
					jQuery(document).ready(function(){
						jQuery('#menu-item-52 a').attr('title', '<div style=\'text-align: left;\'><b style=\'border-bottom: 1px solid #24890d;display: block;margin: 5px 0;\'>Titre ouverture aide</b>Lorem ipsum dolor sit amet, consectetur adipiscing elit.<br /> Ut et odio augue, ac pellentesque lectus. Vivamus non leo eget elit dapibus ultricies ac eget lorem.</div>');
						jQuery('#menu-item-52 a').attr('data-html', 'true');
						jQuery("#menu-item-52 a").tooltip({
				            placement:"right"
				        });


				        /*jQuery('#main-content').append();*/
					});
				</script>
			<?php
			}
		}
	?>
	<style type="text/css">
		.tooltip{
		    position:absolute;
		    z-index:1020;
		    display:block;
		    visibility:visible;
		    padding:5px;
		    font-size:13px;
		    opacity:0;
		    filter:alpha(opacity=0)
		}
		.tooltip.in{
		    opacity:1;
		    filter:alpha(opacity=100)
		}

		.tooltip-inner{
		    width:350px;
		    padding:3px 8px;
		    color:#000;
		    text-align:center;
		    background: #fff; 
		    -webkit-border-radius:5px;
		    -moz-border-radius:5px;
		    border-radius:5px;
		    border: 1px solid #24890d;
		}

		.tooltip.right .tooltip-arrow {
		    top: 50%;
		    left: 0;
		    margin-top: -5px;
		    border-width: 5px 5px 5px 0;
		    border-right-color: #24890d;
		}
		.tooltip-arrow {
		    position: absolute;
		    width: 0;
		    height: 0;
		    border-color: transparent;
		    border-style: solid;
		}
	</style>
</body>
</html>