jQuery(document).ready(function(){
	jQuery('#service-new').click(function(e){
		jQuery(this).button('loading');
		jQuery.post(
		    serviceObject.ajaxurl, 
		    {
		        'action': serviceObject.action_new,
		    }, 
		    function(response){
				jQuery('.alert').alert('close');
		        jQuery('#service').html(response);
		    }
		);
	});

	// edit
	jQuery('button.edit-service').click(function(e){
		jQuery(this).button('loading');
		var dataId = jQuery(this).data('id');
		jQuery.post(
		    serviceObject.ajaxurl, 
		    {
		        'action': serviceObject.action_edit,
		        'data': dataId
		    }, 
		    function(response){
				jQuery('.alert').alert('close');
		        jQuery('#service').html(response);
		    }
		);
	});

	// delete
	jQuery('button.delete-service').click(function(e){
		var dataId = jQuery(this).data('id');
		jQuery('#service_id').val(dataId);
	});
	jQuery('button#confirm-delete').click(function(e){
		var id = jQuery('#service_id').val();
		jQuery('#confirmDelete').modal('hide');
		jQuery.post(
		    serviceObject.ajaxurl, 
		    {
		        'action': serviceObject.action_delete,
		        'data': id
		    }, 
		    function(response){
		    	if (response == "1")
		        	jQuery('#'+id).remove();
		        else
		        	alert('Erreur suppression');
				
				jQuery('#service_id').val('');
		    }
		);
	});

	// submit
	jQuery('body').on('submit', '.appbook_form', function(){
		if(jQuery('#description').val() == '')
		{
			alert('Veuillez remplir le champ description');
			jQuery('#description').focus();
			return false;
		}
	});
});