<?php

  class Session{

    static $instance;

    // load la class auto
    static function getInstance(){
      if(!self::$instance){
        self::$instance = new Session();
      }
      return self::$instance;
    }

    // CONSTRUCTEUR demarre session
    public function __construct(){
      if (session_status() == PHP_SESSION_NONE) {
         session_start();
      }
    }

    // MODIFIEUR FLASH
    public function setFlash($key,$message){
      $_SESSION['flash'][$key] = $message;

    }

    // Retourne s'il existe des messages flash
    public function hasFlashes(){
      return isset($_SESSION['flash']);
    }

    // Recupere les messages flash en session
    public function getFlashes(){
      $flash = $_SESSION['flash'];
      unset($_SESSION['flash']);
      return $flash;
    }

    // Creation de la session
    public function write($key,  $value){
      $_SESSION[$key]= $value;
    }

    // Lecture de la session
    public function read($key){
      return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    // Suppression de la session
    public function delete($key){
      unset($_SESSION[$key]);
    }
  }





?>
