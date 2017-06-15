<?php

if(!empty($_POST) && !empty($_POST['email']) ){

	require_once 'inc/db.php';

	require_once 'inc/functions.php';

	$req = $pdo->prepare('SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL');

	$req->execute([$_POST['email']]);

	$user = $req->fetch();

	//var_dump($user->password);

	if($user){

		session_start();

		$reset_token = str_random(60);

		$pdo->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?')->execute([$reset_token, $user->id]);

		$_SESSION['flash']['sucess'] = 'un email vient de vous être envoyé pour changer votre mot de passe';

		mail($_POST['email'], 'Réinitialisation de votre mot de passe', "Afin de réinitialisation votre mot de passe merci cliquer sur ce lien\n\nhttp://localhost/tests/projet-commerce/reset.php?id={$user->id}&token=$reset_token");


		header('Location: login.php');

		exit();

	}else{

		session_start();

		$_SESSION['flash']['danger'] = 'Aucun compte ne correspond a cette adresse mail';

		
	}

	
}

?>


<?php require 'inc/header.php'; ?>

	<h1>Mot de passe oublié</h1>


<form action="" method="POST">
	

	<label>Email</label>

	<input type="email" name="email" />

	

	<button type="submit">Envoyer mon mot de passe</button>

</form>

<?php require 'inc/footer.php'; ?>

<?php var_dump($_SESSION); ?>



