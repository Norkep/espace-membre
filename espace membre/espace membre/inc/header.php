<?php


if(session_status() == PHP_SESSION_NONE){

	session_start();

}


?>


<!DOCTYPE html>
<html>
<head>
	<title>Projet Commerce</title>

	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

	<div>

		<ul>

			<?php if(isset($_SESSION['auth'])): ?>

				<li><a href="logout.php">Se déconnecter</a></li>

			<?php else: ?>

				<li><a href="register.php">S'inscrire</a></li>
				<li><a href="login.php">Se connecter</a></li>

			<?php endif; ?>

		</ul>

<?php if(isset($_SESSION['flash'])): ?>

	<?php foreach($_SESSION['flash'] as $type => $message): ?>

		<div class="<?= $type; ?>">
			
			<p><?= $message; ?></p>

		</div>

	<?php endforeach; ?>

	<?php unset($_SESSION['flash']); ?>

<?php endif; ?>

