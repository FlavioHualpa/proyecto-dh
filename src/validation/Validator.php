<?php

abstract class Validator
  {
    private $errors = [];

    public function getErrors()
    {
        return $this->errors;
    }

    public function addError($key, $message = '')
    {
        $this->errors[$key][] = $message;
    }

    public function isEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function exists($key, $array)
    {
        return array_key_exists($key, $array);
    }

    public function isValid()
    {
      return empty($this->errors);
    }

    public function isStringWithNumber($key, $array)
    {
      return strpbrk($key, "0123456789");
    }

    public function isYoungerThan($age, $key, $array)
    {
      return (time()-strtotime($key))/(60*60*24*365.25) < $age;
    }

    public function passwordLength($key, $array)
    {
      if(strlen(($array[$key]) < 6) || (strlen($array[$key]) > 12)){
        return true;
      }
    }
    public function passwordRepeat($key1, $key2, $array)
    {
      return ($key1 != $key2);
    }
  }

//public static function validarLogin($datos){
//    global $dbAll;

//    $errores = [];
//    if(strlen($datos["email"]) == 0){
//      $errores["email"] = "Por favor complete el campo email.";
//    } elseif (!filter_var($datos["email"], FILTER_VALIDATE_EMAIL)) {
//      $errores["email"] = "Por favor ingrese un email con formato válido.";
//    } if(!$dbAll->existeUsuario($datos["email"])){ //TODO agergar validación de usaurio existente.
//      $errores["email"] = "El email no se encuentra registrado.";
//    }

//    if(strlen($datos["pass"]) == 0){
//      $errores["pass"] = "El campo contraseña no puede estar vacío.";
//    } else {
//      $usuario = $dbAll->buscarUsuarioPorMail($datos["email"]);
//      if(!password_verify($datos["pass"], $usuario->getPass())){
//        $errores["pass"] = "La contraseña es incorrecta.";
//      }
//    }

//    return $errores;

//  }
?>
