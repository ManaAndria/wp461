<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$app = appBook();

?>
<?php 
$wp_session = WP_Session::get_instance();
if (isset($wp_session['display_tooltip'])): ?>
<div class="alert alert-info">
	<div class="pull-left" style="font-size: 32px;margin-right: 10px"><div class="glyphicon glyphicon-info-sign"></div></div>
	<div>Sur cette page, vous avez la liste sous forme de calendrier, des vos rendez-vous effectués depuis votre application mobile.<br />Vous pouvez appliquer un filtre pour affiner la liste (par mois, par semaine, ...)<br />Vous pouvez aussi ajouter un rendez-vous en cliquant sur le bouton "Ajouter un rendez-vous".<br />Le bouton "Voir la liste de tous les rendez-vous" vous permet d'avoir une liste sous forme de tableau de vos rendez-vous. Depuis cette page, vous pouvez éditer ou supprimer vos rendez-vous.</div>
</div>
<?php endif; ?>
<div class="row-fluid">
	<div class="pull-left">
		<h4>
			<a href="<?php echo esc_url( add_query_arg( 'booking', '0', site_url( '/rendez-vous/' ) ) ); ?>" class="btn btn-success" style="text-decoration:none;"><?php _e('Ajouter un rendez-vous', $app->slug); ?></a>
			<a href="<?php echo esc_url( site_url( '/rendez-vous/liste/' ) ); ?>" class="btn btn-primary" style="text-decoration:none;"><?php _e('Voir la liste de tous les rendez-vous', $app->slug); ?></a>
		</h4>
	</div>
</div>
<div class="clearfix"></div>
<div id="booking"></div>
<script type="text/javascript">
<?php 
if(!empty($app->app->datas->hour_zone)){ ?>
	var bookingTimezone = '<?php echo $app->app->datas->hour_zone ?>';
<?php }
else{ ?>
	var bookingTimezone = false;
<?php
}
?>
var closingEventsSingle = <?php echo json_encode($app->app->closing->getClosingEventsSingle()); ?>;
var closingEventsFrequenty = <?php echo json_encode($app->app->closing->getClosingEventsFrequenty()); ?>;
var isSingle = false;
</script>