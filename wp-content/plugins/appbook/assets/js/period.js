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
	//// edit
	// jQuery('body').on('submit', '#appbook_app_period_edit', function(){
	jQuery('body').on('click', '#submit-edit-period-form', function(){
		var res = formatPeriod();
		jQuery('#stats-loading').show();
		if ( jQuery('#hour').val() == '' ){
			jQuery('#stats-loading').hide();
			alert("Veuillez remplir l'heure du début.");
			jQuery('#hour').focus();
			return false;
		}
		if ( jQuery('#minute').val() == '' ){
			jQuery('#stats-loading').hide();
			alert("Veuillez remplir la minute du début.");
			jQuery('#minute').focus();
			return false;
		}
		if ( jQuery('#end_hour').val() == '' ){
			jQuery('#stats-loading').hide();
			alert("Veuillez remplir l'heure de la fin.");
			jQuery('#end_hour').focus();
			return false;
		}
		if ( jQuery('#end_minute').val() == '' ){
			jQuery('#stats-loading').hide();
			alert("Veuillez remplir la minute de la fin.");
			jQuery('#end_minute').focus();
			return false;
		}
		var day = jQuery('#day').val();
		if(day == '')
		{
			alert('Veuillez choisir le jour.')
			jQuery('#day + div.btn-group > button').click();
			return false;
		}
		if (res)
		{
			var validOpening = checkOpening(day);
			if(validOpening)
			{
				if ( checkPeriodDay(day) !== false )
				{
					var days = [day]
					jQuery.post(
						periodObject.ajaxurl, 
					    {
					        'action': periodObject.action_checkperiod,
					        'employee_id': jQuery('input[name="period_edit[employee_id]"]').val(),
					        'start': jQuery('#hour').val()+':'+jQuery('#minute').val(),
					        'end': jQuery('#end_hour').val()+':'+jQuery('#end_minute').val(),
					        'days': [day],
					        'period_id' : jQuery('input[name="period_edit[period_id]"]').val()
					    }, 
					    function(response){
					    	jQuery('#stats-loading').hide();
					    	if (response == "1")
					        	jQuery('#appbook_app_period_edit').submit();
					        else
					        	alert("La période choisie est déjà définie en partie ou en totalité pour d'autre(s) service(s).");
					    }
					);
				}
				else
				{
					jQuery('#stats-loading').hide();
					return false;
				}
			}
			else{
				jQuery('#stats-loading').hide();
				return false;
			}
		}
	});
	//// new
	// jQuery('body').on('submit', '#appbook_app_period_new', function(){
	jQuery('body').on('click', '#submit-new-period-form', function(){
		var res = formatPeriod();
		jQuery('#stats-loading').show();
		if ( jQuery('#hour').val() == '' ){
			jQuery('#stats-loading').hide();
			alert("Veuillez remplir l'heure du début.");
			jQuery('#hour').focus();
			return false;
		}
		if ( jQuery('#minute').val() == '' ){
			jQuery('#stats-loading').hide();
			alert("Veuillez remplir la minute du début.");
			jQuery('#minute').focus();
			return false;
		}
		if ( jQuery('#end_hour').val() == '' ){
			jQuery('#stats-loading').hide();
			alert("Veuillez remplir l'heure de la fin.");
			jQuery('#end_hour').focus();
			return false;
		}
		if ( jQuery('#end_minute').val() == '' ){
			jQuery('#stats-loading').hide();
			alert("Veuillez remplir la minute de la fin.");
			jQuery('#end_minute').focus();
			return false;
		}
		var days = jQuery('#day').val();
		if(days == null)
		{
			jQuery('#stats-loading').hide();
			alert('Veuillez choisir le(s) jour(s).');
			jQuery('#day + div.btn-group > button').click();
			return false;
		}

		if (res)
		{
			var validOpening = checkOpenings(days);
			if(validOpening)
			{
				if (checkPeriodDays(days) === true){
					jQuery.post(
						periodObject.ajaxurl, 
					    {
					        'action': periodObject.action_checkperiod,
					        'employee_id': jQuery('input[name="period_new[employee_id]"]').val(),
					        'start': jQuery('#hour').val()+':'+jQuery('#minute').val(),
					        'end': jQuery('#end_hour').val()+':'+jQuery('#end_minute').val(),
					        'days': days
					    }, 
					    function(response){
					    	jQuery('#stats-loading').hide();
					    	if (response == "1")
					        	jQuery('#appbook_app_period_new').submit();
					        else
					        	alert("La période choisie est déjà définie en partie ou en totalité pour d'autre(s) service(s).");
					    }
					);
				}else
					jQuery('#stats-loading').hide();
			}
			else{
				jQuery('#stats-loading').hide();
				return false;
			}
		}
	});
	// end submit
	
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
			// alert('La période choisie pour '+allDays[openings[d]]+' est hors des heures d\'ouvertures du jour! Veuillez choisir une période valide entre '+openingValid+'.')
			alert('La période choisie est hors des heures d\'ouvertures du jour! Veuillez choisir une période valide entre '+openingValid+'.')
			return false;
		}
	}

	function checkOpenings(days){
		for (var i = 0; i < days.length; i++) {
			var valid = checkOpening(days[i]);
			if(valid === false)
				return false;
		}
		return true;
	}

	function checkPeriodDay(d, add){
		if(add !== true)
			add = false;

		var start = ( jQuery('#hour').val().split('').length == 1 ? '0'+jQuery('#hour').val() : jQuery('#hour').val() ) +':'+ ( jQuery('#minute').val().split('').length == 1 ? '0'+jQuery('#minute').val() : jQuery('#minute').val() );
		var end = ( jQuery('#end_hour').val().split('').length == 1 ? '0'+jQuery('#end_hour').val() : jQuery('#end_hour').val() ) +':'+ ( jQuery('#end_minute').val().split('').length == 1 ? '0'+jQuery('#end_minute').val() : jQuery('#end_minute').val() );
		var dayObject = periods[d];
		if(dayObject.length == 0)
			return 'valid';
		
		for (var i = 0; i < dayObject.length; i++) {
			var refStart = dayObject[i].start;
			var refEnd = dayObject[i].end;
			if( (refStart > start || start >= refEnd) && (refStart >= end || end > refEnd) )
				continue;
			else if( add === false && jQuery('input[name="period_edit[period_id]"]').val() == dayObject[i].id )
				continue;
			else
			{
				var periodList = '';
				for (var j = 0; j < periods[d].length; j++) {
					var plStart = periods[d][j].start.replace(':', 'h');
					var plEnd = periods[d][j].end.replace(':', 'h');
					periodList += (j!=0 ? ', ':'')+'de '+plStart+' à '+plEnd;
				}
				if(add)
					return confirm('La période choisie est déjà définie en partie ou en totalité pour '+allDays[d]+'.\nVoulez-vous continuer et la période pour les autres jours sera traité ou tout annuler?\nLes périodes définies pour ce jour sont : '+periodList);
				else
				{
					alert('La période choisie est déjà définie en partie ou en totalité pour '+allDays[d]+'.\nLes périodes définies pour ce jour sont : '+periodList);
					return false;
				}
			}
		}
		return 'valid';
	}

	function checkPeriodDays(days){
		var daysValid = 0;
		for (var i = 0; i < days.length; i++) {
			var singleDay = parseInt(days[i]);
			var isChecked = checkPeriodDay(singleDay, true);
			if(isChecked === false)
				return false;
			else if(isChecked === true)
				jQuery('#day option[value="'+days[i]+'"]').prop('selected', false);
			else if(isChecked == 'valid')
				daysValid++;
		}
		if(daysValid == 0)
		{
			alert('Aucun jour n\'a de période valide');
			return false;
		}
		else
			return true;
	}
});