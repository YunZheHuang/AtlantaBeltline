$( document ).ready(function() 
{
    get_transport_type();
});

function get_transport_type()
{
  var info = document.cookie.split('; ');
  for(var i=0;i<info.length;i++){
    tmp = info[0].split('=');
    if(tmp[0] == 'transit_info'){
      transit_info = tmp[1];
    }
  }
  // console.log(transit_info)
  transit_info = transit_info.split('-');
  trans_type = transit_info[0];
  trans_route = transit_info[1];
  trans_price = Number(transit_info[2]);
  // console.log(trans_route)

  document.getElementById("transport_type").value = trans_type;
  document.getElementById("route").value = trans_route;
  document.getElementById("price").value = trans_price;

  $.get( "../queries/get_all_connected_sites.php?trans_type="+ trans_type + "&trans_route=" + trans_route , function(data){
    console.log(data)
    if(data != "error"){
      dataArray = data.split("~");
      all_array = dataArray[0].split('|');
      for(var i = 0; i < all_array.length; i++)
      {
        $('#site_info').append('<tr><td id="site_name"><div class="checkbox"><label><input class="Site" id="site_name_'+all_array[i]+'" name="site_name" value= "'+all_array[i]+'" type="checkbox">'+all_array[i]+'</label></div></td></tr>');
      }

      checked_array = dataArray[1].split('|');
      for(var i = 0; i < checked_array.length; i++)
      {
        if(all_array.includes(checked_array[i])){
          $('input[id="site_name_'+checked_array[i]+'"]').attr("checked","checked");
        }
      }
    }
  })
}


function Update(){
  var info = document.cookie.split('; ');
  for(var i=0;i<info.length;i++){
    tmp = info[0].split('=');
    if(tmp[0] == 'transit_info'){
      transit_info = tmp[1];
    }
  }

  transit_info = transit_info.split('-');
  trans_type = transit_info[0];
  old_route = transit_info[1];
  old_price = transit_info[2];
  new_route = $('#route').val();
  new_price = $('#price').val();
  trans_price = Number(trans_price);

  // console.log(transit_info)

  var site_list = $("input[name='site_name']:checked");
  var checkBoxValue = ""; 
  site_list.each(function(){
    checkBoxValue += $(this).val()+",";
  })
  checkBoxValue = checkBoxValue.substring(0,checkBoxValue.length-1);
  value_list = checkBoxValue.split(',');

  if(value_list.length < 2){
    alert("site number must greater than 2")
    return;
  }
  else{
    $.get( "../queries/edit_transit.php?trans_type="+trans_type+"&old_route="+old_route+"&old_price="+old_price+"&new_route="+new_route+"&new_price="+new_price, function(data){
          // console.log(data)
    if(data == "error"){
      alert("update new transit information not successfully");
      return;
    }})
    console.log(value_list)
    for(var i =0;i<value_list.length;i++){
      console.log(value_list[i])
      $.get( "../queries/update_connected_transit_site.php?trans_type="+trans_type+"&new_route="+new_route+"&new_price="+new_price+"&sites="+value_list[i], function(data){
            console.log(data)
        if(data == "error"){
          alert("insert not successfully");
          return;
        }
      })
    }
    window.location.reload()
  }
  // console.log(document.cookie)
  // document.cookie.split("; ").forEach(function(c){ 
  //     c = c.split('=');
  //     if(c[0] != "Email"){
  //       document.cookie = c[0] + "=; expires=Thu, 18 Dec 2013 12:00:00 UTC;"; 
  //       console.log(c);
  //     }
  //   });
}





function goBack()
{
  // console.log(document.cookie);
  document.cookie.split("; ").forEach(function(c){ 
    c = c.split('=');
    if(c[0] != "Email"){
      document.cookie = c[0] + "=; expires=Thu, 18 Dec 2013 12:00:00 UTC;"; 
      // console.log(c);
    }
  });

  x = document.cookie
  console.log(x)

  window.location.assign("../pages/manage_transit.php");
}
