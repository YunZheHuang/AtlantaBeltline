// $( document ).ready(function() 
// {
//     get_Transit_info();
// });

function Filter()
{
  $("#transit_info tr").remove();
	var	site_name = $('#Site_list').text();
	var trans_type = $('#Transit_Type').text();
	var low_price = $('#low_price').val();
	var high_price = $('#high_price').val();

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

        $('#transit_info').append('<tr><td id="Route"><div class="checkbox"><label><input class="route" id= "route-' + row[0] + '~'+row[1]+' " type="checkbox" onclick="chooseCheckbox(\'first_class_checkbox-' + row[0] + '\', ' + row[3] + ')">' + row[0]+ '</label></div></td><td id="Type">' + row[1] + '</td><td id="Price">'+ price +'</td><td id="#ofsites">'+row[3]+'</td></tr>');
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
  if(cost != 0)
    window.location.replace('https://academic-php.cc.gatech.edu/groups/cs4400_Team_57/pages/selectbaggage.php?arrival=' + getUrlParameter('arrival') + '&depart=' + getUrlParameter('depart') + '&train=' + trainNumber + '&cost=' + cost + '&date=' + getUrlParameter('date') + '&departTime=' + departureTime.toLocaleTimeString() + '&arrivalTime=' + arrivalTime.toLocaleTimeString() + '&class=' + trainClass);
  else
    $('#costBlankAlert').show();
}

function chooseCheckbox(id, value)
{
  var x = document.cookie;
  console.log(x)
  $('.route').prop('checked', false);
  $('#' + id).prop('checked', true);

  trainClass = id.split('_')[0];

  trainNumber = id.split('-')[1];
  cost = value;
}




function test(){
  var test = $("input[name='checkboxname']:checked");
  var checkBoxValue = ""; 
  test.each(function(){
    checkBoxValue += $(this).val()+",";
  })
  checkBoxValue = checkBoxValue.substring(0,checkBoxValue.length-1);
  console.log(checkBoxValue)
}

