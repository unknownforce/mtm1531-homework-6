<?php
	require_once 'includes/filter-wrapper.php';
	require_once 'includes/db.php';
	
	$errors = array();
	
	$movietitle = filter_input(INPUT_POST, 'movietitle', FILTER_SANITIZE_STRING);
	$releasedate = filter_input(INPUT_POST, 'releasedate', FILTER_SANITIZE_NUMBER_INT);
	$director = filter_input(INPUT_POST, 'director', FILTER_SANITIZE_STRING);
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (empty($movietitle)) {
			$errors['movietitle'] = true;
		}
		
		if (empty($releasedate)) {
			$errors['releasedate'] = true;
		}
		if (empty($director)) {
			$errors['director'] = true;
		}
		
		if (empty($errors)) {
			require_once 'includes/db.php';
			
			$sql = $db->prepare('
				INSERT INTO movies (movietitle, releasedate, director)
				VALUES (:movietitle, :releasedate, :director)
			');
			
			$sql->bindValue(':movietitle', $movietitle, PDO::PARAM_STR);
			$sql->bindValue(':releasedate', $releasedate, PDO::PARAM_INT);
			$sql->bindValue(':director', $director, PDO::PARAM_STR);
			$sql->execute();
			
			header('Location: index.php');
			exit;
		}
	}

	

?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>Add Movie</title>
	<link href="css/general.css" rel="stylesheet">
</head>

<body>

	<form method="post" action="add.php">
		<div>
			<label for="movietitle">Movie Name<?php if (isset($errors['movietitle'])) : ?> <strong> is required</strong><?php endif; ?></label>
			<input id="movietitle" name="movietitle" value="<?php echo $movietitle; ?>" required> <em>ie. Scary Movie</em>
		
			<label for="releasedate">Release Date<?php if (isset($errors['releasedate'])) : ?> <strong> is required</strong><?php endif; ?></label>
			<input type="date" id="releasedate" name="releasedate" value="<?php echo $releasedate; ?>" required> <em>ie. YYYY-MM-DD</em>
	
			<label for="director">Director<?php if (isset($errors['director'])) : ?> <strong> is required</strong><?php endif; ?></label>
			<input id="director" name="director" value="<?php echo $director; ?>" required> <em>ie. Steven Spielberg</em>
		
			<button type="submit">Add</button>
		</div>
	</form>


</body>
</html>