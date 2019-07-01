<?php
class App{

  static $db = null;

  // Load la bd
  static function getDatabase(){
    if(!self::$db){
      self::$db = new Database('root','','amjd_adherents');
    }
    return self::$db;
  }

    // RECUP SESSION
  static function getAuth(){
    return new Auth(Session::getInstance(), ["restriction_msg" => "Vous devez être connecter pour accéder à cette page"]);
  }


  // REDIRIGER VERS PAGE
  static function redirect($page){
    header("Location:$page");
    exit();
  }

}


?>
