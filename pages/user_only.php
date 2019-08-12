<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Atlanta Beltline - User</title>

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../assets/css/addnewuser.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <!-- <script src="../assets/js/addnewuser.js"></script> -->
  </head>
  <body>
    <div class="container">
        <div class="card card-container">
            <form class="form-signin">
                <h4 class="text-center">Welcome User<h4/><h5></h5>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onClick="location.href='./user_take_transit.php';">Take Transit</button>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onClick="location.href='./user_transit_history.php';">View Transit History</button>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onClick="history.back()">Back</button>
            </form><!-- /form -->
        </div>
    </div>
  </body>
</html>