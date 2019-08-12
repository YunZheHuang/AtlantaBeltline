<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/images/favicon.ico">

    <title>Atlanta Beltline - Add User</title>

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../assets/css/addnewuser.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/addnewuser.js"></script>
  </head>
  <body>
    <div class="container">
        <div class="card card-container">
            <form class="form-signin">
                <h4 class="text-center">Register User<h4/><h5></h5>
                <div id="usernameBlankAlert" style="display: none;" class="alert alert-danger">Firstname cannot be blank.<span style="cursor: pointer;" class="pull-right" onClick="$('#firstnameBlankAlert').hide()">x</span></div>
                <div id="usernameBlankAlert" style="display: none;" class="alert alert-danger">Lastname cannot be blank.<span style="cursor: pointer;" class="pull-right" onClick="$('#lastnameBlankAlert').hide()">x</span></div>
                <div id="usernameBlankAlert" style="display: none;" class="alert alert-danger">Username cannot be blank.<span style="cursor: pointer;" class="pull-right" onClick="$('#usernameBlankAlert').hide()">x</span></div>
                <div id="emailBlankAlert" style="display: none;" class="alert alert-danger">Email cannot be blank.<span style="cursor: pointer;" class="pull-right" onClick="$('#emailBlankAlert').hide()">x</span></div>
                <div id="passwordBlankAlert" style="display: none;" class="alert alert-danger">Password cannot be blank.<span style="cursor: pointer;" class="pull-right" onClick="$('#passwordBlankAlert').hide()">x</span></div>
                <div id="passwordsDontMatchAlert" style="display: none;" class="alert alert-danger">Passwords do not match.<span style="cursor: pointer;" class="pull-right" onClick="$('#passwordsDontMatchAlert').hide()">x</span></div>
                <div id="accountExistsAlert" style="display: none;" class="alert alert-danger">Account already exists. Choose another username.<span style="cursor: pointer;" class="pull-right" onClick="$('#accountExistsAlert').hide()">x</span></div>
                <input type="firstname" id="inputFirstname" class="form-control" placeholder="Firstname" required>
                <input type="lastname" id="inputLastname" class="form-control" placeholder="Lastname" required >
                <input type="username" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
                <input type="email" id="inputEmail" class="form-control" placeholder="Email" required >
                <input type="password" id="inputPassword" class="form-control" placeholder="Password" required >
                <input type="password" id="inputConfirmPassword" class="form-control" placeholder="Confirm Password" required>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onClick="verifyLogin($('#inputEmail').val(), $('#inputPassword').val())">Register</button>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onClick="history.back()">Back</button>
            </form><!-- /form -->
        </div>
    </div>
  </body>
</html>