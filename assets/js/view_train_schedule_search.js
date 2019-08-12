function view_train_schedule_search(train_number)
{
	if($('#train_number').val() != '')
	{
		$.get( "../queries/view_train_schedule_search.php?train_number=" + train_number, function( data ) 
		{
			if(data == 'success')
			{
				window.location.replace("https://academic-php.cc.gatech.edu/groups/cs4400_Team_57/pages/view_train_schedule.php?train_number=" + train_number);
			}
			else
			{
				alert(data);
			}
		});
	}
	else
	{
		$('#TrainBlankAlert').show();
	}
}