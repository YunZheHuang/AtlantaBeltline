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
});

function Filter()
{
  $("#transit_info tr").remove();
  var route = $('#route').val();

// email stored in cookie. cookie looks like: Email=xxx@xxx.com ,split by = , then use email to retrieve username from Email table
  var email = document.cookie;
  email = email.split('=')[1];


  var site_name = $('#Site_list').text();
  var trans_type = $('#Transit_Type').text();
  var start_date = $('#start_date').val();
  var end_date = $('#end_date').val();

  site_name = site_name.split('\n');
  site_name = site_name[0];
  trans_type = trans_type.split('\n');
  trans_type = trans_type[0];
  
  console.log(route);

  $.get( "../queries/transit_history.php?site_name=" + site_name + "&trans_type=" + trans_type + "&route=" + route + "&email=" + email + "&start_date=" + start_date + "&end_date=" + end_date, function( data )
  {
    console.log(data)
    if(data != '')
    {
      dataArray = data.split("|");
      for(i = 0; i < dataArray.length; i++)
      {
        row = dataArray[i].split(',');

        var price = parseFloat(row[3]);

        $('#transit_info').append('<tr></td><td id="trans_date">'+ row[0] +'</td><td id="route">' + row[1] + '</td><td id="T_type">'+ row[2] +'</td><td id="price">'+price+'</td></tr>');
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


 


