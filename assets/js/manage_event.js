$( document ).ready(function() 
{
  $("table").hide();
})

function selectOnlyThis(id){
  $('#edit_button').removeAttr('disabled');
  $('#delete_button').removeAttr('disabled');
  var myCheckbox = document.getElementsByName("event");
  Array.prototype.forEach.call(myCheckbox,function(el){
    el.checked = false;
  });
  id.checked = true;
}


function Filter()
{
  $("#event_info tr").remove();
  var event_name = $('#event_name').val();
  var descrip = $('#descrip').val();
  var start_date = $('#start_date').val();
  var end_date = $('#end_date').val();
  var duration_start = $('#duration_start').val();
  var duration_end = $('#duration_end').val();
  var visit_low = $('#visit_low').val();
  var visit_high = $('#visit_high').val();
  var Revenue_low = $('#Revenue_low').val();
  var Revenue_high = $('#Revenue_high').val();

  visit_low = Number(visit_low);
  visit_high = Number(visit_high);
  Revenue_low = Number(Revenue_low);
  Revenue_high = Number(Revenue_high);
  duration_start = Number(duration_start);
  duration_end = Number(duration_end);

  duration = duration_end - duration_start;
  visit = visit_high - visit_low;
  revenue =  Revenue_high - Revenue_low;

  if(duration < 0 || visit < 0 || revenue < 0){
    alert("Number error");
    return;
  }
  else{
    x = document.cookie
    var email = x.split('=')[1]
    console.log(email);
  
    $.get( "../queries/manager_manage_event.php?event_name="+event_name+"&descrip="+descrip+"&start_date="+start_date+"&end_date="+end_date+"&duration_start="+duration_start+"&duration_end="+duration_end+"&visit_low="+visit_low+"&visit_high="+visit_high+"&email="+email, function( data )
    {
      console.log(data)
      if(data != '')
      {
        dataArray = data.split("|");
        for(i = 0; i < dataArray.length; i++)
        {
          row = dataArray[i].split(',');

          var price = parseFloat(row[4]);
          var revenue = price * row[3];

          $('#event_info').append('<tr><td id="event_name"><div class="checkbox"><label><input class="event" name="event" value="'+row[0]+'~'+row[1]+'~'+row[2]+'~'+row[3]+'~'+row[4]+'~'+row[5]+'~'+row[6]+'" type="checkbox" onclick="selectOnlyThis(this)">'+row[0]+'</label></div></td><td id="staff_count">'+row[1]+'</td><td id="duration">'+row[2]+'</td><td id="total_visit">'+row[3]+'</td><td id="total_revenue">'+revenue+'</td></tr>');
        }
      }
      else{
        $('#event_info').append('<tr><td id="event_name">no match data</td></tr>');
      }
    })
   }
  $("table").show();
}

function Edit(){
  var event = $("input[name='event']:checked");
  var checkBoxValue = ""; 
  event.each(function(){
    checkBoxValue += $(this).val()+",";
  })
  checkBoxValue = checkBoxValue.substring(0,checkBoxValue.length-1);
  value_list = checkBoxValue.split(',');
  // console.log(value_list)
  document.cookie = 'event_info=' +value_list;

  x = document.cookie
  console.log(x)
  window.location.href='../pages/edit_event.php';

  // console.log(x);
  // $.get( "../queries/edit_transit.php?value_list=" + value_list, function(data){
  //   console.log(data)
  // });

  // if(value_list.length != 1){
  //   alert('Must choose a route');
  // }
  // else{
  //   window.location.href='../pages/edit_transit.php';
  // }

}



function goBack()
{
  window.history.back();
}

