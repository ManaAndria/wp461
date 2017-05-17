jQuery(document).ready(function(){
	jQuery('.period-new').click(function(e){
		jQuery(this).button('loading');
		var employee = jQuery(this).data('employee');
		var service = jQuery(this).data('service');
		jQuery.post(
		    periodObject.ajaxurl, 
		    {
		        'action': periodObject.action_new,
		        'data': employee,
		        'service': service,
		    }, 
		    function(response){
				jQuery('.alert').alert('close');
		        jQuery('#period').html(response);
		    }
		);
	});

	// edit
	jQuery('button.edit-period').click(function(e){
		jQuery(this).button('loading');
		var dataId = jQuery(this).data('id');
		jQuery.post(
		    periodObject.ajaxurl, 
		    {
		        'action': periodObject.action_edit,
		        'data': dataId
		    }, 
		    function(response){
				jQuery('.alert').alert('close');
		        jQuery('#period').html(response);
		    }
		);
	});

	// delete
	jQuery('button.delete-period').click(function(e){
		var dataId = jQuery(this).data('id');
		jQuery('#period_id').val(dataId);
	});

	jQuery('button#confirm-delete').click(function(e){
		var id = jQuery('#period_id').val();
		jQuery('#confirmDelete').modal('hide');
		jQuery.post(
		    periodObject.ajaxurl, 
		    {
		        'action': periodObject.action_delete,
		        'data': id
		    }, 
		    function(response){
		    	if (response == "1")
		        	jQuery('#'+id).remove();
		        else
		        	alert('Erreur suppression');
				
				jQuery('#period_id').val('');
		    }
		);
	});

	// submit
	jQuery('body').on('submit', '#appbook_app_period_edit', function(){
		var res = formatPeriod();
		var day = jQuery('#day').val();
		if(day == '')
		{
			alert('Veuillez choisir le jour.')
			jQuery('#day').focus();
			return false;
		}
		// if(res == true)
		// 	return true;
		if (res)
		{
			return checkOpening(day);
		}
	});
	jQuery('body').on('submit', '#appbook_app_period_new', function(){
		var res = formatPeriod();
		var days = jQuery('#day').val();
		if(days == null)
		{
			alert('Veuillez choisir le jour.')
			jQuery('#day').focus();
			return false;
		}
		if (res)
		{
			return checkOpenings(days);
		}
	});
	
	function formatPeriod()
	{
		var hour = jQuery('#hour').val();
		var minute = jQuery('#minute').val()
		var newHour = hour.split('');
		if(newHour.length == 1)
			jQuery('#hour').val('0'+hour);
		var newMinute = minute.split('');
		if (newMinute.length == 1)
			jQuery('#minute').val('0'+minute);

		var endHour = jQuery('#end_hour').val();
		var endMnute = jQuery('#end_minute').val();

		var newEndHour = endHour.split('');
		if(newEndHour.length == 1)
			jQuery('#end_hour').val('0'+endHour);

		var newEndMnute = endMnute.split('');
		if (newEndMnute.length == 1)
			jQuery('#end_minute').val('0'+endMnute);

		return true;
	}

	function checkOpening(d)
	{
		var start = ( jQuery('#hour').val().split('').length == 1 ? '0'+jQuery('#hour').val() : jQuery('#hour').val() ) +':'+ ( jQuery('#minute').val().split('').length == 1 ? '0'+jQuery('#minute').val() : jQuery('#minute').val() );
		var end = ( jQuery('#end_hour').val().split('').length == 1 ? '0'+jQuery('#end_hour').val() : jQuery('#end_hour').val() ) +':'+ ( jQuery('#end_minute').val().split('').length == 1 ? '0'+jQuery('#end_minute').val() : jQuery('#end_minute').val() );
		if(start >= end)
		{
			alert('Attention!!! Le début de la période doit être avant la fin.')
			return false;
		}
		var valid = [];
		var openingValid = '';
		for (var i = 0; i < openings[d].length; i++) {
			if( start >= openings[d][i].start && start < openings[d][i].end && end > openings[d][i].start && end <= openings[d][i].end )
				valid[i] = 1;
			else
				valid[i] = 0;
			if (i == 0)
				openingValid += openings[d][i].start+' et '+openings[d][i].end;
			else
				openingValid += ' ou '+openings[d][i].start+' et '+openings[d][i].end;
		}
		var sum = 0
		for (var j = 0; j < valid.length; j++) {
			sum += valid[j];
		}
		if (sum) {
			return true;
		}
		else
		{
			alert('La période choisie pour '+allDays[openings[d]]+' est hors des heures d\'ouverture du jour! Veuillez choisir une période valide entre '+openingValid+'.')
			return false;
		}
	}

	function checkOpenings(days){
		for (var i = 0; i < days.length; i++) {
			checkOpening(days[i]);
		}
	}

	jQuery(function(){
		jQuery('select[name="period_new[day][]"]').multiselect({
			allSelectedText: 'Tous',
			numberDisplayed: 1,
			nSelectedText: 'selectionnés',
			nonSelectedText: 'Aucun',
			includeSelectAllOption: true,
			selectAllText : 'Tous'
		});
	});
});