<!DOCTYPE HTML>
<html>
	<head>
		<title>Dashboard</title>
	</head>
	<body>
		<h1>Dashboard</h1>
		<p>
			Welcome to the Dashboard! You can only see this page when you are logged in. This would be the page in your application where you show users their ost recent activity, anything they have missed or give them links to other areas of your application. In this case we simply welcome you to the loggewd in area. I guess you cold 
			<?php echo anchor('account/logout', 'logout'); ?>
			if you wanted to?
		</p>
	</body>
</html>