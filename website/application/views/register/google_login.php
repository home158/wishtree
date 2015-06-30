<script src="https://apis.google.com/js/plusone.js"></script>
<script src="https://apis.google.com/js/client:plusone.js"></script>

<script type="text/javascript">
var global_r;
var loginFinished = function(authResult)
{
    if (authResult['access_token']) {
        // Successfully authorized
        //gapi.auth.setToken(authResult); // Store the returned token.
        //CHECK USER IN database
        gapi.client.load('oauth2', 'v2', function() {
            var request = gapi.client.oauth2.userinfo.get();
            request.execute(function(resp)
            {
                // Shows user email
                check_3rd_user_exist(resp);
            });
        });
    } else if (authResult['error']) {
        // There was an error.
        // Possible error codes:
        //   "access_denied" - User denied access to your app
        //   "immediate_failed" - Could not automatically log in the user
        console.log('There was an error: ' + authResult['error']);
        window.location = location.protocol+"//"+location.hostname+'/register';
        return false;
    }else{
        window.location = location.protocol+"//"+location.hostname+'/register';
        return false;
    }
    function check_3rd_user_exist(resp){
        $.ajax({
          method: "POST",
          url: "/register/check_3rd_user_exist/google",
          dataType: 'json',
          data        : resp
        }).success(function( response ) { 
            if(response.access == 'pass'){
                window.location = location.protocol+"//"+location.hostname+'/login/google/'+response.id+'/'+response.email;
            }else{
                $('#Member_email').val(resp.email);
                $('#Member_name').val(resp.name);
                $('#Member_id').val(resp.id);
                $('#Member_register_type').val(3);
                $.isLoading( "hide" );            
            }
        
            
        });
    }

};

var options = {
  'callback': loginFinished,
  'approvalprompt': 'force',
  'clientid': '953716904749-tt5thjf4cn4q5geg5m4bopat8teeog2q.apps.googleusercontent.com',
  'scope': 'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email',
  'requestvisibleactions': 'http://schemas.google.com/CommentActivity http://schemas.google.com/ReviewActivity',
  'cookiepolicy': 'single_host_origin'
};


var renderBtn = function()
{
    $.isLoading({ text: "Loading" });
    var parameters = {
      'client_id' : '953716904749-tt5thjf4cn4q5geg5m4bopat8teeog2q.apps.googleusercontent.com',
      'immediate' : false,
      'scope': 'https://www.googleapis.com/auth/userinfo.email'
    };
    gapi.auth.authorize(parameters, loginFinished);

}
function ajax_login_process(r){
    r.city = $('#Client_region').val();
    r.gender = $('input[name=gender]:checked').val();
    $.ajax({
      method: "POST",
      url: "/register/google_login_process",
      dataType: 'json',
      data        : r
    }).success(function( response ) { 
        if(response.error_code == 0){
            window.location = location.protocol+"//"+location.hostname;
        }
    });
}

window.onload=renderBtn;
    
</script>

