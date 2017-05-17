<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( isset($_POST['action']) && $_POST['action'] == appBook()->slug.'_edit_service' && isset($_POST['data']) )
{
	$service_id = (int)$_POST['data'];
	$current = appBook()->app->service->getSingle($service_id);
	$form_action = 'service_edit';
}
else
	$form_action = 'service_new';
$app = appBook();
?>
<div class="page-header row">
	<h2>
		<?php if (isset($current))
			echo __('Modifier un service', $app->slug);
		else
			echo __('Ajouter un nouveau service', $app->slug);
		?>
	</h2>
</div>
<form id="<?php echo $app->slug; ?>_app<?php echo '_'.$form_action?>"  class="<?php echo $app->slug; ?>_form form-horizontal col-xs-12 col-sm-8" method="POST" action="">
	<div class="form-group">
	    <label for="service_name" class="col-xs-12 col-sm-4 control-label"><?php echo __('Nom du service', $app->slug) ?> *</label>
	    <div class="col-xs-12 col-sm-6">
	    	<input type="text" class="form-control" id="service_name" name="<?php echo $form_action; ?>[service_name]" placeholder="<?php echo __('Nom du service', $app->slug) ?>" value="<?php echo ( isset($current) ? stripslashes($current->service_name) : '' ); ?>" required />
	    </div>
  	</div>
	<div class="form-group">
	    <label for="duration" class="col-xs-12 col-sm-4 control-label"><?php echo __('Durée du service', $app->slug) ?> *</label>
	    <div class="col-xs-12 col-sm-6">
	    	 <div class="input-group">
	    		<input type="number" min="1" class="form-control" id="duration" name="<?php echo $form_action; ?>[duration]" placeholder="<?php echo __('Durée du service', $app->slug) ?>" value="<?php echo ( isset($current) ? stripslashes($current->duration) : '' ); ?>" required />
	    		<span class="input-group-addon"><?php _e('minutes', $app->slug) ?></span>
    		</div>
	    </div>
  	</div>
  	<div class="form-group">
  		<label for="description" class="col-xs-12 col-sm-4 control-label"><?php echo __('Description', $app->slug) ?> *</label>
  		<div class="col-xs-12 col-sm-6">
  			<textarea name="<?php echo $form_action; ?>[description]" id="description" class="form-control" rows="4" placeholder="<?php echo __('Description', $app->slug) ?>"><?php echo ( isset($current) ? stripslashes($current->description) : '' ); ?></textarea>
		</div>
  	</div>
  	<?php 
  	if(isset($current)){
  		if($current->price == ''){
  			$checked = "";
  			$price_field_style = 'style="display:none"';
  		}
  		else{
  			$checked = "checked";
  			$price_field_style = 'style="display:block"';
  		}
  	}
  	else{
  		$checked = "";
  		$price_field_style = 'style="display:none"';
  	}
  	?>
  	<div class="form-group">
  		<label for="switch-displyaPrice" class="col-xs-12 col-sm-4 control-label"><?php echo __('Afficher le prix', $app->slug) ?></label>
  		<div class="col-xs-12 col-sm-8 yesno">
  			<div class="btn-group" >
  				<input id="switch-displyaPrice" class="switch-checkbox" value="1" <?php echo $checked; ?> name="<?php echo $form_action; ?>[display_price]" type="checkbox" />
  			</div>
		</div>
  	</div>
	<div class="form-group" id="price-field" <?php echo $price_field_style ?>>
	    <label for="price" class="col-xs-12 col-sm-4 control-label"><?php echo __('Prix', $app->slug) ?> </label>
	    <div class="col-xs-12 col-sm-4">
	    	 <div class="input-group">
	    		<input type="text" class="form-control" id="price" name="<?php echo $form_action; ?>[price]" value="<?php echo ( (isset($current) && $current->price != '') ? stripslashes($current->price) : '' ); ?>" />
	    		<span class="input-group-addon"><?php echo $app->app->datas->currency ?></span>
    		</div>
	    </div>
  	</div>
  	<div class="clearfix"></div><hr />
  	<div class="control-group">
		<div class="col-xs-12 col-sm-offset-4 col-sm-8">
			<button type="button" onclick="javascript: location.assign(location.href);" class="btn btn-default"><?php echo __('Annuler', $app->slug); ?></button>
			<input class="btn btn-primary" name="<?php echo $app->slug; ?>_app" type="submit" value="<?php echo  ( isset($current) ? __('Sauvegarder', $app->slug) : __('Ajouter', $app->slug) ) ?>">
		</div>
	</div>
	<?php 
	if ( isset($current) )
	{
	?>
		<input type="hidden" name="<?php echo $form_action ?>[service_id]" value="<?php echo $service_id; ?>" >
	<?php } ?>
	<?php wp_nonce_field( $form_action, $app->slug.'_'.$form_action ) ?>
</form>
<script type="text/javascript">
jQuery(function(){
	jQuery('#switch-displyaPrice').bootstrapToggle({
		on: '<?php echo __("OUI", $app->slug) ?>',
  		off: '<?php echo __("NON", $app->slug) ?>',
  		onstyle: 'success',
  		offstyle: 'danger'
	});
	jQuery('#switch-displyaPrice').change(function() {
		if (!jQuery(this).prop('checked')) {
			jQuery('#price-field').hide();
			// jQuery('#price').val('');
		} else {
			jQuery('#price-field').show();
		}
	});
});
</script>