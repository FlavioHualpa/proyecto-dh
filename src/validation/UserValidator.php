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
    if (!$this->exists('email', $this->data)) {
      if($this->isValid())
      $this->addError('email', 'El campo email es requerido');
    } elseif (!$this->isEmail($this->data['email'])) {
        $this->addError('email', 'El campo email no es valido');
      }

    if (!$this->exists('nombre', $this->data)){
      $this->addError('nombre', 'El campo nombre es requerido');
    } elseif ($this->isStringWithNumber('nombre', $this->data['nombre'])) {
        $this->addError('nombre', 'El nombre no debe contener números');
      }

    if (!$this->exists('apellido', $this->data)) {
      $this->addError('apellido', 'El campo apellido es requerido');
    } elseif ($this->isStringWithNumber('apellido', $this->data['apellido'])) {
        $this->addError('apellido', 'El apellido no debe contener números');
      }

    if (!$this->exists('nacimiento', $this->data)) {
      $this->addError('nacimiento', 'La fecha de nacimiento es requerida');
    } elseif ($this->isYoungerThan(18, 'nacimiento', $this->data['nacimiento'])) {
        $this->addError('nacimiento', 'El usuario debe tener al menos 18 años de edad.');
      }

    if (!$this->exists('sexo', $this->data)) {
      $this->addError('sexo', 'Se debe seleccionar una opción.');
    }

    if (!$this->exists('pass', $this->data)) {
      $this->addError('pass', 'La contraseña es requerida.');
    } elseif ($this->passwordLength('pass', $this->data)) {
        $this->addError('pass', 'La contraseña debe contener entre 6 y 12 caracteres.');
      }

    if (!$this->exists('pass2', $this->data)) {
      $this->addError('pass2', 'Debe reingresar la contraseña.');
    } elseif ($this->passwordRepeat('pass2', 'pass', $this->data)) {
        $this->addError('pass2', 'Las contraseñas no coinciden.');
      }

    if (!$this->exists('terms', $this->data)) {
      $this->addError('terms', 'Debe aceptar los términos y condiciones.');
    }

    return $this;
  }
}

?>
