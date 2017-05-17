<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$app = appBook();
if ( isset($_POST['action']) && $_POST['action'] == appBook()->slug.'_edit_opening' && isset($_POST['data']) )
{
	$opening_id = (int)$_POST['data'];
	$current = appBook()->app->opening->getSingle($opening_id);
	$service_id = $current->service_id;
	$start = explode(':', $current->start);
	$end = explode(':', $current->end);
	$day = $current->day;
	$form_action = 'opening_edit';
	$form_id = 'edit-service';
}
else
{
	$form_id = 'new-service';
	$form_action = 'opening_new';
	/*$services = $app->app->service->datas;
	$dataServices = array();
	foreach ($services as $service) {
		$exist = $app->app->opening->filterByService($service->service_id, $_POST['day']);
		if (!$exist)
			$dataServices[] = array($service->service_id, $service->service_name);

	}*/
}
?>
<form id="<?php echo $form_id ?>"  class="<?php echo $app->slug; ?>_form form-horizontal container-fluid" method="POST" action="">
<?php
/*if (!isset($current))
{
?>
	<div class="form-group col-xs-12">
	    <label for="service_id" class="col-xs-4 control-label"><?php echo __('Service', $app->slug) ?> *</label>
	    <div class="col-xs-8">
    		<select id="service_id" class="form-control" name="<?php echo $form_action ?>[service_id]">
	    	<?php
			foreach ($dataServices as $value) {
	    	?>
	    		<option value="<?php echo $value[0] ?>"><?php echo $value[1] ?></option>
	    	<?php		
	    	}
	    	?>
    		</select>
		</div>
  	</div>
<?php
}*/
?>
	<div class="form-group col-xs-12">
		<h5 class="col-xs-offset-4 col-xs-8"><?php _e('Début', $app->slug); ?></h5>
	    <label for="start-hour" class="col-xs-4 control-label"><?php echo __('Heure', $app->slug) ?> *</label>
	    <div class="col-xs-8">
    		<input type="number" class="form-control" step="1" id="start-hour" min="0" max="23" name="<?php echo $form_action; ?>[start-hour]" value="<?php echo ( isset($current) ? $start[0] : '' ) ?>" required />
		</div>
	</div>
	<div class="form-group col-xs-12">
    	<label for="start-minute" class="col-xs-4 control-label"><?php echo __('Minute', $app->slug) ?> *</label>
    	<div class="col-xs-8">
    		<input type="number" class="form-control" id="start-minute" step="1" min="0" max="59" name="<?php echo $form_action; ?>[start-minute]" value="<?php echo ( isset($current) ? $start[1] : '' ) ?>" required />
		</div>
  	</div>
  	<div class="form-group col-xs-12">
  		<h5 class="col-xs-offset-4 col-xs-8"><?php _e('Fin', $app->slug); ?></h5>
	    <label for="end-hour" class="col-xs-4 control-label"><?php echo __('Heure', $app->slug) ?> *</label>
	    <div class="col-xs-8">
    		<input type="number" class="form-control" step="1" id="end-hour" min="0" max="23" name="<?php echo $form_action; ?>[end-hour]" value="<?php echo ( isset($current) ? $end[0] : '' ) ?>" required />
		</div>
	</div>
	<div class="form-group col-xs-12">
    	<label for="minute" class="col-xs-4 control-label"><?php echo __('Minute', $app->slug) ?> *</label>
    	<div class="col-xs-8">
    		<input type="number" class="form-control" id="end-minute" step="1" min="0" max="59" name="<?php echo $form_action; ?>[end-minute]" value="<?php echo ( isset($current) ? $end[1] : '' ) ?>" required />
		</div>
  	</div>
	<?php 
	if ( isset($current) )
	{
	?>
		<input type="hidden" name="<?php echo $form_action ?>[opening_id]" value="<?php echo $opening_id; ?>" >
		<input type="hidden" name="<?php echo $form_action ?>[day]" value="<?php echo $day; ?>" >
	<?php
	}
	else
	{
	?>
		<input type="hidden" name="<?php echo $form_action ?>[day]" value="<?php echo $_POST['day']; ?>" >
	<?php
	}
	?>
	<?php wp_nonce_field( $form_action, $app->slug.'_'.$form_action ) ?>
</form>