var app = angular.module('MyParty', ["ngRoute","ngCookies","srph.age-filter"]);
app.config(function($routeProvider,$locationProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "view/login.html",
        controller : "LoginCtrl"
    })
    .when("/view_party/:party", {
        templateUrl : "view/viewparty.html",
        controller : "ViewPartyCtrl"
    })
    .when("/home", {
        templateUrl : "view/partylist.html",
        controller : "PartiesCtrl"
    })
    .when("/map", {
        templateUrl : "view/map.html",
        controller : "MapCtrl"
    })
    .when("/new_party", {
        templateUrl : "view/newparty.html",
        controller : "NewPartyCtrl"
    })
    .when("/edit_profile", {
        templateUrl : "view/editprofile.html",
        controller: "EditProfileCtrl"
    });
});
app.controller('NavbarCtrl', function($scope, $http, $cookies) {
	$scope.login = $cookies.get('login');
	$scope.removeCookie = function(){
		$cookies.remove("login");
		$cookies.remove("email");
	};
	$scope.sessionBroke = function(){
		$http({
		    method : "GET",
		    url : "http://localhost/MyParty/user?session_broke"
		  }).then(function mySuccess(response) {
		    $scope.mySession = response.data;
		    console.log($scope.myData);	 
		    	$scope.removeCookie();
		    	window.location = '#/';
		    }, function myError(response) {
		    $scope.mySession = response.statusText;
		  });
	};
});
app.controller('LoginCtrl', function($scope, $http, $cookies) {
		$scope.gender = "male";
		$scope.msg;
		$scope.birthday;
		$scope.setCookie = function(val1,val2){
			$cookies.put('login',val1);
			$cookies.put('email',val2);
		};
		$scope.setDate = function(value){
			$scope.birthday = value;
		};
		$scope.functionGET = function(value1,value2){
		$http({
		    method : "GET",
		    url : "http://localhost/MyParty/user?login=" + value1 + "&pass=" + value2
		  }).then(function mySuccess(response) {
		    $scope.myData = response.data;
		    if(angular.equals([], $scope.myData)){
		    	$scope.msg = true;
		    }else{
		    	$scope.msg = false;
		    	$scope.setCookie($scope.myData[0].login,$scope.myData[0].email);
		    	window.location = '#/home';
		    }
		    }, function myError(response) {
		    $scope.myData = response.statusText;
		  });
	  	};
		$scope.functionPOST = function(value1,value2,value3,value4,value5,value6,value7){
		$http({
			//http://localhost/MyParty/user?first_name=joao&last_name=teste&birthday=1996-07-20&email=joao@gmail.com&login=jvmichnik&pass=123123&relationship_status=solteiro&hometown=
		    method : "POST",
		    url : "http://localhost/MyParty/user?first_name="+ value1 +"&last_name="+ value2 +"&birthday="+ $scope.birthday +"&email="
		    + value4 +"&login="+ value5 +"&pass="+ value6 +"&relationship_status=solteiro&hometown=&gender=" + value7
		  }).then(function mySucces(response) {
		      $scope.myData = response.data;
		      window.location = '#/';
		    }, function myError(response) {
		      $scope.myData = response.statusText;
		  });
	};
});
app.controller('PartiesCtrl', function($scope, $http, $timeout, $routeParams) {
	$scope.search;
	  $http({
	    method : "GET",
	    url : "http://localhost/MyParty/party?"
	  }).then(function mySuccess(response) {
	      $scope.myData = response.data;
	    }, function myError(response) {
	      $scope.myData = response.statusText;
	  });
});
app.directive('ngConfirmClick', [
    function(){
        return {
            priority: 1,
            terminal: true,
            link: function (scope, element, attr) {
                var msg = attr.ngConfirmClick || "Are you sure?";
                var clickAction = attr.ngClick;
                element.bind('click',function (event) {
                    if ( window.confirm(msg) ) {
                        scope.$eval(clickAction)
                    }
                });
            }
        };
}]);
app.controller('ViewPartyCtrl', function($scope, $http, $timeout, $routeParams, $cookies, $filter) {
	$scope.obj;
	$scope.lat;
	$scope.lon;
	$scope.obj;
	$scope.showDelete;
	$scope.showEnter = true;
	$scope.showLeave = false;
	$scope.arrMembers = [];
	$scope.showButtonDelete = function(value){
		if($cookies.get('email') == value){
			$scope.showDelete = true;
		}else{
			$scope.showDelete = false;
		}
	};
	$http({
	    method : "GET",
	    url : "http://localhost/MyParty/party?cod=" + $routeParams.party
	  }).then(function mySuccess(response) {
	      $scope.myData = response.data;
	      $scope.showButtonDelete($scope.myData[0].creator);
	      $scope.functionGET($scope.myData[0].creator);
	      $scope.maxparticipants = $scope.myData[0].max_participants;
	    }, function myError(response) {
	      $scope.myData = response.statusText;
	});
	$scope.functionGET = function(value){
		$http({
		    method : "GET",
		    url : "http://localhost/MyParty/user?email=" + value
		  }).then(function mySuccess(response) {
		      $scope.myCreator = response.data;
		    }, function myError(response) {
		      $scope.myCreator = response.statusText;
		});
	}
	$http({
	    method : "GET",
	    url : "http://localhost/MyParty/participants?cod_party=" + $routeParams.party
	  }).then(function mySuccess(response) {
	      $scope.myList = response.data;
	      $scope.participants = $scope.myList.length;
	      for(var i = 0; i < $scope.myList.length;i++){   
	      	$scope.members($scope.myList[i].cod_user);
	      }
	    }, function myError(response) {
	      $scope.myList = response.statusText;
	});
	$scope.members = function(value){
		$http({
	    method : "GET",
	    url : "http://localhost/MyParty/user?cod=" + value
	  }).then(function mySuccess(response) {
	      $scope.myMembers = response.data;
	      $scope.arrMembers.push($scope.myMembers[0]);
	      if($scope.myMembers[0].email == $cookies.get('email')){
	      	$scope.showEnter = false;
	      	$scope.showLeave = true;
	      }else{
	      }
	    }, function myError(response) {
	      $scope.myMembers = response.statusText;
	});
	};
	$scope.functionPOST = function(value){
		if($scope.maxparticipants > $scope.participants){
		$http({
	    method : "POST",
	    url : "http://localhost/MyParty/participants?cod_party=" + $routeParams.party
	  }).then(function mySuccess(response) {
	      $scope.myPost = response.data;
	      window.location.reload();
	    }, function myError(response) {
	      $scope.myPost = response.statusText;
	});
		}else{
			alert('The party is already full');
		}
			
	};
	$scope.functionLEAVE = function(value){
		console.log($routeParams.party);
		$http({
	    method : "DELETE",
	    url : "http://localhost/MyParty/participants?cod_party=" + $routeParams.party
	  }).then(function mySuccess(response) {
	      $scope.myPost = response.data;
	      window.location.reload();
	    }, function myError(response) {
	      $scope.myPost = response.statusText;
	});
	};
	angular.element(document).ready(function () {
		  $timeout(function () {
		  		var mapOptions = {
	                  mapTypeControlOptions: {
	                    mapTypeIds: ['']
	                  },
	                  zoom: 14,
	                  //center: new google.maps.LatLng($scope.party.map_lat,$scope.party.map_long),
	                  center: new google.maps.LatLng($scope.myData[0].map_lat,$scope.myData[0].map_long),
	                  mapTypeId: google.maps.MapTypeId.ROADMAP,
	                  styles: styles
	              };

	              $scope.map = new google.maps.Map(document.getElementById('map'), mapOptions);
	              $scope.markers = [];

	              var infoWindow = new google.maps.InfoWindow();
	              
	                  var marker = new google.maps.Marker({
	                      map: $scope.map,
	                      position: new google.maps.LatLng($scope.myData[0].map_lat,$scope.myData[0].map_long),
	                      icon: 'img/icon.png'
	                  });         
	  	}, 100);
	});
	$scope.functionDELETE = function(value1,value2){
		$http({
			//http://localhost/MyParty/map?map_lat=1&map_long=1
		  	//http://localhost/MyParty/party/?party_name=teste&description=teste&max_participants=200&age_group=19&initial_date=200-05-05&final_date=200-05-05&price=30&creator=teste&city=planaltina&map_lat=4&map_long=6
		    method : "DELETE",
		    url : "http://localhost/myparty/party?cod=" + value1
		  }).then(function mySucces(response) {
		      $scope.myData = response.data;
		      window.location = '#/home';
		    }, function myError(response) {
		      $scope.myData = response.statusText;
		  });
		  $http({
			//http://localhost/MyParty/map?map_lat=1&map_long=1
		  	//http://localhost/MyParty/party/?party_name=teste&description=teste&max_participants=200&age_group=19&initial_date=200-05-05&final_date=200-05-05&price=30&creator=teste&city=planaltina&map_lat=4&map_long=6
		    method : "DELETE",
		    url : "http://localhost/myparty/map?cod=" + value2
		  }).then(function mySucces(response) {
		      $scope.myData = response.data;
		      window.location.reload();
		    }, function myError(response) {
		      $scope.myData = response.statusText;
		  });
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
          icon: 'img/icon.png'
      });

      google.maps.event.addListener(marker, 'click', function(){
          infoWindow.setContent('<i class="fa fa-reply fa-lg" aria-hidden="true"></i> <a class="linkParty" href="#/view_party/' + info.cod + '" >' + marker.title + '</a>');
          infoWindow.open($scope.map, marker);
      });
      $scope.markers.push(marker);          
	};  
});
app.controller('NewPartyCtrl', function($scope, $http, $window, $cookies) {
	$scope.cod;
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
	$scope.mark = function(value, value2){
		$scope.lat = value;
		$scope.lon = value2;
	};
	$scope.setDate = function(value, value2){
		$scope.initial_date = value;
		$scope.final_date = value2;
	};
	$scope.functionPOST = function(){
		$http({
			//http://localhost/MyParty/map?map_lat=1&map_long=1
		  	//http://localhost/MyParty/party/?party_name=teste&description=teste&max_participants=200&age_group=19&initial_date=200-05-05&final_date=200-05-05&price=30&creator=teste&city=planaltina&map_lat=4&map_long=6
		    method : "POST",
		    url : "http://localhost/MyParty/party?party_name="+ $scope.party_name +"&description="+ $scope.Description +"&max_participants="+ $scope.max_participants +"&age_group="
		    + $scope.age_group +"&initial_date="+ $scope.initial_date +"&final_date="+ $scope.final_date +"&price="+ $scope.price +"&creator=" + $cookies.get('email') + "&city="+ $scope.city + "&map_lat=" + $scope.lat + "&map_long=" + $scope.lon
		  }).then(function mySucces(response) {
		      $scope.myData = response.data;
		      window.location = '#/home';
		    }, function myError(response) {
		      $scope.myData = response.statusText;
		  });
	};
});
app.controller('EditProfileCtrl', function($scope, $http, $cookies) {
	$scope.first_name;
	$scope.last_name;
	$scope.gender;
	$scope.birthday;
	$scope.newbirthday;
	$scope.city;
	$scope.relationship_status;

	$scope.setParams = function(value){
		$scope.first_name = value[0].first_name;
		$scope.last_name = value[0].last_name;
		$scope.gender = value[0].gender;
		$scope.birthday = value[0].birthday;
		$scope.city = value[0].hometown;
		$scope.relationship_status = value[0].relationship_status;
	};
	$http({
	    method : "GET",
	    url : "http://localhost/MyParty/user?email=" + $cookies.get('email') 
	  }).then(function mySuccess(response) {
	      $scope.myData = response.data;
	      $scope.setParams($scope.myData);
	    }, function myError(response) {
	      $scope.myData = response.statusText;
	});
	$scope.setDate = function(value){
		$scope.newbirthday = value;
	};
	$scope.functionPUT = function(value1,value2,value3,value4,value5,value6){
		$http({
	    method : "PUT",
	    //http://localhost/MyParty/user?first_name=joao&last_name=vitu&birthday=1990-02-05&relationship_status=solteiro&hometown=brasilia&gender=male
	    url : "http://localhost/MyParty/user?first_name="+ value1 +"&last_name="+ value2 +"&birthday="+ $scope.newbirthday +"&relationship_status="+ value4 + "&hometown=" + value5 + "&gender=" + value6
	  }).then(function mySuccess(response) {
	      $scope.myData = response.data;
	      window.location = '#/home';
	    }, function myError(response) {
	      $scope.myData = response.statusText;
	});
	};
});