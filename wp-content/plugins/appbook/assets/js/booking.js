jQuery(document).ready(function(){
	if (isSingle !== true){
		jQuery('#booking').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek listMonth,listWeek,listDay'
				// right: 'month,agendaWeek,agendaDay'
			},
			views:{
				'listDay':{
					titleFormat: 'dddd D MMMM YYYY'
				}
			},
			buttonText: {
				listDay: 'Liste jour',
				listWeek:'Liste semaine',
				listMonth: 'Liste mois'
			},
			navLinks: true, 
			editable: false,
			eventLimit: true,
			/*timezone: bookingTimezone,*/
			defaultDate: bookingObject.defaultDate,
			defaultView: 'basicWeek',
			allDaySlot: false,
			listDayFormat: false,
			listDayAltFormat: 'dddd D MMMM YYYY',
			eventSources: [
	        	{
					events: JSON.parse(bookingObject.events)
				},
	        	{
					events: closingEventsSingle,
					allDay: true,
					color: '#c9302c',
					backgroundColor: '#c9302c',
					resourceEditable: true,
					constraint: 'holiday',
				},
				{
					events: [{
						id: 'holiday',
					    allDay: true,
					    color: '#c9302c',
						backgroundColor: '#c9302c',
					    dow: JSON.parse(bookingObject.hiddenDays),
					    start: "00:00:00",
					    end: "23:59:59" 
					}],
				}
			],
			viewRender: function( view, element ){
				var currentYear = jQuery('#booking').fullCalendar('getDate').year();
				var todayYear = moment(jQuery('#booking').fullCalendar('option', 'defaultDate')).year();
				var YearDiff = currentYear - todayYear;
				if (jQuery("#booking").fullCalendar( 'getEventSourceById', currentYear.toString()+'perYear' ) === undefined)
				{
					var sourceString = '{"id":"'+currentYear.toString()+'perYear","constraint":"holiday","events":';
					var myEvents = '[';
					for (var i = 0; i < closingEventsFrequenty.length; i++) {
						var start = moment(closingEventsFrequenty[i].start);
						var startYear = start.year()+YearDiff;
						var finalStart = start.year(startYear);//change year to the current
						var end = moment(closingEventsFrequenty[i].end);
						var endYear = end.year()+YearDiff;
						end.year(endYear);//change year to the current
						myEvents += (i==0 ? '' : ',')+'{"start":"'+start.startOf('day').format()+'","end":"'+end.endOf('day').format()+'","color":"#c9302c","backgroundColor":"#c9302c","constraint":"holiday"}';/*"allDay":true,"title":"Congé annuel",*/
					}
					myEvents += ']';
					sourceString += myEvents+'}';
					var source = JSON.parse(sourceString);
					// console.log(source);
					jQuery('#booking').fullCalendar( 'addEventSource', source );
				}
			},
			/*eventClick: function(calEvent, jsEvent, view){

			}*/
		});
	}
});