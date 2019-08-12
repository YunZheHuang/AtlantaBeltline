<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>View/Edit Event</title>

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../assets/css/selectdeparture.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/edit_event.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="card card-container">
        <h4 class="text-center" style="padding-bottom: 10px;">View/Edit Event<h4/><h5></h5>
        <div class="row">
          <div class="col-md-6">
          Event Name: <input type="text" id="event_name" readonly class="input-disabled">
          </div>
          Price: <input type="text" id="price" readonly class="input-disabled">
          </div>
          <div class="row" style="padding-bottom: 15px;"></div>
          <div class="row">
          <div class="col-md-6">
          Start Date: <input type="text" id="start_date" readonly class="input-disabled">
          </div>
          End Date: <input type="text" id="end_date" readonly class="input-disabled">
          </div>
          <div class="row" style="padding-bottom: 15px;"></div>
          <div class="row">
          <div class="col-md-6">
          Minimum Staff Required: <input type="text" id="min_staff_req" readonly class="input-disabled">
          </div>
          Capacity: <input type="text" id="Capacity" readonly class="input-disabled">
          </div>

        
        <div class="row" style="padding-bottom: 15px;"></div>

        <div class="row" style="padding-bottom: 15px;">
            <table class="table table-hover">
              <thead>
              <tr>
                <th>Staff Assigned</th>
              </tr>
            </thead>
            <tbody id="staff_info">
            </tbody>
            </table>
        </div>

        <div class="row" style="padding-bottom: 15px;"></div>

        <div class="row">
          Description: <input type="text" class="form-control input-lg" id="Description">
        </div>

        <div class="row" style="padding-bottom: 15px;"></div>

        <div class="row">
          
          Daily Visits Range: <input type="text" id="price">
           -- <input type="text" id="price">
         </div>
         <div class="row">
           Daily revenue Range: <input type="text" id="price">
           -- <input type="text" id="price">
        
        </div>
        
        <div class="row" style="padding-bottom: 15px;"></div>
        <div class="row">
          <div class="col-md-3">
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onClick="goBack()">Filter</button>
          </div>
          <div class="col-md-6"></div>
          <div class="col-md-3">
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onClick="Update()">Update</button>
          </div>
        </div>

        <div class="row" style="padding-bottom: 15px;"></div>
        <div class="row" style="padding-bottom: 15px;">
            <table class="table table-hover">
              <thead>
              <tr>
                <th>Date</th>
                <th>Daily Visits</th>
                <th>Daily Revenue</th>
              </tr>
            </thead>
            <tbody id="staff_info">
            </tbody>
            </table>
        </div>
        <div class="row">
          <div class="col-md-3">
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onClick="goBack()">Back</button>
          </div>
          
        </div>
        </div>
      </div>
    </div>
  </body>
</html>
