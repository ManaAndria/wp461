jQuery(document).ready(function(){
	jQuery('#employee-new').click(function(e){
		jQuery(this).button('loading');
		jQuery.post(
		    employeeObject.ajaxurl, 
		    {
		        'action': employeeObject.action_new,
		    }, 
		    function(response){
		    	jQuery('.alert').alert('close');
		        jQuery('#employee').html(response);
		    }
		);
	});

	// edit
	jQuery('button.edit-employee').click(function(e){
		jQuery(this).button('loading');
		var dataId = jQuery(this).data('id');
		jQuery.post(
		    employeeObject.ajaxurl, 
		    {
		        'action': employeeObject.action_edit,
		        'data': dataId
		    }, 
		    function(response){
		    	jQuery('.alert').alert('close');
		        jQuery('#employee').html(response);
		    }
		);
	});

	// delete
	jQuery('button.delete-employee').click(function(e){
		var dataId = jQuery(this).data('id');
		jQuery('#employee_id').val(dataId);
	});
	jQuery('button#confirm-delete').click(function(e){
		var id = jQuery('#employee_id').val();
		jQuery('#confirmDelete').modal('hide');
		jQuery.post(
		    employeeObject.ajaxurl, 
		    {
		        'action': employeeObject.action_delete,
		        'data': id
		    }, 
		    function(response){
		    	if (response == "1")
		        	jQuery('#'+id).remove();
		        else
		        	alert('Erreur suppression');
				
				jQuery('#employee_id').val('');
		    }
		);
	});

	//submit
	jQuery('body').on('submit', '#appbook_app_employee_new', function(e){
		var fields = JSON.parse(employeeObject.fields);
		for (var i = 0; i < fields.length; i++) {
			if(jQuery("#"+fields[i]).val() == ""){
		        alert("Certains champs sont invalides");
		        jQuery("#"+fields[i]).focus();
		        return false;
		    }
		}
	});
	jQuery('body').on('submit', '#appbook_app_employee_edit', function(e){
		var fields = JSON.parse(employeeObject.fields);
		for (var i = 0; i < fields.length; i++) {
			if(jQuery("#"+fields[i]).val() == ""){
		        alert("Certains champs sont invalides");
		        jQuery("#"+fields[i]).focus();
		        return false;
		    }
		}
	});

	//multiselect
	// jQuery(document).ready(function() {
 //        jQuery('#poste').multiselect({
 //        	allSelectedText: 'Tous',
 //        	numberDisplayed: 1,
 //        	nSelectedText: 'selectionnés',
 //        	nonSelectedText: 'Aucun',
 //        	includeSelectAllOption: true,
 //        	selectAllText : 'Tous'
 //        });
 //    });
});