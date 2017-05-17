<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$app = appBook();
$employees = appBook()->app->employee->datas;
?>
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title" id="myModalLabel"><?php echo __('Supprimer un employé', $app->slug) ?></h4>
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
	<div>Sur cette page, vous avez les options pour définir les employés que vous souhaitez afficher sur votre application.<br />Vous pouvez visualiser, ajouter, supprimer et éditer vos employés.</div>
</div>
<?php endif; ?>
<div class="col-xs-12 row" id="employee">
	<div class="page-header row">
		<h2 class="pull-left"><?php _e('Liste des employés', $app->slug) ?></h2>
		<button id="employee-new" href="#" class="page-header-btn btn btn-large pull-right btn-success" data-toggle="button" aria-pressed="false" data-remote="true" data-loading-text="<?php _e("Patientez", $app->slug) ?> ..."><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;&nbsp;<?php _e("Ajouter un employé", $app->slug) ?></button>
	</div>
<?php
if (!count($employees))
	echo '<div class="alert alert-info" role="alert">'.__("Il n'y a aucun employé", $app->slug).'</div>';
else
{
?>
	<table class="table table-striped app-table">
		<thead>
			<tr>
				<th><?php echo __("Prénom", $app->slug) ?></th>
				<th><?php echo __("Nom", $app->slug) ?></th>
				<th class="col-email"><?php echo __("Email", $app->slug) ?></th>
				<!-- <th><?php echo __("Code pays", $app->slug) ?></th> -->
				<th><?php echo __("Téléphone", $app->slug) ?></th>
				<th><?php echo __("Service(s)", $app->slug) ?></th>
				<th class="col-actions"><?php /*echo __("Actions", $app->slug)*/ ?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ($employees as $key => $employee) { ?>
			<tr id="<?php echo $employee->employee_id ?>">
				<td><?php echo $employee->firstname ?></td>
				<td><?php echo $employee->lastname ?></td>
				<td><a href="mailto:<?php echo $employee->email ?>"><?php echo $employee->email ?></a></td>
				<!-- <td><?php echo $employee->country_code ?></td> -->
				<td><?php echo $employee->phonenumber ?></td>
				<td>
					<?php
					$postes = json_decode($employee->poste);
					if(is_array($postes))
					{
						foreach ($postes as $key => $value) {
							echo ($key ? ', ' : '').$app->app->service->getServiceName($value);
						}
					}
					else
					{
						if($employee->poste)
							echo $app->app->service->getServiceName($employee->poste);
					}
					?>
				</td>
				<td style="width: 100px;">
					<div class="pull-right">
						<button class="btn btn-large btn-default edit-employee" autocomplete="off" data-toggle="tooltip" aria-pressed="false" data-id="<?php echo $employee->employee_id ?>" data-loading-text="<?php _e("Patientez", $app->slug) ?> ...">
							<span class="glyphicon glyphicon-edit" aria-hidden="true" title="<?php echo __('Modifier', $app->slug); ?>"></span>
						</button>
						<button class="btn btn-large btn-danger delete-employee" autocomplete="off" data-toggle="modal" aria-pressed="false" data-id="<?php echo $employee->employee_id ?>" data-target="#confirmDelete">
							<span class="glyphicon glyphicon-remove" aria-hidden="true" title="<?php echo __('Supprimer', $app->slug); ?>"></span>
						</button>
					</div>
				</td>
			</tr>
		<?php }
		?>
		</tbody>
	</table>
	<input type="hidden" id="employee_id" name="employee_id" value="">
<?php }
unset($_POST);
?>
</div>