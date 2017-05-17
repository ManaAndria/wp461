<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$app = appBook();
$services = $app->app->service->datas;
$employees = $app->app->employee->datas;
if ( isset($_POST['action']) && $_POST['action'] == appBook()->slug.'_edit_holiday' && isset($_POST['data']) )
{
	$holiday_id = (int)$_POST['data'];
	$current = appBook()->app->holiday->getSingle($holiday_id);
	$form_action = 'holiday_edit';
}
else
	$form_action = 'holiday_new';
?>
<div class="page-header row">
	<h2>
		<?php if (isset($current))
			echo __('Modifier un congé', $app->slug);
		else
			echo __('Ajouter un nouveau congé', $app->slug);
		?>
	</h2>
</div>
<form id="<?php echo $app->slug; ?>_app<?php echo '_'.$form_action?>"  class="<?php echo $app->slug; ?>_form form-horizontal col-xs-12 col-sm-8" method="POST" action="">
	
  	<div class="form-group">
	    <label for="employee_id" class="col-xs-12 col-sm-4 control-label"><?php echo __('Employé(e)', $app->slug) ?> *</label>
	    <div class="col-xs-12 col-sm-8">
	    	<!-- <select class="form-control" onchange="getService(this.value)" id="employee_id" name="<?php echo $form_action; ?>[employee_id]"> -->
	    	<select class="form-control" id="employee_id" name="<?php echo $form_action; ?>[employee_id]">
	    		<option value="0"><?php echo __('Séléctionner un(e) employé(e)', $app->slug) ?></option>
	    	<?php
	    		foreach ($employees as $employee) {
	    			$selected_employee = "";
	    			if(isset($current) && (int)$employee->employee_id == (int)$current->employee_id) {
	    				$selected_employee = 'selected = "selected"';
	    			}
	    			echo '<option '.$selected_employee.' value="'.$employee->employee_id.'">'.$employee->firstname.' '.$employee->lastname.'</option>';
	    		}
	    	?>
	    	</select>
    	</div>
  	</div>
  	<!-- <div class="form-group">
	    <label for="service_id" class="col-xs-12 col-sm-4 control-label"><?php echo __('Service', $app->slug) ?> *</label>
	    <div class="col-xs-12 col-sm-8">
	    	<?php
	    		$disabled_service_id = (isset($current) ? '' : 'disabled="true"');
	    	?>
	    	<select class="form-control" id="service_id" <?php echo $disabled_service_id; ?> name="<?php echo $form_action; ?>[service_id]">
	    	<?php
	    	if (isset($current)) {
	    		$postes = json_decode($app->app->employee->getSingle((int)$current->employee_id)->poste);
	    		$selected_poste = "";
				for($i=0; $i < count($postes); $i++) {
					if ((int)$postes[$i] == (int)$current->service_id)
						$selected_poste = 'selected="selected"';
					echo '<option '.$selected_poste.' value="'.$postes[$i].'">'.$app->app->service->getServiceName($postes[$i]).'</option>';
				}
	    	}
	    	?>
	    	</select>
	    	<label for="service_id" style="display: none;" id="loading-service" class="select-group-addon"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></label>
    	</div>
  	</div> -->

  	<div class="form-group">
	    <label for="all_day" class="col-xs-12 col-sm-4 control-label"><?php echo __('Une journée ?', $app->slug) ?></label>
	    <div class="col-xs-12 col-sm-8 yesno">
	    	<div class="btn-group" >
	    		<?php
	    			$checked_one_day = "checked";
	    			$styled_one_time = "style='display:block;'";
	    			$styled_one_time_show = "style='display:none;'";
	    			if (isset($current) && !(int)$current->one_day) {
	    				$checked_one_day = "";
	    				$styled_one_time = "style='display:none;'";
	    				$styled_one_time_show = "style='display:block;'";
	    			}
	    		?>
				<input id="switch-onDayText" class="switch-checkbox" value="1" <?php echo $checked_one_day; ?> name="<?php echo $form_action; ?>[one_day]" type="checkbox" />
			</div>
    	</div>
  	</div>

  	<!-- <div class="form-group" style="display: none;" id="holiday_date_start"> -->
  	<div class="form-group" <?php echo $styled_one_time_show ?> id="holiday_date_start">
	    <label for="date" class="col-xs-12 col-sm-4 control-label"><?php echo __('Date de début', $app->slug) ?> *</label>
	    <div class="col-xs-12 col-sm-4">
		    <div class="input-group">
		    	<input type="text" class="form-control date" id="date_start" name="<?php echo $form_action; ?>[date_start]" value="<?php echo ( isset($current) ? date('d-m-Y', strtotime($current->date_start)) : date('d-m-Y') ); ?>" required readonly />
		    	<label for="date_start" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
	    	</div>
	    </div>
  	</div>

  	<div class="form-group" <?php echo $styled_one_time_show ?> id="holiday_date_end">
	    <label for="date" class="col-xs-12 col-sm-4 control-label"><?php echo __('Date fin', $app->slug) ?> *</label>
	    <div class="col-xs-12 col-sm-4">
		    <div class="input-group">
		    	<input type="text" class="form-control date" id="date_end" name="<?php echo $form_action; ?>[date_end]" value="<?php echo ( isset($current) ? date('d-m-Y', strtotime($current->date_end)) : date('d-m-Y') ); ?>" required readonly />
		    	<label for="date_end" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
	    	</div>
	    </div>
  	</div>

  	<div class="form-group" id="holiday_date" <?php echo $styled_one_time ?>>
	    <label for="date" class="col-xs-12 col-sm-4 control-label"><?php echo __('Date', $app->slug) ?> *</label>
	    <div class="col-xs-12 col-sm-4">
		    <div class="input-group">
		    	<input type="text" class="form-control date" id="date" name="<?php echo $form_action; ?>[date]" placeholder="<?php echo __('Début', $app->slug) ?>" value="<?php echo ( isset($current) ? date('d-m-Y', strtotime($current->date)) : date('d-m-Y') ); ?>" required readonly />
		    	<label for="date" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
	    	</div>
	    </div>
  	</div>

  	<div class="form-group" <?php echo $styled_one_time; ?> id="all_day" >
	    <label for="all_day" class="col-xs-12 col-sm-4 control-label"><?php echo __('Toute la journée ?', $app->slug) ?></label>
	    <div class="col-xs-12 col-sm-8 yesno">
	    	<div class="btn-group" >
	    		<?php
	    			$checked_all_day = "checked";
	    			$styled_time = "style='display:none;'";
	    			if (isset($current) && (int)$current->one_day && !(int)$current->all_day) {
	    				$checked_all_day = "";
	    				$styled_time = "style='display:block;'";
	    			}
	    		?>
				<input id="switch-onText" class="switch-checkbox" value="1" <?php echo $checked_all_day; ?> name="<?php echo $form_action; ?>[all_day]" type="checkbox" />
			</div>
    	</div>
  	</div>
  	<div class="form-group start-block" <?php echo $styled_time; ?> >
	    <label for="h_start" class="col-xs-12 col-sm-4 control-label"><?php echo __('Debut', $app->slug) ?></label>
	    <label for="m_start" class="col-xs-12 col-sm-2 control-label"><?php echo __('Heure', $app->slug) ?></label>
	    <div class="col-xs-12 col-sm-2">
	    	<?php
	    		$h_start = 00;
	    		$m_start = 00;
	    		$h_end = 00;
	    		$m_end = 00;

	    		if(isset($current) && !(int)$current->all_day) {
	    			$start_time = explode(':', $current->start);
	    			$h_start = $start_time[0];
	    			$m_start = $start_time[1];

	    			$end_time = explode(':', $current->end);
	    			$h_end = $end_time[0];
	    			$m_end = $end_time[1];
	    		}
	    	?>
	    	<input type="number" class="form-control" maxlength="2" step="1" min="0" max="23" id="h_start" name="<?php echo $form_action; ?>[h_start]" value="<?php echo $h_start; ?>" />
    	</div>
    	<label for="end" class="col-xs-12 col-sm-2 control-label"><?php echo __('Minute', $app->slug) ?></label>
	    <div class="col-xs-12 col-sm-2">
	    	<input type="number" class="form-control" maxlength="2" step="1" min="0" max="59" id="m_start" name="<?php echo $form_action; ?>[m_start]" value="<?php echo $m_start; ?>" />
    	</div>
  	</div>
  	<div class="form-group end-block" <?php echo $styled_time; ?> >
	    <label for="h_end" class="col-xs-12 col-sm-4 control-label"><?php echo __('Fin', $app->slug) ?></label>
	    <label for="m_end" class="col-xs-12 col-sm-2 control-label"><?php echo __('Heure', $app->slug) ?></label>
	    <div class="col-xs-12 col-sm-2">
	    	<input type="number" class="form-control" step="1" min="0" max="23" id="h_end" name="<?php echo $form_action; ?>[h_end]" value="<?php echo $h_end; ?>" />
    	</div>
    	<label for="end" class="col-xs-12 col-sm-2 control-label"><?php echo __('Minute', $app->slug) ?></label>
	    <div class="col-xs-12 col-sm-2">
	    	<input type="number" class="form-control" step="1" min="0" max="59" id="m_end" name="<?php echo $form_action; ?>[m_end]" value="<?php echo $m_end; ?>" />
    	</div>
  	</div>
  	
  	<div class="clearfix"></div><hr />
  	<div class="control-group">
		<div class="col-xs-12 col-sm-offset-4 col-sm-8">
			<button type="button" onclick="javascript: location.assign(location.href);" class="btn btn btn-default"><?php echo __('Annuler', $app->slug); ?></button>
			<input class="btn btn btn-primary" name="<?php echo $app->slug; ?>_app" type="submit" value="<?php echo ( isset($current) ? __('Sauvegarder', $app->slug) : __('Ajouter', $app->slug) ) ?>">
			<span style="display: none;" id="loading-service" class="select-group-addon"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></span>
		</div>
	</div>
	<?php 
	if ( isset($current) )
	{
	?>
		<input type="hidden" name="<?php echo $form_action ?>[holiday_id]" value="<?php echo $holiday_id; ?>" >
	<?php } ?>
	<?php wp_nonce_field( $form_action, $app->slug.'_'.$form_action ) ?>
