/* ---------Controllers*/

    /*Location Controller*/
    app.controller('LocationCtrl',function (LocationService, $scope)
    {
        $scope.locations=new Array();
        $scope.cities=[];

        $scope.LoadLocations=function(state_id)
        {
            LocationService.getLocation(state_id,function(data)
            {
                $scope.locations=data;
            });
        };

        $scope.LoadCities=function()
        {
            LocationService.getCities(function(data){
                $scope.cities=data;
            });
        };


    });

    /*User Controller*/
    app.controller('UserCtrl',function (UserService, $scope)
    {
        $scope.users=[];
        UserService.getUsers(function(data)
        {
            $scope.users=data;
        });
    });




