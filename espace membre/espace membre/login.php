<?php require 'inc/functions.php'; ?>

<?php require 'inc/header.php'; ?>

<?php 

if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){

	require 'inc/db.php';

	$req = $pdo->prepare('SELECT * FROM users WHERE (username = :username OR email = :username) AND confirmed_at IS NOT NULL');

	$req->execute(['username' => $_POST['username']]);

	$user = $req->fetch();

	//var_dump($user->password);

	if(password_verify($_POST['password'],$user->password)){

		session_start();

		$_SESSION['auth'] = $user;

		$_SESSION['flash']['sucess'] = 'Vous êtes maintenant connecté';

		header('Location: account.php');

		exit();

	}else{

		$_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorrecte';

		// il ne faut pas donner d'indice si le mot de passe ou l'identifiant est bon.
	}

	
}

?>

	<h1>Se connecter</h1>

	<form action="" method="POST">

	
		<label>Pseudo ou email</label>

		<input type="text" name="username" />

		<br><br>

		<label>Mot de passe<a href="forget.php">(J'ai oublié mon mot de passe)</a></label>

		<input type="password" name="password" />

		<br><br>

		<input type="checkbox" name="remember" value="1" />Se souvenir de moi

		<br><br>

		<button type="submit">Se connecter</button>

	</form>

	<?php var_dump($_SESSION); ?>



<?php require 'inc/footer.php'; ?>
