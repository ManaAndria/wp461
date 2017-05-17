jQuery(document).ready(function(){
	jQuery('body').on('click', '.add-service', function(e){
		var vis = jQuery(this);
		jQuery(this).button('loading');
		jQuery('#add-service').modal('hide');
		var day = jQuery(this).data('day');
		jQuery.post(
		    openingObject.ajaxurl, 
		    {
		        'action': openingObject.action_new,
		        'day': day
		    }, 
		    function(response){
				vis.button('reset');
				jQuery('.alert').alert('close');
				jQuery('#add-edit-title').text("Ajouter une période d'ouverture");
		        jQuery('#add-service .modal-body').html(response);
		        jQuery('#add-service').modal('show');
		    }
		);
	});
	jQuery('#add-service').on('hide.bs.modal', function(e){
		jQuery('#add-service .modal-body').html('');
	});

	// edit
	jQuery('body').on('click', '.edit-service', function(e){
		var vis = jQuery(this);
		jQuery(this).button('loading');
		jQuery('#add-service').modal('hide');
		var dataId = jQuery(this).data('id');
		jQuery.post(
		    openingObject.ajaxurl, 
		    {
		        'action': openingObject.action_edit,
		        'data': dataId
		    }, 
		    function(response){
		    	vis.button('reset');
				jQuery('.alert').alert('close');
		    	jQuery('#add-edit-title').text("Modifier une période d'ouverture");
		        jQuery('#add-service .modal-body').html(response);
		        jQuery('#add-service').modal('show');
		    }
		);
	});

	// delete
	jQuery('body').on('click', '.delete-service', function(e){
		var dataId = jQuery(this).data('id');
		jQuery('#opening_id').val(dataId);
	});

	jQuery('button#confirm-delete').click(function(e){
		var id = jQuery('#opening_id').val();
		jQuery('#confirmDelete').modal('hide');
		jQuery.post(
		    openingObject.ajaxurl, 
		    {
		        'action': openingObject.action_delete,
		        'data': id
		    }, 
		    function(response){
		    	console.log(response);
		    	if (response == "1")
		        	jQuery('#'+id).remove();
		        else
		        	alert('Erreur suppression');
				
				jQuery('#opening_id').val('');
		    }
		);
	});
	jQuery('#confirmDelete').on('hide.bs.modal', function(e){
		jQuery('#opening_id').val('');
	});

	// submit
	jQuery('body').on('click', '#confirm-add', function(){
		var format = formatDate();
		if(format)
		{
			if (jQuery('#edit-service').length)
				jQuery('#edit-service').submit();
			else if(jQuery('#new-service').length)
				jQuery('#new-service').submit();
		}
	});
	function formatDate()
	{
		// validate fields
		if( jQuery('#start-hour').val() == '' )
		{
			alert('Veuillez remplir le champ Heure')
			jQuery('#start-hour').focus();
			return false;
		}
		if( jQuery('#start-minute').val() == '' )
		{
			alert('Veuillez remplir le champ Minute')
			jQuery('#start-minute').focus();
			return false;
		}
		if( jQuery('#end-hour').val() == '' )
		{
			alert('Veuillez remplir le champ Heure')
			jQuery('#end-hour').focus();
			return false;
		}
		if( jQuery('#end-minute').val() == '' )
		{
			alert('Veuillez remplir le champ Minute')
			jQuery('#end-minute').focus();
			return false;
		}
		// end validate fields filling

		var startHour = jQuery('#start-hour').val();
		var startMinute = jQuery('#start-minute').val();
		var endHour = jQuery('#end-hour').val();
		var endMinute = jQuery('#end-minute').val();

		// validate fields values
		if(startHour >= 23)
		{
			alert('L\'heure doit être inférieure ou égale à 23');
			jQuery('#start-hour').focus();
			return false;
		}
		if(startMinute >= 59)
		{
			alert('La minute doit être inférieure ou égale à 59');
			jQuery('#start-minute').focus();
			return false;
		}
		if(endHour >= 23)
		{
			alert('L\'heure doit être inférieure ou égale à 23');
			jQuery('#end-hour').focus();
			return false;
		}
		if(startMinute >= 59)
		{
			alert('La minute doit être inférieure ou égale à 59');
			jQuery('#end-minute').focus();
			return false;
		}
		// end validate fields values

		// format hours & minutes 
		var newStartHour = startHour.split('');
		if(newStartHour.length == 1)
		{
			jQuery('#start-hour').val('0'+startHour);
			sHour = '0'+startHour;
		}
		else
			sHour = startHour;
		
		var newStartMinute = startMinute.split('');
		if (newStartMinute.length == 1)
		{
			jQuery('#start-minute').val('0'+startMinute);
			sMinute = '0'+startMinute;
		}
		else
			sMinute = startMinute;

		var newEndHour = endHour.split('');
		if(newEndHour.length == 1)
		{
			jQuery('#end-hour').val('0'+endHour);
			eHour = '0'+endHour;
		}
		else
			eHour = endHour;

		var newEndMinute = endMinute.split('');
		if (newEndMinute.length == 1)
		{
			jQuery('#end-minute').val('0'+endMinute);
			eMinute = '0'+endMinute
		}
		else
			eMinute = endMinute;

		// validate start & end values
		var start = sHour+':'+sMinute;
		var end = eHour+':'+eMinute;
		if(start >= end)
		{
			alert('Le début doit être avant la fin.')
			return false;
		}
		// end validate start & end values
		
		return true;
	}
});