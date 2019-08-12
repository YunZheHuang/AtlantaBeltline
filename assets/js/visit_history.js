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
      console.log($(this).text() + "This is the text");
   });
});

function Filter()
{
  $("#visit_history_info tr").remove();
  var email = document.cookie;
  email = email.split('=')[1];
  var site_name = $('#Site_list').text();
  var event_name = $('#Event_Name').val();
  var start_date = $('#start_date').val();
  var end_date = $('#end_date').val();

  site_name = site_name.split('\n');
  site_name = site_name[0];
  event_name = event_name.split('\n');
  event_name = event_name[0];
  console.log(site_name);
  console.log(start_date);
  console.log(end_date);
  console.log(event_name);

  $.get( "../queries/visit_history.php?site_name=" + site_name + "&event_name=" + event_name + "&email=" + email + "&start_date=" + start_date + "&end_date=" + end_date, function( data )
  {
    console.log(data)
    if(data != '')
    {
      dataArray = data.split("|");
      for(i = 0; i < dataArray.length; i++)
      {
        row = dataArray[i].split(',');

        var price = parseFloat(row[3]);

        if(isNaN(price)) {
          price = 0;
        }

        $('#visit_history_info').append('<tr></td><td id="visit_date">'+ row[0] +'</td><td id="event_name">' + row[1] + '</td><td id="site_name">'+ row[2] +'</td><td id="price">'+price+'</td></tr>');
      }
    }
    else{
      $('#visit_history_info').append('<tr><td id="Type">no match data</td></tr>');
    }
  })
  $("table").show();
}

function goBack()
{
  window.history.back();
}


 


