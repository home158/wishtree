  <script src="https://apis.google.com/js/plusone.js" type="text/javascript"></script>
  <script type="text/javascript">
  /*
   * Triggered when the user accepts the sign in, cancels, or closes the
   * authorization dialog.
   */
  function loginFinishedCallback(authResult) {
    if (authResult) {
      if (authResult['error'] == undefined){
        gapi.auth.setToken(authResult); // Store the returned token.
        toggleElement('signin-button'); // Hide the sign-in button after successfully signing in the user.
        getEmail();                     // Trigger request to get the email address.
      } else {
        console.log('An error occurred');
      }
    } else {
      console.log('Empty authResult');  // Something went wrong
    }
  }

  /*
   * Initiates the request to the userinfo endpoint to get the user's email
   * address. This function relies on the gapi.auth.setToken containing a valid
   * OAuth access token.
   *
   * When the request completes, the getEmailCallback is triggered and passed
   * the result of the request.
   */
  function getEmail(){
    // Load the oauth2 libraries to enable the userinfo methods.
    gapi.client.load('oauth2', 'v2', function() {
          var request = gapi.client.oauth2.userinfo.get();
          request.execute(getEmailCallback);
        });
  }

  function getEmailCallback(obj){
    console.log(obj);
    var el = document.getElementById('email');
    var email = '';

    if (obj['email']) {
      email = 'Email: ' + obj['email'];
    }

    //console.log(obj);   // Uncomment to inspect the full object.

    el.innerHTML = email;
    toggleElement('email');
  }

  function toggleElement(id) {
    var el = document.getElementById(id);
    if (el.getAttribute('class') == 'hide') {
      el.setAttribute('class', 'show');
    } else {
      el.setAttribute('class', 'hide');
    }
  }
  
<!-- Place this asynchronous JavaScript just before your </body> tag -->
  (function() {
   var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
   po.src = 'https://apis.google.com/js/client:plusone.js';
   var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
 })();
 function signinCallback(authResult) {
  if (authResult['access_token']) {
    // Successfully authorized
    // Hide the sign-in button now that the user is authorized, for example:
    document.getElementById('signinButton').setAttribute('style', 'display: none');
    console.log(authResult);
  } else if (authResult['error']) {
    // There was an error.
    // Possible error codes:
    //   "access_denied" - User denied access to your app
    //   "immediate_failed" - Could not automatically log in the user
    // console.log('There was an error: ' + authResult['error']);
  }
}
</script>
<span id="signinButton">
  <span
    class="g-signin"
    data-callback="signinCallback"
    data-clientid="770989853271-v3juqbb7hb9uh9vd1mb5cbfp6rrr5p0i.apps.googleusercontent.com"
    data-cookiepolicy="single_host_origin"
    data-requestvisibleactions="http://schemas.google.com/AddActivity"
    data-scope="https://www.googleapis.com/auth/plus.login">
  </span>
</span>
  <div id="signin-button" class="show">
  <!--
     <span class="g-signin" data-callback="loginFinishedCallback"
      data-approval prompt="force"
      data-clientid="770989853271-v3juqbb7hb9uh9vd1mb5cbfp6rrr5p0i.apps.googleusercontent.com"
      data-scope="https://www.googleapis.com/auth/userinfo.email"
      data-height="short"
      data-cookiepolicy="single_host_origin"
      >
    </span>
   -->
    <!-- In most cases, you don't want to use approvalprompt=force. Specified
    here to facilitate the demo.-->
  </div>

  <div id="email" class="hide"></div>
