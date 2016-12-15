var app = angular.module("challengeApp", ['ngRoute', 'ui.bootstrap','ngAnimate']);


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
			templateUrl : 'pages/my-profile.html',
			controller  : 'profileController'
		})
		.when('/start-challenge', {
			templateUrl : 'pages/start-challenge.html'
		})
		.when('/thank-you', {
			templateUrl : 'pages/thank-you.html',
			controller  : 'thankyouController'
		})
		.when('/faq', {
			templateUrl : 'pages/faq.html',
			controller  : 'faqController'
		})
		.when('/proceed', {
			templateUrl : 'pages/dataFrom.html'
		})
		.when('/proceedWallet', {
			templateUrl : 'pages/proceedWallet.html'
		});
		//$locationProvider.html5Mode(true);
}]);


app.factory('Session', function($http) {
	
  var Session = {
    data: {},
    saveSession: function() {},
    updateSession: function() {
      $http.get('/getSession')
        .then(function(r) { return Session.data = r.data;})
    }
  };
 // Session.updateSession();
  return Session; 
});
app.directive('slideable', function () {
    return {
        restrict:'C',
        compile: function (element, attr) {
            // wrap tag
            var contents = element.html();
            element.html('<div class="slideable_content" style="margin:0 !important; padding:0 !important" >' + contents + '</div>');

            return function postLink(scope, element, attrs) {
                // default properties
                attrs.duration = (!attrs.duration) ? '1s' : attrs.duration;
                attrs.easing = (!attrs.easing) ? 'ease-in-out' : attrs.easing;
                element.css({
                    'overflow': 'hidden',
                    'height': '0px',
                    'transitionProperty': 'height',
                    'transitionDuration': attrs.duration,
                    'transitionTimingFunction': attrs.easing
                });
            };
        }
    };
})
app.directive('slideToggle', function() {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var target = document.querySelector(attrs.slideToggle);
            attrs.expanded = false;
            element.bind('click', function() {
                var content = target.querySelector('.slideable_content');
                if(!attrs.expanded) {
                    content.style.border = '1px solid rgba(0,0,0,0)';
                    var y = content.clientHeight;
                    content.style.border = 0;
                    target.style.height = y + 'px';
                } else {
                    target.style.height = '0px';
                }
                attrs.expanded = !attrs.expanded;
            });
        }
    }
});
app.run(function($rootScope, $location, $http, $window) {

	$rootScope.$on('$routeChangeStart', function (ev, next, curr) {
		 $http.get('/getSession')
        .success(function (user) {
			
            if (user) {
                $rootScope.user = user;
				if($rootScope.user != undefined){
					if($rootScope.user.email == "undefined" || $rootScope.user.email == undefined){
						$("#email-pop").modal({backdrop: 'static', keyboard: false});
					}
				}
			}
        });
	
	  
	});
});

app.directive('numbersOnly', function () {
    return {
        require: 'ngModel',
        link: function (scope, element, attr, ngModelCtrl) {
            function fromUser(text) {
                if (text) {
                    var transformedInput = text.replace(/[^0-9]/g, '');

                    if (transformedInput !== text ) {
                        ngModelCtrl.$setViewValue(transformedInput);
                        ngModelCtrl.$render();
                    }
                    return transformedInput;
                }
                return undefined;
            }            
            ngModelCtrl.$parsers.push(fromUser);
        }
    };
});

app.directive('toggleClass', function() {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            element.bind('click', function() {
                element.toggleClass(attrs.toggleClass);
            });
        }
    };
});

app.service('sharedProperties', function () {
	var property = '';

	return {
		getProperty: function () {
			return property;
		},
		setProperty: function(value) {
			property = value;
		}
	};
});


