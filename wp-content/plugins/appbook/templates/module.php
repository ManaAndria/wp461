<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$app = appBook();
$module = $app->app->module->datas;
$color = json_decode($app->app->datas->color);
// var_dump($color);
if($module === null)
{
	$form_action = 'module_new';
	$display = false;
}
else{
	$display = true;
}
?>
<div id="stats-loading" style="display: none;"><div class="stats-loading-anim"></div></div>
<?php 
$wp_session = WP_Session::get_instance();
if (isset($wp_session['display_tooltip'])): ?>
<div class="alert alert-info">
	<div class="pull-left" style="font-size: 32px;margin-right: 10px"><div class="glyphicon glyphicon-info-sign"></div></div>
	<div>Sur cette page, vous avez les options pour personnaliser votre application.<br />Vous pouvez définir les couleurs de fond, les couleurs des textes, les couleurs des boutons, …<br />Vous trouverez aussi une option permettant de paramétrer si vous souhaitez afficher ou pas vos employés sur votre application et une autre option pour générer le module pour votre application.</div>
</div>
<?php endif; ?>
<div class="page-header row">
	<h2>
		<?php if ($display === false)
			echo __('Générer le module', $app->slug);
		else
			echo __('Paramètre du module', $app->slug);
		?>
	</h2>
</div>
<?php if($module === null)
{ ?>
<div class="alert alert-info pull-right col-xs-12 col-sm-4">
<p>Cette partie est essentiel. Elle crée votre application à partir des données et informations que vous avez fournies.</p>
</div>
<form id="<?php echo $app->slug; ?>_app<?php echo '_'.$form_action?>"  class="<?php echo $app->slug; ?>_form form-inline col-xs-12 col-sm-8 pull-left" method="POST" action="">
	<div class="form-group">
	    <label for="folder"><?php _e('Nom de votre dossier', $app->slug) ?></label>
	    <input type="text" class="form-control" id="folder" name="<?php echo $form_action ?>[folder]">
  	</div>
  	<button type="submit" class="btn btn-default"><?php _e('Générer', $app->slug); ?></button>
  	<?php wp_nonce_field( $form_action, $app->slug.'_'.$form_action ) ?>
</form>
<?php }else{ ?>
<p class="alert alert-info "><?php _e('Votre module est prêt. Merci de votre confiance.', $app->slug) ?></p>
<?php } 
$checked = $app->app->datas->display_employee == 1 ? " checked" : "";
?>
<div class="col-xs-12">
	<div class="form-group">
		<label class="control-label"><?php _e("Afficher les employés", $app->slug) ?></label>
		<input id="display_employee" class="switch-checkbox" value="1" type="checkbox" name="display_employee" <?php echo $checked ?> />
	</div>
