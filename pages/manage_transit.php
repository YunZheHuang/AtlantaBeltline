<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manage Transit</title>

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../assets/css/selectdeparture.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/manage_transit.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="card card-container">
        <h4 class="text-center" style="padding-bottom: 10px;">Manage Transit<h4/><h5></h5>
        <div class="row">
          <div class="col-md-4">
            <div class="row" style="padding-bottom: 15px;">
          
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Transport Type</span>
            <div class="btn-group" aria-describedby="basic-addon1">
              <button class="btn btn-primary btn-md dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="Transit_Type" onclick="RemoveDisable()">--ALL--<span class="caret"></span>
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
          <div class="col-md-4"></div>
          <div class="col-md-3">
            <div class="input-group">
            <span class="input-group-addon" id="basic-addon1" >Cotain Site</span>
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

        <div class="input-group">
          Route: <input type="text" name="route" id="route">
          Price Range : <input type="text" name="low_price" id="low_price" value= "0" onfocus="this.value='';">
          -- <input type="text" name="high_price" id="high_price" value= "10" onfocus="this.value='';">
          <span class="input-group-btn">
            <button class="btn btn-block btn-primary btn-signin" type="button" onClick="Filter()">Filter</button>
          </span>
        </div>
        <div class="row" style="padding-bottom: 15px;"></div>

        <div class="row">
          <div class="col-md-3">
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" id="create_button" onClick="location.href='./create_transit.php';">Create</button>
          </div>
          <!-- <div class="col-md-6"></div> -->
          <div class="col-md-3">
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" disabled="disabled" id="edit_button" onClick="Edit()">Edit</button>
          </div>
          <div class="col-md-3">
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" disabled="disabled" id="delete_button" onClick="Delete()">Delete</button>
          </div>
          <!-- delete later -->
          <!-- <button onclick="test()">test</button> -->
        </div>
        <div class="row" style="padding-bottom: 15px;">
            <table class="table table-hover">
              <thead>
              <tr>
                <th>Route</th>
                <th>Transport Type</th>
                <th>Price</th>
                <th># Connected Sites</th>
                <th># Transit Logged</th>
              </tr>
            </thead>
            <tbody id="transit_info">
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
