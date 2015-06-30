<script>
  var global_r;
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
        FB.login(function(response) {
            console.log('connected');
            fb_login_success();
        }, {scope: 'public_profile,email'});
    }
    else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
        FB.login(function(response) {
            console.log('not_authorized');
            fb_login_success();
        }, {scope: 'public_profile,email'});
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
        FB.login(function(response) {
            console.log('not logged into');
            fb_login_success();
        }, {scope: 'public_profile,email'});
    }

  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
        //statusChangeCallback(response);
        FB.login(function(response) {
            fb_login_success();
        }, {scope: 'public_profile,email',display:'page'});        
    });
  
  }

  window.fbAsyncInit = function() {
      FB.init({
        appId      : '887400507985719',
        cookie     : true,  // enable cookies to allow the server to access 
                            // the session
        xfbml      : true,  // parse social plugins on this page
        version    : 'v2.2' // use version 2.2
      });
      $.isLoading({ text: "Loading" });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

      FB.getLoginStatus(function(response) {
            FB.login(function(r) {
                     console.log(r);
                if (r.status === 'connected') {
                    fb_login_success();
                }else{
                    window.location = location.protocol+"//"+location.hostname+'/register';
                    return false;
                }
            }, {scope: 'public_profile,email'});        
      });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/zh_TW/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function fb_login_success() {
    //console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
    
        check_3rd_user_exist(response);

    });
  
  }
    function check_3rd_user_exist(resp){
        $.ajax({
          method: "POST",
          url: "/register/check_3rd_user_exist/facebook",
          dataType: 'json',
          data        : resp
        }).success(function( response ) { 
            console.log(response);
            if(response.access == 'pass'){
                window.location = location.protocol+"//"+location.hostname+'/login/facebook/'+response.id+'/'+response.email;
            }else{
                $('#Member_email').val(resp.email);
                $('#Member_name').val(resp.name);
                $('#Member_id').val(resp.id);
                $('#Member_register_type').val(2);
                $.isLoading( "hide" );            
            }
        
            
        });
    }
    
</script>

