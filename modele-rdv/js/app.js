var appointmentApp = angular.module('appointmentApp', ['ngAnimate', 'ngSanitize', 'ui.bootstrap']);
appointmentApp.controller('appointmentCtrl', ['$scope', '$http', '$compile', function ($scope, $http, $compile){
	$scope.appointment = {};
	$scope.appointment.employeetype = false;
	$scope.appointment.employees = {};
	//$scope.showLoading = true;
	$scope.appointment.hours = {};
	$scope.appointment.hour = "";
	$scope.appointment.date = "";
	$scope.now = new Date();
	$scope.openclosesign = "plus";
	$scope.appointment.emptyhour = true;
	$scope.defaultbloc = true;
	$scope.formbloc = false;
	$scope.noemployeetype = false;

	//$scope.app_id = 3;
	$scope.businessinformations = {};

	$scope.appointment.id_service = 0;
	$scope.appointment.id_employee = 0;

	var app_id = $.param({
                app_id: $scope.app_id
            });
	var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            };

	$http.post(
		'../getemployees.php',
		app_id,
		config
	).success(function(data2, status, headers){
		$scope.appointment.employees = data2;
		console.log(data2);
		$scope.showLoading = false;
	});

	$http.post(
		'../getinformations.php',
		app_id,
		config
	).success(function(datax, status, headers){
		$scope.businessinformations = datax;
		console.log($scope.businessinformations);
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
  	if ($scope.appointment.employeedata){
  		var dataemployee = $scope.appointment.employeedata.split(',');
  		$scope.appointment.employeename = dataemployee[0];
  		$scope.appointment.id_service = dataemployee[1];
  		$scope.appointment.id_employee = dataemployee[2];
  	}
  	// var postdata = {
  	// 	id_employee: $scope.appointment.id_employee,
  	// 	id_service: $scope.appointment.id_service
  	// };
  	var postdata = $.param({
            id_employee: $scope.appointment.id_employee,
            id_service: $scope.appointment.id_service,
            num_day: $scope.dt.getDay()
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
			console.log("1**"+data);
			for (hour in data) {
				var hourmin = data[hour].split(":");
				var datahour = parseInt(hourmin[0]);
				var dataminute = parseInt(hourmin[1]);
				if (datahour > curr_hour || (datahour == curr_hour && dataminute > curr_minute)) {
					final_data.push(data[hour]);
				}
			}
		} else {
			console.log("2**"+data);
			final_data = data;
		}
		$scope.appointment.hour = "";
		$scope.appointment.emptyhour = (final_data.length ? true : false);
		$scope.appointment.hours = final_data;
		$scope.showLoading = false;
		$scope.appointment.date = document.getElementById('bookingdate').value;
	})
	;
  }


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
	$scope.backChoice = function(){
		$scope.appointment.employeetype = false;
		$scope.appointment.employeename = false;
		angular.element(document.getElementById('user-form')).html('');
		$scope.appointment.date = document.getElementById('bookingdate').value;
		$scope.defaultbloc = true;
		$scope.formbloc = false;
        $scope.appointment.hour = false;
        console.log($scope.appointment.hour);
        console.log($scope.appointment.date);
	}
	$scope.razDetails = function(){
		$scope.appointment.employeetype = false;
		$scope.appointment.employeename = false;
		$scope.appointment.emptyhour = true;
		$scope.appointment.hour = false;
		$scope.appointment.date = document.getElementById('bookingdate').value;
		$scope.defaultbloc = true;
		$scope.formbloc = false;
		$scope.noemployeetype = true;
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