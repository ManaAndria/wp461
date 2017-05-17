<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$app = appBook();
$from = date('Y-m-d');
$to = date('Y-m-d', strtotime('+6 day'));
$dashboard = $app->app->booking->getDashboard($from, $to);
?>
<div id="dashboard">
	<p><?php _e("Bonjour, bienvenu dans votre tableau de bord.", $app->slug); ?></p>
	<p><?php _e("Voici le résumé de vos rendez-vous pour cette semaine.", $app->slug); ?></p>
	<div class="panel panel-success"">
		<div class="panel-heading">
			<h5><?php echo __('Rendez-vous du ', $app->slug).date_i18n( 'l j F Y', strtotime($from)).' '.__(' au ', $app->slug).date_i18n( 'l j F Y', strtotime($to)) ?></h5>
  		</div>
  		<div class="panel-body">
  		<?php if(count($dashboard) == 0) : ?>
  			<div class="alert alert-info"><?php echo __("Vous n'avez pas de rendez-vous entre le ", $app->slug).date_i18n( 'l j F Y', strtotime($from)).__(" et le ", $app->slug).date_i18n( 'l j F Y', strtotime($to)); ?>.<br />
  				<a href="<?php echo site_url("/rendez-vous/"); ?>" class="btn btn-primary" style="text-decoration:none;">Voir le calendrier des rendez-vous</a>
  			</div>
  		<?php else : ?>
  			<div class="list-group">
  		<?php foreach ($dashboard as $value) { ?>
				<a href="<?php echo esc_url( add_query_arg( 'booking', $value->booking_id, site_url( '/rendez-vous/' ) ) ) ?>" class="list-group-item" style="text-decoration:none;">
					<h6 class="list-group-item-heading"><?php echo date_i18n( 'l j F Y', strtotime($value->date)).__(" à ", $app->slug).$value->hour ?></h6>
					<div><?php echo __("Client: ", $app->slug).$value->firstname.' '.$value->lastname.', service: '.$app->app->service->getServiceName($value->service_id); ?></div>
				</a>
  		<?php } ?>
  			</div>
		<?php endif; ?>
  		</div>
	</div>
</div>