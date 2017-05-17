<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$app = appBook();
$holidays = appBook()->app->holiday->datas;
?>
<div id="stats-loading" style="display: none;"><div class="stats-loading-anim"></div></div>
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title" id="myModalLabel"><?php echo __('Supprimer un congé', $app->slug) ?></h4>
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
	<div>Sur cette page, vous avez les options pour configurer les congés de vos employés.<br />Vous pouvez ainsi visualiser, ajouter, supprimer et éditer les congés de vos employés.</div>
</div>
<?php endif; ?>
<div class="col-xs-12 row" id="holiday">
	<div class="page-header row">
		<h2 class="pull-left"><?php _e('Liste des congés planifiés', $app->slug) ?></h2>
		<button id="holiday-new" href="#" class="page-header-btn btn btn-large pull-right btn-success" data-toggle="button" aria-pressed="false" data-remote="true" data-loading-text="<?php _e("Patientez", $app->slug) ?> ..."><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;&nbsp;<?php _e("Ajouter une journée de congé planifié", $app->slug) ?></button>
	</div>
<?php
if (!count($holidays))
	echo '<div class="alert alert-info" role="alert">'.__("Il n'y a aucune journée de congé planifié", $app->slug).'</div>';
else
{
?>
	<table class="table table-striped app-table">
		<thead>
			<tr>
				<th><?php echo __("Date de début", $app->slug) ?>
					&nbsp;&nbsp;&nbsp;<a onclick="orderBy(1);" ><i class="glyphicon glyphicon-chevron-down"></i></a>
					<a onclick="orderBy(2);" ><i class="glyphicon glyphicon-chevron-up"></i></a>
				</th>
				<th><?php echo __("Date Fin", $app->slug) ?>
					&nbsp;&nbsp;&nbsp;<a onclick="orderBy(7);" ><i class="glyphicon glyphicon-chevron-down"></i></a>
					<a onclick="orderBy(8);" ><i class="glyphicon glyphicon-chevron-up"></i></a>
				</th>
				<th><?php echo __("Durée", $app->slug) ?></th>
				<th><?php echo __("Employé(e)", $app->slug) ?>
					&nbsp;&nbsp;&nbsp;<a onclick="orderBy(3);" ><i class="glyphicon glyphicon-chevron-down"></i></a>
					<a onclick="orderBy(4);" ><i class="glyphicon glyphicon-chevron-up"></i></a>
				</th>
				<!-- <th><?php echo __("Service", $app->slug) ?>
					&nbsp;&nbsp;&nbsp;<a onclick="orderBy(5);" ><i class="glyphicon glyphicon-chevron-down"></i></a>
					<a onclick="orderBy(6);" ><i class="glyphicon glyphicon-chevron-up"></i></a>
				</th> -->
				<th><?php /*echo __("Actions", $app->slug)*/ ?></th>
			</tr>
		</thead>
		<tbody id="holiday-list">
		<?php
		foreach ($holidays as $key => $holiday) { ?>
			<tr id="<?php echo $holiday->holiday_id ?>">
				<td><?php
					if ((int)$holiday->one_day) {
						echo dateEnToFr($holiday->date);
					} else {
						echo dateEnToFr($holiday->date_start);
					}
				?></td>
				<td><?php
					if ((int)$holiday->one_day) {
						echo dateEnToFr($holiday->date);
					} else {
						echo dateEnToFr($holiday->date_end);
					}
				?></td>
				<td><?php
					if (!(int)$holiday->one_day) {
						echo getNumDay($holiday->date_start, $holiday->date_end) .' '.__('jour(s)', $app->slug);

					} else if ((int)$holiday->all_day) {
						echo __('Toute la journée', $app->slug);
					} else {
						echo __('De ', $app->slug).$holiday->start.__(' à ', $app->slug).$holiday->end;
					}
				?></td>
				<td><?php echo $app->app->employee->getSingle($holiday->employee_id)->firstname.' '.$app->app->employee->getSingle($holiday->employee_id)->lastname ?></td>
				<!-- <td><?php echo $app->app->service->getServiceName($holiday->service_id) ?></td> -->
				<td>
					<div class="pull-right">
						<button class="btn btn-large btn-default edit-holiday" autocomplete="off" data-toggle="tooltip" aria-pressed="false" data-id="<?php echo $holiday->holiday_id ?>" data-loading-text="<?php _e("Patientez", $app->slug) ?> ...">
							<span class="glyphicon glyphicon-edit" aria-hidden="true" title="<?php echo __('Modifier', $app->slug); ?>"></span>
						</button>
						<button class="btn btn-large btn-danger delete-holiday" autocomplete="off" data-toggle="modal" aria-pressed="false" data-id="<?php echo $holiday->holiday_id ?>" data-target="#confirmDelete">
							<span class="glyphicon glyphicon-remove" aria-hidden="true" title="<?php echo __('Supprimer', $app->slug); ?>"></span>
						</button>
					</div>
				</td>
			</tr>
		<?php }
		?>
		</tbody>
	</table>
	<input type="hidden" id="holiday_id" name="holiday_id" value="">
<?php }
unset($_POST);
?>
</div>