<?php

require 'Validator.php';

class UserValidator extends Validator
{
  // User information
  private $data;

  public function __construct($data)
  {
    $this->data = $data;
  }

  public function validate()
  {
    if (!$this->exists('email', $this->data) || $this->isEmpty('email', $this->data)){
      $this->addError('email', 'El campo email es requerido');
    } elseif (!$this->isEmail($this->data['email'])) {
        $this->addError('email', 'El campo email no es valido');
      }

    if (!$this->exists('first_name', $this->data) || $this->isEmpty('first_name', $this->data)){
      $this->addError('first_name', 'El campo nombre es requerido');
    } elseif ($this->isStringWithNumber('first_name', $this->data)) {
        $this->addError('first_name', 'El nombre no debe contener números');
      }

    if (!$this->exists('last_name', $this->data) || $this->isEmpty('last_name', $this->data)) {
      $this->addError('last_name', 'El campo apellido es requerido');
    } elseif ($this->isStringWithNumber('last_name', $this->data)) {
        $this->addError('last_name', 'El apellido no debe contener números');
      }

    if (!$this->exists('birth_date', $this->data) || $this->isEmpty('birth_date', $this->data)) {
      $this->addError('birth_date', 'La fecha de nacimiento es requerida');
    } elseif ($this->isYoungerThan(18, 'birth_date', $this->data)) {
        $this->addError('birth_date', 'El usuario debe tener al menos 18 años de edad.');
      }

    if (!$this->exists('sex', $this->data)) {
      $this->addError('sex', 'Se debe seleccionar una opción.');
    }

    if (!$this->exists('password', $this->data) || $this->isEmpty('password', $this->data)) {
      $this->addError('password', 'La contraseña es requerida.');
    } elseif ($this->passwordLength('password', $this->data)) {
        $this->addError('password', 'La contraseña debe contener entre 6 y 12 caracteres.');
      }

    if (!$this->exists('pass2', $this->data) || $this->isEmpty('pass2', $this->data)) {
      $this->addError('pass2', 'Debe reingresar la contraseña.');
    } elseif ($this->passwordRepeat('pass2', 'password', $this->data)) {
        $this->addError('pass2', 'Las contraseñas no coinciden.');
      }

    if (!$this->exists('terms', $this->data)) {
      $this->addError('terms', 'Debe aceptar los términos y condiciones.');
    }

    return $this;
  }
}

                //      $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        //      if ($_FILES["avatar"]["error"] != 0){
        //        $errors["avatar"][] = "El archivo no se subió correctamente.";
        //      } else
        //      if ($ext != "jpg" && $ext != "png" && $ext != "gif" && $ext != "bmp") {
        //        $errors["avatar"][] = "El archivo debe ser del tipo '.jpg', '.png', '.bmp' o '.gif'.";
        //      } else
        //      if ($_FILES['avatar']['size'] > 10*1024*1024) {
        //        $errors["avatar"][] = "El tamaño del archivo no debe ser mayor a 10MB.";
        //      }
?>
