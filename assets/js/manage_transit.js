$( document ).ready(function() 
{
  // $('##transit_info').submit(function () {
  //   $.cookie('routes', $('#routes').val());
  // });
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
});


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
  var site_name = $('#Site_list').text();
  var trans_type = $('#Transit_Type').text();
  var low_price = $('#low_price').val();
  var high_price = $('#high_price').val();
  var route = $('#route').val();

  site_name = site_name.split('\n');
  site_name = site_name[0];
  trans_type = trans_type.split('\n');
  trans_type = trans_type[0];
  low_price = Number(low_price);
  high_price = Number(high_price);

  $.get( "../queries/manage_transit_info.php?site_name=" + site_name + "&trans_type=" + trans_type + "&low_price=" + low_price + "&high_price=" + high_price + "&route=" + route, function( data )
  {
    // console.log(data)
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

