app.controller("headerController", function($scope, $http,$window, $rootScope, $location){
	$scope.data = {};
	
	$('#navbar ul li a').on('click', function(){
		$('.navbar-toggle').click();
	});	
	$scope.login = function(type){
		if(type == "fb")
			$().facebookLogin(type);
		if(type == "google")
			$().googleLogin(type);
	}
	
	var path = $location.path();
	if( path == "/")
		$scope.homePage = true;
	else if (path == "/about-us")
		$scope.aboutPage = true;
	else if (path == "/gallery")
		$scope.galleryPage = true;
	else if (path == "/contact-us")
		$scope.contactPage = true;
	else if (path == "/faq")
		$scope.faqPage = true;
	
	$scope.activeClass = function(page){
		//location.reload();
		MAgallery("myGallery");
		if( page == "homePage"){
			$scope.homePage = true;
			$scope.aboutPage = false;
			$scope.galleryPage = false;
			$scope.contactPage = false;
			$scope.faqPage = false;
		}else if (page == "aboutPage"){
			$scope.homePage = false;
			$scope.aboutPage = true;
			$scope.galleryPage = false;
			$scope.contactPage = false;
			$scope.faqPage = false;
		}else if (page == "galleryPage"){
			$scope.homePage = false;
			$scope.aboutPage = false;
			$scope.galleryPage = true;
			$scope.contactPage = false;
			$scope.faqPage = false;
		}else if (page == "contactPage"){
			$scope.homePage = false;
			$scope.aboutPage = false;
			$scope.galleryPage = false;
			$scope.contactPage = true;
			$scope.faqPage = false;
		}else if (page == "faq"){
			$scope.homePage = false;
			$scope.aboutPage = false;
			$scope.galleryPage = false;
			$scope.contactPage = false;
			$scope.faqPage = true;
		}
	}
	
	$scope.logout = function(){
		$http.get('/logout').success(function(){
			$rootScope.user = "";
			$window.location.href = '#/';
		});
	}
		
	$.fn.facebookLogin = function(type) {		
		FB.login(function(response) {
			if (response.authResponse) {
				FB.api("/me", {fields: "id,first_name,last_name,picture, email, gender"}, function(response){
					$scope.data.type = type;
					$scope.data.id = response.id;
					$scope.data.first_name = response.first_name;
					$scope.data.last_name = response.last_name;
					$scope.data.email = response.email;
					$scope.data.img = response.picture.data.url;
						console.log($scope.data);
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
										location.reload();
									}
									
								});
							  }
							}
						);
					
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
										location.reload();
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