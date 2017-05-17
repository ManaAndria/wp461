jQuery(function(){
	jQuery('#start').datepicker({
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		onClose: function(value){
			jQuery('#end').datepicker('option', 'minDate', value);
		}
	});
	jQuery('#end').datepicker({
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		onClose: function(value){
			jQuery('#start').datepicker('option', 'maxDate',value);
		}
	});
	jQuery(document).ready(function() {
        jQuery('#services').multiselect({
        	allSelectedText: 'Tous',
        	numberDisplayed: 1,
        	nSelectedText: 'selectionnés',
        	nonSelectedText: 'Aucun',
        	includeSelectAllOption: true,
        	selectAllText : 'Tous'
        });
    });
    jQuery('body').on('submit', '#stats-form', function(){
    	if (jQuery('#services').val() == null)
    	{
    		jQuery('#services').focus();
    		alert('Vous devez selectionner au moins un service');
    		return false;
    	}
    	jQuery('#stats-loading').show();
    	var start = jQuery('#start').val();
    	var end = jQuery('#end').val();
    	var services = jQuery('#services').val();
    	jQuery.post(
		    statsObject.ajaxurl, 
		    {
		        'action': statsObject.action,
		        'start': start,
		        'end': end,
		        'services': services
		    }, 
		    function(response){
		    	if (response)
		    	{
		    		var res = JSON.parse(response);
		    		var myElement = Math.floor(Math.random() * 10000000);
		    		jQuery('canvas').prop("id", myElement);
		    		loadStats(res, myElement);
		    		jQuery('#stats-loading').hide();
		    	}
		    }
		);
    	return false;
    });
    if (JSON.parse(statsObject.data).datasets !== undefined){
    	loadStats(JSON.parse(statsObject.data), "canvas-stats");
    }else{
    	jQuery('input.btn[name="appbook_app"]').prop('disabled','disabled');
    	jQuery('canvas').before('<div class="alert alert-info">Aucune donnée disponible.</div>');
    }    
});
function loadStats(data, canvasElement)
{
	var ctx = document.getElementById(canvasElement);
	var myChart = new Chart(ctx, {
			type: 'line',
			data: data,
			options: {
	            responsive: true,
	            title: {
		            display: true,
		            text: 'Statistiques des rendez-vous',
		            fontSize: 16
		        },
		        tooltips: {
		        	mode: 'x-axis'
		        },
		        scales: {
		        	xAxes: [{
		        		scaleLabel: {
			            	display: true,
			            	labelString: 'Dates',
			            	fontColor: '#337ab7'
			            }
		        	}],
		            yAxes: [{
		            	type: 'linear',
		                ticks: {
		                    min: 0,
		                    stepSize: 1
		                },
		                scaleLabel: {
			            	display: true,
			            	labelString: 'Nombre de rendez-vous',
			            	fontColor: '#337ab7'
			            }
		            }]
		        }
	        }
	});
}