app.controller("profileController", function($scope, Session, $http){
	$scope.data = {};
	$scope.session = Session;
	
	$scope.return = function(){
		$().select2fn();
	}
	
	if($scope.session.data == ""){
		$scope.hasuser="false";
	}else{
		$scope.hasuser="true";
		$scope.username = $scope.session.data.first_name;
	}
	
	setTimeout(function(){
		$scope.return();
	},1000);
	
	
	$.fn.select2fn = function() {
		$('select').select2();
	};
});