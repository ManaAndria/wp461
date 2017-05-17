<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (is_user_logged_in())
{
	$app = appBook();
	$appDatas = $app->app->userinfo->datas;
	$form_action = $app->form_action;
	$form_action2 = $app->form_action2;
?>
	<div class="col-xs-12">
		<form id="<?php echo $app->slug; ?>_app<?php echo '_'.$form_action?>"  class="<?php echo $app->slug; ?>_form form-horizontal" method="POST" action="">
			<div class="form-group">
			    <label for="firstname" class="col-xs-12 col-md-4 control-label"><?php echo __('Prénom', $app->slug) ?> *</label>
			    <div class="col-xs-12 col-md-8">
			    	<input type="text" class="form-control" id="firstname" name="<?php echo $form_action; ?>[firstname]" placeholder="<?php echo __('Prénom', $app->slug) ?>" value="<?php echo $appDatas->firstname ?>" required />
			    </div>
		  	</div>
		  	<div class="form-group">
			    <label for="lastname" class="col-xs-12 col-md-4 control-label"><?php echo __('Nom', $app->slug) ?> *</label>
			    <div class="col-xs-12 col-md-8">
			    	<input type="text" class="form-control" id="lastname" name="<?php echo $form_action; ?>[lastname]" placeholder="<?php echo __('Nom', $app->slug) ?>" value="<?php echo $appDatas->lastname ?>" required />
		    	</div>
		  	</div>
		  	<div class="form-group">
			    <label for="email" class="col-xs-12 col-md-4 control-label"><?php echo __('Email', $app->slug) ?> *</label>
			    <div class="col-xs-12 col-md-8">
			    	<input type="email" class="form-control" id="email" name="<?php echo $form_action; ?>[email]" placeholder="<?php echo __('Email', $app->slug) ?>" value="<?php echo $appDatas->email ?>" required />
		    	</div>
		  	</div>
		  	<div class="form-group">
			    <label for="phonenumber" class="col-xs-12 col-md-4 control-label"><?php echo __('Téléphone', $app->slug) ?></label>
			    <div class="col-xs-12 col-md-8">
			    	<input type="text" class="form-control" id="phonenumber" name="<?php echo $form_action; ?>[phonenumber]" placeholder="<?php echo __('Téléphone', $app->slug) ?>" value="<?php echo $appDatas->phonenumber ?>" />
		    	</div>
		  	</div>
		  	<div class="control-group">
				<div class="col-xs-12 col-md-offset-4 col-md-8">
					<input class="btn btn btn-primary" name="<?php echo $app->slug; ?>_app" data-disable-with="En cours ..." name="commit" type="submit" value="<?php echo __('Enregistrer', $app->slug) ?>">
				</div>
			</div>
			<?php wp_nonce_field( $app->form_action, $app->slug.'_'.$app->form_action ) ?>
		</form>
		<hr class="col-xs-12">
		<form id="<?php echo $app->slug; ?>_app<?php echo '_'.$form_action2?>"  class="<?php echo $app->slug; ?>_form form-horizontal" method="POST" action="">
			<div class="form-group">
			    <label for="old_password" class="col-xs-12 col-md-4 control-label"><?php echo __('Ancien mot de passe', $app->slug) ?> *</label>
			    <div class="col-xs-12 col-md-8">
			    	<input type="password" class="form-control" id="old_password" name="<?php echo $form_action2; ?>[old_password]" placeholder="<?php echo __('Ancien mot de passe', $app->slug) ?>" required />
		    	</div>
		  	</div>
			<div class="form-group">
			    <label for="password" class="col-xs-12 col-md-4 control-label"><?php echo __('Nouveau mot de passe', $app->slug) ?> *</label>
			    <div class="col-xs-12 col-md-8">
			    	<input type="password" class="form-control" id="password" name="<?php echo $form_action2; ?>[password]" placeholder="<?php echo __('Nouveau mot de passe', $app->slug) ?>" required />
		    	</div>
		  	</div>
			<div class="form-group">
			    <label for="user_confirm_password" class="col-xs-12 col-md-4 control-label"><?php echo __('Confirmation du nouveau mot de passe', $app->slug) ?> *</label>
			    <div class="col-xs-12 col-md-8">
			    	<input type="password" class="form-control" id="user_confirm_password" name="<?php echo $form_action2; ?>[user_confirm_password]" placeholder="<?php echo __('Confirmation du nouveau mot de passe', $app->slug) ?>" required />
		    	</div>
		  	</div>
		  	<div class="control-group">
				<div class="col-xs-12 col-md-offset-4 col-md-8">
					<input class="btn btn btn-primary" name="<?php echo $app->slug; ?>_app" data-disable-with="En cours ..." name="commit" type="submit" value="<?php echo __('Modifier mon mot de passe', $app->slug) ?>">
				</div>
			</div>
			<?php wp_nonce_field( $app->form_action2, $app->slug.'_'.$app->form_action2 ) ?>
		</form>
	</div>
<?php } ?>