</div>
<div class="clearfix"></div>
<div class="well well-lg">
	<h3><?php _e("Configuration des couleurs") ?></h3><hr />
	<form  id="update_color" method="post">
		<!-- fond -->
		<div class="form-group">
			<label for="background_color" class="col-xs-12 col-sm-5 control-label"><?php _e("Couleur de fond", $app->slug) ?></label>
			<div id="background_color" class="col-xs-12 col-sm-5 input-group colorpicker-component">
			    <input type="text" name="update_color[background]" value="<?php echo ($color !== null && isset($color->background) ? $color->background : '#ffffff') ?>" class="form-control" />
			    <span class="input-group-addon"><i></i></span>
			<?php if (isset($wp_session['display_tooltip'])): ?>
				<span class="hastooltip input-group-addon"><span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-placement="left" data-html="true"></span></span>
			<?php endif; ?>
			</div>
			<script>
			    jQuery(function() {
			        jQuery('#background_color').colorpicker();
			    });
			</script>
		</div>
		<!-- fond de block -->
		<div class="form-group">
			<label for="background_block" class="col-xs-12 col-sm-5 control-label"><?php _e("Couleur de fond de block de contenu", $app->slug) ?></label>
			<div id="background_block" class="col-xs-12 col-sm-5 input-group colorpicker-component">
			    <input type="text" name="update_color[background_block]" value="<?php echo ($color !== null && isset($color->background_block) ? $color->background_block : '#ffffff') ?>" class="form-control" />
			    <span class="input-group-addon"><i></i></span>
			<?php if (isset($wp_session['display_tooltip'])): ?>
				<span class="hastooltip input-group-addon"><span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-placement="left" data-html="true"></span></span>
			<?php endif; ?>
			</div>
			<script>
			    jQuery(function() {
			        jQuery('#background_block').colorpicker();
			    });
			</script>
		</div>
		<!-- en-tête block -->
		<div class="form-group">
			<label for="background_heading_block" class="col-xs-12 col-sm-5 control-label"><?php _e("Couleur de fond d'en-tête de block de contenu", $app->slug) ?></label>
			<div id="background_heading_block" class="col-xs-12 col-sm-5 input-group colorpicker-component">
			    <input type="text" name="update_color[background_heading_block]" value="<?php echo ($color !== null && isset($color->background_heading_block) ? $color->background_heading_block : '#f5f5f5') ?>" class="form-control" />
			    <span class="input-group-addon"><i></i></span>
			<?php if (isset($wp_session['display_tooltip'])): ?>
				<span class="hastooltip input-group-addon"><span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-placement="left" data-html="true"></span></span>
			<?php endif; ?>
			</div>
			<script>
			    jQuery(function() {
			        jQuery('#background_heading_block').colorpicker();
			    });
			</script>
		</div>
		<!-- en-bas block -->
		<div class="form-group">
			<label for="background_footer_block" class="col-xs-12 col-sm-5 control-label"><?php _e("Couleur de fond de bas de block de contenu", $app->slug) ?></label>
			<div id="background_footer_block" class="col-xs-12 col-sm-5 input-group colorpicker-component">
			    <input type="text" name="update_color[background_footer_block]" value="<?php echo ($color !== null && isset($color->background_footer_block) ? $color->background_footer_block : '#f5f5f5') ?>" class="form-control" />
			    <span class="input-group-addon"><i></i></span>
			<?php if (isset($wp_session['display_tooltip'])): ?>
				<span class="hastooltip input-group-addon"><span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-placement="left" data-html="true"></span></span>
			<?php endif; ?>
			</div>
			<script>
			    jQuery(function() {
			        jQuery('#background_footer_block').colorpicker();
			    });
			</script>
		</div>
		<!-- titre -->
		<div class="form-group">
			<label for="title_color" class="col-xs-12 col-sm-5 control-label"><?php _e("Couleur des titres", $app->slug) ?></label>
			<div id="title_color" class="col-xs-12 col-sm-5 input-group colorpicker-component">
			    <input type="text" name="update_color[title]" value="<?php echo ($color !== null && isset($color->title) ? $color->title : '#333333') ?>" class="form-control" />
			    <span class="input-group-addon"><i></i></span>
			<?php if (isset($wp_session['display_tooltip'])): ?>
				<span class="hastooltip input-group-addon"><span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-placement="left" data-html="true"></span></span>
			<?php endif; ?>
			</div>
			<script>
			    jQuery(function() {
			        jQuery('#title_color').colorpicker();
			    });
			</script>
		</div>
		<!-- textes -->
		<div class="form-group">
			<label for="text_color" class="col-xs-12 col-sm-5 control-label"><?php _e("Couleur des textes", $app->slug) ?></label>
			<div id="text_color" class="col-xs-12 col-sm-5 input-group colorpicker-component">
			    <input type="text" name="update_color[text]" value="<?php echo ($color !== null && isset($color->text) ? $color->text : '#333333') ?>" class="form-control" />
			    <span class="input-group-addon"><i></i></span>
			<?php if (isset($wp_session['display_tooltip'])): ?>
				<span class="hastooltip input-group-addon"><span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-placement="left" data-html="true"></span></span>
			<?php endif; ?>
			</div>
			<script>
			    jQuery(function() {
			        jQuery('#text_color').colorpicker();
			    });
			</script>
		</div>
		<!-- bouton -->
		<div class="form-group">
			<label for="button_color" class="col-xs-12 col-sm-5 control-label"><?php _e("Couleur des boutons", $app->slug) ?></label>
			<div id="button_color" class="col-xs-12 col-sm-5 input-group colorpicker-component">
			    <input type="text" name="update_color[button]" value="<?php echo ($color !== null && isset($color->button) ? $color->button : '#2e6da4') ?>" class="form-control" />
			    <span class="input-group-addon"><i></i></span>
			<?php if (isset($wp_session['display_tooltip'])): ?>
				<span class="hastooltip input-group-addon"><span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-placement="left" data-html="true"></span></span>
			<?php endif; ?>
			</div>
			<script>
			    jQuery(function() {
			        jQuery('#button_color').colorpicker();
			    });
			</script>
		</div>
		<!-- texte bouton -->
		<div class="form-group">
			<label for="button_text_color" class="col-xs-12 col-sm-5 control-label"><?php _e("Couleur des textes des boutons", $app->slug) ?></label>
			<div id="button_text_color" class="col-xs-12 col-sm-5 input-group colorpicker-component">
			    <input type="text" name="update_color[button_text]" value="<?php echo ($color !== null && isset($color->button_text) ? $color->button_text : '#ffffff') ?>" class="form-control" />
			    <span class="input-group-addon"><i></i></span>
			<?php if (isset($wp_session['display_tooltip'])): ?>
				<span class="hastooltip input-group-addon"><span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-placement="left" data-html="true"></span></span>
			<?php endif; ?>
			</div>
			<script>
			    jQuery(function() {
			        jQuery('#button_text_color').colorpicker();
			    });
			</script>
		</div>
		<!-- bordure -->
		<div class="form-group">
			<label for="border_color" class="col-xs-12 col-sm-5 control-label"><?php _e("Couleur des bordures", $app->slug) ?></label>
			<div id="border_color" class="col-xs-12 col-sm-5 input-group colorpicker-component">
			    <input type="text" name="update_color[border_color]" value="<?php echo ($color !== null && isset($color->border_color) ? $color->border_color : '#2e6da4') ?>" class="form-control" />
			    <span class="input-group-addon"><i></i></span>
			<?php if (isset($wp_session['display_tooltip'])): ?>
				<span class="hastooltip input-group-addon"><span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-placement="left" data-html="true"></span></span>
			<?php endif; ?>
			</div>
			<script>
			    jQuery(function() {
			        jQuery('#border_color').colorpicker();
			    });
			</script>
		</div>
		<hr />
		<div class="row">
			<div class="col-xs-12 col-sm-offset-5 col-sm-5"><button type="button" class="btn btn-primary" id="update_color_button"><?php _e("Enregistrer", $app->slug) ?></button></div>
		</div>
	</form>
