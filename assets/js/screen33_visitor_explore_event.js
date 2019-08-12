console.log("connected to visitor explore event js")
$(function(){
    $("#contain_sites").on('click', 'li a', function(){
      $('#Site_list').text($(this).text());
   });
});

function Filter()
{
  var event_name = document.getElementById('event_name').value;
  var desc_key = document.getElementById('desc_key').value;
  var site_name = $('#Site_list').text();
  var start_date = document.getElementById('start_date').value;
  var end_date = document.getElementById('end_date').value;
  var low_price = document.getElementById('low_price').value;
  var high_price = document.getElementById('high_price').value;
  var low_visit = document.getElementById('low_visit').value;
  var high_visit = document.getElementById('high_visit').value;
  var visited = document.getElementById('visited').checked;
  var sold_out = document.getElementById('sold_out').checked;
  var sortBy = document.getElementById('sortlabel').value;
  var orderBy = document.getElementById('orderlabel').value;

  var username = 'manager2';//this is hardcoded lol, learn how to use cookies
  site_name = site_name.split('\n');
  site_name = site_name[0];

  low_price = Number(low_price);
  high_price = Number(high_price);
  low_visit = Number(low_visit);
  high_visit = Number(high_visit);

  $.get( "../queries/screen33_get_event_info.php?event_name=" + event_name + "&desc_key=" + desc_key + "&site_name=" + site_name + "&start_date=" + start_date  + "&end_date=" + end_date+ "&low_visit=" + low_visit + "&high_visit=" + high_visit + "&visited=" + visited + "&sold_out=" + sold_out + "&low_price=" + low_price + "&high_price=" + high_price + "&username=" + username+ "&sortBy=" + sortBy+ "&orderBy=" + orderBy, function( data )
  {
    
    $('#event_info').children().remove();
    if(data != '')
    {
      
      dataArray = data.split("|");
      for(i = 0; i < dataArray.length -1; i++)
      {

        row = dataArray[i].split(',');
        console.log(row)
        if (row[5].length == 1) {
          row[5] = "0"
        }
        $('#event_info').append('<tr><td id="event"><div class="checkbox"><label><input class="route" name="event" value= "' + row[0] + '='+ row[1] + '=' + row[6] +'" type="checkbox">'+row[0]+'</label></div></td><td id="site_name">' + row[1] + '</td><td id="price">'+ row[2] +'</td><td id="remaining">'+row[3]+'</td><td id="total_visits">'+row[4]+'</td><td id="my_visits">'+row[5]+'</td></tr>');
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

function goBack()
{
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

function goToNext()
{

  var items=document.getElementsByName('event');
  var selectedItems="";
  for(var i=0; i<items.length; i++){
    if(items[i].type=='checkbox' && items[i].checked==true)
    {
      selectedEvent =items[i].value;
    }
    
  }
  if (selectedEvent == null) {
    alert("Please select an event!")
  }
  selectedEvent = selectedEvent.split("=")
  
  document.cookie = "event_name=" + selectedEvent[0]
  document.cookie="site_name=" + selectedEvent[1] 
  document.cookie="start_date=" + selectedEvent[2] 
  document.cookie="username=" + "mary.smith"
  
  window.location.reload(true);
  window.location.replace("./screen34_visitor_event_detail.php");
 
}











