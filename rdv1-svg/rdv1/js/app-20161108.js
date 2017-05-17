var appointmentApp = angular.module('appointmentApp', ['ngAnimate', 'ngSanitize', 'ui.bootstrap']);
appointmentApp.controller('appointmentCtrl', ['$rootScope','$scope', '$http', '$compile', function ($rootScope, $scope, $http, $compile){
	$scope.showLoading = true;
	$scope.blocTitle = true;
	$scope.appointment = {};
	$scope.appointment.employeetype = false;
	$scope.appointment.employees = {};
	$scope.appointment.hours = {};
	$scope.appointment.hour = "";
	$scope.appointment.date = "";
	$scope.now = new Date();
	$scope.openclosesign = "plus";
	$scope.appointment.emptyhour = true;
	// $scope.defaultbloc = true;
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

	// $http.post(
	// 	'../getemployees.php',
	// 	app_ids,
	// 	config
	// ).success(function(data2, status, headers){
	// 	$scope.appointment.employees = data2;
	// 	$scope.showLoading = false;
	// });

	$http.post(
		'../getinformations.php',
		app_ids,
		config
	).success(function(datax, status, headers){
		$scope.businessinformations = datax;
		$rootScope.title = "Prise de rendez-vous | "+datax.app_name;
		$scope.defaultblocTitle = true;
		$scope.defaultbloc = true;
		$scope.showLoading = false;
	});
	$scope.selectHour = function(selhour){
		$scope.appointment.hour = selhour;
	};
	$scope.showMessageBlock = function(){
		if($scope.addmessage) {
			$scope.addmessage = false;
			$scope.openclosesign = "plus";
		} else {
			$scope.addmessage = true;
			$scope.openclosesign = "minus";
		}
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
  		$scope.appointment.id_service = dataemployee[1];
  		$scope.appointment.id_employee = dataemployee[2];
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
			$scope.appointment.hours = final_data;
			$scope.showLoading = false;
			$scope.appointment.date = document.getElementById('bookingdate').value;
		});
  	} else {
  		var dataservice = $scope.appointment.service.split(',');
  		$scope.appointment.servicename = dataservice[1];
  		$scope.appointment.id_service = dataservice[0];
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
			$scope.appointment.hours = final_data;
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
        $scope.defaultbloc = false;
        $scope.formbloc = true;
    }
    $scope.submitForm = function(){
		$scope.showLoading = true;
		var hour_f = $scope.appointment.hour;
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
				$scope.successSend = true;
				$scope.failledSend = false;
				$scope.showChoiceTime = false;
				$scope.formbloc = false;
				$scope.blocTitle = false;
			} else {
				$scope.failledSend = true;
				$scope.successSend = false;
				$scope.showChoiceTime = false;
				$scope.formbloc = false;
				$scope.blocTitle = false;
			}
			$scope.showLoading = false;
		});
	}
	$scope.getPeriodes = function(){
		this.dateChange();
	}
	$scope.backChoice = function(){
		$scope.appointment.employeetype = false;
		$scope.appointment.employeename = false;
		angular.element(document.getElementById('user-form')).html('');
		$scope.appointment.date = document.getElementById('bookingdate').value;
		$scope.defaultbloc = true;
		$scope.blocTitle = true;
		$scope.formbloc = false;
        $scope.appointment.hour = false;
		$scope.successSend = false;
		$scope.failledSend = false;
	}
	$scope.showEmployeeBlock = function(){
		$scope.showLoading = true;
		$scope.noemployee = false;
		$http.post(
			'../getemployees.php',
			app_ids,
			config
		).success(function(data2, status, headers){
			$scope.appointment.employees = data2;
			$scope.showLoading = false;
		});
		//document.getElementById('bookingdate').
	}
	$scope.razDetails = function(){
		$scope.showLoading = true;
		$scope.noemployee = true;
		var employees = $scope.appointment.employees;
		$scope.appointment = {};
		$scope.appointment.employees = employees;
		$scope.appointment.date = document.getElementById('bookingdate').value;
		$scope.defaultbloc = true;
		$scope.blocTitle = true;
		$scope.formbloc = false;
		$scope.noemployeetype = true;

		var datatopost = $.param({
            app_id: $scope.app_id
        });

		$http({
          method  : 'POST',
          url     : '../getservices.php',
          data    : datatopost,
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         })
		.success(function(data, status, headers, config){
			$scope.appointment.services = data;
			$scope.showLoading = false;
		});
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