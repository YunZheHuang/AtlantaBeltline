function goBack()
{
  console.log("going back")
  window.history.back();
}
getEventDetail()
function getCookie(name) {
    var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
    return v ? v[2] : null;
}

var remaining = 0;
var predate = "";
var enddate = "";

function getEventDetail()
{
  console.log(document.cookie)
  var helperInfo = document.cookie.split(";").join(',').split('=')
  event_name = getCookie("event_name")
  site_name = getCookie("site_name")
  start_date = getCookie('start_date')
  username = getCookie('username')

  $.get( "../queries/screen34_get_event_detail.php?event_name=" + event_name + '&site_name=' + site_name + "&start_date=" + start_date + "&username=" + username, function( data ) 
  {
    if(data != '')
    {
      
      row = data.split(",");
      console.log(row)
      $('#event_details').append('Name: ' + row[0])
      $('#event_details').append('<br>')
      $('#event_details').append('Site: ' + row[1])
      $('#event_details').append('<br><br>Start Date: ' + row[2] + '<br>End Date: ' + row[3] + '<br><br>Ticket Price: $' +row[4] + '<br>Tickets Remaining: ' + row[5] + '<br><br>Description: ' + row[6] + '<br>');
      remaining = row[5];
      predate = row[2];
      enddate = row[3];
    }
  })
}

function goToNext()
{
  if (remaining == 0) {
    alert('There are no tickets available');
  }
  visit_date = document.getElementById("visit_date").value



  if(visit_date == 'YYYY-MM-DD'){
    alert('Must enter a date')
  } else if (!checkdate(visit_date, predate, enddate)) {
    alert('Date must be in valid range.')
  } else {
    $.get( "../queries/log_event.php?username="+username+"&event_name="+event_name+"&site_name="+site_name+"&start_date="+start_date+"&visit_date="+visit_date, function(data){
      if(data == 'error'){
        alert("an error occours\n Notice user can only take the same transit once a day.\n Try another date.")
      }
      else if (data == 'sameday'){
        alert("Cannot log two visits on the same day.");
      }
      else{
        alert("Successfully logged the transit information!")
      }
  })

  }
}
function checkdate(visit, start, end){
  visit = visit.split("-");
  start = start.split("-");
  end = end.split("-");
  var v = new Date(visit[0], visit[1], visit[2])
  var s = new Date(start[0], start[1], start[2])
  var e = new Date(end[0], end[1], end[2])
  if (v >= s && v <= e) {
    return true
  }
  return false
}








