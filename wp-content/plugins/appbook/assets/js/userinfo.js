jQuery(document).ready(function(){
	jQuery('body').on('submit', '#appbook_app_password', function(e){
		if ( jQuery('#password').val() != jQuery('#user_confirm_password').val() )
		{
			alert('Veuillez corriger la confirmation du mot de passe');
			jQuery('#user_confirm_password').focus();
			return false;
		}
	});
});