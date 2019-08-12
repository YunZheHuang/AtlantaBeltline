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
    <script src="../assets/js/visitor_explore_event.js"></script>

</head>
  <body>
    <div class="container">
      <div class="card card-container">
        <h4 class="text-center" style="padding-bottom: 10px;">Explore Event<h4/>

        <div class = "row">
          <div class = "input-group">
            Name:<input type="text" name="event_name" id="event_name" value= "" onfocus="this.value='';">
            Description Keyword:<input type="text" name="desc_key" id="desc_key" value= "" onfocus="this.value='';">
          </div>
        </div>
        <div class="row" style="padding-bottom: 15px;"></div>
        <div class="row">
          <div class="col-md-4">
            <div class="row" style="padding-bottom: 15px;">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1" >Site Name</span>
                <div class="btn-group" aria-describedby="basic-addon1">
                  <button class="btn btn-primary btn-md dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="Site_list">--<span id="selected"></span>
                  <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" id="contain_sites" >
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="row" style="padding-bottom: 15px;"></div>
                Start Date : <input type="text" name="start_date" required="required" id="start_date" value="YYYY-MM-DD" onfocus="this.value='';">
                End Date : <input type="text" name="start_date" required="required" id="start_date" value="YYYY-MM-DD" onfocus="this.value='';">
          <div class="row" style="padding-bottom: 15px;"></div>
          <div class="row">
            <div class="input-group">
              Ticket Price Range : <input type="text" name="low_price" id="low_price" value= "" onfocus="this.value='';">
              -- <input type="text" name="high_price" id="high_price" value= "" onfocus="this.value='';">
              <div class="row" style="padding-bottom: 15px;"></div>
              Total Visits Range : <input type="text" name="low_visit" id="low_visit" value= "" onfocus="this.value='';">
              -- <input type="text" name="high_visit" id="high_visit" value= "" onfocus="this.value='';">

              <div class="row" style="padding-bottom: 15px;"></div>
              Include Visited <input type="checkbox" name="visited" id="visited">
              Include Sold Out <input type="checkbox" name="sold_out" id="sold_out">

              <span class="input-group-btn">
                <button class="btn btn-block btn-primary" onClick="Filter()">Filter</button>
              </span>
            </div>
          </div>
        </div>
        <div class="row" style="padding-bottom: 15px;">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Event Name</th>
                <th>Site Name</th>
                <th>Ticket Price</th>
                <th>Ticket Remaining</th>
                <th>Total Visits</th>
                <th>My Visits</th>
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
          <div class="col-md-6"></div>
          <div class="col-md-3">
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onClick="goToNext()">Event Detail</button>
          </div>

        </div>

      </div>
    </div>
  </body>
</html>
