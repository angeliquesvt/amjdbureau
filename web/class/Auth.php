<?php
// CLASS POUR AUTHENTIFICATION
class Auth{

  private $options = [
    "restriction_msg" => "Vous n'avez pas le droit d'accéder à cette page"
  ];
  private $session;

  // recupere session, message d'erreur
  public function __construct($session, $options =[]){
    $this->options = array_merge($this->options, $options);
    $this->session = $session;
  }

  // Crypter un mot de passe
  public function hashPassword($password){
    return password_hash($password, PASSWORD_BCRYPT);
  }

  // Confirmer le token d'inscription
  public function confirm($db, $user_id, $token){

    $user = $db->query('SELECT * FROM users WHERE id=?', [$user_id])->fetch(); //recup l'id de l'utilisateur
    // Si les tokens corresponde (celui envoyer par mail)
    if($user && $user->confirmation_token == $token){
      // confirmer en db
      $db->query('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id= ?',[$user_id]);
      $this->session->write('auth', $user);
      return true;
    }
    return false;
  }

  // Empeche de se co à une page sans être auth
  public function restrict(){
    if(!$this->session->read('auth')){
      $this->session->setFlash("danger", $this->options["restriction_msg"]);
      header('Location: index.php');
      exit();
    }
  }

  // Verifie si il y a un user
  public function user(){
    if(!$this->session->read('auth')){
      return false;
    }
    return $this->session->read('auth');
  }

  // Genere session de l'ult
  public function connect($user){
    $this->session->write('auth', $user);
  }

  // Génère un coockie
  public function connectfromcookie($db){
    if(isset($_COOKIE['remember']) && !$this->user()){

      $remember_token=$_COOKIE['remember'];
      $parts = explode ('==', $remember_token);
      $user_id = $parts[0];
      $user = $db->query('SELECT * FROM users WHERE id= ?', [$user_id])->fetch();
      if($user){
        $expected = $user_id . '==' . $user->remember_token . sha1($user_id . 'ratonlaveurs');
        if($expected == $remember_token){
          $this->connect($user);
          setcookie('remember', $remember_token, time() + 60*60*24*7);

        } else{
          setcookie('remember', null, -1);
        }
      } else{
        setcookie('remember', null, -1);
      }
    }
  }

// Connexion account
  public function login($db, $usermail, $password, $remember = false){

    $user= $db->query('SELECT * FROM users WHERE (email =:usermail)', ['usermail' => $usermail])->fetch();

    if(password_verify($password, $user->password)){
      $this->connect($user);
      // Genere cookie si remember
      if($remember){
        $this->remember($db, $user->id);
      }
      return $user;
    }else{
      return false;
    }
  }

  // Fonction pour genere cookie quand remember
  public function remember($db, $user_id){
    $remember_token = Str::random(250);
    $db->query('UPDATE users SET remember_token = ? WHERE id= ?', [$remember_token, $user_id]);
    setcookie('remember', $user_id . '==' . $remember_token . sha1($user_id . 'ratonlaveurs'), time()+60*60*24*7);

  }

// Deconnexion de l'ultilisateur
  public function logout(){
    setcookie('remember', NULL, -1);
    $this->session->delete("auth"); //Suprimme cookeie et session
  }

  // Reset password
  public function resetPassword($db, $email){

    $user = $db->query('SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL', [$email])->fetch();

    if($user){
      $reset_token = Str::random(60); //Genere token envoyer par mail
      $db->query('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?', [$reset_token, $user->id]);
      mail($_POST['email'], 'Reinitialisation de votre mot de passe', "Afin de réinitialiser votre mot de passe, merci de cliquer sur ce lien\n\nhttp://localhost/fleet/reset.php?id={$user->id}&token=$reset_token");
      return $user;
    }
    return false;
  }

  // Verifie le token de recuperation du mdp
  public function checkResetToken($db, $user_id, $token){
    return $db->query('SELECT * FROM users WHERE id=? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)', [$user_id, $token])->fetch();

  }
}




?>