</form>
<input type="hidden" id="app_id" name="app_id" value="<?php echo $app->app->app_id; ?>" >
<input type="hidden" id="validate_one_not_all_day" name="validate_one_not_all_day" value="0" >
	<script type="text/javascript">
		jQuery(function(){
			jQuery('#date').datepicker({
				dateFormat: 'dd-mm-yy',
				changeYear: true,
				changeMonth: true,
				onClose: function(value){
					jQuery('#end').datepicker('option', 'minDate', new Date());
				}
			});
			jQuery('#date_start').datepicker({
				dateFormat: 'dd-mm-yy',
				changeYear: true,
				changeMonth: true,
				onClose: function(value){
					var min = value.split('-');
					var newMin = new Date(min[2], min[1]-1, +min[0]+1);
					jQuery('#date_end').datepicker('option', 'minDate', newMin);
				}
			});
			jQuery('#date_end').datepicker({
				dateFormat: 'dd-mm-yy',
				changeYear: true,
				changeMonth: true,
				onClose: function(value){
					var max = value.split('-');
					var newMax = new Date(max[2], max[1]-1, +max[0]-1);
					jQuery('#date_start').datepicker('option', 'maxDate', newMax);
				}
			});
			jQuery('#switch-onText').bootstrapToggle({
				on: '<?php echo __("OUI", $app->slug) ?>',
	      		off: '<?php echo __("NON", $app->slug) ?>',
	      		onstyle: 'success',
	      		offstyle: 'danger'
			});
			jQuery('#switch-onText').change(function() {
				if (!jQuery(this).prop('checked')) {
					jQuery('.start-block').show();
					jQuery('.end-block').show();
					jQuery('#switch-onText').val(0);

					jQuery('#h_start').val(0);
					jQuery('#h_end').val(0);
					jQuery('#m_start').val(0);
					jQuery('#m_end').val(0);
				} else {
					jQuery('.start-block').hide();
					jQuery('.end-block').hide();
					jQuery('#switch-onText').val(1);

				}
			});

			jQuery('#switch-onDayText').bootstrapToggle({
				on: '<?php echo __("OUI", $app->slug) ?>',
	      		off: '<?php echo __("NON", $app->slug) ?>',
	      		onstyle: 'success',
	      		offstyle: 'danger'
			});
			jQuery('#switch-onDayText').change(function() {
				if (!jQuery(this).prop('checked')) {
					jQuery('#all_day').hide();
					jQuery('#holiday_date_start').show();
					jQuery('#holiday_date_end').show();
					jQuery('#holiday_date').hide();
					/*jQuery('.end-block').show();*/
					jQuery('#switch-onDayText').val(0);

					jQuery('#h_start').val(0);
					jQuery('#h_end').val(0);
					jQuery('#m_start').val(0);
					jQuery('#m_end').val(0);

					jQuery('.start-block').hide();
					jQuery('.end-block').hide();
					jQuery('#switch-onText').val(0);
				} else {
					jQuery('.start-block').hide();
					jQuery('.end-block').hide();
					jQuery('#all_day').show();
					jQuery('#holiday_date_start').hide();
					jQuery('#holiday_date_end').hide();
					jQuery('#holiday_date').show();
					jQuery('#switch-onDayText').val(1);
					jQuery('#switch-onText').val(1);

					jQuery('#h_start').val(0);
					jQuery('#h_end').val(0);
					jQuery('#m_start').val(0);
					jQuery('#m_end').val(0);

					jQuery('.start-block').hide();
					jQuery('.end-block').hide();

				}
			});
		});
	</script>