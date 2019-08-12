$( document ).ready(function() 
{
  // $('##transit_info').submit(function () {
  //   $.cookie('routes', $('#routes').val());
  // });
  // $("table").hide();
})


function RemoveDisable(){
  $('#create_button').removeAttr('disabled');
}

function RemoveEditDisable(){
  $('#edit_button').removeAttr('disabled');
  $('#delete_button').removeAttr('disabled');
}

function selectOnlyThis(id){
  $('#edit_button').removeAttr('disabled');
  $('#delete_button').removeAttr('disabled');
  var myCheckbox = document.getElementsByName("routes");
  Array.prototype.forEach.call(myCheckbox,function(el){
    el.checked = false;
  });
  id.checked = true;
}

function Filter()
{
  $("#transit_info tr").remove();
  var start_date = $('#start_date').val();
  var end_date = $('#end_date').val();
  var event_count_low = $('#event_count_low').val();
  var event_count_high = $('#event_count_high').val();
  var staff_count_low = $('#staff_count_low').val();
  var staff_count_high = $('#staff_count_high').val();
  var visit_low = $('#visit_low').val();
  var visit_high = $('#visit_high').val();
  var Revenue_low = $('#Revenue_low').val();
  var Revenue_high = $('#Revenue_high').val();

  event_count_low = Number(event_count_low);
  event_count_high = Number(event_count_high);
  Revenue_low = Number(Revenue_low);
  Revenue_high = Number(Revenue_high);
  staff_count_low = Number(staff_count_low);
  staff_count_high = Number(staff_count_high);
  visit_low = Number(visit_low);
  visit_high = Number(visit_high);

  x = document.cookie
    var email = x.split('=')[1]
    console.log(email);

  if(start_date=="YYYY-MM-DD" || end_date=="YYYY-MM-DD"){
    alert("Please enter start date and end date")
    return;
  }

  $.get( "../queries/view_site_report.php?start_date="+start_date+"&end_date="+end_date+"&event_count_low="+event_count_low+"&event_count_high="+event_count_high+"&staff_count_low="+staff_count_low+"&staff_count_high="+staff_count_high+"&visit_low="+visit_low+"&visit_high="+visit_high+"&Revenue_low="+Revenue_low+"&Revenue_high="+Revenue_high+"&email="+email, function( data )
  {
    console.log(data)
    if(data != '')
    {
      dataArray = data.split("|");
      for(i = 0; i < dataArray.length; i++)
      {
        row = dataArray[i].split(',');

        var price = parseFloat(row[2]);

        $('#transit_info').append('<tr><td id="Route"><div class="checkbox"><label><input class="route" id="routes" name="routes" onclick="selectOnlyThis(this)" value= "' + row[1] + '-'+row[0]+ '-' + row[2] + ' " type="checkbox">' + row[0]+ '</label></div></td><td id="Type">' + row[1] + '</td><td id="Price">'+ price +'</td><td id="numofsites">'+row[3]+'</td><td id="numoflogs">'+row[4]+'</td></tr>');
      }
    }
    else{
      $('#transit_info').append('<tr><td id="Type">no match data</td></tr>');
    }
  })
  $("table").show();
}

function Create(){          //##################################################################
  var trans_type = $('#Transit_Type').text();
  trans_type = trans_type.split('\n');
  trans_type = trans_type[0];
  if(trans_type == '--ALL--'){
    alert("You must select a transition type before create!");
    document.getElementById("create_button").disabled = true;
    return;
  }
  window.location.assign("../pages/create_transit.php");
}

function Edit(){
  var route_list = $("input[name='routes']:checked");
  var checkBoxValue = ""; 
  route_list.each(function(){
    checkBoxValue += $(this).val()+",";
  })
  checkBoxValue = checkBoxValue.substring(0,checkBoxValue.length-1);
  value_list = checkBoxValue.split(',');
  // console.log(value_list)
  document.cookie = 'transit_info=' +value_list;

  x = document.cookie
  console.log(x)
  window.location.href='../pages/edit_transit.php';
  
}


function goBack()
{
  window.history.back();
}

