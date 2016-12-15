app.controller("profileController", function($scope, $http, $window,$rootScope, sharedProperties){
	$scope.data = {};
	$scope.content = 'reading';
	$scope.paytm = {};
	//$scope.seconds = new Date('2016-12-03 11:34:35').getTime() / 1000;
	$scope.regex = "/^[0-9]{10}$/";
	if($rootScope.user == undefined || $rootScope.user == ''){
		window.location.href="#/";
	}
	$('[data-toggle="tooltip"]').tooltip(); 
	//location.reload();
	$('.in').removeClass("modal-backdrop");
	
	setTimeout(function(){
		$( "#startChallenges" ).effect( "shake",{direction: "up", times: 2} );
	}, 500);
	
	$scope.return = function(){
		var timerCount;
		$http.get('/books').success(function(response){
			$scope.books = response.reading;
			$scope.timer = response.timer;
			$scope.orderStatus = response.status;
			//if( $scope.orderStatus != 'selection' &&  $scope.orderStatus != 'labeling' &&   $scope.orderStatus != 'on transits' &&   $scope.orderStatus != 'packaging' ){
				if( $scope.timer == null || $scope.timer == '' ){
					if( $scope.books.length == 0 ||  $scope.books.length == undefined ){	
						$scope.startChallenge = true;
						$().select2fn();
					}else{
						$scope.notConfirmChallenge = true;
						$().select2fn();				
					}
				}else{
					if($scope.orderStatus == 'pickup'){
						callAgain($scope.timer);
						$scope.startChallenge = false;
						$scope.notConfirmChallenge = false;
						$scope.existChallenge = false;
						$scope.timerChallenge = true;
						$scope.pickupRequest = true;
					}else{
						callAgain($scope.timer);
						$scope.existChallenge = true;
						$scope.timerChallenge = true;
						$().select2fn();
					}
				}
/* 			}else{
				$scope.notConfirmChallenge = true;
				$().select2fn();				
			} */
			
		});
	}
	
	$scope.payDeposits = function(){
		var d = new Date();
		var n = d.getTime();
		$scope.WalletOrderNumber = "RABC"+$scope.profileData.user_id+n;
		$scope.depositeAmountWallet = $scope.depositeAmount;
		$('#deposite').modal();
	}
	$scope.withdraw = function(){
		$('#paytm-pop').modal();
		$scope.message = "";
	}
	
	$scope.sendRequest = function(){
		var paytmMbl = $scope.paytm.mobile;
		if( paytmMbl != undefined && paytmMbl.toString().length == 10){
			$http.post("/walletRequest",{ number: paytmMbl, id : $scope.profileData.user_id} ).success(function(response){
				if(response.code == 200){
					$scope.loadData();
					$("#paytm-pop").modal('hide');
					$("#thankyou-pop").modal();
				}
			});
			$scope.message = "";
		}else{
			$scope.message = "Please Enter Valid Mobile Number";
		}
	}
	
	function callAgain(timerCount){
		$().select2fn();
		$().countDown(timerCount);
	}
	
	
	/* Load loggedin User Profile */ 
	
	$scope.loadData = function(){
		$scope.depositBtnShow = true;
		$http.get('/my-profile').success(function(response){			
			$scope.profileData = response;
			$scope.depositeAmount = 500 - $scope.profileData.wallet;
			if($scope.depositeAmount == 0)
				$scope.depositBtnShow = false;
		});
		$http.get('/city').success(function(response){
			$scope.city = response;
		});
		
		$http.get('/pincode').success(function(response){
			$scope.pincode = response;
		});
		
		$http.get('/walletRequestStatus').success(function(response){
			$scope.wallet_status = response.status;
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
			$scope.orderStatus = response.status;
			//if( $scope.orderStatus != 'selection' &&  $scope.orderStatus != 'labeling' &&   $scope.orderStatus != 'on transits' &&   $scope.orderStatus != 'packaging'){
				if( $scope.timer == null || $scope.timer == '' ){
					if( $scope.books.length == 0 ||  $scope.books.length == undefined){	
						$scope.startChallenge = true;
						$().select2fn();
					
					}else{
						$scope.notConfirmChallenge = true;
						$().select2fn();				
					}
				}else{
					if($scope.orderStatus == 'pickup'){
						callAgain($scope.timer);
						$scope.startChallenge = false;
						$scope.notConfirmChallenge = false;
						$scope.existChallenge = false;
						$scope.timerChallenge = true;
						$scope.pickupRequest = true;
					}else{
						callAgain($scope.timer);
						$scope.existChallenge = true;
						$scope.timerChallenge = true;
						$().select2fn();
					}
				}
			/* }else{
				$scope.notConfirmChallenge = true;
				$().select2fn();				
			} */
		});
		
		$scope.loadWishlist();
		$scope.loadLibrary();
	}
	
	/* Edit loggedin User Profile */ 
	$scope.editProfile = function(){
		$().removeDisabled();
	}
	
	/* Update loggedin User Profile */ 
	$scope.updateProfile = function(){
		if($scope.profileData.first_name != '' && $scope.profileData.last_name != '' && $scope.profileData.phone_number != '' && $scope.profileData.email_id != '' && $scope.profileData.age != '' && $scope.profileData.address != '' && $scope.profileData.city != '' &&$scope.profileData.area != '' &&  $scope.profileData.landmark != '' && $scope.profileData.pincode != '' && $scope.profileData.first_name != undefined && $scope.profileData.last_name != undefined && $scope.profileData.phone_number != undefined && $scope.profileData.email_id != undefined && $scope.profileData.age != undefined && $scope.profileData.address != undefined && $scope.profileData.city != undefined &&$scope.profileData.area != undefined &&  $scope.profileData.landmark != undefined && $scope.profileData.pincode != undefined){
			$http.put('/updateProfile',{'data': $scope.profileData}).success(function(response){
				console.log(response);
				if(response.status == "failed"){
					$scope.updateErrorMessage = "";
					$scope.updateErrorMessage = response.message;
				}else{
					$scope.updateSuccessMessage = "Updated Successfully!"
					$http.get('/my-profile').success(function(response){
						$scope.profileData = response;
					});
				}
			});
		}else{
			$scope.updateErrorMessage = "Please Fill all the Mandatory Fields!";
		}
	}
	
	/*Return Popup */
	$scope.returnPopup = function(){
		$scope.reason = true;
		$scope.newBook = false;
		$scope.returnBook = false;
		$('#return-books').modal();
	}
	/*Extend Popup */
	$scope.extendPopup = function(){
		$('#time-ext').modal();
	}
	
	/*Extend Time */
	var username = "readabookchallenge@gmail.com";
	var hash = "3a3bdd183ec7601ae380c99c4ad01445ebb1c3ea";
	var test = "0";
	var sender = "RDBOOK";	
	
	$scope.extendTime = function(){
		$http.post('/extendTime',{time: $scope.extendTimeVal, books: $scope.books.length}).success(function(response){
			if(response.code == 200){
				$('#time-ext').modal('hide');
				$('#time-thankyou-pop').modal('show');
				$scope.loadData();
				
				var message = "Hi "+$scope.profileData.first_name+", Your extension request for "+$scope.extendTimeVal+" weeks for the Read a Book Challenge has been processed. Happy Reading !";				
				var numbers = $scope.profileData.phone_number;				
				var SMSdata = "username="+username+"&hash="+hash+"&message="+message+"&sender="+sender+"&numbers="+numbers+"&test="+test;
				$http.post('http://api.textlocal.in/send/?'+SMSdata).success( function(response, err){
					console.log(response)
					console.log(err)
				});
				
			}else if(response.code == 400){
				$scope.extError = response.message;
			}
		});
	}
	
	/* GET AMOUNT */
	$scope.getAmount = function(val){
		if( val > 0 && val < 5){
			$http.post('/getExtendAmount',{week: val, books: $scope.books.length}).success(function(response){
				$scope.extendAmntHolder = true;
				$scope.extendAmountWeeks = response.amount;
			});
		}
	}
	
	$scope.payDeposit = function(){
		//depositeAmount
		/* $http.post('/ccavRequestHandler',{amount: $scope.depositeAmount}).success(function(response){
			$scope.extendAmntHolder = true;
			$scope.extendAmountWeeks = response.amount;
		}); */
	}
	
	$scope.selectOption = function(val){
		$scope.reason = true;
		$scope.newBook = false;
		$scope.returnBook = false;
		
		if(val == 'returnBook'){
			$scope.reason = false;
			$scope.returnBook = true;
		}else if(val == 'newBook'){
			$scope.newBook = true;
		}
	}
	
	$scope.returnContinue = function(){
		if(!$scope.reason){
			if($scope.returnReason != '' && $scope.returnReason != undefined ){
				$scope.reasonEmpty = false;
				$http.post('/onlyPickup',{reason: $scope.returnReason}).success(function(response){
					if(response.affectedRows == 1){
						$scope.loadData();
						$('#return-books').modal('hide');
						var message = "Hi "+$scope.profileData.first_name+", Your pick up request has been placed and will take place in the next two days, do make sure someone is available at the address with the books.";				
						var numbers = $scope.profileData.phone_number;				
						var SMSdata = "username="+username+"&hash="+hash+"&message="+message+"&sender="+sender+"&numbers="+numbers+"&test="+test;
						$http.post('http://api.textlocal.in/send/?'+SMSdata).success( function(response, err){
							console.log(response)
							console.log(err)
						});
					}
				});
			}else{
				$scope.reasonEmpty = true;
			}
		}else{
			$http.post('/setDeliveryType', {val: 'pickup & delivery'}).success(function(response){
				if(response.code == 200){
					$window.location.href = '#/start-challenge';
					location.reload();
				}
			});
		}
	}
	
	/* Start Challenge */
	$scope.start_challenge = function(){
			$http.post('/setDeliveryType', {val: 'delivery'}).success(function(response){
				if(response.code == 200){
					$window.location.href = '#/start-challenge';
				}else{
					$('#taken_challenge_pop').modal('show');
				}
			});
	}
	
	/*My wishlist */
	$scope.wishsearchResults = {};
	var count = 0;
	$scope.wishlistSearch = function(val){
		
		if(val != '' && val != undefined && val.length >3){			
			$.get("https://www.googleapis.com/books/v1/volumes?q="+val+"&maxResults=10", function(data, status){
				if(status == 'success'){
					count++;
					console.log(data)
					 $scope.searchResults = data.items;
					$scope.wishsearchResults = $scope.searchResults;
					$scope.wishlistContent = true;
					if(count == 1){
						$('#searchwishlist').click();						
					}
				}		
			});
		}
		
	}
	
	/* ADD WISHLIST */
	$scope.addWishlist = function(data, index){
		var str = data.volumeInfo.title;
		data.volumeInfo.title = str.replace(/'/g, "\\'");
		$http.post('/wishlistAdd',{'data': data}).success(function(response){
			$scope.loadWishlist();
			if(response.affectedRows == 1){
				var data = $scope.wishsearchResults[index];
				data.status = 'DONE';
				$scope.loadWishlist();
				$scope.wishlistContent = false;
				$scope.libContent = false;
			}else{
				data.status = 'DONE';
			}
		});
	}
	
	/* LOAD WISHLIST */
	$scope.loadWishlist = function(){
		$http.get('/loadWishlist').success(function(response){
			console.log(response);
			if(response.code == 200){
				$scope.emptyWishlist = "";
				$scope.listWishlist = response.data;
			}else{
				$scope.emptyWishlist = response.message;
				$scope.listWishlist = {};
			}
		});
	}
	
	/*REMOVE WISHLIST */
	$scope.removeWishlist = function(id){
		$http.post('/wishlistDelete',{'id': id}).success(function(response){
			$scope.loadWishlist();
		});
	}
	
	
	/*My Library */
	$scope.listsearchResults = {};
	var count = 0;
	$scope.librarySearch = function(val){
		if(val != '' && val != undefined && val.length >3){
			$.get("https://www.googleapis.com/books/v1/volumes?q="+val+"&maxResults=10", function(data, status){
				if(status == 'success'){
					count++;
					console.log(data)
					 $scope.searchResults = data.items;
					$scope.listsearchResults = $scope.searchResults;
					$scope.libContent = true;
					if(count == 1){
						$('#searchlibrary').click();						
					}
				}		
			});
		}
		
	}
	
	/* ADD Library */
	$scope.addLibrary = function(data, index){
		var str = data.volumeInfo.title;
		data.volumeInfo.title = str.replace(/'/g, "\\'");
		$http.post('/libraryAdd',{'data': data}).success(function(response){
			if(response.affectedRows == 1){
				var data = $scope.listsearchResults[index];
				data.status = 'DONE';
				$scope.loadLibrary();
				$scope.wishlistContent = false;
				$scope.libContent = false;
			}else{
				data.status = 'DONE';
			}
		});
	}
	
	/* LOAD Library */
	$scope.loadLibrary = function(){
		$http.get('/loadLibrary').success(function(response){
			if(response.code == 200){
				$scope.listLibrary = response.data;
				$scope.emptyLibrary = "";
			}else{
				$scope.emptyLibrary = response.message;
				$scope.listLibrary = {};
			}
		});
	}
	
	/*REMOVE Library */
	$scope.removeLibrary = function(id){
		$http.post('/libraryDelete',{'id': id}).success(function(response){
			$scope.loadLibrary();
		});
	}
	
	$scope.closeWishlist = function(){
		$scope.wishlistContent = false;
		$scope.libContent = false;
	}
	
	$scope.closeModal = function(){
		$("#deposite").modal('hide');
		$("#paytm-pop").modal('hide');
		$("#thankyou-pop").modal('hide');
		$("#return-books").modal('hide');
		$("#time-ext").modal('hide');
		$("#taken_challenge_pop").modal('hide');
	}
	
	/*$('body').click( function(e){
		if($(e.target).parents('.srch-dropdown').length <= 0){
			$scope.wishlistContent = false;
		}
	});
	
	 $('.srch_add_btn').click( function(){
		 alert();
		$(this).text('ADDED');
	}); */
	
	setTimeout(function(){
		$scope.return();
	},500);
	
	var selectCount = 0;
	var unselectCount = 0;
	$.fn.select2fn = function() {
		$('#interestCategory').select2().on("select2:selecting", function(e) {
			selectCount++;
			if( selectCount == 4 ){
				$http.post('/updateGenere',{id: e.params.args.data.id}).success(function(response){
					selectCount = 0;
				});
			}
        }).on("select2:unselecting", function(e) {
			unselectCount++;
			if( unselectCount == 4 ){
				$http.post('/updateGenere',{id: e.params.args.data.id}).success(function(response){
					unselectCount = 0;
				});
			}
        });
		$("#profile").find('input').attr('disabled', 'true');
		$("#profile").find('select').attr('disabled', 'true');
	};
	
	$scope.proceed = function(){
		$scope.orders = {};
		var d = new Date();
		var n = d.getTime();
		$scope.WalletOrderNumber = "RABC"+$scope.profileData.user_id+n;
		$scope.depositeAmountWallet = $scope.depositeAmount;
		
		$scope.orders.number = $scope.WalletOrderNumber;
		$scope.orders.total = $scope.depositeAmountWallet;
		
		var checkoutData = [{'profile': $scope.profileData, 'orders': $scope.orders}];
		sharedProperties.setProperty(checkoutData);
		window.location.href = "#/proceedWallet";
	}
	
	$.fn.removeDisabled = function() {
		$("#profile").find('input').removeAttr('disabled');
		$("#profile").find('select').removeAttr('disabled');
	};
	$.fn.countDown = function(date) {
		$('#future_date').countdowntimer({
            dateAndTime : date,
            size : "lg",
            regexpMatchFormat: "([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})",
			regexpReplaceWith: "<span class='timer-profile'>$1</span>:<span class='timer-profile'>$2</span>:<span class='timer-profile'>$3</span>:<span class='timer-profile'>$4</span>"
			//timeUp: timeUp
        });
	};
	
	/* function timeUp(){
		$http.post('/timeUp').success(function(response){
			if(response.affectedRows == 1){
				$scope.return();
				$scope.loadData();
			}
		});
	} */
	
	$scope.loadData();
});

function isNumberKey(evt){
	  var charCode = (evt.which) ? evt.which : evt.keyCode;
	  if (charCode != 46 && charCode > 31 
		&& (charCode < 48 || charCode > 57))
		 return false;

	  return true;
   }