/* ---------- Services */

/*Location Service*/
//app.service('LocationService', function ($http)
//{
//
//   return
//    {
//        getLocation: function(){
//            $http({
//                url: 'http://localhost/villa/public/Locations' ,
//                method: "POST",
//                data: {'state_id':'0'}
//            }).success(function(data, status, headers, config) {
//                    window.alert(data);
//                }).error(function(data, status, headers, config) {
//
//                });
//
//        };
//    }
//});
app.service('LocationService', function ($http)
{

    this.setURL=function()
    {
        var hostname=window.location.hostname;
        if(hostname=='localhost')
        {
            return 'http://localhost/villa/public'
        }
        else
        {
            return window.location.protocol + '//'+hostname;
        }
    };
    var base_url=this.setURL();

    this.getLocation=function(state_id,callBack)
        {

          return $http.post(base_url + '/Locations',{'state_id':state_id})
              .success(callBack)
              .error(callBack);

        };
        this.getCities=function(callBack)
        {

          return $http.get(base_url + '/getCities')
              .success(callBack)
              .error(callBack);

        };
});

app.service('UserService', function ($http)
{
    this.setURL=function()
    {
        var hostname=window.location.hostname;
        if(hostname=='localhost')
        {
            return 'http://localhost/villa/public'
        }
        else
        {
            return window.location.protocol + '//'+hostname;
        }
    };
    var base_url=this.setURL();

    this.getUsers=function(callBack)
    {
        return $http.get(base_url + '/getalluser')
            .success(callBack)
            .error(callBack);
    };

    this.getUser=function(user_id,callBack)
    {
        return $http.post(base_url + '/getuser',{'user_id':user_id})
            .success(callBack)
            .error(callBack);
    };
});
