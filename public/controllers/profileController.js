app.controller("profileController", function($scope, Session, $http, $window){
	$scope.data = {};	
	$scope.session = Session;
	$scope.content = 'reading';
	
	//$scope.seconds = new Date('2016-12-03 11:34:35').getTime() / 1000;
	
	
	
	$scope.return = function(){
		var timerCount;
		$http.get('/books').success(function(response){
			$scope.books = response.reading;
			$scope.timer = response.timer;
			if( response.length == 0 ||  response.length == undefined ){	
				$scope.startChallenge = true;
				$().select2fn();
			}else{
				callAgain($scope.timer);
				$scope.existChallenge = true;
				$().select2fn();				
			}
		});
	}
	
	function callAgain(timerCount){		
		$().select2fn();
		$().countDown(timerCount);
	}
	
	if($scope.session.data == ""){	
		Session.updateSession();
		$window.location.href = '#/';
		$scope.hasuser="false";
	}else{
		$scope.hasuser="true";
		$scope.username = $scope.session.data.first_name;
	}
	
	/* Load loggedin User Profile */ 
	$scope.loadData = function(){
		$http.get('/my-profile').success(function(response){
			$scope.profileData = response;
		});
		$http.get('/city').success(function(response){
			$scope.city = response;
		});
		
		$http.get('/pincode').success(function(response){
			$scope.pincode = response;
		});
		
		$http.get('/genre').success(function(response){
			var interestedID = [];
			$scope.gnere = response.genres;
			var interested = response.interested;
			for(i=0; i < interested.length; i++){
				interestedID.push(interested[i]['category_id']);
			}
			setTimeout(function(){
				$('#interestCategory').val(interestedID).trigger("change");
			}, 500)
			
		});
		
		$http.get('/books').success(function(response){
			$scope.books = response.reading;
			$scope.timer = response.timer;
			if( response.length == 0 ||  response.length == undefined){				
				$scope.startChallenge = true;
			}else{
				$scope.existChallenge = true;
			}
		});
		
		
	}
	
	/* Edit loggedin User Profile */ 
	$scope.editProfile = function(){
		$().removeDisabled();
	}
	
	/* Update loggedin User Profile */ 
	$scope.updateProfile = function(){
		$http.put('/updateProfile',{'data': $scope.profileData}).success(function(response){
			console.log(response);
			if(response.status == "failed"){
				$scope.message = response.message;
			}else{
				$http.get('/my-profile').success(function(response){
					$scope.profileData = response;
				});
			}
		});
	}
	
	setTimeout(function(){
		$scope.return();
	},500);
	
	
	$.fn.select2fn = function() {
		$('#interestCategory').select2().on("select2:selecting", function(e) {			
			$http.post('/updateGenere',{id: e.params.args.data.id}).success(function(response){
				
			});
        }).on("select2:unselecting", function(e) {
			$http.post('/updateGenere',{id: e.params.args.data.id}).success(function(response){
				
			});
        });
		$("#profile").find('input').attr('disabled', 'true');
		$("#profile").find('select').attr('disabled', 'true');
	};
	
	$.fn.removeDisabled = function() {
		$("#profile").find('input').removeAttr('disabled');
		$("#profile").find('select').removeAttr('disabled');
	};
	$.fn.countDown = function(date) {
		$('#future_date').countdowntimer({
            dateAndTime : date,
            size : "lg",
            regexpMatchFormat: "([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})",
			regexpReplaceWith: "$1<sup class='displayformat'>days</sup> $2<sup class='displayformat'>hours</sup> $3<sup class='displayformat'>minutes</sup> $4<sup class='displayformat'>seconds</sup>",
			timeUp: timeUp
        });
	};
	
	function timeUp(){
		$http.post('/timeUp').success(function(response){
			if(response.affectedRows == 1){
				$scope.return();
				$scope.loadData();
			}
		});
	}
});