jQuery(document).ready(function(){
	jQuery('body').on('submit', '#appbook_app', function(e){
		var fields = JSON.parse(settingObject.fields);
		for (var i = 0; i < fields.length; i++) {
			if(jQuery("#"+fields[i]).val() == ""){
		        alert("Certains champs sont invalides");
		        jQuery("#"+fields[i]).focus();
		        return false;
		    }
		}
	});

	// code pays
	jQuery.ajax({
		url: settingObject.phone,
		dataType: 'json',
		method: "GET",
		success: function(data1){
			var countries = data1;
			jQuery.ajax({
				url: settingObject.names,
				dataType: 'json',
				method: "GET",
				success: function(data2){
					var countryCodes = data2;
					// var datas = new Array();
					var code = '';
					var phonecode = '';
					var options = '';
					var selected = jQuery('#country_code').val();
					for (name in countries)
					{
						if (countries[name].trim() != ''){
							phonecode = countries[name];
							if (phonecode.split('+').length == 1){
								if(phonecode.split('-').length == 1){
									code = '+'+phonecode;
									// datas[countryCodes[name]] = '+'+phonecode;
								}else{
									code = '+'+phonecode.split('-')[0];
									// datas[countryCodes[name]] = '+'+phonecode.split('-')[0];
								}
							}else{
								if(phonecode.split('-').length == 1){
									code = phonecode;
									// datas[countryCodes[name]] = phonecode;
								}else{
									code = phonecode.split('-')[0];
									// datas[countryCodes[name]] = phonecode.split('-')[0];
								}
							}
							if(selected != code){
								options += '<option value="'+code+'" data-name="'+countryCodes[name]+'">'+countryCodes[name]+' ('+code+')'+'</option>';
								// options += '<option value="'+code+'" data-name="'+countryCodes[name]+'">'+code+' ('+countryCodes[name]+')</option>';
							}
						}
					}
					jQuery('#country_code').append(options);
					// console.log(datas);
				}
			});
		}
	});

	//code pays
	jQuery('#country_code').change(function(){
		jQuery('#country_name').val(jQuery('#country_code option:selected').data('name'));
	});
});