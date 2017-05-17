<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$app = appBook();
$services = $app->app->service->datas;
if ( isset($_POST['action']) && $_POST['action'] == appBook()->slug.'_edit_employee' && isset($_POST['data']) )
{
	$employee_id = (int)$_POST['data'];
	$current = appBook()->app->employee->getSingle($employee_id);
	$form_action = 'employee_edit';
}
else
	$form_action = 'employee_new';
?>
<div class="page-header row">
	<h2>
		<?php if (isset($current))
			echo __('Modifier un employé', $app->slug);
		else
			echo __('Ajouter un nouvel employé', $app->slug);
		?>
	</h2>
</div>
<form id="<?php echo $app->slug; ?>_app<?php echo '_'.$form_action?>"  class="<?php echo $app->slug; ?>_form form-horizontal col-xs-12 col-sm-8" method="POST" action="">
	<div class="form-group">
	    <label for="firstname" class="col-xs-12 col-sm-4 control-label"><?php echo __('Prénom', $app->slug) ?> *</label>
	    <div class="col-xs-12 col-sm-8">
	    	<input type="text" class="form-control" id="firstname" name="<?php echo $form_action; ?>[firstname]" placeholder="<?php echo __('Prénom', $app->slug) ?>" value="<?php echo ( isset($current) ? stripslashes($current->firstname) : '' ) ?>" required />
	    </div>
  	</div>
  	<div class="form-group">
	    <label for="lastname" class="col-xs-12 col-sm-4 control-label"><?php echo __('Nom', $app->slug) ?> *</label>
	    <div class="col-xs-12 col-sm-8">
	    	<input type="text" class="form-control" id="lastname" name="<?php echo $form_action; ?>[lastname]" placeholder="<?php echo __('Nom', $app->slug) ?>" value="<?php echo ( isset($current) ? stripslashes($current->lastname) : '' ) ?>" required />
    	</div>
  	</div>
  	<div class="form-group">
	    <label for="email" class="col-xs-12 col-sm-4 control-label"><?php echo __('Email', $app->slug) ?> *</label>
	    <div class="col-xs-12 col-sm-8">
	    	<input type="email" class="form-control" id="email" name="<?php echo $form_action; ?>[email]" placeholder="<?php echo __('Email', $app->slug) ?>" value="<?php echo ( isset($current) ? $current->email : '' ) ?>" required />
    	</div>
  	</div>
  	<div class="form-group">
	    <label for="country_code" class="col-xs-12 col-sm-4 control-label"><?php echo __('Code pays', $app->slug) ?></label>
	    <div class="col-xs-12 col-sm-8">
	    	<input type="text" class="form-control" id="country_code" name="<?php echo $form_action; ?>[country_code]" placeholder="<?php echo __('Code pays', $app->slug) ?>" value="<?php echo ( isset($current) ? $current->country_code : '' ) ?>" />
    	</div>
  	</div>
  	<div class="form-group">
	    <label for="phonenumber" class="col-xs-12 col-sm-4 control-label"><?php echo __('Téléphone', $app->slug) ?></label>
	    <div class="col-xs-12 col-sm-8">
	    	<input type="text" class="form-control" id="phonenumber" name="<?php echo $form_action; ?>[phonenumber]" placeholder="<?php echo __('Téléphone', $app->slug) ?>" value="<?php echo ( isset($current) ? $current->phonenumber : '' ) ?>" />
    	</div>
  	</div>
	<div class="form-group">
	    <label for="poste" class="col-xs-12 col-sm-4 control-label"><?php echo __('Service(s)', $app->slug) ?> *</label>
	    <div class="col-xs-12 col-sm-8">
	    	<select class="form-control" name="<?php echo $form_action; ?>[poste][]" id="poste" multiple="multiple">
	    		<?php
	    		if ($current)
	    		{
	    			$postes = json_decode($current->poste);
	    		}
	    		foreach ($services as $service) {
	    			if ($current && in_array($service->service_id, $postes))
		    		{
		    			$selected = $service->service_id;
		    		}
		    		else
		    			$selected = '';
	    			echo '<option value="'.$service->service_id.'"'.($selected == $service->service_id ? " selected" : "").'>'.$service->service_name.'</option>';
	    		}
	    		?>
	    	</select>
	    </div>
  	</div>
  	<div class="clearfix"></div><hr />
  	<div class="control-group">
		<div class="col-xs-12 col-sm-offset-4 col-sm-8">
			<button type="button" onclick="javascript: location.assign(location.href);" class="btn btn btn-default"><?php echo __('Annuler', $app->slug); ?></button>
			<input class="btn btn btn-primary" name="<?php echo $app->slug; ?>_app" type="submit" value="<?php echo ( isset($current) ? __('Sauvegarder', $app->slug) : __('Ajouter', $app->slug) ) ?>">
		</div>
	</div>
	<?php 
	if ( isset($current) )
	{
	?>
		<input type="hidden" name="<?php echo $form_action ?>[employee_id]" value="<?php echo $employee_id; ?>" >
	<?php } ?>
	<?php wp_nonce_field( $form_action, $app->slug.'_'.$form_action ) ?>
</form>
<script type="text/javascript">
	jQuery('#poste').multiselect({
    	allSelectedText: 'Tous',
    	numberDisplayed: 1,
    	nSelectedText: 'selectionnés',
    	nonSelectedText: 'Aucun',
    	includeSelectAllOption: true,
    	selectAllText : 'Tous'
    });
</script>