app.controller('mainController', function($scope, $rootScope, $window, $http) {
	$scope.data = {};
	
	$scope.startChallenge = function(){
		if( $rootScope.user != undefined && $rootScope.user != "" ){
			$window.location.href = '#/start-challenge';
		}else{
			$("#login-popup").modal('show')
		}
	}
	
	$scope.closeModal = function(){
		$("#login-popup").modal("hide");
	}
	
	$scope.login = function(type){
		if(type == "fb")
			$().facebookLogin(type);
		if(type == "google")
			$().googleLogin(type);
	}
	
	$.fn.facebookLogin = function(type) {	
		//alert(type)
		FB.login(function(response) {
			console.log(response.authResponse)
			if (response.authResponse) {
				FB.api("/me", {fields: "id,first_name,last_name,picture, email, gender"}, function(response){
					//console.log(response)
					$scope.data.type = type;
					$scope.data.id = response.id;
					$scope.data.first_name = response.first_name;
					$scope.data.last_name = response.last_name;
					$scope.data.email = response.email;
					$scope.data.img = response.picture.data.url;
						console.log($scope.data);
						if($scope.data.email != "" && $scope.data.email != undefined ){
							FB.api(
								"/"+response.id+"/picture?width=216",
								function (response) {						
								  if (response && !response.error) {
									$scope.data.img = response.data.url;
									$http.post('/saveUser',{data:$scope.data}).success(function(response){
										if(response.status == 'OK'){
											var results = response.result;
											$rootScope.user = results;
											$window.location.href = '#/profile';
										}
										
									});
								  }
								}
							);
						}else{
							$("#email-error-pop").modal("show");
						}
				});
				
			}
		}, {scope: 'email,public_profile', return_scopes: true});
	};
	
	$scope.getEmail = function(email){
		if(validateEmail(email)){
			$scope.data.email = email;
			$http.post('/checkEmailDup',{'data': $scope.data}).success(function(response){
				if(response.code == 200){
					if($scope.data.type == "fb"){
						FB.api(
							"/"+$scope.data.id+"/picture?width=216",
							function (response) {						
							  if (response && !response.error) {
								$scope.data.img = response.data.url;
								$http.post('/saveUser',{data:$scope.data}).success(function(response){
									console.log(response)
									if(response.status == 'OK'){
										var results = response.result;
										$rootScope.user = results;
										$window.location.href = '#/profile';
										$("#email-pop").modal("hide");
									}
									
								});
							  }
							}
						);
					}else{
						$scope.data.type = "twitter";
						$http.post('/saveUser',{data:$scope.data}).success(function(response){
							console.log(response)
							if(response.status == 'OK'){
								var results = response.result;
								$rootScope.user = results;
								$window.location.href = '#/profile';
								$("#email-pop").modal("hide");
							}
							
						});
					}
				}else{
					$scope.message = response.message;
				}
			});
		}else{
			$scope.message = "Enter Valid Email ID";
		}
	}
	
	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
	
	window.fbAsyncInit = function() {
		FB.init({
			appId      : '1453646344961262',
			xfbml      : true,
			version    : 'v2.2'
		});
	};
	 
	(function(d, s, id){
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
	
// function for google sign in

 (function() {
       var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
       po.src = 'https://apis.google.com/js/client.js?onload=onLoadCallback';
       var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
     })();
     function logout()
{
    gapi.auth.signOut();
    location.reload();
}
$.fn.googleLogin = function(type) 
{
  var myParams = {
    'clientid' : '755750646212-hie3nejshns5gsd6gfqbnfvoihvr4tvt.apps.googleusercontent.com',
    'cookiepolicy' : 'single_host_origin',
    'callback' : $scope.loginCallback,
    'approvalprompt':'force',
    'scope' : 'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.profile.emails.read'
  };
  gapi.auth.signIn(myParams);
  
}

$scope.userInfoCallback = function(userInfo) {
	$scope.data.type = 'google';
	$scope.data.id = userInfo.id;
	$scope.data.first_name = userInfo.name.givenName;
	$scope.data.last_name = userInfo.name.familyName;
	$scope.data.email = userInfo.emails[0].value;
	$scope.data.img = userInfo.image.url;
	
	var imageUrl = $scope.data.img;
	var tempimageUrl = imageUrl.split("?");
	
	$scope.data.img = tempimageUrl[0]+"?sz=250";
	
	console.log($scope.data.img)

	$http.post('/saveUser',{data:$scope.data}).success(function(response){
		if(response.status == 'OK'){
			var results = response.result;
			$rootScope.user = results;
			$window.location.href = '#/profile';
		}
		
	});
};
 
$scope.loginCallback = function (authResult)
{
// Do a check if authentication has been successful.
    if(authResult['access_token']) {
       	gapi.client.request(
	    {
	        'path':'/plus/v1/people/me',
	        'method':'GET',
	        'callback': $scope.userInfoCallback
	    }
	);

        //     ...
    } else if(authResult['error']) {
        // Error while signing in.
        $scope.signedIn = false;

        // Report error.
    }
 
    }
 

 $.fn.onLoadCallback = function()
	{
	    gapi.client.setApiKey('AIzaSyDor89kMIaagUpVhKc5ifpkvS_jk53lO_Y');
	    gapi.client.load('plus', 'v1',function(){});
	}
	
});

app.controller('aboutController', function($scope,Session, $http) {
	$scope.session = Session;
	$scope.endorse = {};
	
	$scope.showPopup = function(img){
		$scope.imgSrc = img;
		$("#img-pop").modal("show");
	}
	
	$scope.submit = function(){
		if($scope.endorse.first_name != undefined && $scope.endorse.last_name != undefined && $scope.endorse.phone != undefined && $scope.endorse.emailid != undefined &&  $scope.endorse.books != undefined ){
			if( validateEmail($scope.endorse.emailid) ){
				if( $scope.endorse.phone.length < 10 ){
					$scope.message = "Enter valid Phone Number";
				}else{
					$http.post('/mailEndorse',{'data': $scope.endorse}).success(function(response){
						if(response.code == "200"){
							$scope.endorse = {};
							$scope.message = "";
							$scope.SuccessMessage = "Thank you! We'l get in touch with you for endorsement shortly!";
						}
					});
				}
			}else{
				$scope.message = "Enter valid Email ID";
			}
		}else{
			$scope.message = "Fill All the Fields!";
		}
	}
	
	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
});

app.controller('contactController', function($scope,Session, $http) {
	$scope.session = Session;
	$scope.query = {};
	
	$scope.submit = function(){
		if($scope.query.first_name != undefined && $scope.query.last_name != undefined && $scope.query.phone != undefined && $scope.query.emailid != undefined &&  $scope.query.subject != undefined  &&  $scope.query.querymessage != undefined ){
			if( validateEmail($scope.query.emailid) ){
				if( $scope.query.phone.length < 10 ){
					$scope.message = "Enter valid Phone Number";
				}else{
					$http.post('/mailEnquiry',{'data': $scope.query}).success(function(response){
						if(response.code == "200"){
							$scope.query = {};
							$scope.message = "";
							$scope.SuccessMessage = "Thank you! We'l get in touch right away!";
						}
					});
				}
			}else{
				$scope.message = "Enter valid Email ID";
			}
		}else{
			$scope.message = "Fill All the Fields!";
		}
	}
	
	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
});

app.controller('faqController', function($scope,Session) {
	$scope.session = Session;
});
app.controller('thankyouController', function($scope,Session) {
	$scope.session = Session;
	if($scope.session.data == ""){
		$scope.hasuser="false";
	}else{
		$scope.hasuser="true";
		$scope.username = $scope.session.data.first_name;
	}
});
	
	