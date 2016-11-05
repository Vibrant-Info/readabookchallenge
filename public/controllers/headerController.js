app.controller("headerController", function($scope, Session, $http,$window){
	$scope.data = {};
	$scope.session = Session;

	if($scope.session.data == ""){
		$scope.hasuser="false";
	}else{
		$scope.hasuser="true";
		$scope.username = $scope.session.data.first_name;
	}

	$scope.login = function(type){
		if(type == "fb")
			$().facebookLogin(type);
		if(type == "twitter")
			$().twitterLogin(type);
		if(type == "google")
			$().googleLogin(type);
		
	}
	$scope.logout = function(){
		$http.get('/logout').success(function(){
			Session.updateSession();
			$scope.hasuser="false";
			$scope.username="";
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
					FB.api(
						"/"+response.id+"/picture?width=216",
						function (response) {						
						  if (response && !response.error) {
							$scope.data.img = response.data.url;
							$http.post('/saveUser',{data:$scope.data}).success(function(response){
								if(response.status == 'OK'){
									var results = response.result;
									$scope.username = results.first_name;
									$scope.hasuser="true";
								}else{
									$scope.hasuser="false";
								}
								
							});
						  }
						}
					);
				});
				
			}
		}, {scope: 'email,public_profile', return_scopes: true});
	};
	
	window.fbAsyncInit = function() {
		//SDK loaded, initialize it
		FB.init({
			appId      : '1657182577883387',
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
// When callback is received, process user info.
$scope.userInfoCallback = function(userInfo) {
		$scope.data.type = 'google';
			$scope.data.id = userInfo.id;
			$scope.data.name = userInfo.displayName;
			$scope.data.email = userInfo.emails[0].value;
			$scope.data.img = userInfo.image.url;
			$http.post('/saveUser',{data:$scope.data}).success(function(response){
				if(response.status == 'success'){
					var results = response.result;
					$scope.username = results.name;
					$scope.hasuser="true";
				}else{
					$scope.hasuser="false";
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
	
 //when the user clicks the twitter button, the popup authorization window opens
    $.fn.twitterLogin = function(type) {
       $http.get('/auth/twitter').success(function(rs){
      $window.open(rs,'_self','width=500,height=400');
       })
	}
	

});