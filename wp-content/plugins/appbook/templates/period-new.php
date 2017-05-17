<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$app = appBook();
if ( isset($_POST['action']) && $_POST['action'] == appBook()->slug.'_edit_period' && isset($_POST['data']) )
{
	$period_id = (int)$_POST['data'];
	$current = appBook()->app->period->getSingle($period_id);
	$period = explode(':', $current->period);
	$end = explode(':', $current->end);
	$form_action = 'period_edit';
	$employee_id = $current->employee_id;
	$service_id = $current->service_id;
}
else
{
	$employee_id = (int)$_POST['data'];
	$service_id =(int)$_POST['service'];
	$form_action = 'period_new';
}
$employee = $app->app->employee->getSingle($employee_id);
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
<?php 
$openings = $app->app->opening->getOpenings();
if(!count($openings)){ // pas d'ouverture
	echo '<div class="alert alert-warning" role="alert">'.__("Aucun jour d'ouverture n'a été défini, veuillez en définir pour pouvoir ajouter une période.", $app->slug).'</div>';;
}else{
	
// Infos à droite
?>
<div class="alert alert-info pull-right col-xs-12 col-sm-4">
<?php 
echo __('Service : ', $app->slug) .' '. $app->app->service->getServiceName($service_id).' - '.__('durée', $app->slug).' '.$app->app->service->getFieldById($service_id, 'duration').' '.__('minutes', $app->slug).'<br />'. __('Employé : ', $app->slug).$employee->firstname.' '.$employee->lastname;
echo '<div class="clearfix"></div><hr />';

//// Périodes définies
$periods = $app->app->period->getByEmployeeService($employee->employee_id, $service_id);
$days = $app->app->period->getDays();
  	if ($periods !== null)
  	{
  		echo '<h5>'.__("Les périodes définies : ", $app->slug).'</h5>';
  		echo '<ul>'; 
  		foreach ($periods as $_period) {// boucle period
  			$start = explode(':', $_period['period']);
  			$_end = explode(':', $_period['end']);
  			$day = (int)$_period['day'];
  			$period_text = __('de', $app->slug).' '.$start[0].'h'.$start[1].' '.( isset($_end[1]) > 0 ? __('à', $app->slug).' '.$_end[0].'h'.$_end[1] : '' );
  	?>
	    <li id="<?php echo $_period['period_id'] ?>">
	    	<?php echo $days[$day].' : '.$period_text ?>
	    </li>
    <?php
		}
		echo '</ul>';
	}
	else{ ?>
	<div class="text-warning"><?php echo __("Aucune période n'est définie.") ?></div>
    <?php }
//// Fin périodes définies

//// Heures d'ouvertures
if(count($openings)){
	echo '<h5>'.__("Les heures d'ouvertures : ", $app->slug).'</h5>';
	foreach ($openings as $day_key => $values) {
		$day_key = (int)$day_key;
		echo '<div class="pull-left">'.__($days[$day_key], $app->slug).' :</div>';
		echo '<ul class="pull-left" style="list-style:none;margin-left:10px;">';
		foreach ($values as $key => $value) {
			$op_start = explode(':', $value["start"]);
			$op_end = explode(':', $value["end"]);
			echo '<li>';
			echo __('de', $app->slug).' '.$op_start[0].'h'.$op_start[1].' '.( isset($op_end[1]) > 0 ? __('à', $app->slug).' '.$op_end[0].'h'.$op_end[1] : '' );
			echo '</li>';
		}
		echo '</ul>'; 
		echo '<div class="clearfix"></div>'; 
	}
}else{
	echo '<div class="text-warning">'.__("Aucune ouverture n'est définie.").'</div>';
}
//// Fin heures d'ouvertures
?>
</div>
<?php 
// Fin infos à droite
?>
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
	    <label for="day" class="control-label col-xs-6 col-sm-4"><?php echo ( !isset($current) ? __('Jour(s)', $app->slug) : __('Jour', $app->slug)) ?> *</label>
    	<div class="col-xs-6 col-sm-3">
    		<select class="form-control" name="<?php echo $form_action; ?>[day]<?php echo (isset($current) ? '' : "[]"); ?>" id="day"<?php echo (isset($current) ? '' : ' multiple="multiple"'); ?>>
    			<?php 
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
			<input class="btn btn btn-primary" id="<?php echo ( isset($current) ? "submit-edit-period-form" : "submit-new-period-form" ) ?>" type="button" value="<?php echo ( isset($current) ? __('Sauvegarder', $app->slug) : __('Ajouter', $app->slug) ) ?>" />
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
<!-- <script type="text/javascript" src="<?php echo plugins_url().'/'.$app->slug.'/assets/js/bootstrap-multiselect.js' ?>"></script> -->
<?php 
$js_periods = array(0=>array(),1=>array(),2=>array(),3=>array(),4=>array(),5=>array(),6=>array());
foreach ($days as $dk => $dv) {
	foreach ($periods as $pv) {
		if( $pv["day"] == $dk )
			$js_periods[$dk][] = array("start" => $pv["period"], "end" => $pv["end"], "id" => $pv["period_id"]);
	}
}
?>
<script type="text/javascript">
var myUrl = '<?php echo plugins_url().'/'.$app->slug.'/assets/js/bootstrap-multiselect.js' ?>';
jQuery.getScript(myUrl, function(){
// jQuery(function(){
    jQuery('select[name="period_new[day][]"]').multiselect({
    	allSelectedText: 'Tous',
    	numberDisplayed: 1,
    	nSelectedText: 'selectionnés',
    	nonSelectedText: 'Aucun',
    	includeSelectAllOption: true,
    	selectAllText : 'Tous'
    });
});
/* <![CDATA[ */
openings = <?php echo json_encode($app->app->opening->getOpenings()); ?>;
periods = <?php echo json_encode($js_periods); ?>;
allDays = <?php echo json_encode($app->app->period->getDays()); ?>;
/* ]]> */
</script>
<?php } ?>