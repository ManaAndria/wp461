<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$app = appBook();
$closings = $app->app->closing->datas;
$days = $app->app->opening->days;
$frequencies = $app->app->closing->getFrequency();
?>
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title" id="myModalLabel"><?php echo __('Supprimer une fermeture', $app->slug) ?></h4>
	      	</div>
	      	<div class="modal-body">
	        <?php echo __("Êtes vous sûr de vouloir supprimer !?") ?>
	      	</div>
	      	<div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('NON', $app->slug) ?></button>
		        <button id="confirm-delete" type="button" class="btn btn-primary"><?php echo __('OUI', $app->slug) ?></button>
	      	</div>
	    </div>
  	</div>
</div>
<?php 
$wp_session = WP_Session::get_instance();
if (isset($wp_session['display_tooltip'])): ?>
<div class="alert alert-info">
	<div class="pull-left" style="font-size: 32px;margin-right: 10px"><div class="glyphicon glyphicon-info-sign"></div></div>
	<div>Sur cette page, vous avez les options pour définir les jours fériés.<br/>Vous pouvez visualiser, ajouter, supprimer, éditer les jours fériés.</div>
</div>
<?php endif; ?>
<div class="col-xs-12 row" id="closing">
	<div class="page-header row">
		<h2 class="pull-left"><?php _e('Les jours fériés', $app->slug) ?></h2>
		<button id="closing-new" class="page-header-btn btn btn-large pull-right btn-success" data-toggle="button" aria-pressed="false" data-loading-text="<?php _e("Patientez", $app->slug) ?> ..."><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;&nbsp;<?php _e("Ajouter une fermeture", $app->slug) ?></button>
	</div>
<?php
if (!count($closings))
	echo '<div class="alert alert-info" role="alert">'.__("Il n'y a aucune fermeture définie", $app->slug).'</div>';
else
{
?>
<table class="table app-table">
	<tr>
		<th><?php _e('Date de début', $app->slug) ?></th>
		<th><?php _e('Date de fin', $app->slug) ?></th>
		<th><?php _e('Fréquence', $app->slug) ?></th>
		<th><?php /*_e('Actions', $app->slug)*/ ?></th>
	</tr>
	<?php
	foreach ($closings as $key => $closing) { 
		$frequencies_keys = array_keys($frequencies, $closing->frequency);
		if($frequencies_keys[0] == 2){
			$closing_days = json_decode($closing->day);
			$weekly_text = __('Chaque :', $app->slug);
			foreach ($closing_days as $kd => $day) {
				$weekly_text .= ($kd != 0 ? ', ' : ' ').$days[$day];
			}
		?>
	<tr id="<?php echo $closing->closing_id ?>">
		<td colspan="2"><?php echo $weekly_text ?></td>
		<td><?php echo ucfirst($closing->frequency) ?></td>
		<td>
			<div class="pull-right">
			<button class="btn btn-large btn-default edit-closing" autocomplete="off" data-toggle="tooltip" aria-pressed="false" data-id="<?php echo $closing->closing_id ?>" data-loading-text="<?php _e("Patientez", $app->slug) ?> ...">
				<span class="glyphicon glyphicon-edit" aria-hidden="true" title="<?php echo __('Modifier', $app->slug); ?>"></span>
			</button>
			<button class="btn btn-large btn-danger delete-closing" autocomplete="off" data-toggle="modal" aria-pressed="false" data-id="<?php echo $closing->closing_id ?>" data-target="#confirmDelete">
				<span class="glyphicon glyphicon-remove" aria-hidden="true" title="<?php echo __('Supprimer', $app->slug); ?>"></span>
			</button>
		</div>
		</td>
	</tr>
		<?php 
		}else{
		?>
	<tr id="<?php echo $closing->closing_id ?>">
		<td><?php echo date_i18n( 'l j F Y', strtotime( $closing->start) ); ?></td>
		<td><?php echo date_i18n( 'l j F Y', strtotime($closing->end)) ?></td>
		<td><?php echo ucfirst($closing->frequency) ?></td>
		<td>
			<div class="pull-right">
			<button class="btn btn-large btn-default edit-closing" autocomplete="off" data-toggle="tooltip" aria-pressed="false" data-id="<?php echo $closing->closing_id ?>" data-loading-text="<?php _e("Patientez", $app->slug) ?> ...">
				<span class="glyphicon glyphicon-edit" aria-hidden="true" title="<?php echo __('Modifier', $app->slug); ?>"></span>
			</button>
			<button class="btn btn-large btn-danger delete-closing" autocomplete="off" data-toggle="modal" aria-pressed="false" data-id="<?php echo $closing->closing_id ?>" data-target="#confirmDelete">
				<span class="glyphicon glyphicon-remove" aria-hidden="true" title="<?php echo __('Supprimer', $app->slug); ?>"></span>
			</button>
		</div>
		</td>
	</tr>
	<?php
		}
	}
	?>
</table>
<?php
}
?>
<input type="hidden" id="closing_id" name="closing_id" value="">
</div>