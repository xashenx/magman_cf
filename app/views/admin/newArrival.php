<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>Admin</title>
</head>
<body>
	<p>
		<h1>Hello Admin!</h1>
		<div class="links">
		<a href="addSeries">Aggiungi Serie</a>
		<a href="addVolume">Aggiungi Volume</a>
		<a href="addBox">Aggiungi Casellante</a>
		<a href="newArrival">Carica Arrivo</a>
		<a href="manageBoxes">Gestisci Casellanti</a>
		<a href="manageSeries">Gestisci Serie</a>
		</div>
		<?php
		echo "<h1>Users</h1>";
		$users = User::all();
		foreach ($users as $user) {
			echo $user . "<br>";
			$series = $user->listSeries;


		?>
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
		}
		echo "<h1>Comics</h1>";
		$comics = Comic::all();
		foreach ($comics as $comic) {
		echo $comic . "<br>";
		}
		echo "<h1>Series</h1>";
		$series = Series::all();
		foreach ($series as $serie) {
		echo $serie . "<br>";
		$comics = $serie->listComics;
		foreach($comics as $comic){
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $comic . "<br>";
		}
		}
		?>
	</p>
	@foreach ($bears as $bear)
	<h2>{{ $series }}</h2>
	@endforeach
	<br>
	<a href="logout">Logout</a>
</body>
</html>