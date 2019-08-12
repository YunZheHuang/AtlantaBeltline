$( document ).ready(function() 
{
  getSites();
})


function getSites()
{
  
  $.get( "../queries/get_sites.php", function( data ) 
  {
    if(data != '')
    {
      // console.log(data)
      dataArray = data.split("|");
      for(i = 0; i < dataArray.length; i++)
      {
        $('#site_info').append('<tr><td id="Sites"><div class="checkbox"><label><input class="sites" name="sites" value= "'+dataArray[i]+'" type="checkbox">'+dataArray[i]+'</label></div></td></tr>');
      }
    }
  });
}


$(function(){
    $("#transit_type").on('click', 'li a', function(){
      $('#Transit_Type').text($(this).text());
   });
});


function Create()
{
  var site_list = $("input[name='sites']:checked");
  // if(site_list == ''){
  //   alert('Must choose two sites')
  // }
  var checkBoxValue = ""; 
  site_list.each(function(){
    checkBoxValue += $(this).val()+",";
  })

  checkBoxValue = checkBoxValue.substring(0,checkBoxValue.length-1);
  // console.log(checkBoxValue)
  var trans_type = $('#Transit_Type').text();
  trans_type = trans_type.split('\n');
  trans_type = trans_type[0];
  var route = $('#route').val();
  var price = $('#price').val();
  value_list = checkBoxValue.split(',');
  input_list = [];
  for(i = 0; i < value_list.length; i ++){
    tmp = value_list[i].trim();
    input_list[i] = tmp;
  }

  // console.log(input_list)

  if(value_list.length < 2 || trans_type == "--ALL--" || route == "" || price == "" ){
    alert("All fields are required. Please enter those information.")
  }
  else{
    $.get( "../queries/create_transit.php?trans_type="+ trans_type + "&route=" + route + "&price=" + price , function(data){
        // console.log(data)
        if(data == "error"){
          alert("Exsited Route, please choose another one");
        }})
    for(i=0;i<input_list.length;i ++){
      $.get( "../queries/create_site_con_transit.php?trans_type="+ trans_type + "&route=" + route + "&site_select=" + input_list[i] , function(data){
        console.log(data)
        if(data == "error"){
          alert("there is an error");
          return;
        }
      })
    alert("Transit created successfully!");
    window.location.reload()
    }
  }
}


function Edit(){
  var route_list = $("input[name='routes']:checked");
  var checkBoxValue = ""; 
  route_list.each(function(){
    checkBoxValue += $(this).val()+",";
  })
  checkBoxValue = checkBoxValue.substring(0,checkBoxValue.length-1);
  value_list = checkBoxValue.split(',');
  console.log(value_list)
  if(value_list == ''){
    alert('Must choose a route');
  }
  else{
    window.location.assign("../pages/edit_transit.php");
  }

}



function goBack()
{
  window.history.back();
}
