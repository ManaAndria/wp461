jQuery(document).ready(function(){	
	jQuery('#closing-new').click(function(e){
		jQuery(this).button('loading');
		jQuery.post(
		    closingObject.ajaxurl, 
		    {
		        'action': closingObject.action_new,
		    }, 
		    function(response){
				jQuery('.alert').alert('close');
		        jQuery('#closing').html(response);
		    }
		);
	});

	// edit
	jQuery('button.edit-closing').click(function(e){
		jQuery(this).button('loading');
		var dataId = jQuery(this).data('id');
		jQuery.post(
		    closingObject.ajaxurl, 
		    {
		        'action': closingObject.action_edit,
		        'data': dataId
		    }, 
		    function(response){
				jQuery('.alert').alert('close');
		        jQuery('#closing').html(response);
		    }
		);
	});

	// delete
	jQuery('button.delete-closing').click(function(e){
		var dataId = jQuery(this).data('id');
		jQuery('#closing_id').val(dataId);
	});
	jQuery('button#confirm-delete').click(function(e){
		var id = jQuery('#closing_id').val();
		jQuery('#confirmDelete').modal('hide');
		jQuery.post(
		    closingObject.ajaxurl, 
		    {
		        'action': closingObject.action_delete,
		        'data': id
		    }, 
		    function(response){
		    	if (response == "1")
		        	jQuery('#'+id).remove();
		        else
		        	alert('Erreur suppression');
				
				jQuery('#closing_id').val('');
		    }
		);
	});

	// submit
	jQuery('body').on('submit','#appbook_app_closing_new', function(){
		if(jQuery('#frequency').val() == 2)
		{
			if(jQuery('#day').val() == null)
			{
				alert('Veuillez choisir au moins un jour.');
				jQuery('#day + div.btn-group > button').click();
				return false;
			}
		}else{
			if( jQuery('#start').val() == '' )
			{
				alert('Veuillez choisir la date de début.');
				jQuery('#start').datepicker('show');
				return false;
			}
			else if( jQuery('#end').val() == '' )
			{
				alert('Veuillez choisir la date de fin.');
				jQuery('#end').datepicker('show');
				return false;
			}
		}
	});

	jQuery('body').on('change','#frequency', function(){
		if( jQuery('#frequency').val() == 2 )
		{
			jQuery('.non-weekly').hide();
			jQuery('.weekly').show();
		}
		else
		{
			jQuery('.weekly').hide();
			jQuery('.non-weekly').show();
		}
	});
});