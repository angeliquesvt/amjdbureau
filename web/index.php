<?php
require_once 'inc/bootstrap.php';

  if(isset($_SESSION['auth'])){
    header('Location: main.php');
    exit();
  }
 
  // CONNEXION
  $auth = App::getAuth();
  $db = App::getDatabase();
  $auth->connectfromcookie($db);
  if($auth->user()){
    App::redirect("main.php");
  }
  if(!empty($_POST) && !empty($_POST['userlogin']) && !empty($_POST['connexion_password'])){
  $auth = App::getAuth();
    $user = $auth->login($db, $_POST['userlogin'], $_POST['connexion_password'], isset($_POST['remember']));
    $session = Session::getInstance();
    if($user){
      App::redirect('main.php');
      }
      else{
        $session->setFlash("danger", "Identifiant ou mot de passe incorrect");
      }
  }
	$image = new Image();
 ?>


<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Adhérents AMJD</title>
  <link rel="stylesheet" href="css/global.css">
</head>
<body>
  <div class="Form_container">
    <form method="POST">
      <fieldset>
      <legend>AMJD</legend>
        <div class="modal-body">
            <table>
              <tr>
                <td><input type="text" name="userlogin" placeholder="Login"/></td>
              </tr>
              <tr>
                  <!-- <a href="remember.php"><br/>(Mot de passe oublié)</a> -->
                <td><input type="password" name="connexion_password" placeholder="Password"/></td>
              </tr>
            </table>
        </div>
      <div class="Form_footer">
        <button type="submit" class="Form_button">Se connecter</button>
      </div>
      </fieldset>
    </form>
    	<?php if(!empty($errors)): ?>
 				<div class="alert alert-danger">
 					<p>Vous n'avez pas rempli le formulaire correctement</p>
 					<ul>
 							<?php foreach($errors as $error): ?>
 								<li><?=$error; ?></li>
 							<?php endforeach; ?>
 						</ul>
 				</div>
 			<?php endif; ?>
  </div>
</body>
</html>