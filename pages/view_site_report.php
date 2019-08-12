<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>View Site Report</title>

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../assets/css/selectdeparture.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/view_site_report.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="card card-container">
        <h4 class="text-center" style="padding-bottom: 10px;">Site Report<h4/><h5></h5>
        <div class="row">
          Start Date: <input type="text" name="start_date" id="start_date" value="YYYY-MM-DD" onfocus="this.value='';">
          End Date: <input type="text" name="end_date" id="end_date" value="YYYY-MM-DD" onfocus="this.value='';">
        </div>

        <div class="row" style="padding-bottom: 15px;"></div>
          <div class="row">
          Event Count Range: <input type="text" name="event_count_low" default="0" id="event_count_low" >
          -- <input type="text" name="event_count_high" default="0" id="event_count_high" >
        </div>
        <div class="row" style="padding-bottom: 15px;"></div>
          <div class="row">
          Staff Count Range: <input type="text" name="staff_count_low" default="0" id="staff_count_low" >
          -- <input type="text" name="staff_count_high" default="0" id="staff_count_high" >
        </div>
        <div class="row" style="padding-bottom: 15px;"></div>
          <div class="row">
          Total Visits Range: <input type="text" name="visit_low" default="0" id="visit_low" >
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
          <div class="col-md-6"></div>
          <div class="col-md-3">
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onClick="Detail()" id="detail_button" name="detail_button" disabled="disabled">Daily Detail</button>
          </div>
        </div>
        <div class="row" style="padding-bottom: 15px;"></div>

        <div class="row" style="padding-bottom: 15px;">
            <table class="table table-hover">
              <thead>
              <tr>
                <th>Date</th>
                <th>Event Count</th>
                <th>Staff Count</th>
                <th>Total Visits</th>
                <th>Total Revenue($)</th>
              </tr>
            </thead>
            <tbody id="site_info">
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
