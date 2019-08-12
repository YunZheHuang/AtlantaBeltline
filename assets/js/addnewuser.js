function addNewUser(username, password, email)
{
	if($('#inputUsername').val() != '')
	{
		if($('#inputEmail').val() != '')
		{
			if($('#inputPassword').val() != '')
			{
				if($('#inputPassword').val() == $('#inputConfirmPassword').val())
				{
					$.get( "../queries/addnewuser.php?user=" + username + "&pass=" + password + "&email=" + email, function( data ) 
					{
						if(data == 'success')
						{
							window.location.replace("https://academic-php.cc.gatech.edu/groups/cs4400_Team_57/");
						}
						else
						{
							$('#accountExistsAlert').show();
						}
					});
				}
				else
				{
					$('#passwordsDontMatchAlert').show();
				}
			}
			else
			{
				$('#passwordBlankAlert').show();
			}
		}
		else
		{
			$('#emailBlankAlert').show();
		}
	}
	else
	{
		$('#usernameBlankAlert').show();
	}
}