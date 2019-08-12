
function FindStaff(){
  $("#staff_info tr").remove();
  var event_name = $('#event_name').val();
  var description = $('#description').val();
  var start_date = $('#start_date').val();
  var end_date = $('#end_date').val();
  var price = Number($('#price').val());
  var capacity = Number($('#capacity').val());
  var min_req = Number($('#min_req').val());
  var d1 = new Date(start_date);
  var d2 = new Date(end_date);
  email = document.cookie.split('=')[1];
  console.log(email)

  if(event_name=="" || description=="" || start_date=="YYYY-MM-DD" || end_date=="YYYY-MM-DD" || price<0 || capacity<=0 || min_req <=0 || d1 > d2){
    alert("Must fill in all the fields!\nPrice cannot less than 0\nCapacity must be positive\nMinimum Staff Required must be positive\nEnd date must come after start date");
  }
  else{
    $.get( "../queries/check_input_info.php?email="+email+"&event_name="+event_name+"&start_date="+start_date+"&end_date="+end_date, function( data ){
      console.log(data)
      dataArray = data.split('|');
      k = 0;
      for(i=0;i<dataArray.length;i++){
        check = dataArray[i].split(",");
        if(end_date<check[0] || start_date>check[1]){

        }
        else{
          alert("date has overlap with other events, please choose another date");
          k++;
        }
        
      }
      if(k != 0){
        return;
      }
      else{
        $.get( "../queries/assign_staff.php?email="+email+"&event_name="+event_name+"&start_date="+start_date+"&end_date="+end_date+"&description="+description+"&price="+price+"&capacity="+capacity+"&min_req="+min_req, function( data ){
          console.log(data)
          dataArray = data.split('|');
          for(i=0;i<dataArray.length;i++){
            Staff_name = dataArray[i].split(',');
            console.log(Staff_name)
            $('#staff_info').append('<tr><td id="Staff"><div class="checkbox"><label><input class="name" id="staff_name" name="staff_name" onclick="removeDisable()" value= "'+Staff_name[0]+'-'+Staff_name[1]+'-'+Staff_name[2]+'" type="checkbox">'+Staff_name[0]+'</label></div></td><td id="lname">'+Staff_name[1]+'</td></tr>');
          }
        })
      }
    })
  }
}


function removeDisable(){
  $('#create_button').removeAttr('disabled');
}


function Create()
{
  var event_name = $('#event_name').val();
  var description = $('#description').val();
  var start_date = $('#start_date').val();
  var end_date = $('#end_date').val();
  var price = Number($('#price').val());
  var capacity = Number($('#capacity').val());
  var min_req = Number($('#min_req').val());
  var d1 = new Date(start_date);
  var d2 = new Date(end_date);
  email = document.cookie.split('=')[1];


  var staff_list = $("input[name='staff_name']:checked");

  var checkBoxValue = ""; 
  staff_list.each(function(){
    checkBoxValue += $(this).val()+",";
  })

  checkBoxValue = checkBoxValue.substring(0,checkBoxValue.length-1);
  console.log(checkBoxValue)


  value_list = checkBoxValue.split(',');

  if(value_list.length < min_req ){
    alert('Staff number is not enough');
    return;
  }
  $.get( "../queries/create_event.php?email="+email+"&event_name="+event_name+"&start_date="+start_date+"&end_date="+end_date+"&description="+description+"&price="+price+"&capacity="+capacity+"&min_req="+min_req, function( data ){
    if(data == "error"){
      alert("oops! Insert event not successfully");
      return;
    }else{
      alert("Insert Event successfully!");
    }
  })
  for(i=0;i<value_list.length;i++){
    username = value_list[i].split('-')[2];
    $.get( "../queries/insert_staff_into_event.php?email="+email+"&event_name="+event_name+"&start_date="+start_date+"&username="+username, function( data ){
    if(data == "error"){
      alert("oops! Insert not staff assigned to events successfully");
      return;
    }
    else{
      // alert("Insert successfully!");
    }
  })
  }
  alert("Insert staff assigned to events successfully!");
  window.location.href='./create_event.php';
}



function goBack()
{
  window.location.href='./manage_event.php';
}
