app.controller("startChallengeController", function($scope, $rootScope, $http, $window, sharedProperties){
	$scope.data = {};	
	
	$scope.step = 'step1';
	$scope.payment = 'credit card';
	$scope.orders = {};
	if($rootScope.user == undefined || $rootScope.user == ''){
		window.location.href="#/";
	}
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
			$scope.interested = response.interested;
			addClass($scope.interested)
		});
		
		$http.get('/checkChallenge').success(function(response){
			if(response.code == 400){
				$window.location.href = '#/profile';
			}
		});
		
		
	}
	
	$scope.updateCategory = function(val){
		$http.post('/updateGenere',{id: val}).success(function(response){});
	}
	
	
	$scope.changeStep2 = function(){
		if( $scope.orders.noOfBooks > 0 ){
			$http.get('/genre').success(function(response){
				$scope.interested = response.interested;
				if($scope.interested.length > 0) {
					$http.post('/price',
						{
							'count' : $scope.orders.noOfBooks, 
							'interested': $scope.interested 
						}).success(function(response){
							$scope.message = "";
							$scope.orders.delivery_charge = response.plan.delivery_charge;
							$scope.orders.no_of_book = response.plan.no_of_book;
							$scope.orders.pickup_charge = response.plan.pickup_charge;
							$scope.orders.price_per_month = response.plan.price_per_month;
							$scope.orders.cat_name = "";
							$scope.orders.cat_ids = "";
							
							for(i=0; i< response.cat_name.length; i++){
								$scope.orders.cat_name += response.cat_name[i].category_name + ",";
								$scope.orders.cat_ids += response.cat_name[i].id + ",";
							}
							$scope.orders.cat_name = $scope.orders.cat_name.replace(/(^,)|(,$)/g, "");
							$scope.orders.cat_ids = $scope.orders.cat_ids.replace(/(^,)|(,$)/g, "");
							
							var date = new Date();
							var newdate = new Date(date);
							newdate.setDate(newdate.getDate() + 6);
							var nd = new Date(newdate);	
							var monthNames = [
							  "January", "February", "March",
							  "April", "May", "June", "July",
							  "August", "September", "October",
							  "November", "December"
							];

							var date = new Date(nd);
							var day = date.getDate();
							var monthIndex = date.getMonth();
							var year = date.getFullYear();
							var terms;
							
							if( day == 1 )
								terms = 'st';
							else if( day == 2 )
								terms = 'nd';
							else if( day == 3)
								terms = 'rd';
							else
								terms = 'th';
							
							$scope.orders.expectedDate = day + terms+' ' + monthNames[monthIndex] + ' ' + year;
							
							$scope.orders.deposit = 500 - $scope.profileData.wallet;
							
							$scope.orders.total = parseInt($scope.orders.price_per_month) + parseInt($scope.orders.pickup_charge) + parseInt($scope.orders.delivery_charge) + parseInt($scope.orders.deposit);
							$scope.step = 'step2';
					});
				}else{
					$scope.message = "Please Choose one of the Genres!";
				}
			});
		}else{
			$scope.message = "Please Choose Number of Books";
		}
	}
	
	$scope.changeStep3 = function(){
		
		if( $scope.profileData.address != '' && $scope.profileData.city != ''  && $scope.profileData.area != '' && $scope.profileData.pincode != '' && $scope.profileData.phone_number != '' && $scope.profileData.alt_phone_number != '' ){
			$http.put('/updateProfile',{'data': $scope.profileData, 'orderData': $scope.orders}).success(function(response){
				$scope.message = "";
				$scope.FinalOrderNumber = response.someText;
				
				if($scope.FinalOrderNumber != undefined && $scope.FinalOrderNumber != 'undefined' ){
					$scope.step = 'step3';					
				}else{
					$("#undefined_pop").modal("show");
				}
			});
		}else{
			$scope.message = "Please Fill all the Fields!";
		}
	}
	
	$scope.changeStep1 = function(){
		$http.get('/genre').success(function(response){
			$scope.gnere = response.genres;
			$scope.interested = response.interested;
			addClass($scope.interested)
		});
		$scope.step = 'step1';
	}
	
	$scope.proceed = function(){
		$scope.orders.number = $scope.FinalOrderNumber;
		
		var checkoutData = [{'profile': $scope.profileData, 'orders': $scope.orders}];
		sharedProperties.setProperty(checkoutData);
		window.location.href = "#/proceed";
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
	}
	
	/*check out*/
	var username = "readabookchallenge@gmail.com";
	var hash = "3a3bdd183ec7601ae380c99c4ad01445ebb1c3ea";
	var test = "0";
	var sender = "RDBOOK";
	
	$scope.finalCheckout = function(type){
		var ip_address;
		$.getJSON("http://jsonip.com/?callback=?", function (data) {
			ip_address = data.ip;
			$http.post('/checkOut',{'order': $scope.orders, 'profile': $scope.profileData, 'type': type, 'ip': ip_address}).success(	function(response){
				if(response.code == 200){
					$window.location.href = '#/thank-you';
					/* var message = "Hi "+$scope.profileData.first_name+", Your order has been successfully placed. Expected date of delivery on or before "+$scope.orders.expectedDate+". Please make sure someone is available at the address.";				
					var numbers = $scope.profileData.phone_number;				
					var SMSdata = "username="+username+"&hash="+hash+"&message="+message+"&sender="+sender+"&numbers="+numbers+"&test="+test;
					$http.post('http://api.textlocal.in/send/?'+SMSdata).success( function(response, err){
						console.log(response)
						console.log(err)
					}); */
				}
			});
		});
	}
	
	function addClass(interested){
		setTimeout(function(){
			for(i=0; i < interested.length; i++){
				$('.active_'+interested[i]['category_id']).addClass('active');
			}
		}, 500);
	}
	
	
	
});
