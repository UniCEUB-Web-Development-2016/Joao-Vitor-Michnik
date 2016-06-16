var app = angular.module('MyParty', ["ngRoute"]);
app.controller('PartiesCtrl', function($scope, $http, $timeout) {
	$scope.search;
	$scope.PartyList = true;
	$scope.PartyInfo;
	$scope.redInfo = function(value){
		$scope.PartyList = false;
		$scope.party = value;
		$scope.PartyInfo = true;
	};
	$scope.redList = function(){
		$scope.PartyList = true;
		$scope.PartyInfo = false;
	};
	$scope.teste = function(value){
		alert(value);
	};
	  $http({
	    method : "GET",
	    url : "http://localhost/MyParty/party?"
	  }).then(function mySuccess(response) {
	      $scope.myData = response.data;
	    }, function myError(response) {
	      $scope.myData = response.statusText;
	  });
	  $scope.rodar = function(){
		  $timeout(function () {
		  		var mapOptions = {
	                  mapTypeControlOptions: {
	                    mapTypeIds: ['']
	                  },
	                  zoom: 14,
	                  center: new google.maps.LatLng($scope.party.map_lat,$scope.party.map_long),
	                  mapTypeId: google.maps.MapTypeId.ROADMAP,
	                  styles: styles
	              };

	              $scope.map = new google.maps.Map(document.getElementById('map'), mapOptions);
	              $scope.markers = [];

	              var infoWindow = new google.maps.InfoWindow();
	              
	                  var marker = new google.maps.Marker({
	                      map: $scope.map,
	                      position: new google.maps.LatLng($scope.party.map_lat, $scope.party.map_long),
	                      icon: '../img/icon.png'
	                  });         
	  	}, 100);
	};

});
app.controller('MapCtrl', function ($scope, $http) {
	$scope.myData;
	$http({
        method : "GET",
        url : "http://localhost/MyParty/map?"
    	}).then(function mySuccess(response) {
        //$scope.myData = JSON.stringify(response.data);
        $scope.myData = response.data;
        for(var i = 0; i < $scope.myData.length;i++){
          createMarker($scope.myData[i]);
        }
	});
	var mapOptions = {
      mapTypeControlOptions: {
        mapTypeIds: ['']
      },
      zoom: 14,
      center: new google.maps.LatLng(-15.793999,-47.882882),
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      styles: styles
	}

	$scope.map = new google.maps.Map(document.getElementById('map'), mapOptions);

	$scope.markers = [];

	var infoWindow = new google.maps.InfoWindow();

	var createMarker = function (info){
	      
      var marker = new google.maps.Marker({
          map: $scope.map,
          position: new google.maps.LatLng(info.map_lat, info.map_long),
          title: info.party_name,
          icon: '../img/icon.png'
      });

      google.maps.event.addListener(marker, 'click', function(){
          infoWindow.setContent('<a href="#" style="text-decoration: none;font-size:16px;margin-right:5px;">' + marker.title + '</a>');
          infoWindow.open($scope.map, marker);
      });
      $scope.markers.push(marker);          
	};  
});
app.controller('NewPartyCtrl', function($scope, $http, $window) {
	$scope.party_name;
	$scope.Description;
	$scope.price;
	$scope.max_participants;
	$scope.age_group;
	$scope.initial_date;
	$scope.final_date;
	$scope.city;
	$scope.lat;
	$scope.lon;
	$scope.functionPOST = function(){
		$http({
			//http://localhost/MyParty/map?map_lat=1&map_long=1
		  	//http://localhost/MyParty/party/?party_name=teste&description=teste&max_participants=200&age_group=19&initial_date=200-05-05&final_date=200-05-05&price=30&creator=teste&city=planaltina&map_lat=4&map_long=6
		    method : "POST",
		    url : "http://localhost/MyParty/party?party_name="+ $scope.party_name +"&description="+ $scope.Description +"&max_participants="+ $scope.max_participants +"&age_group="+ $scope.age_group +"&initial_date="+ $scope.initial_date +"&final_date="+ $scope.final_date +"&price="+ $scope.price +"&creator=João&city="+ $scope.city + "&map_lat=" + $scope.lat +"&map_long="+$scope.lon
		  }).then(function mySucces(response) {
		      $scope.myData = response.data;
		    }, function myError(response) {
		      $scope.myData = response.statusText;
		  });
		};
});