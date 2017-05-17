<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$app = appBook();
if ( isset($_POST['action']) && $_POST['action'] == appBook()->slug.'_edit_period' && isset($_POST['data']) )
{
	$period_id = (int)$_POST['data'];
	$current = appBook()->app->period->getSingle($period_id);
	$employee_id = $current->employee_id;
	$period = explode(':', $current->period);
	$end = explode(':', $current->end);
	$form_action = 'period_edit';
}
else
	$form_action = 'period_new';

?>
<div class="page-header row">
	<h2>
		<?php if (isset($current))
			echo __('Modifier une période', $app->slug);
		else
			echo __('Ajouter une nouvelle période', $app->slug);
		?>
	</h2>
</div>
<?php if (isset($current)) : 
$employee = $app->app->employee->getSingle($current->employee_id);
?>
	<div class="alert alert-info pull-right col-xs-12 col-sm-4"><?php echo __('Service : ', $app->slug) .' '. $app->app->service->getServiceName($current->service_id).' - '.__('durée', $app->slug).
	' '.$app->app->service->getFieldById($current->service_id, 'duration').' '.__('minutes', $app->slug).'<br />'. __('Employé : ', $app->slug).$employee->firstname.' '.$employee->lastname; ?></div>
<?php else : 
$employee = $app->app->employee->getSingle($_POST['data']);
?>
	<div class="alert alert-info pull-right col-xs-12 col-sm-4"><?php echo __('Service : ', $app->slug) .' '. $app->app->service->getServiceName($_POST['service']).' - '.__('durée', $app->slug).
		' '.$app->app->service->getFieldById($_POST['service'], 'duration').' '.__('minutes', $app->slug).'<br />'. __('Employé : ', $app->slug).$employee->firstname.' '.$employee->lastname; ?></div>
<?php endif; ?>
<form id="<?php echo $app->slug; ?>_app<?php echo '_'.$form_action?>"  class="<?php echo $app->slug; ?>_form form-horizontal col-xs-12 col-sm-8 pull-left" method="POST" action="">
	<div class="form-group col-xs-12">
		<h5 class="col-xs-offset-4 col-xs-8"><?php _e('Début', $app->slug); ?></h5>
	    <label for="hour" class="control-label col-xs-6 col-sm-4"><?php echo __('Heure', $app->slug) ?> *</label>
    	<div class="col-xs-6 col-sm- col-sm-3">
    		<input type="number" class="form-control" step="1" id="hour" min="0" max="23" name="<?php echo $form_action; ?>[hour]" value="<?php echo ( isset($current) ? $period[0] : '' ) ?>" required />
		</div>
  	</div>
  	<div class="form-group col-xs-12">
	    <label for="minute" class="control-label col-xs-6 col-sm-4"><?php echo __('Minute', $app->slug) ?> *</label>
    	<div class="col-xs-6 col-sm-3">
    		<input type="number" class="form-control" id="minute" step="1" min="0" max="59" name="<?php echo $form_action; ?>[minute]" value="<?php echo ( isset($current) ? $period[1] : '' ) ?>" required />
		</div>
  	</div>
  	<!-- Fin -->
	<div class="form-group col-xs-12">
		<h5 class="col-xs-offset-4 col-xs-8"><?php _e('Fin', $app->slug); ?></h5>
	    <label for="end_hour" class="control-label col-xs-6 col-sm-4"><?php echo __('Heure', $app->slug) ?> *</label>
    	<div class="col-xs-6 col-sm- col-sm-3">
    		<input type="number" class="form-control" step="1" id="end_hour" min="0" max="23" name="<?php echo $form_action; ?>[end_hour]" value="<?php echo ( isset($current) ? $end[0] : '' ) ?>" required />
		</div>
  	</div>
  	<div class="form-group col-xs-12">
	    <label for="end_minute" class="control-label col-xs-6 col-sm-4"><?php echo __('Minute', $app->slug) ?> *</label>
    	<div class="col-xs-6 col-sm-3">
    		<input type="number" class="form-control" id="end_minute" step="1" min="0" max="59" name="<?php echo $form_action; ?>[end_minute]" value="<?php echo ( isset($current) ? $end[1] : '' ) ?>" required />
		</div>
  	</div>
  	<div class="form-group col-xs-12">
	    <label for="day" class="control-label col-xs-6 col-sm-4"><?php echo __('Jour', $app->slug) ?> *</label>
    	<div class="col-xs-6 col-sm-3">
    		<select class="form-control" name="<?php echo $form_action; ?>[day]<?php echo (isset($current) ? '' : "[]"); ?>" id="day">
    			<?php 
    			$days = $app->app->period->getDays();
    			$opening_days = $app->app->opening->getDayOff();
    			$options = '';
    			if (isset($current))
    			{
    				$day_selected = $current->day;
    			}
    			else
    			{
    				$day_selected = 7777;
    			}
    			foreach ($days as $key => $day) {
    				// if(isset($current))
    				// 	$exist = $app->app->period->checkDayExist($current->employee_id, $current->service_id, $key);
    				// else
    				// 	$exist = $app->app->period->checkDayExist($_POST['data'], $_POST['service'], $key);
    				// if( (!$exist && !in_array($key, $opening_days)) || $key == $day_selected )
    				if( !in_array($key, $opening_days))
    				{
    					$options .= '<option value="'.$key.'"'.( $key == $day_selected ? ' selected' : '' ).'>'.ucfirst($day).'</option>';
    				}
    			}
    			echo $options;
    			?>
    		</select>
		</div>
  	</div>
  	<div class="clearfix"></div><hr />
  	<div class="control-group col-xs-12">
		<div class="col-xs-12 col-sm-offset-2 col-sm-8" style="padding-left: 0px;">
			<button type="button" onclick="javascript: location.assign(location.href);" class="btn btn btn-default"><?php echo __('Annuler', $app->slug); ?></button>
			<input class="btn btn btn-primary" name="<?php echo $app->slug; ?>_app" type="submit" value="<?php echo ( isset($current) ? __('Sauvegarder', $app->slug) : __('Ajouter', $app->slug) ) ?>">
		</div>
	</div>
	<?php 
	if ( isset($current) )
	{
	?>
		<input type="hidden" name="<?php echo $form_action ?>[period_id]" value="<?php echo $period_id; ?>" >
		<input type="hidden" name="<?php echo $form_action ?>[employee_id]" value="<?php echo $employee_id; ?>" >
	<?php
	}
	else
	{
	?>
		<input type="hidden" name="<?php echo $form_action ?>[employee_id]" value="<?php echo $_POST['data']; ?>" >
		<input type="hidden" name="<?php echo $form_action ?>[service_id]" value="<?php echo $_POST['service']; ?>" >
	<?php
	}
	?>
	<?php wp_nonce_field( $form_action, $app->slug.'_'.$form_action ) ?>
</form>
<script type="text/javascript">
/* <![CDATA[ */
openings = <?php echo json_encode($app->app->opening->getOpenings()); ?>;
jQuery(document).ready(function() {
    jQuery('select[name="period_new[day]"]').multiselect({
    	allSelectedText: 'Tous',
    	numberDisplayed: 1,
    	nSelectedText: 'selectionnés',
    	nonSelectedText: 'Aucun',
    	includeSelectAllOption: true,
    	selectAllText : 'Tous'
    });
});
/* ]]> */
</script>