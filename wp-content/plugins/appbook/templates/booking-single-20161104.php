<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$app = appBook();
$booking_id = get_query_var( 'booking', false );

$booking_id = (int)$booking_id;
$services = $app->app->service->datas;
if ($booking_id !== 0)
{
	$current = $app->app->booking->getSingle($booking_id);
	$employees = $app->app->employee->getByPoste($current->service_id);
	$form_action = 'booking-edit';
	$action = '';
}else
{
	$employees = $app->app->employee->getByPoste($services[0]->service_id);
	$form_action = 'booking-new';
	$action = site_url('/rendez-vous/');
}
?>
<div id="stats-loading" style="display: none;"><div class="stats-loading-anim"></div></div>
<div id="booking-single">
	<div class="page-header row">
		<h2>
			<?php if (isset($current))
				echo __('Modifier un rendez-vous', $app->slug);
			else
				echo __('Ajouter un rendez-vous', $app->slug);
			?>
		</h2>
	</div>
	<form id="<?php echo $app->slug; ?>_app<?php echo '_'.$form_action?>"  class="<?php echo $app->slug; ?>_form form-horizontal col-xs-12 col-sm-8" method="POST" action="<?php echo $action ?>">
		<h4 class="col-xs-12 col-sm-offset-4 col-sm-8"><?php _e('Client', $app->slug) ?></h4>
		<div class="form-group">
		    <label for="firstname" class="col-xs-12 col-sm-4 control-label"><?php echo __('Prénom', $app->slug) ?> *</label>
		    <div class="col-xs-12 col-sm-8">
		    	<input type="text" class="form-control" id="firstname" name="<?php echo $form_action; ?>[userfirstname]" placeholder="<?php echo __('Prénom', $app->slug) ?>" value="<?php echo ( isset($current) ? stripslashes($current->firstname) : '' ) ?>" required />
		    </div>
	  	</div>
	  	<div class="form-group">
		    <label for="lastname" class="col-xs-12 col-sm-4 control-label"><?php echo __('Nom', $app->slug) ?> *</label>
		    <div class="col-xs-12 col-sm-8">
		    	<input type="text" class="form-control" id="lastname" name="<?php echo $form_action; ?>[username]" placeholder="<?php echo __('Nom', $app->slug) ?>" value="<?php echo ( isset($current) ? stripslashes($current->lastname) : '' ) ?>" required />
	    	</div>
	  	</div>
	  	<div class="form-group">
		    <label for="email" class="col-xs-12 col-sm-4 control-label"><?php echo __('Email', $app->slug) ?> *</label>
		    <div class="col-xs-12 col-sm-8">
		    	<input type="email" class="form-control" id="email" name="<?php echo $form_action; ?>[useremail]" placeholder="<?php echo __('Email', $app->slug) ?>" value="<?php echo ( isset($current) ? $current->email : '' ) ?>" required />
	    	</div>
	  	</div>
	  	<div class="form-group">
		    <label for="phonenumber" class="col-xs-12 col-sm-4 control-label"><?php echo __('Téléphone', $app->slug) ?> *</label>
		    <div class="col-xs-12 col-sm-8">
		    	<input type="text" class="form-control" id="phonenumber" name="<?php echo $form_action; ?>[userphone]" placeholder="<?php echo __('Téléphone', $app->slug) ?>" value="<?php echo ( isset($current) ? $current->phonenumber : '' ) ?>" required />
	    	</div>
	  	</div>
	  	<div class="form-group">
		    <label for="message" class="col-xs-12 col-sm-4 control-label"><?php echo __('Message', $app->slug) ?></label>
		    <div class="col-xs-12 col-sm-8">
		    	<textarea rows="3" class="form-control" id="message" name="<?php echo $form_action; ?>[usermessage]"><?php echo ( isset($current) ? $current->message : '' ) ?></textarea>
	    	</div>
	  	</div>
	  	<h4 class="col-xs-12 col-sm-offset-4 col-sm-8"><?php _e('Détails du rendez-vous', $app->slug) ?></h4>
	  	<?php
	  	$service_options = '';
	  	foreach ($services as $service) {
	  		$service_options .= '<option value="'.$service->service_id.'"'.($service->service_id == $current->service_id ? ' selected' : '').'>'.$service->service_name.'</option>';
	  	} ?>
	  	<div class="form-group">
	  		<label for="service_id" class="col-xs-12 col-sm-4 control-label"><?php echo __('Service', $app->slug) ?> *</label>
	  		<div class="col-xs-12 col-sm-8">
			  	<select class="form-control" id="service_id" name="<?php echo $form_action; ?>[service_id]" onchange="getEmployee(false)">
			  		<?php echo $service_options; ?>
			  	</select>
		  	</div>
	  	</div>
	  	<?php
	  	$employee_options = '';
	  	if (isset($current))
	  	{
		  	foreach ($employees as $employee) {
		  		$employee_options .= '<option value="'.$employee->employee_id.'"'.($employee->employee_id == $current->employee_id ? ' selected' : '').'>'.$employee->firstname.' '.$employee->lastname.'</option>';
		  	}
	  	}
	  	?>
	  	<div class="form-group">
	  		<label for="employee_id" class="col-xs-12 col-sm-4 control-label"><?php echo __('Employé(e)', $app->slug) ?> *</label>
	  		<div class="col-xs-12 col-sm-8">
			  	<select class="form-control" id="employee_id" name="<?php echo $form_action; ?>[employee_id]" onchange="getPeriode(false)">
			  		<?php echo $employee_options; ?>
			  	</select>
		  	</div>
	  	</div>
	  	<div class="form-group">
	  		<label for="date" class="col-xs-12 col-sm-4 control-label"><?php echo __('Date', $app->slug) ?> *</label>
	  		<div class="col-xs-12 col-sm-4">
		    	<div class="input-group">
			  		<input type="text" class="form-control" id="date" name="<?php echo $form_action; ?>[date]" value="<?php echo ( isset($current) ? date('d-m-Y', strtotime($current->date)) : date('d-m-Y', time()) ) ?>" onchange="getPeriode(false)" readonly />
			  		<label for="date" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
		  		</div>
		  	</div>
	  	</div>
	  	<div class="form-group">
	  		<label for="hour" class="col-xs-12 col-sm-4 control-label"><?php echo __('Heure', $app->slug) ?> *</label>
	  		<div class="col-xs-12 col-sm-3">
		  		<select class="form-control" id="hour" name="<?php echo $form_action; ?>[hour]">
		  			<option value="<?php echo $current->hour ?>" selected><?php echo $current->hour ?></option>
		  		</select>
		  	</div>
	  	</div>
	  	<div class="clearfix"></div><hr />
	  	<div class="control-group">
			<div class="col-xs-12 col-sm-offset-4 col-sm-8">
				<button type="button" onclick="javascript: history.go(-1);" class="btn btn btn-default"><?php echo __('Annuler', $app->slug); ?></button>
				<input class="btn btn btn-primary" name="<?php echo $app->slug; ?>_app" type="submit" value="<?php echo ( isset($current) ? __('Sauvegarder', $app->slug) : __('Enregistrer', $app->slug) ) ?>">
			</div>
		</div>
		<?php if (isset($current)) : ?>
			<input type="hidden" name="<?php echo $form_action ?>[booking_id]" value="<?php echo $current->booking_id; ?>" />
		<?php endif; ?>
		<?php wp_nonce_field( $form_action, $app->slug.'_'.$form_action ) ?>
	</form>
