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
});