</div>
<script type="text/javascript">
jQuery(function(){
	jQuery('#display_employee').bootstrapToggle({
		on: '<?php echo __("OUI", $app->slug); ?>',
  		off: '<?php echo __("NON", $app->slug); ?>',
  		onstyle: 'success',
  		offstyle: 'danger'
	});

	jQuery('body').on('change', '#display_employee', function(){
		jQuery('#stats-loading').show();
		var displayEmployee = (jQuery('#display_employee').is(":checked") === false ? 0 : 1);
		var ajaxurl = '<?php echo admin_url("/admin-ajax.php/"); ?>';
		var action = '<?php echo $app->slug."_display_employee"; ?>';
		jQuery.post(
			ajaxurl,
			{
		        'action': action,
		        'display_employee': displayEmployee
		    }, 
		    function(response){
		    	if(response == '0')
		    		alert('<?php _e("Une erreur s\'est produite pendant la modification.", $app->slug); ?>');
	    		// else
	    		// 	alert('<?php _e("Modification effectuée.", $app->slug); ?>');
		        jQuery('#stats-loading').hide();
		    }
		);
	});

	// update_color
	jQuery('body').on('click', '#update_color_button', function(){
		jQuery('#stats-loading').show();
		var updateColor = jQuery('#update_color').serialize();
		var ajaxurl = '<?php echo admin_url("/admin-ajax.php/"); ?>';
		var action = '<?php echo $app->slug."_update_color"; ?>';
		jQuery.post(
			ajaxurl,
			updateColor+'&action='+action,
			/*{
		        'action': action,
		        'update_color': updateColor
		    }, */
		    function(response){
		    	if(response == '0')
		    		alert('<?php _e("Une erreur s\'est produite.", $app->slug); ?>');
	    		// else
	    		// 	alert('<?php _e("Modification effectuée.", $app->slug); ?>');
		        jQuery('#stats-loading').hide();
		    }
		);
	});
	jQuery('body').on('submit', '#update_color', function(){return false;});
<?php if (isset($wp_session['display_tooltip'])): ?>
	// tooltip
	jQuery('body').on('hover, focus', '.hastooltip span', function(){
		var content =  "<div{color}><h3{title_color}>Titre</h3><div class='panel panel-default'{block}><div class='panel-heading'{background_heading_block}><h3{title_color}>en-tête du block de contenu</h3></div><div class='panel-body'>contenu</div><div class='panel-footer'{background_footer_block}><div class='panel-footer-content'>bas du block de contenu</div></div></div><button class='btn'{button}>Bouton</button></div>";
		var color = " style='background-color:"+jQuery('#background_color input').val()+";color:"+jQuery('#text_color input').val()+";padding:5px!important;'";
		var titleColor = " style='color:"+jQuery('#title_color input').val()+"!important;'";
		var block = " style='background-color:"+jQuery('#background_block input').val()+";border-color:"+jQuery('#border_color input').val()+";border-top-width:5px;border-top-radius:5px;padding:5px;margin-left:5px!important;margin-right:5px!important;'";
		var backgroundHeadingBlock = " style='background-color:"+jQuery('#background_heading_block input').val()+";color:"+jQuery('#text_color input').val()+"!important;border-color:"+jQuery('#background_heading_block input').val()+"!important;'";
		var backgroundFooterBlock = " style='background-color:"+jQuery('#background_footer_block input').val()+"!important;border-color:"+jQuery('#background_footer_block input').val()+"'";
		var button = " style='background-color:"+jQuery('#button_color input').val()+"!important;border_color:"+jQuery('#button_color input').val()+"!important;color:"+jQuery('#button_text_color input').val()+"!important;'";

		var res1, res2, res3, res3, res4, res5, res6, res7, res8, res9;
		res1 = content.replace('{color}', color);
		res3 = res1.replace('{title_color}', titleColor);
		res4 = res3.replace('{block}', block);
		res6 = res4.replace('{background_heading_block}', backgroundHeadingBlock);
		res7 = res6.replace('{background_footer_block}', backgroundFooterBlock);
		res9 = res7.replace('{button}', button);

		jQuery(this).prop('title', res9);
		jQuery(this).tooltip('show');
		jQuery(this).attr('title', '');
	});
	jQuery('body').on('mouseleave, mouseout', '.hastooltip span', function(){
		jQuery(this).attr('title', '');
		jQuery(this).attr('data-original-title', '');
		jQuery(this).tooltip('destroy');
	});
<?php endif; ?>
});
</script>