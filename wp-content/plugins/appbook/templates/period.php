<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$app = appBook();
$services = $app->app->service->datas;
$days = $app->app->period->getDays();
?>
<div id="stats-loading" style="display: none;"><div class="stats-loading-anim"></div></div>
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title" id="myModalLabel"><?php echo __('Supprimer une période', $app->slug) ?></h4>
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
	<div>Sur cette page, vous avez la liste des périodes classées par services et employés.<br />Vous pouvez ainsi visualiser, ajouter, supprimer et éditer les périodes que vous souhaitez associer à vos employés et vos services.</div>
</div>
<?php endif; ?>
<div class="col-xs-12 row" id="period">
	<div class="page-header row">
		<h2><?php echo __('Liste des périodes', $app->slug); ?></h2>
	</div>
	<?php
if (!count($services))
	echo '<div class="alert alert-info" role="alert">'.__("Il n'y a aucune période", $app->slug).'</div>';
else
{
	foreach ($services as $service) {// boucle service
		
		$employees = $app->app->employee->getByPoste($service->service_id);
?>
	<div class="panel panel-primary" id="service-<?php echo $service->service_id ?>">
	  	<div class="panel-heading"><h4><?php echo __('Service', $app->slug).' - '.$service->service_name ?>
	  		&nbsp;<span class="badge"><?php echo count($employees).' '.__('employé(s)', $app->slug) ?></span><span class="pull-right"><?php echo $service->price.($service->price != '' ? " ".$app->app->datas->currency : ''); ?></span></h4>
  		</div>
	  	<div class="panel-body">
	  		<div class="pull-left">
	  			<div class="text-info"><?php echo __('La durée du service est de ', $app->slug).'<span class="label label-primary">'.$app->app->service->getFieldById($service->service_id, 'duration').' '.__('minutes', $app->slug).'</span>.'; ?></div>
	  			<div class="text-info"><?php echo __('Chaque période sera divisée par intervalle de la durée du service.', $app->slug) ?></div>
	  		</div>
	 	</div>
	 	<?php 
	 	foreach ($employees as $employee) { //boucle employee
	 		// $periods = $app->app->period->getPeriodByEmployee($employee->employee_id);
	 		$periods = $app->app->period->getByEmployeeService($employee->employee_id, $service->service_id);
	 	?>
	 	<div class="panel panel-default" style="margin-bottom: 0px;border-bottom: none;">
	 		<div class="panel-heading container-fluid"> 
  				<div>
			    	<div class="pull-right">
			  			<button class="period-new btn btn-large pull-right btn-success" data-toggle="button" aria-pressed="false" data-remote="true" data-loading-text="<?php _e("Patientez", $app->slug) ?> ..." data-employee="<?php echo $employee->employee_id ?>" data-service="<?php echo $service->service_id ?>">
			  				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;&nbsp;<?php _e("Ajouter une période", $app->slug) ?>
							</button>
			  		</div>
				 	<div class="pull-left">
				 		<h5><?php echo __('Employé', $app->slug).' - '.$employee->firstname.' '.$employee->lastname ?>
				 			<span class="label label-default"><?php echo count($periods).' '.__('période(s)', $app->slug) ?></span>
				 		</h5>
			 		</div>
		 		</div>
	 		</div>
	  		<ul class="list-group">
		  	<?php 
		  	if ($periods !== null)
		  	{
		  		foreach ($periods as $period) {// boucle period
		  			$start = explode(':', $period['period']);
		  			$end = explode(':', $period['end']);
		  			// $period_text = __('De', $app->slug).' '.$start[0].'h'.$start[1].' '.__('à', $app->slug).' '.$end[0].'h'.$end[1];
		  			$day = (int)$period['day'];
		  			$period_text = __('de', $app->slug).' '.$start[0].'h'.$start[1].' '.( isset($end[1]) > 0 ? __('à', $app->slug).' '.$end[0].'h'.$end[1] : '' );
		  	?>
			    <li id="<?php echo $period['period_id'] ?>" class="list-group-item">
			    	<span class="pull-left"><?php echo ucfirst($days[$day]).' - '.$period_text ?></span>
			    	<div class="pull-right">
			    		<button class="btn btn-large btn-default edit-period" autocomplete="off" data-toggle="tooltip" aria-pressed="false" data-id="<?php echo $period['period_id'] ?>" data-employee="<?php echo $employee->employee_id ?>" data-loading-text="<?php _e("Patientez", $app->slug) ?> ...">
			    			<span class="glyphicon glyphicon-edit" aria-hidden="true" title="<?php echo __('Modifier', $app->slug); ?>"></span>		    			
			    		</button>
			    		<button class="btn btn-large btn-danger delete-period" autocomplete="off" data-toggle="modal" aria-pressed="false" data-id="<?php echo $period['period_id'] ?>" data-target="#confirmDelete">
			    			<span class="glyphicon glyphicon-remove" aria-hidden="true" title="<?php echo __('Supprimer', $app->slug); ?>"></span>
			    		</button>
			    	</div>
			    </li>
		    <?php
				}
			}
			else{ ?>
					<li id="<?php echo $period['period_id'] ?>" class="list-group-item">
						<div class="text-warning"><?php echo __("Aucune période n'est définie.") ?></div>
					</li>
		    <?php } ?>
	  		</ul>
  		</div>
	  	<?php
	  	}
	  	?>
	</div>
<?php
	}
}
?>
<input type="hidden" id="period_id" name="period_id" value="">
</div>