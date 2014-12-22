<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>User</title>
</head>
<body>
	<?php 
	// $user = Auth::user();
	$user = User::find(Auth::id()); // CRASHA USANDO AUTH::USER()
	// $user = User::find(1);
	echo "<h1>Hello User <i>$user->name!<i> - Box</h1>";
	$series = $user->listSeries;
	?>
	<div class="links">
		<a href="box">Casella</a>
		<a href="logout">Logout</a>
	</div>
		<h4>Series of the user</h4>
		<?php
		foreach ($series as $serie) {
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $serie -> series . "<br>";
		}
		?>
		<h4>Comics of the user</h4>
		<?php
		$comics = $user -> listComics;
		foreach ($comics as $comic) {
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $comic -> comic . "<br>";
		}
	?>
</body>
</html>