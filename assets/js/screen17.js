function showDetails(str)
 {
    //console.log("clicke");
    if (str.length == 0) { 
    document.getElementById("txtHint").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "17_populateDropdown.php?q=" + str, true);
    xmlhttp.send();
  }
 }//end function showDetails()



var i=1;
function addEmail(obj){

    curID=obj.id;
    //console.log(curID);
    i=i+1;
    var newTableID="emailTable_"+i;
    //console.log(obj.parentNode.parentNode.rowIndex,i);
    var table=document.getElementById("table1");
    var newRow=table.insertRow(obj.parentNode.parentNode.rowIndex+1);
    newRow.setAttribute("class","email_table");
    newRow.setAttribute("id",newTableID);
    var newCell1=newRow.insertCell(0);
    newCell1.innerHTML="<td style='font-weight: bold'><div align='right'><label for='email'>Email</label></div></td>"; //one label email is enough
    var newCell2=newRow.insertCell(1);
    var addCell2="<td><input name='emails[]' type='email' class='input' size='25' id=email_" +i + " required/></td>" ;
    newCell2.innerHTML=addCell2; 
    var newCell3=newRow.insertCell(2);
    newCell3.innerHTML="<td><input type='button' onclick='addEmail(this)'  value='add' id=addButton" + i + "></td>";
    var newCell4=newRow.insertCell(3);
    newCell4.innerHTML="<td><input type='button' onclick='removeEmail(this)'  value='remove' id=removeButton" + i + "></td>";
    return i;
}

/*function removeEmail(obj,i){
    
    if(i>1 ){
        d=obj.parentNode.parentNode.rowIndex;
        //console.log(d);
        document.getElementById("table1").deleteRow(d);
        i=i-1;
    }else{
        window.alert("Employee must have  at least 1 email");
    }
}*/
function removeEmail(obj){
    
        d=obj.parentNode.parentNode.rowIndex;
        //console.log(d);
        document.getElementById("table1").deleteRow(d);
        
}
function change(obj){
    obj.name=obj.checked ? 'is_visitor':'not_visitor';
    obj.value=obj.checked ? 'yes':'no';
    console.log(obj.value);
}
