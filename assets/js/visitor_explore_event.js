console.log("connected to visitor explore event js")

function Filter()
{
  $("#transit_info tr").remove();
  var site_name = $('#Site_list').text();
  var trans_type = $('#Transit_Type').text();
  var low_price = $('#low_price').val();
  var high_price = $('#high_price').val();

  site_name = site_name.split('\n');
  site_name = site_name[0];
  trans_type = trans_type.split('\n');
  trans_type = trans_type[0];
  low_price = Number(low_price);
  high_price = Number(high_price);

  //rlly gotta do work here
  $.get( "../queries/get_event_info.php?" + site_name + "&trans_type=" + trans_type + "&low_price=" + low_price + "&high_price=" + high_price, function( data )
  {
    console.log(data)
    if(data != '')
    {
      dataArray = data.split("|");
      for(i = 0; i < dataArray.length; i++)
      {
        row = dataArray[i].split(',');
        console.log(row);
        var price = parseFloat(row[2]);
        //instead of route blah blah
        $('#event_info').append('<tr><td id="Route"><div class="checkbox"><label><input class="route" name="routes" value= "route_' + row[0] + '-'+row[1]+' " type="checkbox">' + row[0]+ '</label></div></td><td id="Type">' + row[1] + '</td><td id="Price">'+ price +'</td><td id="#ofsites">'+row[3]+'</td></tr>');
      }
    }
    else{
      $('#event_info').append('<tr><td id="Type">no match data</td></tr>');
    }
  })
  $("table").show();
}


//------------------------------------------------------------------------------
$( document ).ready(function()
{
  $("table").hide();
  getSites();
})

$(function(){
    $("#contain_sites").on('click', 'li a', function(){
      $('#Site_list').text($(this).text());
   });
});

function goToNext()
{
  event_name = document.getElementById("event_name").value
  console.log('event_name')
//changed name=routes to events
  var event_list = $("input[name='events']:checked");
  if(event_list == ''){
    alert('No events are available.')
  }
  var checkBoxValue = "";
  route_list.each(function(){
    checkBoxValue += $(this).val()+",";
  })
  checkBoxValue = checkBoxValue.substring(0,checkBoxValue.length-1);
  value_list = checkBoxValue.split(',');
  if (value_list == 0) {
    alert("Please select an event.")
  }

  var i;
  for (i = 0; i < value_list.length; i++) {
    info_list = value_list[i].split('-');
    t_type = info_list[0].split('_')[1];
    //load new page with info from selected
    //$.get( "../queries/log_transit.php?email="+email+"&route="+t_type+"&trans_type="+info_list[1]+"&transit_date="+transit_date, function(data){
  };
  window.location.reload(true);
}

function goBack()
{
  console.log("going back")
  window.history.back();
}

function getSites()
{
  $.get( "../queries/get_sites.php", function( data )
  {
    if(data != '')
    {
      dataArray = data.split("|");
      for(i = 0; i < dataArray.length; i++)
      {
        $('#contain_sites').append('<li><a value="' + dataArray[i] + '">' + dataArray[i] + '</a></li>');
      }
    }
  });
}