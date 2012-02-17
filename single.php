<?php
	$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
	
	if (empty($id)) {
		header('Location: index.php');
		exit;	
	}

	require_once 'includes/db.php';

	$sql = $db->prepare('
		SELECT id, movietitle, releasedate, director
		FROM movies
		WHERE id = :id
	');
	
	$sql->bindValue(':id', $id, PDO::PARAM_INT);
	
	$sql->execute();
	
	$results = $sql->fetch();
	
	if (empty($results)) {
		header('Location: index.php');
		exit;	
	}


?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $results['movietitle']; ?> &middot; Movies</title>
	<link href="css/general.css" rel="stylesheet">
</head>

<body>
	<h1><?php echo $results['movietitle']; ?></h1>
	<p>Directed by: <b><?php echo $results['director']; ?></b></p>
	<p>Release Date: <?php echo $results['releasedate']; ?></p>
	
	<p><a href="index.php">Back</a></p>
	

</body>
</html>