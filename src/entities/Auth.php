<?php

/**
 * Iniciar sesión, loguear y controlar que el usuario esté logueado.
 */
class Auth
{

  function __construct()
  {
    session_start();
  }

  public function loguearUsuario($email){
    $_SESSION["email"] = $email;
  }

  public function usuarioLogueado(){
     return isset($_SESSION["email"]);
  }


}
