<?php
	require_once 'includes/db.php';
	
	$results = $db->query('
		SELECT id, movietitle, releasedate, director FROM movies
		ORDER BY id ASC
	
	');
	
	
?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>MTM1531 Homework 5</title>
	<link href="css/general.css" rel="stylesheet">
	
</head>

<body>
	<a href="add.php">Add a Movie!</a>

	<ol>
		<?php foreach($results as $movies) : ?>
			<li>
				<strong><a href="single.php?id=<?php echo $movies['id']; ?>"><?php echo $movies['movietitle']; ?></a></strong>
				<p>
					<a href="edit.php?id=<?php echo $movies['id']; ?>">Edit</a>
					<a href="delete.php?id=<?php echo $movies['id']; ?>">Delete</a>				
				</p>
			</li>
		<?php endforeach; ?>
	</ol>

</body>
</html>