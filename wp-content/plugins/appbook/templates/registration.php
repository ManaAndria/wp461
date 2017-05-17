<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$app = appBook();
$form_action = $app->form_action;

?>
<div class="col-xs-12">
	<form id="<?php echo $app->slug; ?>_login_form"  class="<?php echo $app->slug; ?>_form form-horizontal" method="POST" action="">
		<div class="form-group">
		    <label for="firstname" class="col-xs-12 col-md-4"><?php echo __('Prénom', $app->slug) ?> *</label>
		    <div class="col-xs-12 col-md-8">
		    	<input type="text" class="form-control" id="firstname" name="<?php echo $form_action; ?>[firstname]" placeholder="<?php echo __('Prénom', $app->slug) ?>" required />
		    </div>
	  	</div>
	  	<div class="form-group">
		    <label for="lastname" class="col-xs-12 col-md-4"><?php echo __('Nom', $app->slug) ?> *</label>
		    <div class="col-xs-12 col-md-8">
		    	<input type="text" class="form-control" id="lastname" name="<?php echo $form_action; ?>[lastname]" placeholder="<?php echo __('Nom', $app->slug) ?>" required />
	    	</div>
	  	</div>
	  	<div class="form-group">
		    <label for="email" class="col-xs-12 col-md-4"><?php echo __('Email', $app->slug) ?> *</label>
		    <div class="col-xs-12 col-md-8">
		    	<input type="email" class="form-control" id="email" name="<?php echo $form_action; ?>[email]" placeholder="<?php echo __('Email', $app->slug) ?>" required />
	    	</div>
	  	</div>
	  	<div class="form-group">
		    <label for="phonenumber" class="col-xs-12 col-md-4"><?php echo __('Téléphone', $app->slug) ?> *</label>
		    <div class="col-xs-12 col-md-8">
		    	<input type="text" class="form-control" id="phonenumber" name="<?php echo $form_action; ?>[phonenumber]" placeholder="<?php echo __('Téléphone', $app->slug) ?>" required />
	    	</div>
	  	</div>
	  	<div class="form-group">
		    <label for="user_login" class="col-xs-12 col-md-4"><?php echo __('Identifiant', $app->slug) ?> *</label>
		    <div class="col-xs-12 col-md-8">
		    	<input type="text" class="form-control" id="user_login" name="<?php echo $form_action; ?>[user_login]" placeholder="<?php echo __('Identifiant', $app->slug) ?>" required />
	    	</div>
	  	</div>
  		<div class="form-group">
		    <label for="user_password" class="col-xs-12 col-md-4"><?php echo __('Mot de passe', $app->slug) ?> *</label>
		    <div class="col-xs-12 col-md-8">
		    <input type="password" class="form-control" id="user_password" name="<?php echo $form_action; ?>[user_password]" placeholder="<?php echo __('Mot de passe', $app->slug) ?>" required />
		    </div>
	  	</div>
	  	<div class="form-group">
		    <label for="user_confirm_password" class="col-xs-12 col-md-4"><?php echo __('Confirmation du mot de passe', $app->slug) ?> *</label>
		    <div class="col-xs-12 col-md-8">
		    	<input type="password" class="form-control" id="user_confirm_password" name="<?php echo $form_action; ?>[user_confirm_password]" placeholder="<?php echo __('Confirmation du mot de passe', $app->slug) ?>" required />
	    	</div>
	  	</div>
	  	<div class="control-group">
			<div class="col-xs-12 col-md-offset-4 col-md-8">
				<input class="btn btn btn-primary" name="<?php echo $app->slug.'_'; ?>register" data-disable-with="En cours ..." name="commit" type="submit" value="<?php echo __('Valider', $app->slug) ?>">
			</div>
		</div>
		<?php wp_nonce_field( $app->form_action, $app->slug.'_'.$app->form_action ) ?>
	</form>
</div>