</div>
<script type="text/javascript">
	var isSingle = true;
	jQuery(function(){
		jQuery('#date').datepicker({
			dateFormat: 'dd-mm-yy',
			changeYear: true,
			changeMonth: true,
		});
	});
	jQuery(document).ready(function(){
		//ready
		var currentHour = jQuery('#hour').html();
		if(jQuery('#hour').val() == ''){
			getEmployee(true);
		}else{
			getPeriode(false, true, currentHour);
		}
		//submit
		jQuery('body').on('submit', '#appbook_app_booking-new, #appbook_app_booking-edit', function(){
			if( jQuery('#firstname').val() == '' )
			{
				alert('<?php echo __('Veuillez remplir le champ ', $app->slug).__('Prénom', $app->slug); ?>')
				jQuery('#firstname').focus();
				return false;
			}
			if( jQuery('#lastname').val() == '' )
			{
				alert('<?php echo __('Veuillez remplir le champ ', $app->slug).__('Nom', $app->slug); ?>')
				jQuery('#lastname').focus();
				return false;
			}
			if( jQuery('#email').val() == '' )
			{
				alert('<?php echo __('Veuillez remplir le champ ', $app->slug).__('Email', $app->slug); ?>')
				jQuery('#email').focus();
				return false;
			}
			if( jQuery('#phonenumber').val() == '' )
			{
				alert('<?php echo __('Veuillez remplir le champ ', $app->slug).__('Téléphone', $app->slug); ?>')
				jQuery('#phonenumber').focus();
				return false;
			}
			if( jQuery('#service_id').val() == '' )
			{
				alert('<?php echo __('Veuillez choisir ', $app->slug).__('un service', $app->slug); ?>')
				jQuery('#service_id').focus();
				return false;
			}
			if( jQuery('#employee_id').val() == '' )
			{
				alert('<?php echo __('Veuillez choisir ', $app->slug).__('un(e) employé(e)', $app->slug); ?>')
				jQuery('#employee_id').focus();
				return false;
			}
			if( jQuery('#date').val() == '' )
			{
				alert('<?php echo __('Veuillez choisir ', $app->slug).__('une date', $app->slug); ?>')
				jQuery('#date').focus();
				return false;
			}
			if( jQuery('#hour').val() == '' )
			{
				alert('<?php echo __('Veuillez choisir ', $app->slug).__('une heure', $app->slug); ?>')
				jQuery('#hour').focus();
				return false;
			}
		});
	});
	function getEmployee(hideAlert){
		jQuery('#stats-loading').show();
		jQuery.post(
			'<?php echo admin_url( 'admin-ajax.php' ) ?>',
			{
				'action': '<?php echo appBook()->slug."_get_employees"; ?>',
				'id_service': jQuery('#service_id').val()
			},
			function(response){
		        jQuery('#employee_id').html(response);
				jQuery('#stats-loading').hide();
				if (hideAlert === true)
		        	getPeriode(true);
		        else
		        	getPeriode();
		    }
		);
	}
	function getPeriode(hideAlert, onLoad, content){
		jQuery('#stats-loading').show();
		var cDate = new Date(parseInt(jQuery('#date').val().split('-')[2]), parseInt(jQuery('#date').val().split('-')[1]-1), parseInt(jQuery('#date').val().split('-')[0]));
		jQuery.post(
			'<?php echo site_url('/getperoides.php') ?>',
			{
				'id_employee': jQuery('#employee_id').val(),
				'id_service': jQuery('#service_id').val(),
				'num_day': cDate.getDay(),
				'app_id': <?php echo $app->app->app_id ?>,
				'appointment_date': jQuery('#date').val().split('-')[2]+'-'+jQuery('#date').val().split('-')[1]+'-'+jQuery('#date').val().split('-')[0]
			},
			function(response){
		    	if (response == "") {
		    		if (onLoad === true){
		    			jQuery('#hour').html(content);
		    		} else {
		    			if (hideAlert !== true)
			        		alert('<?php echo __('Aucune heure disponible.', $app->slug); ?>');
			        	jQuery('#hour').html('<option value=""><?php echo __('Aucune', $app->slug); ?></option>');
		        	}
		    	}
		        else{
	        		var res = JSON.parse(response);
		        	var responseOptions = '';
		        	var key;
		        	for (key in res) {
				        if (res.hasOwnProperty(key)) {
				        	responseOptions += '<option value="'+res[key]+'">'+res[key]+'</option>';
				        }
				    }
			        jQuery('#hour').html(responseOptions);
		        }
		        if (onLoad === true){
		        	jQuery('#hour').prepend(content);
		        }
				jQuery('#stats-loading').hide();
		    }
		);
	}
</script>