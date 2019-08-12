<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Explore Event</title>

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../assets/css/selectdeparture.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    
    <!-- NEED TO CHANGE HERE -->
    <script src="../assets/js/screen34_visitor_event_detail.js"></script>

</head>
  <body>
    <div class="container">
      <div class="card card-container">
        <h4 class="text-center" style="padding-bottom: 10px;">Event Detail<h4/>

        <div class = "row">
          <div class = "input-group" id="event_details">

          </div>
          <div class = "input-group">
            Visit Date : <input type="text" name="visit_date" required="required" id="visit_date" value="YYYY-MM-DD" onfocus="this.value='';">
            <div class="col-md-3">
              <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onClick="goToNext()">Log Visit</button>
            </div>
          </div>
        </div>
        <div class="row" style="padding-bottom: 15px;"></div>



        <div class="row">
          <div class="col-md-3">
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onClick="goBack()">Back</button>
          </div>
          <div class="col-md-6"></div>


        </div>

      </div>
    </div>
  </body>
</html>
