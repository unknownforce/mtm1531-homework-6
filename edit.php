<?php
	require_once 'includes/filter-wrapper.php';
	$errors = array();
	
	$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
	
	if (empty($id)) {
		header('Location: index.php');
		exit;	
	}
	
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
				UPDATE movies
				SET movietitle = :movietitle, releasedate = :releasedate, director = :director
				WHERE id = :id
			');
			
			$sql->bindValue(':movietitle', $movietitle, PDO::PARAM_STR);
			$sql->bindValue('releasedate', $releasedate, PDO::PARAM_INT);
			$sql->bindValue(':director', $director, PDO::PARAM_STR);
			$sql->bindValue(':id', $id, PDO::PARAM_INT);
			$sql->execute();
			
			header('Location: index.php');
			exit;
		}
	}else {
		require_once 'includes/db.php';
		
		$sql = $db->prepare('
			SELECT id, movietitle, releasedate, director
			FROM movies
			WHERE id = :id			
		');
		
		$sql->bindValue(':id', $id, PDO::PARAM_INT);
		$sql->execute();
		$results = $sql->fetch();
		
		$movietitle = $results['movietitle'];
		$releasedate = $results['releasedate'];
		$director = $results['director'];
	}


?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Edit Movie</title>
</head>

<body>

	<form method="post" action="edit.php?id=<?php echo $id; ?>">
		<div>
			<label for="movietitle">Movie Name<?php if (isset($errors['movietitle'])) : ?> <strong> is required</strong><?php endif; ?></label>
			<input id="movietitle" name="movietitle" value="<?php echo $movietitle; ?>" required> <em>ie. Scary Movie</em>
		</div>	
		<div>
			<label for="releasedate">Release Date<?php if (isset($errors['releasedate'])) : ?> <strong> is required</strong><?php endif; ?></label>
			<input type="date" id="releasedate" name="releasedate" value="<?php echo $releasedate; ?>" required> <em>ie. YYYY-MM-DD</em>
		</div>	
		<div>
			<label for="director">Director<?php if (isset($errors['director'])) : ?> <strong> is required</strong><?php endif; ?></label>
			<input id="director" name="director" value="<?php echo $director; ?>" required> <em>ie. Steven Spielberg</em>
		</div>	
		<button type="submit">Edit</button>
	</form>

</body>
</html>