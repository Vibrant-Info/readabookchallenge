app.controller("startChallengeController", function($scope, Session, $http, $window){
	$scope.data = {};	
	$scope.session = Session;
	$scope.step = 'step1';
	
	$scope.return = function(){
		var timerCount;
		$http.get('/books').success(function(response){
			$scope.books = response.reading;
			$scope.timer = response.timer;
			if( response.length == 0 ||  response.length == undefined ){	
				$scope.checkChallenge = false;
			}else{
				$window.location.href = '#/profile';
				$scope.checkChallenge = false;
			}
		});
		
		$http.get('/genre').success(function(response){
			$scope.gnere = response.genres;
			var interested = response.interested;
			addClass(interested)
		});
	}
	
	function addClass(interested){
		setTimeout(function(){
			for(i=0; i < interested.length; i++){
				$('.active_'+interested[i]['category_id']).css('opacity', '0.4');
				$('.active_'+interested[i]['category_id']).addClass('active');
			}
		}, 500);
	}
	
	if($scope.session.data == ""){	
		Session.updateSession();
		$window.location.href = '#/';
		$scope.hasuser="false";
	}else{
		$scope.hasuser="true";
		$scope.username = $scope.session.data.first_name;
	}
	
});
