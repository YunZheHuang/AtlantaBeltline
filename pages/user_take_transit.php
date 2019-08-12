<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Take transit</title>

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../assets/css/selectdeparture.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/user_take_transit.js"></script> <!--need to modify-->
    <!-- <script src="../assets/js/get_transit_info.js"></script> -->
  </head>
  <body>
    <div class="container">
      <div class="card card-container">
        <h4 class="text-center" style="padding-bottom: 10px;">Take Transit<h4/><h5></h5>
        <!-- <div id="costBlankAlert" style="display: none;" class="alert alert-danger">You must choose a site<span style="cursor: pointer;" class="pull-right" onClick="$('#costBlankAlert').hide()">x</span></div> -->
        <div class="row">
          <div class="col-md-4">
            <div class="row" style="padding-bottom: 15px;">
              <div class="input-group">
            <span class="input-group-addon" id="basic-addon1" >Contain Site</span>
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
          <div class="col-md-4"></div>
          <div class="col-md-3">
            <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Transport Type</span>
            <div class="btn-group" aria-describedby="basic-addon1">
              <button class="btn btn-primary btn-md dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="Transit_Type">--ALL--<span class="caret"></span>
              </button>
              
              <ul class="dropdown-menu" id="transit_type">
                <li value="MARTA"><a>MARTA</a></li>
                <li value="Bike"><a>Bike</a></li>
                <li value="Bus"><a>Bus</a></li>
              </ul>
            
            </div>
          </div>
          </div>
        </div>
        <div class="row" style="padding-bottom: 15px;"></div>

        <div class="input-group">
          Price Range : <input type="text" name="low_price" id="low_price" value= "0" onfocus="this.value='';">
          -- <input type="text" name="high_price" id="high_price" value= "10" onfocus="this.value='';">
          <span class="input-group-btn">
            <button class="btn btn-block btn-primary" onClick="Filter()">Filter</button>
          </span>
        </div>
        <!-- <div class="row" style="padding-bottom: 15px;"></div>

        <div class="col-md-3">
            <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Sort By</span>
            <div class="btn-group" aria-describedby="basic-addon1">
              <button class="btn btn-primary btn-md dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="sort_button">--<span class="caret"></span>
              </button>
              
              <ul class="dropdown-menu" id="columns">
                <li value="Route"><a>Route</a></li>
                <li value="Trans_Type"><a>Transport Type</a></li>
                <li value="price"><a>Price</a></li>
                <li value="num"><a># Connected Sites</a></li>
              </ul>
            
            </div>
          </div>
          </div> -->
        
        <div class="row" style="padding-bottom: 15px;">
            <table class="table table-hover">
              <thead>
              <tr>
                <th>Route</th>
                <th>Transport Type</th>
                <th>Price</th>
                <th># Connected Sites</th>
              </tr>
            </thead>
            <tbody id="transit_info">
            </tbody>
            </table>
        </div>

        <div class="row" style="padding-bottom: 15px;"></div>
        Transit Date : <input type="text" name="transit_date" required="required" id="transit_date" value="YYYY-MM-DD" onfocus="this.value='';">
        <div class="row" style="padding-bottom: 15px;"></div>
        <div class="row">
          <div class="col-md-3">
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onClick="goBack()">Back</button>
          </div>
          <div class="col-md-6"></div>
          <div class="col-md-3">
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onClick="goToNext()">Log Transit</button>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
