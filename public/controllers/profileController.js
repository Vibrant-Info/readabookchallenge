app.controller("profileController", function($scope, Session, $http, $window){
	$scope.data = {};	
	$scope.session = Session;
	//$scope.arrow = true;
	$scope.return = function(){
		$().select2fn();
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
		$http.get('/gnere').success(function(response){
			$scope.gnere = response;
		});
	}
	
	/* Edit loggedin User Profile */ 
	$scope.editProfile = function(){
		$().removeDisabled();
	}
	
	/* Update loggedin User Profile */ 
	$scope.updateProfile = function(){
		
		console.log($scope.profileData)
		/* $http.put('/updateProfile').success(function(response){
			console.log($scope.profileData)
			//$scope.gnere = response;
		}); */
	}
	
	setTimeout(function(){
		$scope.return();
	},500);
	
	
	$.fn.select2fn = function() {
		$('#interestCategory').select2();
		$("#derp").find('input').attr('disabled', 'true');
		$("#derp").find('select').attr('disabled', 'true');
	};
	
	$.fn.removeDisabled = function() {
		$("#derp").find('input').removeAttr('disabled');
		$("#derp").find('select').removeAttr('disabled');
	};
	$.fn.defaultSelect2Values = function() {
			for(var i=0;i<tag.length;i++){
				tags.push(tag[i].name);
				tag_id.push(tag[i].id);
			}
		
			 selections = ["37"];
			
			var extract_preselected_ids = function (element) {
				var preselected_ids = [];
				if (element.val())
					$(element.val().split(",")).each(function () {
						preselected_ids.push({id: this});
					});
				return preselected_ids;
			};

			var preselect = function (preselected_ids) {
				var pre_selections = [];
				for (index in selections)
					for (id_index in preselected_ids)
						if (selections[index].id == preselected_ids[id_index].id)
							pre_selections.push(selections[index]);
						console.log(pre_selections);
				return pre_selections;
			};
			 $("#select2-option").select2();
			$('#art_tag').select2({
				placeholder: 'Select Tags',
				minimumInputLength: 0,
				multiple: true,
				allowClear: true,
				data: function () {
					return {results: selections}
				},
				initSelection: function (element, callback) {
					var preselected_ids = extract_preselected_ids(element);
					var preselections = preselect(preselected_ids);
					callback(preselections);
				}
			}).select2('val', tag_id);
	};
});