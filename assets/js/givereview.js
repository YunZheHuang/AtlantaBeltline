var trainNumber;

$( document ).ready(function()
{
	getTrain();
});

function giveReview(trainnumber, rating, comment)
{
	if($('#inputTrainNumber').val() != '')
	{
		if($('#inputRating').val() != '')
		{
/*			$('#suAlert').show();
			console.log($('#inputTrainNumber').val());
			console.log($('#inputRating').val());
			console.log($('#inputComment').val());
*/			
				$.get( "../queries/givereview.php?tnum=" + trainNumber + "&rating=" + rating + "&comment=" + comment + "&ID=" + parseInt(generateID()) + "&user=" + (getCookie("username")), function( data ) 
				{
					if(data == 'success')
					{
						//$('#suAlert').show();
						window.location.replace("customerchoosefunctionality.php");
					}
					else
					{
						$('#failAlert').show();
					}
				});
		}
		else
		{
			$('#ratingBlankAlert').show();
		}
	}
	else
	{
		$('#trainnumberBlankAlert').show();
	}
}

function generateID()
{
  return Math.random() * 99999;
}


function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}

function getTrain()
{
	$.get( "../queries/givereviewgettrain.php", function( data ) 
	{
		if(data != '')
		{
			dataArray = data.split("|");
			for(i = 0; i < dataArray.length; i++)
			{
				$('#tmunDropdown').append('<li><a onClick="selectTrain(\'' + dataArray[i] + '\');">' + dataArray[i] + '</a></li>');
			}
		}
		else
		{
			
		}
	});
}

function selectTrain(trainNum)
{
	trainNumber = trainNum;
	$('#trainNumberText').html(trainNum + '<span class="glyphicon glyphicon-triangle-bottom"></span>');
}