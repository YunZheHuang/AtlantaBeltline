$( document ).ready(function() 
{
  $("table").hide();
  getSites();
})


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

$(function(){
    $("#contain_sites").on('click', 'li a', function(){
      $('#Site_list').text($(this).text());
   });
    $("#transit_type").on('click', 'li a', function(){
      $('#Transit_Type').text($(this).text());
   });
    $("#columns").on('click', 'li a', function(){
      $('#sort_button').text($(this).text());
   });
});

function Filter()
{
  $("#transit_info tr").remove();
  var site_name = $('#Site_list').text();
  var trans_type = $('#Transit_Type').text();
  var low_price = $('#low_price').val();
  var high_price = $('#high_price').val();
  var sortby = $('#sort_button').text();

  site_name = site_name.split('\n');
  site_name = site_name[0];
  trans_type = trans_type.split('\n');
  trans_type = trans_type[0];
  low_price = Number(low_price);
  high_price = Number(high_price);
  // console.log(low_price);

  $.get( "../queries/get_transit_info.php?site_name=" + site_name + "&trans_type=" + trans_type + "&low_price=" + low_price + "&high_price=" + high_price, function( data )
  {
    // console.log(data)
    if(data != '')
    {
      dataArray = data.split("|");
      for(i = 0; i < dataArray.length; i++)
      {
        row = dataArray[i].split(',');

        var price = parseFloat(row[2]);

        $('#transit_info').append('<tr><td id="Route"><div class="checkbox"><label><input class="route" name="routes" value= "route_' + row[0] + '-'+row[1]+' " type="checkbox">' + row[0]+ '</label></div></td><td id="Type">' + row[1] + '</td><td id="Price">'+ price +'</td><td id="#ofsites">'+row[3]+'</td></tr>');
      }
    }
    else{
      $('#transit_info').append('<tr><td id="Type">no match data</td></tr>');
    }
  })
  $("table").show();
}

function goBack()
{
  window.history.back();
}


function goToNext()
{
  transit_date = document.getElementById("transit_date").value
  var email = document.cookie;
  email = email.split('=')[1];
  console.log(transit_date);
  var route_list = $("input[name='routes']:checked");
  if(transit_date == 'YYYY-MM-DD' || route_list == ''){
    alert('Must choose a route and enter a date')
  }
  var checkBoxValue = ""; 
  route_list.each(function(){
    checkBoxValue += $(this).val()+",";
  })
  checkBoxValue = checkBoxValue.substring(0,checkBoxValue.length-1);
  value_list = checkBoxValue.split(',');
  console.log(value_list[0])
  
  var i;
  for (i = 0; i < value_list.length; i++) { 
    info_list = value_list[i].split('-');
    t_type = info_list[0].split('_')[1];
    // console.log(t_type)
    $.get( "../queries/log_transit.php?email="+email+"&route="+t_type+"&trans_type="+info_list[1]+"&transit_date="+transit_date, function(data){
      // console.log(data)
      if(data == 'error'){
        alert("an error occours\n Notice user can only take the same transit once a day.\n Try another date.")
      }
      else{
        alert("Successfully logged the transit information!")
      }
    });
    window.location.reload(true);
  }
}

 


