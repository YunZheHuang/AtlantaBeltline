<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manage Event</title>

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../assets/css/selectdeparture.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/manage_event.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="card card-container">
        <h4 class="text-center" style="padding-bottom: 10px;">Manage Event<h4/><h5></h5>
        <div class="row">
          Name: <input type="text" name="event_name" id="event_name">
          Description Keyword: <input type="text" name="descrip" id="descrip">

        </div>
        <div class="row" style="padding-bottom: 15px;"></div>
        <div class="row">
          Start Date: <input type="text" name="start_date" id="start_date" value="YYYY-MM-DD" onfocus="this.value='';">
          End Date: <input type="text" name="end_date" id="end_date" value="YYYY-MM-DD" onfocus="this.value='';">
        </div>
        <div class="row" style="padding-bottom: 15px;"></div>
          <div class="row">
          Duration Range: <input type="text" name="duration_start" id="duration_start" >
          -- <input type="text" name="duration_end" id="duration_end" >
        </div>
        <div class="row" style="padding-bottom: 15px;"></div>
          <div class="row">
          Total Visits Range: <input type="text" name="visit_low" id="visit_low" >
          -- <input type="text" name="visit_high" id="visit_high" >
        </div>
        <div class="row" style="padding-bottom: 15px;"></div>
          <div class="row">
          Total Revenue Range: <input type="text" name="Revenue_low" default="0" id="Revenue_low" >
          -- <input type="text" name="Revenue_high" id="Revenue_high" >
        </div>
        <div class="row" style="padding-bottom: 15px;"></div>
          <div class="row">
            <div class="col-md-3">
          <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onClick="Filter()">Filter</button>
          </div>
        </div>
        <div class="row" style="padding-bottom: 15px;"></div>
        <div class="row">
          <div class="col-md-3">
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" id="create_button" onClick="location.href='./create_event.php';">Create</button>
          </div>
          <div class="col-md-3">
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" disabled="disabled" id="edit_button" onClick="Edit()">View/Edit</button>
          </div>
          <div class="col-md-3">
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" disabled="disabled" id="delete_button" onClick="Delete()">Delete</button>
          </div>
        </div>

        <div class="row" style="padding-bottom: 15px;">
            <table class="table table-hover">
              <thead>
              <tr>
                <th>Name</th>
                <th>Staff Count</th>
                <th>Duration(days)</th>
                <th>Total Visits</th>
                <th>Total Revenue($)</th>
              </tr>
            </thead>
            <tbody id="event_info">
            </tbody>
            </table>
        </div>

        <div class="row" style="padding-bottom: 15px;"></div>
        <div class="row">
          <div class="col-md-3">
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onClick="goBack()">Back</button>
          </div>
          
        </div>
      </div>
    </div>
  </body>
</html>
