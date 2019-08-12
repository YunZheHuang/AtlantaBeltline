var i=1;

function addEmail(obj){
    curID=obj.id;
    i=i+1;
    var newTableID="emailTable_"+i;
    console.log(obj.parentNode.parentNode.rowIndex,i);
    var table=document.getElementById("table");
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
}
/*function addEmail(obj){
    console.log(obj.id);
    //document.getElementById("addButton"+i).value="remove";
    i=i+1;
    var newTableID="emailTable"+i;
    console.log(i);
    var dict={id:"email"+i,};
    var table=document.getElementById("table");
    var newRow=table.insertRow(5);
    newRow.setAttribute("class","email_table");
    newRow.setAttribute("id",newTableID);
    
    var newCell1=newRow.insertCell(0);
    newCell1.innerHTML="<td style='font-weight: bold'><div align='right'><label for='email'>Email</label></div></td>"; //one label email is enough
    var newCell2=newRow.insertCell(1);
    var addCell2="<td><input name='emails[]' type='email' class='input' size='25' id=" +dict["id"] + " required/></td>" ;
    newCell2.innerHTML=addCell2; 

    var newCell3=newRow.insertCell(2);
    newCell3.innerHTML="<td><input type='button' onclick='addEmail(this)'  value='add' id=addButton" + i + "></td>";

    var newCell4=newRow.insertCell(3);
    newCell4.innerHTML="<td><input type='button' onclick='removeEmail(this)'  value='remove' id=removeButton" + i + "></td>";
}*/


    function removeEmail(obj){
        
        
        //var curTableID=document.getElementsByClassName("email_table")[0].id;
        
        //var curRow = document.getElementById(curTableID);
        if(i>1 ){
            d=obj.parentNode.parentNode.rowIndex;
            document.getElementById("table").deleteRow(d);
            var curID=obj.parentNode.parentNode;
            i=i-1;
        }
        else{
            window.alert("You must register with at least 1 email");
        }

}