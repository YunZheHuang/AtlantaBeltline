<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Create Event</title>

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../assets/css/selectdeparture.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/create_event.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="card card-container">
        <h4 class="text-center" style="padding-bottom: 10px;">Create Event<h4/><h5></h5>
        <div class="form-group row">
        <div class="col-sm-9">
          Name: <input type="text" class="form-control" id="event_name" name="event_name" required="true">
        </div>
      </div>
        <div class="row" style="padding-bottom: 15px;"></div>

        Price  $: <input type="text" name="price" id="price" required="true">
        Capacity: <input type="text" name="capacity" id="capacity" required="true">
        <div class="row" style="padding-bottom: 15px;"></div>
        Minimum Staff Required: <input type="text" name="min_req" id="min_req" required="true">

        <div class="row" style="padding-bottom: 15px;"></div>
        <div class="row">
          Start Date: <input type="text" name="start_date" id="start_date" value="YYYY-MM-DD" onfocus="this.value='';" required="true">
          End Date: <input type="text" name="end_date" id="end_date" value="YYYY-MM-DD" onfocus="this.value='';" required="true">
        </div>
        <div class="row" style="padding-bottom: 15px;"></div>
        <div class="col-auto">
          Description: <input type="text" class="form-control input-lg" id="description" name="description" required="true">
        </div>

        <div class="row" style="padding-bottom: 15px;"></div>
        <div class="row">
          <div class="col-md-3">
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onClick="FindStaff()">Find Staff</button>
          </div>
          
        </div>
        <div class="row" style="padding-bottom: 15px;">
            <table class="table table-hover">
              <thead>
              <tr>
                <th>First Name</th>
                <th>Last Name</th>
              </tr>
            </thead>
            <tbody id="staff_info">
            </tbody>
            </table>
        </div>

        <div class="row" style="padding-bottom: 15px;"></div>
        <div class="row">
          <div class="col-md-3">
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onClick="goBack()">Back</button>
          </div>
          <div class="col-md-6"></div>
          <div class="col-md-3">
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" name="create_button" id="create_button" onClick="Create()" disabled="disabled">Create</button>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
