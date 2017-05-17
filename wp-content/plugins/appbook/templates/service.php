<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$app = appBook();
$services = appBook()->app->service->datas;
?>
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title" id="myModalLabel"><?php echo __('Supprimer un service', $app->slug) ?></h4>
	      	</div>
	      	<div class="modal-body">
	        <?php echo __("Êtes vous sûr de vouloir supprimer !?") ?>
	      	</div>
	      	<div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('NON', $app->slug) ?></button>
		        <button id="confirm-delete" type="button" class="btn btn-primary" onclick=""><?php echo __('OUI', $app->slug) ?></button>
	      	</div>
	    </div>
  	</div>
</div>
<?php 
$wp_session = WP_Session::get_instance();
if (isset($wp_session['display_tooltip'])): ?>
<div class="alert alert-info">
	<div class="pull-left" style="font-size: 32px;margin-right: 10px"><div class="glyphicon glyphicon-info-sign"></div></div>
	<div>Sur cette page, vous avez les options pour définir les services que vous souhaitez proposer sur votre application.<br />Vous pouvez visualiser, ajouter, supprimer, éditer vos services.</div>
</div>
<?php endif; ?>
<div class="col-xs-12 row" id="service">
	<div class="page-header row">
		<h2 class="pull-left"><?php _e('Liste de services', $app->slug) ?></h2>
		<button id="service-new" class="page-header-btn btn btn-large pull-right btn-success" data-toggle="button" aria-pressed="false" data-loading-text="<?php _e("Patientez", $app->slug) ?> ..."><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;&nbsp;<?php _e("Ajouter un service", $app->slug) ?></button>
	</div>
<?php
if (!count($services))
	echo '<div class="alert alert-info" role="alert">'.__("Il n'y a aucun service", $app->slug).'</div>';
else
{
?>
	<table class="table table-striped app-table">
		<thead>
			<tr>
				<th><?php echo __('Nom du service', $app->slug) ?></th>
				<th><?php echo __('Durée du service', $app->slug) ?></th>
				<th><?php echo __('Description', $app->slug) ?></th>
				<th class="col-price"><?php echo __('Prix', $app->slug) ?></th>
				<th class="col-actions"></th>
			</tr>
		</thead>
		<tbody>
		<?php 
		foreach ($services as $key => $service) { ?>
			<tr id="<?php echo $service->service_id ?>">
				<td><?php echo stripslashes($service->service_name); ?></td>
				<td><?php echo $service->duration.' '.__('minutes', $app->slug); ?></td>
				<td><?php echo stripslashes($service->description); ?></td>
				<td class="col-price"><?php echo ($service->price == '' ? '-' : $service->price.' '.$app->app->datas->currency); ?></td>
				<td>
					<div class="pull-right">
						<button class="btn btn-large btn-default edit-service" autocomplete="off" data-toggle="tooltip" aria-pressed="false" data-id="<?php echo $service->service_id ?>" data-loading-text="<?php _e("Patientez", $app->slug) ?> ...">
							<span class="glyphicon glyphicon-edit" aria-hidden="true" title="<?php echo __('Modifier', $app->slug); ?>"></span>
						</button>
						<button class="btn btn-large btn-danger delete-service" autocomplete="off" data-toggle="modal" aria-pressed="false" data-id="<?php echo $service->service_id ?>" data-target="#confirmDelete">
							<span class="glyphicon glyphicon-remove" aria-hidden="true" title="<?php echo __('Supprimer', $app->slug); ?>"></span>
						</button>
					</div>
				</td>
			</tr>
		<?php
		} ?>
		</tbody>
	</table>
	<input type="hidden" id="service_id" name="service_id" value="">
<?php } 
unset($_POST);
?>
</div>