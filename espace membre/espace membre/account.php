<?php 

require 'inc/header.php';

var_dump(!isset($_SESSION['auth']));



if(!isset($_SESSION['auth'])){

	$_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder à cette page";

	header('Location: login.php');

	exit();

	// on peut créer une fonction si on l'utilise plein de fois dans functions.php sans oublier le require 'inc/functions.php';
}

if(!empty($_POST)){

	if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){

		$_SESSION['flash']['danger'] = "Les mots de passe de correspondent pas";

	}else{

		$user_id = $_SESSION['auth']->id;

		$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

		require_once 'inc/db.php';

		$pdo->prepare('UPDATE users SET password = ? WHERE id = ?')->execute([$password, $user_id]);

		$_SESSION['flash']['sucess'] = "Votre mot de passe a bien été mis à jour";

	}

}




?>

<h1>Bonjour <?= $_SESSION['auth']->username; ?>,</h1>


<form action="" method="POST">
	
	
	<input type="password" name="password" placeholder="Changer de mot de passe" />

	<input type="password" name="password_confirm" placeholder="Confirmation du mot de passe" />

	<button type="submit">Changer mon mot de passe</button>

</form>

<?php var_dump($_SESSION); ?>

<?php require 'inc/footer.php'; ?>
