jQuery(document).ready(function(){
	jQuery('#holiday-new').click(function(e){
		jQuery(this).button('loading');
		jQuery.post(
		    holidayObject.ajaxurl, 
		    {
		        'action': holidayObject.action_new,
		    }, 
		    function(response){
		    	jQuery('.alert').alert('close');
		        jQuery('#holiday').html(response);
		    }
		);
	});

	// edit
	// jQuery('button.edit-holiday').click(function(e){
	jQuery('body').on('click', 'button.edit-holiday', function(e){
		jQuery(this).button('loading');
		var dataId = jQuery(this).data('id');
		jQuery.post(
		    holidayObject.ajaxurl, 
		    {
		        'action': holidayObject.action_edit,
		        'data': dataId
		    }, 
		    function(response){
		    	jQuery('.alert').alert('close');
		        jQuery('#holiday').html(response);
		    }
		);
	});

	// delete
	// jQuery('button.delete-holiday').click(function(e){
	jQuery('body').on('click', 'button.delete-holiday', function(e){
		var dataId = jQuery(this).data('id');
		jQuery('#holiday_id').val(dataId);
	});
	jQuery('button#confirm-delete').click(function(e){
		var id = jQuery('#holiday_id').val();
		jQuery('#confirmDelete').modal('hide');
		jQuery.post(
		    holidayObject.ajaxurl, 
		    {
		        'action': holidayObject.action_delete,
		        'data': id
		    }, 
		    function(response){
		    	if (response == "1")
		        	jQuery('#'+id).remove();
		        else
		        	alert('Erreur suppression');
				
				jQuery('#holiday_id').val('');
		    }
		);
	});

	// submit
	jQuery('body').on('submit', '#appbook_app_holiday_new', function(){
		if(jQuery('#employee_id').val() == 0){
			alert('Veuillez séléctionner un(e) employé(e)');
			jQuery('#employee_id').focus();
			return false;
		}
		if( jQuery('#switch-onDayText').is(':checked') === true && jQuery('#switch-onText').is(':checked') === false ){
			var start = ( jQuery('#h_start').val().split('').length == 1 ? '0'+jQuery('#h_start').val() : jQuery('#h_start').val() ) +':'+ ( jQuery('#m_start').val().split('').length == 1 ? '0'+jQuery('#m_start').val() : jQuery('#m_start').val() );
			var end = ( jQuery('#h_end').val().split('').length == 1 ? '0'+jQuery('#h_end').val() : jQuery('#h_end').val() ) +':'+ ( jQuery('#m_end').val().split('').length == 1 ? '0'+jQuery('#m_end').val() : jQuery('#m_end').val() );
			if (start >= end)
			{
				jQuery('#validate_one_not_all_day').val('0');
				alert("Le début doit être avant la fin!")
				jQuery('#h_start').focus();
				return false;
			}
			if (jQuery('#validate_one_not_all_day').val() == 1)
				return true;
			jQuery('#loading-service').show();
			jQuery.post(
			    holidayObject.ajaxurl, 
			    {
			        'action': holidayObject.action_validate,
			        'app_id': jQuery('#app_id').val(),
			        'date': jQuery('#date').val(),
			        'start': start,
			        'end': end,
			    }, 
			    function(response){
			    	jQuery('#loading-service').hide();
			    	if (response == "1")
			    	{
			    		jQuery('#validate_one_not_all_day').val('1');
			        	jQuery('#appbook_app_holiday_new').submit();
			    	}
			        else{
			        	jQuery('#validate_one_not_all_day').val('0');
			        	alert(response);
			        	return false;
			        }

			    }
			);
			return false;
		}
	});

});
function getService(emp_id){
	var employee_id = parseInt(emp_id);
	jQuery('#loading-service').show();
	jQuery('#service_id').attr("disabled", "true");
	if (!employee_id) {
		alert("Employé(e) incorrecte !!!");
		jQuery('#service_id').html('');
		jQuery('#loading-service').hide();
	} else {
		jQuery.post(
		    holidayObject.ajaxurl, 
		    {
		        'action': holidayObject.action_employee,
		        'employee_id': emp_id,
		    }, 
		    function(response){
		    	jQuery('.alert').alert('close');
		    	jQuery('#service_id').html(response);
		        jQuery('#service_id').removeAttr("disabled");
		        jQuery('#loading-service').hide();
		    }
		);
	}
}
function  orderBy(orderby, app_id) {
	jQuery('#stats-loading').show();
	jQuery.post(
		    holidayObject.ajaxurl, 
		    {
		        'action': holidayObject.action_orderby,
		        'orderby': orderby
		    }, 
		    function(response){
		    	jQuery('.alert').alert('close');
		    	jQuery('#holiday-list').empty();
		    	jQuery('#holiday-list').html(response);
		    	jQuery('#stats-loading').hide();
		    	/*jQuery('#service_id').html(response);
		        jQuery('#service_id').removeAttr("disabled");
		        jQuery('#loading-service').hide();*/
		    }
		);
}