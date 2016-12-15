app.controller('galleryController', function($scope, $uibModal, Session) {
	$scope.session = Session;
	MAgallery("myGallery");
	
	/* $scope.thumbs = [
      {"image":"images/gallery/gallery-img1.jpg","name":""},
      {"image":"images/gallery/gallery-img2.jpg","name":""},
      {"image":"images/gallery/gallery-img3.jpg","name":""},
      {"image":"images/gallery/gallery-img4.jpg","name":""},
      {"image":"images/gallery/gallery-img5.jpg","name":""},
      {"image":"images/gallery/gallery-img6.jpg","name":""},
      {"image":"images/gallery/gallery-img7.jpg","name":""},
      {"image":"images/gallery/gallery-img8.jpg","name":""},
      {"image":"images/gallery/gallery-img9.jpg","name":""},
      {"image":"images/gallery/gallery-img10.jpg","name":""},
      {"image":"images/gallery/gallery-img11.jpg","name":""},
      {"image":"images/gallery/gallery-img12.jpg","name":""},
      {"image":"images/gallery/gallery-img13.png","name":""},
      {"image":"images/gallery/gallery-img14.png","name":""},
      {"image":"images/gallery/gallery-img15.png","name":""}
    ];
	  
	$scope.open=function(indx){
	    $scope.thumbs[indx].active=true;
	    alert(indx)
      $scope.$uibModalInstance=$uibModal.open({
        animation: true,
        templateUrl: 'template/pic-modal.html',
        scope: $scope
      });
    };
	 $scope.myInterval = 5000;
	  $scope.noWrapSlides = false;
	  $scope.active = 0;
	  var slides = $scope.slides = [];
	  var currIndex = 0;
	$scope.ok = function () {
		$scope.$uibModalInstance.close();
	}; */
});