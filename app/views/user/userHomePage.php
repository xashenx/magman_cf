<!DOCTYPE html>
  <head>
    <meta charset="utf-8">
    <title>User</title>
  </head>
  <body>
  	<?php
  	$user = Auth::user();
    echo "<h1>Hello User <i>$user->name!<i></h1>";
	$user->name = "Sikaka";
	// $user->save($user);
	echo $user->name;
    ?>
    <div class="links">
    	<a href="box">Casella</a>
    	<a href="logout">Logout</a>
    </div>
  </body>
</html>