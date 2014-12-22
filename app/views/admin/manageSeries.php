<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>Admin</title>
</head>
<body>
	<p>
		<h1>Hello Admin!</h1>
		<div class="links">
			<a href="home">Homepage</a>
			<a href="addVolume">Aggiungi Volume</a>
			<a href="addBox">Aggiungi Casellante</a>
			<a href="newArrival">Carica Arrivo</a>
			<a href="boxes">Gestisci Casellanti</a>
			<a href="series">Gestisci Serie</a>
			<a href="logout">Logout</a>
		</div>
		<br>
		<?php
		$series = Series::all();
		foreach ($series as $serie) {
			echo $serie . "<br>";
			$comics = $serie -> listComics;
			foreach ($comics as $comic) {
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $comic . "<br>";
			}
		}
		?>
	</p>
</body>
</html>