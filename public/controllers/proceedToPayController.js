app.controller("proceedToPayController", function($scope, $http, $window,$rootScope, sharedProperties){
	
	var checkOut_data = sharedProperties.getProperty();
	if( checkOut_data != "" && checkOut_data != undefined ){
		$scope.checkOut = checkOut_data[0];
		console.log($scope.checkOut)
		document.getElementById("order_id").value = $scope.checkOut.orders.number;
		document.getElementById("amount").value = $scope.checkOut.orders.total;
		document.getElementById("billing_name").value = $scope.checkOut.profile.first_name +" "+ $scope.checkOut.profile.last_name;
		document.getElementById("billing_address").value = $scope.checkOut.profile.address;
		document.getElementById("billing_city").value = $scope.checkOut.profile.city;
		document.getElementById("billing_zip").value = $scope.checkOut.profile.pincode;
		document.getElementById("billing_tel").value = $scope.checkOut.profile.phone_number;
		document.getElementById("billing_email").value = $scope.checkOut.profile.email_id;
		
		setTimeout(function(){
			document.customerData.submit();
		}, 500);
	}else{
		window.location.href = "#/profile";
	}
});