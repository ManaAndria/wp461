<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$app = appBook();
$days = $app->app->opening->days;
?>
<div class="modal fade" id="add-service" tabindex="-1" role="dialog" aria-labelledby="add-edit-title">
 	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title" id="add-edit-title"></h4>
	      	</div>
	      	<div class="modal-body container-fluid">
	      	</div>
	      	<div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Annuler', $app->slug) ?></button>
		        <button id="confirm-add" type="button" class="btn btn-primary"><?php echo __('Sauvegarder', $app->slug) ?></button>
	      	</div>
	    </div>
  	</div>
</div>
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
	<div>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
</div>
<?php endif; ?>
<div class="col-xs-12 row" id="opening">
	<div class="page-header row">
		<h2><?php _e('Les ouvertures hebdomadaires', $app->slug) ?></h2>
	</div>
<?php
$WeeklyClosingDays = $app->app->closing->getWeeklyClosingDays();
foreach ($days as $key => $day) { 
	$openings = $app->app->opening->getOpeningsByDay($key);

?>
	<div class="panel panel-default">
 		<div class="panel-heading"><div class="center-block"><?php echo ucfirst(__($day, $app->slug)); ?></div></div>
  		<div class="panel-body">
  		<?php
  		if(in_array($key, $WeeklyClosingDays)){ ?>
  			<div class="pull-left">
				<div class="text-info"><?php echo __("Ce jour est fermé.", $app->slug) ?></div>
			</div>
  		<?php } elseif ( !count($openings) ){ ?>
			<div class="pull-left">
				<div class="text-info"><?php echo __("Ce jour est considéré comme fermé.", $app->slug) ?></div>
			</div>
		<?php 
		}
		if(!in_array($key, $WeeklyClosingDays)){
		?>
    		<div class="pull-right">
    			<button class="btn btn-sm pull-right btn-success add-service" data-toggle="modal" data-loading-text="<?php _e("Patientez", $app->slug) ?> ..." aria-pressed="false" data-remote="true" data-day="<?php echo $key ?>">
	  				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;&nbsp;<?php _e("Ajouter une ouverture", $app->slug) ?>
  				</button>
    		</div>
  		<?php
  		} ?>
  		</div>
		<?php if ( count($openings) && !in_array($key, $WeeklyClosingDays) ){
		?>
  		<table class="table-responsive app-table">
    		<thead>
    			<tr>
	    			<th><?php _e('Début', $app->slug); ?></th>
	    			<th><?php _e('Fin', $app->slug); ?></th>
	    			<th></th>
    			</tr>
    		</thead>
    		<tbody>
    		<?php
			foreach ($openings as $opening){
				$_start = explode(':', $opening->start);
				$start = implode('h', $_start);
				$_end = explode(':', $opening->end);
				$end = implode('h', $_end);
			?>
				<tr id="<?php echo $opening->opening_id ?>">
					<td><?php echo $start ?></td>
					<td><?php echo $end ?></td>
					<td>
						<div class="pull-right">
				    		<button class="btn btn-sm btn-default edit-service" autocomplete="off" data-loading-text="<?php _e("Patientez", $app->slug) ?> ..." data-toggle="button" aria-pressed="false" data-id="<?php echo $opening->opening_id ?>" data-service="<?php echo $opening->service_id ?>">
				    			<span class="glyphicon glyphicon-edit" aria-hidden="true" title="<?php echo __('Modifier', $app->slug); ?>"></span>	
				    		</button>
							<button class="btn btn-sm btn-danger delete-service" autocomplete="off" data-toggle="modal" aria-pressed="false" data-id="<?php echo $opening->opening_id ?>" data-target="#confirmDelete">
				    			<span class="glyphicon glyphicon-remove" aria-hidden="true" title="<?php echo __('Supprimer', $app->slug); ?>"></span>
				    		</button>
			    		</div>
					</td>
				</tr>
			<?php
			}
			?>	
    		</tbody>
  		</table>
  		<?php
  		}
		?>
	</div>
<?php	
}
?>
<input type="hidden" id="opening_id" name="opening_id" value="">
</div>