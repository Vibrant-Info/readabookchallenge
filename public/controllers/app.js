var app = angular.module("challengeApp", ['ngRoute']);


app.config(['$routeProvider', '$locationProvider',function($routeProvider, $locationProvider) {


	$routeProvider
		.when('/', {
			templateUrl : 'pages/home.html',
			controller  : 'mainController'
		})
		.when('/about-us', {
			templateUrl : 'pages/about-us.html',
			controller  : 'aboutController'
		})
		.when('/contact-us', {
			templateUrl : 'pages/contact-us.html',
			controller  : 'contactController'
		})
		.when('/gallery', {
			templateUrl : 'pages/gallery.html',
			controller  : 'galleryController'
		})
		.when('/home', {
			templateUrl : 'pages/home.html',
			controller  : 'mainController'
		})
		.when('/profile', {
			templateUrl : 'pages/my-profile.html'
		});
		//$locationProvider.html5Mode(true);
}]);
app.run(function(Session) {});

app.factory('Session', function($http) {
  var Session = {
    data: {},
    saveSession: function() {},
    updateSession: function() {
      $http.get('/getSession')
        .then(function(r) { return Session.data = r.data;})
    }
  };
  Session.updateSession();
  return Session; 
});

// create the controller and inject Angular's $scope
	app.controller('mainController', function($scope, Session) {
		$scope.session = Session;
		console.log($scope.session);
		$scope.call = function(){
			$().JqueryFunction();
		}
		 $scope.mail_regex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
		 $scope.phone_regex = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
		
		$.fn.JqueryFunction = function() {
			$("#detail-verify").modal();
		};
		$scope.checkDetails = function(){
			if($scope.mail_regex.test($scope.email) && $scope.phone_regex.test($scope.phone) ){	
			}
			
		}
		
	});

app.controller('aboutController', function($scope,Session) {
		$scope.session = Session;
		$scope.message = 'Look! I am an about page.';
	});

app.controller('contactController', function($scope,Session) {
	$scope.session = Session;
	$scope.message = 'Contact us! JK. This is just a demo.';
});
app.controller('galleryController', function($scope,Session) {
	$scope.session = Session;
	$scope.message = 'Contact us! JK. This is just a demo.';
});
	
	