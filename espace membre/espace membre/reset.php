<?php require 'inc/functions.php'; ?>

<?php require 'inc/header.php'; ?>

<?php 

	if(isset($_GET['id']) && isset($_GET['token'])){

		require 'inc/db.php';

		$req = $pdo->prepare('SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');

		$req->execute([$_GET['id'], $_GET['token']]);

		$user = $req->fetch();

		var_dump($user);

		if($user){

			if(!empty($_POST)){

				if(!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm']){

					$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

					$pdo->prepare('UPDATE users SET password = ?')->execute([$password]);

					session_start();

					$_SESSION['flash']['sucess'] = "Votre mot de passe a bien été modifié";

					$_SESSION['auth'] = $user;

					header('Location: account.php');

					exit();
				}
			}


		}else{

			session_start();

			$_SESSION['flash']['danger'] = "Ce token n'est pas valide";

			header('Location: login.php');

			exit();
		}

	}else{

		header('Location: login.php');

		exit();
	}

?>

	<h1>Réinitialiser mon mot de passe</h1>

	<form action="" method="POST">

	
		<label>Mot de passe</label>

		<input type="password" name="password" />

		<label>Confirmation du mot de passe</label>

		<input type="password" name="password_confirm" />

		<button type="submit">Réinitialiser mon mot de passe</button>

	</form>

	<?php var_dump($_SESSION); ?>

<?php require 'inc/footer.php'; ?>
