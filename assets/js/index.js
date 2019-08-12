function verifyLogin(email, password)
{
	$.get( "queries/login.php?email=" + email + "&pass=" + password, function( data ) 
	{
		console.log(data);
		if(data == 'user')
		{
			document.cookie = 'Email= ' + email;
			window.location.replace("./pages/user_only.php");
		}
		else if(data == 'admin_only')
		{
			document.cookie = 'Email= ' + email;
			window.location.replace("./pages/admin_only.php");
		}
		else if(data == 'admin_visitor')
		{
			document.cookie = 'Email= ' + email;
			window.location.replace("./pages/admin_visitor.php");
		}
		else if(data == 'manager_only')
		{
			document.cookie = 'Email= ' + email;
			window.location.replace("./pages/manager_only.php");
		}
		else if(data == 'manager_visitor')
		{
			document.cookie = 'Email= ' + email;
			window.location.replace("./pages/manager_visitor.php");
		}
		else if(data == 'staff_only')
		{
			document.cookie = 'Email= ' + email;
			window.location.replace("./pages/staff_only.php");
		}
		else if(data == 'staff_visitor')
		{
			document.cookie = 'Email= ' + email;
			window.location.replace("./pages/staff_visitor.php");
		}
		else if(data == 'visitor_only')
		{
			document.cookie = 'Email= ' + email;
			window.location.replace("./pages/visitor_only.php");
		}
		else
		{
			$('#incorrectLoginAlert').show();
		}
	});
}