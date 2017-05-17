var appointmentApp = angular.module('appointmentApp', ['ngAnimate', 'ngSanitize', 'ui.bootstrap']);
appointmentApp.controller('appointmentCtrl', ['$rootScope','$scope', '$http', '$compile', '$q', function ($rootScope, $scope, $http, $compile, $q){
	$scope.showLoading = true;
	$scope.blocTitle = true;
	$scope.appointment = {};
	$scope.appt = {};
	$scope.appointment.employeetype = false;
	$scope.appointment.employees = {};
	$scope.appointment.hours = {};
	$scope.appointment.hour = "";
	$scope.appointment.date = "";
	$scope.now = new Date();
	$scope.openclosesign = "plus";
	$scope.appointment.emptyhour = true;
	$scope.selectservice = true;
	$scope.formbloc = false;
	$scope.noemployeetype = false;

	$scope.businessinformations = {};

	$scope.appointment.id_service = 0;
	$scope.appointment.id_employee = 0;
	$scope.app_id = document.getElementById('app_id').value;

	$scope.errorfirstname = false;
	$scope.errorusername = false;
	$scope.erroruseremail = false;
	$scope.successSend = false;
	$scope.failledSend = false;
	$scope.noemployee = false;

	var app_ids = $.param({
                app_id: $scope.app_id
            });
	var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            };

	var informations = $http.post(
		'../getinformations.php',
		app_ids,
		config
	).success(function(datax, status, headers){
		// colors
		$rootScope.color = {};
		if (datax.color.length > 0){
			var color = angular.fromJson(datax.color);
			$rootScope.color.background = color.background ? 'background-color: '+color.background+'!important;' : '';
			$rootScope.color.title = color.title ? 'color: '+color.title+'!important;' : '';
			$rootScope.color.text = color.text ? 'color: '+color.text+'!important;' : '';
			$rootScope.color.button = color.button ? 'background-color: '+color.button+'!important;' : '';
			$rootScope.color.button_text = color.button_text ? 'color: '+color.button_text+'!important;' : '';
			$rootScope.color.border_color = color.border_color ? color.border_color : '';
			$rootScope.color.background_block = color.background_block ? 'background-color: '+color.background_block+'!important;' : '';
			$rootScope.color.background_heading_block = color.background_heading_block ? color.background_heading_block : '';
			$rootScope.color.background_footer_block = color.background_footer_block ? color.background_footer_block : '';
		}
		//end colors
		$scope.businessinformations = datax;
		$rootScope.title = "Prise de rendez-vous | "+datax.app_name;
		$scope.selectservice = false;
		$scope.defaultblocTitle = true;
		//$scope.defaultbloc = true;
		$scope.showLoading = false;
	});
	var services = $http({
      method  : 'POST',
      url     : '../getservices.php',
      data    : app_ids,
      headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
     })
	.success(function(data, status, headers, config){
		$scope.appointment.services = data;
		// $scope.showLoading = false;
	});
	$scope.selectHour = function(selhour){
		$scope.appointment.hour = selhour;
		$scope.appointment.next = true;
		$scope.appointment.dates = false;
		$scope.appt.date = $scope.appointment.date;
		$scope.appt.hour = selhour;
		$scope.resume_dates = true;
	};
	$scope.showMessageBlock = function(){
		if($scope.addmessage) {
			$scope.addmessage = false;
			$scope.openclosesign = "plus";
		} else {
			$scope.addmessage = true;
			$scope.openclosesign = "minus";
		}
	};
	$scope.defaultbloc = false;
	$scope.serviceChoice = function(service_name, duration, price, service_id){
		$scope.appt.service_name = service_name;
		$scope.appt.service_duration = duration;
		$scope.appt.service_price = price;
		$scope.appt.service_id = $scope.appointment.id_service = service_id;

		$scope.resume_type = false;
		$scope.resume_employee = false;
		$scope.resume_dates = false;

		$scope.appointment.next = false;
		$scope.employee_choice = false;
		$scope.appointment.dates = false;

		$scope.selectservice = true;
		$scope.defaultbloc = true;
		
		if ( $scope.businessinformations.display_employee != 0 ){
			$scope.noemployee = false;
			$scope.noemployeetype = false;
			$scope.appointment.noemployeetype = false;
			$scope.appointment.employeetype = false;

			$scope.employee_type_choice = true;
		}else{
			$scope.noemployee = true;
			$scope.noemployeetype = true;
			$scope.appointment.noemployeetype = true;
			$scope.appointment.employeetype = false;

			$scope.employee_type_choice = false;
			this.dateChange();
		}
	};
	$scope.showServiceChoice = function(){
		$scope.selectservice = false;
		$scope.defaultbloc = false;
		$scope.formbloc = false;

		$scope.resume_type = false;
		$scope.resume_employee = false;
		$scope.resume_dates = false;

		$scope.appt.service_name = $scope.appt.service_duration = $scope.appt.service_price = $scope.appt.service_id = "";
	}
	$scope.showApptType = function(){
		$scope.selectservice = true;
		$scope.defaultbloc = true;
		$scope.formbloc = false;

		$scope.resume_type = false;
		$scope.resume_employee = false;
		$scope.resume_dates = false;

		$scope.appointment.next = false;
		$scope.employee_choice = false;
		$scope.appointment.dates = false;
		$scope.employee_type_choice = true;
	}
	$scope.showApptEmployee = function(){
		$scope.selectservice = true;
		$scope.defaultbloc = true;
		$scope.formbloc = false;

		$scope.resume_type = true;
		$scope.resume_employee = false;
		$scope.resume_dates = false;

		$scope.appointment.next = false;
		$scope.appointment.dates = false;
		$scope.employee_type_choice = false;
		$scope.employee_choice = true;
	}
	$scope.showApptDate = function(){
		$scope.selectservice = true;
		$scope.defaultbloc = true;
		$scope.formbloc = false;

		if ( $scope.businessinformations.display_employee != 0 ){
			$scope.resume_type = true;
			$scope.resume_employee = true;
		}
		$scope.resume_dates = false;

		$scope.appointment.next = false;
		$scope.employee_choice = false;
		$scope.employee_type_choice = false;
		$scope.appointment.dates = true;
	}


	//Datepicker
	$scope.today = function() {
    $scope.dt = new Date();
    $scope.showButtonBar = false;
  };
  $scope.today();

  $scope.clear = function() {
    $scope.dt = null;
  };

  $scope.inlineOptions = {
    customClass: getDayClass,
    minDate: null,
    showWeeks: true 
  };

  $scope.dateOptions = {
    formatYear: 'yy',
    startingDay: 1
  };

  // Disable weekend selection
  function disabled(data) {
    var date = data.date,
      mode = data.mode;
    return mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
  }

  $scope.toggleMin = function() {
    $scope.inlineOptions.minDate = $scope.inlineOptions.minDate ? null : new Date();
    $scope.dateOptions.minDate = $scope.inlineOptions.minDate;
  };

  $scope.toggleMin();


  $scope.open1 = function() {
    $scope.popup1.opened = true;
  };
  $scope.checkEmployee = function(employee_name, employee_id){
  	$scope.appointment.employeedata = employee_name+","+$scope.appt.service_id+","+employee_id+","+$scope.appt.service_name;
  	$scope.appointment.id_employee = employee_id;
  	this.dateChange();
  }
  $scope.dateChange = function(){
  	$scope.showLoading = true;
  	var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            };
    var appointment_date = $scope.dt.getFullYear()+"-"+(parseInt($scope.dt.getMonth()) + 1)+"-"+$scope.dt.getDate();
  	if ($scope.appointment.employeedata){
  		var dataemployee = $scope.appointment.employeedata.split(',');
  		$scope.appointment.employeename = dataemployee[0];
  		//$scope.appointment.id_service = dataemployee[1];
  		// $scope.appointment.id_employee = dataemployee[2];
  		$scope.appointment.servicename = dataemployee[3];

	  	var postdata = $.param({
	            id_employee: $scope.appointment.id_employee,
	            id_service: $scope.appointment.id_service,
	            num_day: $scope.dt.getDay(),
	            app_id: $scope.app_id,
	            appointment_date: appointment_date
	        });
	  	$http.post(
			'../getperoides.php',
			postdata,
			config
		)
		.success(function(data, status, headers, config){
			var curr_minute = $scope.now.getMinutes();
			var curr_hour = $scope.now.getHours();
			var final_data = Array();
			if ($scope.dt.getDate() == $scope.now.getDate() && $scope.dt.getMonth() == $scope.now.getMonth() && $scope.dt.getFullYear() == $scope.now.getFullYear()) {
				for (hour in data) {
					var hourmin = data[hour].split(":");
					var datahour = parseInt(hourmin[0]);
					var dataminute = parseInt(hourmin[1]);
					if (datahour > curr_hour || (datahour == curr_hour && dataminute > curr_minute)) {
						final_data.push(data[hour]);
					}
				}
			} else {
				final_data = data;
			}
			$scope.appointment.hour = "";
			$scope.appointment.emptyhour = (final_data.length ? true : false); 
			if (angular.isArray(final_data) && !final_data.length)
				$scope.appointment.hours = false;
			else	
				$scope.appointment.hours = final_data;
			$scope.appointment.dates = true;// bloc choix date et heure
			$scope.employee_choice = false;//bloc choix employé
			$scope.resume_employee = true;
			$scope.employee_type_choice = false;
			$scope.appt.employee = $scope.appointment.employeename;
			$scope.showLoading = false;
			$scope.appointment.date = document.getElementById('bookingdate').value;
		});
  	} else {
  		// var dataservice = $scope.appointment.service.split(',');
  		// $scope.appointment.servicename = dataservice[1];
  		// $scope.appointment.id_service = dataservice[0];
  		$scope.appointment.id_employee = 0;
	  	var postdata = $.param({
	            id_service: $scope.appointment.id_service,
	            num_day: $scope.dt.getDay(),
	            app_id: $scope.app_id,
	            appointment_date: appointment_date
	        });
	  	$http.post(
			'../getservicesperoides.php',
			postdata,
			config
		)
		.success(function(data, status, headers, config){
			var curr_minute = $scope.now.getMinutes();
			var curr_hour = $scope.now.getHours();
			var final_data = Array();
			if ($scope.dt.getDate() == $scope.now.getDate() && $scope.dt.getMonth() == $scope.now.getMonth() && $scope.dt.getFullYear() == $scope.now.getFullYear()) {
				for (hour in data) {
					var hourmin = data[hour].split(":");
					var datahour = parseInt(hourmin[0]);
					var dataminute = parseInt(hourmin[1]);
					if (datahour > curr_hour || (datahour == curr_hour && dataminute > curr_minute)) {
						final_data.push(data[hour]);
					}
				}
			} else {
				final_data = data;
			}
			$scope.appointment.hour = "";
			$scope.appointment.emptyhour = (final_data.length ? true : false);
			if (angular.isArray(final_data) && !final_data.length)
				$scope.appointment.hours = '';
			else
				$scope.appointment.hours = final_data;
			$scope.appointment.dates = true;// bloc choix date et heure
			$scope.employee_choice = false;//bloc choix employé
			$scope.resume_employee = false;

			if ( $scope.businessinformations.display_employee != 0 ){
				$scope.resume_type = true;
				$scope.appt.type = "Non";
			}
			$scope.employee_type_choice = false;

			$scope.showLoading = false;
			$scope.appointment.date = document.getElementById('bookingdate').value;
		});
  	}
  };


  $scope.setDate = function(year, month, day) {
    $scope.dt = new Date(year, month, day);
  };
  $scope.format = 'EEEE dd MMMM yyyy';
  $scope.altInputFormats = ['M!/d!/yyyy'];

  $scope.popup1 = {
    opened: false
  };

  function getDayClass(data) {
    var date = data.date,
      mode = data.mode;
    if (mode === 'day') {
      var dayToCheck = new Date(date).setHours(0,0,0,0);

      for (var i = 0; i < $scope.events.length; i++) {
        var currentDay = new Date($scope.events[i].date).setHours(0,0,0,0);

        if (dayToCheck === currentDay) {
          return $scope.events[i].status;
        }
      }
    }

    return '';
  }
   $scope.getForm = function(){
		$scope.showLoading = true;
        var compiled = $compile("<div user-form ></div>")($scope);
        angular.element(document.getElementById('user-form')).html(compiled);
        $scope.appointment.next = false;
        $scope.formbloc = true;
    }
    $scope.submitForm = function(){
		$scope.showLoading = true;
		// var hour_f = $scope.appointment.hour;
		var hour_f = $scope.appt.hour;
		var day_f = $scope.appointment.date;
		//$scope.appointment = {};
		$scope.appointment.date = day_f;
		$scope.appointment.usernumber = $scope.usernumber;
		$scope.appointment.hour = hour_f;
		$scope.appointment.service = $scope.service;
		$scope.appointment.userfirstname = $scope.userfirstname;
		$scope.appointment.username = $scope.username;
		$scope.appointment.useremail = $scope.useremail;
		$scope.appointment.userphone = $scope.userphone;
		$scope.appointment.usermessage = $scope.usermessage;
		if($scope.appointment.usermessage == undefined)
			$scope.appointment.usermessage = '';
		$scope.appointment.app_id = $scope.app_id;

		$scope.appointment.admineamil = $scope.businessinformations.email_contact;
		$scope.appointment.app_name = $scope.businessinformations.app_name;
		$http({
          method  : 'POST',
          url     : '../senddata.php',
          data    : $scope.appointment, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         })
		.success(function(data, status, headers, config){
			if (data == "1") {
				var employees = $scope.appointment.employees;
				var services = $scope.appointment.services;
				$scope.appointment = {};
				$scope.appointment.employees = employees;
				$scope.appointment.services = services;
				$scope.successSend = true;
				$scope.failledSend = false;
				$scope.showChoiceTime = false;
				$scope.formbloc = false;
				$scope.defaultblocTitle = false;
				$scope.appointment.noemployeetype = false;
				$scope.appointment.employeetype = false;
				$scope.defaultbloc = false;
			} else {
				$scope.failledSend = true;
				$scope.successSend = false;
				$scope.showChoiceTime = false;
				$scope.formbloc = false;
				$scope.defaultblocTitle = false;
				$scope.appointment.noemployeetype = false;
				$scope.appointment.employeetype = false;
				$scope.defaultbloc = false;
			}
			$scope.showLoading = false;
		});
	}
	$scope.getPeriodes = function(){
		this.dateChange();
	}
	$scope.backChoice = function(){
		if ( $scope.appointment.employeetype === true && $scope.appointment.noemployeetype === false){
			$scope.appointment.employeetype = true;
			$scope.appointment.next = true;
		}
		else if ( $scope.appointment.employeetype === false && $scope.appointment.noemployeetype === false ){
			$scope.appointment.employeetype = false;
			$scope.appointment.next = false;
			$scope.selectservice = false;
		}
		else if ($scope.appointment.noemployeetype === true){
			$scope.appointment.employeetype = false;
			$scope.appointment.next = true;
		}
		$scope.appointment.employeename = false;
		angular.element(document.getElementById('user-form')).html('');
		$scope.appointment.date = document.getElementById('bookingdate').value;
		// $scope.defaultbloc = true;
		$scope.noemployee = $scope.appointment.noemployeetype;
		$scope.noemployeetype = $scope.appointment.noemployeetype;
		$scope.defaultblocTitle = true;
		$scope.formbloc = false;
		$scope.successSend = false;
		$scope.failledSend = false;

	}
	$scope.showEmployeeBlock = function(){
		$scope.showLoading = true;
		$scope.appointment.dates = false;
		
		var appointment_date = $scope.dt.getFullYear()+"-"+(parseInt($scope.dt.getMonth()) + 1)+"-"+$scope.dt.getDate();
		var postdata = $.param({
            id_service: $scope.appointment.id_service,
            num_day: $scope.dt.getDay(),
            app_id: $scope.app_id,
            appointment_date: appointment_date
        });
		$http.post(
			'../getemployeesservice.php',
			postdata,
			config
		).success(function(data2, status, headers){
			$scope.employeesservice = data2;
			$scope.employee_type_choice = false;
			$scope.resume_type = true;
			$scope.appt.type = "Oui";
			$scope.employee_choice = true;
			$scope.showLoading = false;
		});

		//document.getElementById('bookingdate').
	}
	$scope.razDetails = function(){
		$scope.noemployee = true;
		var employees = $scope.appointment.employees;
		$scope.appointment.employeedata = undefined;
		$scope.appointment.employees = employees;

		$scope.appointment.date = document.getElementById('bookingdate').value;
		$scope.defaultbloc = true;
		$scope.selectservice = true;
		$scope.formbloc = false;
		$scope.noemployeetype = true;
		$scope.appointment.noemployeetype = true;
		$scope.appointment.employeetype = false;

		this.dateChange();
	}
}]);
appointmentApp.directive('userForm', function(){
	return {
		templateUrl: 'templates/formuser.html',
		restrict:'A',
		transclude: true,
		remplace: true,
		link: function($scope){
			$scope.showLoading = false;
		}
		
	}
});
appointmentApp.directive('firstEtape', function(){
	return {
		templateUrl: 'templates/etape-1.html',
		restrict:'A',
		transclude: true,
		remplace: true,
		
	}
});