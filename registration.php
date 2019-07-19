<?php

require_once 'src/entities/User.php';
require_once 'src/entities/StorageInterface.php';
require_once 'src/entities/DbStorage.php';
require_once 'src/entities/JsonStorage.php';
require_once 'src/validation/UserValidator.php';
require_once 'src/entities/Auth.php';
require_once 'src/entities/Factory.php';

$storage = new DbStorage; //En caso de usar json cambiar por new JsonStorage
$storage->connect();
$auth = new Auth; //Con esto, se inicia la sesión session_start();


if($auth->usuarioLogueado()){ //Se chequea que el usuario esté logueado, que tenga una $_SESSION iniciada.
  header("Location:index.php");//Se está logueado te lleva a index.php.
  exit;
}

$errors = [];

try {
  if(!empty($_POST)){
      $validator = new UserValidator($_POST);
      $validator->validate();

      $errors = $validator->getErrors();

      $nombre = $_FILES['avatar']['name'];
      $ext = pathinfo($nombre, PATHINFO_EXTENSION);
      $origen = $_FILES['avatar']['tmp_name'];
      $destino = "img/" . $_POST['email'] . $ext;
      move_uploaded_file($origen, $destino);
      $ruta = pathinfo($destino);

      $user = new User;
      $storage = Factory::getDataSource('db');
      $user->setFirstName($_POST['nombre']);
      $user->setLastName($_POST['apellido']);
      $user->setEmail($_POST['email']);
      $user->setCountryCode($_POST['paisNacimiento']);
      $user->setBirthDate($_POST['nacimiento']);
      $user->setSex($_POST['sexo']);
      $user->setPassword($_POST['pass']);
      $user->setAvatarUrl($ruta);

      var_dump($user); die;

      if(empty($errors)){
        $user = new User;
        $storage = Factory::getDataSource('db');
        $user->createInstance($_POST);

        $user->insert($storage, [
          'first_name' => $_POST['nombre'],
          'last_name' => $_POST['apellido'],
          'email' => $_POST['email'],
          'country_code' => $_POST['paisNacimiento'],
          'birth_date' => $_POST['nacimiento'],
          'sex' => $_POST['sexo'],
          'password' => $_POST['pass'],
          'avatar_url' => $ruta,
        ]);
      }
    }
  }
    catch (\Exception $e) {
        die($e->getMessage());
      }




//        $ext = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
//        move_uploaded_file($_FILES["avatar"]["tmp_name"], "img/". $_POST["email"]. "." .$ext);

?>

<?php
//session_start();
include('funciones.php');


$paises = leer_json('datos/paises.json');
//$errors = [];
//  if ($_POST) {
//    if (!isset($_POST["nombre"]) || empty($_POST["nombre"])) {
//      $errors["nombre"][] = "El nombre es requerido";
//    } else
//    if (strpbrk($_POST["nombre"], "0123456789")) {
//      $errors["nombre"][] = "El nombre no debe contener números";
//    }
//    if (!isset($_POST["apellido"]) || empty($_POST["apellido"])) {
//      $errors["apellido"][] = "El apellido es requerido";
//    } else
//    if (strpbrk($_POST["apellido"], "0123456789")) {
//      $errors["apellido"][] = "El apellido no debe contener números";
//    }
//    if (!isset($_POST["usuario"]) || empty($_POST["usuario"])) {
//      $errors["usuario"][] = "El usuario es requerido";
//    } else
//    if (strlen($_POST["usuario"]) < 6 || strlen($_POST["usuario"]) > 12) {
//      $errors["usuario"][] = "El usuario debe contener entre 6 y 12 caracteres";
//    }
//    if (!isset($_POST["email"]) || empty($_POST["email"])) {
//      $errors["email"][] = "El email es requerido";
//    } else
//      if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == false) {
//      $errors["email"][] = "El email ingresado no es válido";
//      }
//    if (!isset($_POST["nacimiento"]) || empty($_POST["nacimiento"])) {
//      $errors["nacimiento"][] = "La fecha de nacimiento es requerida";
//    } else
//      if ((time()-strtotime($_POST["nacimiento"]))/(60*60*24*365.25)<18) {
//      $errors["nacimiento"][] = "El usuario debe tener al menos 18 años de edad.";
//      }
//    if (!isset($_POST["sexo"]) || empty($_POST["sexo"])) {
//        $errors["sexo"][] = "Debe seleccionar una opción.";
//    }
//    if (isset($_FILES['avatar']) && $_FILES['avatar']['name'] != '') {
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
  //  }

//    if (!isset($_POST["pass"]) || empty($_POST["pass"])) {
//        $errors["pass"][] = "La contraseña es requerida";
//      } else
//      if (strlen($_POST["pass"]) < 6 || strlen($_POST["pass"]) > 12) {
//        $errors["pass"][] = "La contraseña debe contener entre 6 y 12 caracteres";
//      }
//    if (!isset($_POST["pass2"]) || empty($_POST["pass2"])) {
//        $errors["pass2"][] = "Debe reingresar la contraseña";
//      } else
//      if ($_POST["pass2"] != $_POST["pass"]) {
//      $errors["pass2"][] = "Las contraseñas no coinciden";
//      }
//    if (!isset($_POST["terms"])) {
//        $errors["terms"][] = "Debe aceptar los términos y condiciones";
//      }
//    if(empty($errors)) {
//      if (existe_usuario($_POST['email'], $_POST['usuario'])) {
//        $errors["submit"][] = "El usuario/email ya existe.";
//      } else {
//        $nuevo_usuario = guardar_usuario();
//        set_session_data($nuevo_usuario);

//        header('location: index.php');
//        exit();
//      }
//
//    }
//  }

//?>


<!DOCTYPE html>
<html lang="es">
   <?php
      $styles = [
         'css/styles.css',
         'css/header.css',
         'css/registration.css',
         'css/footer.css',
      ];
      require 'head.php';
   ?>
  <body>
    <div id="contenedor">
      <?php
        include('header_back.php');
      ?>
      <div class="fondoLogYReg">
      <div id="panel-form">
        <form class="registration" action="registration.php" method="post" enctype="multipart/form-data">
          <p class="error-regist"><?= $errors["submit"][0] ?? "" ?></p>
          <fieldset>
            <legend>Creá tu cuenta </legend>
              <p>
                <label for="nombre">Nombre:</label>
                <input id="nombre" type="text" name="nombre" value="<?= $_POST['nombre'] ?? '' ?>">
                <p class="error-regist"><?= $errors["nombre"][0] ?? "" ?></p>
              </p>
              <p>
                <label for="apellido">Apellido:</label>
                <input id="apellido" type="text" name="apellido" value="<?= $_POST['apellido'] ?? '' ?>">
                <p class="error-regist"><?= $errors["apellido"][0] ?? "" ?></p>
              </p>
<!--                <p>
                <label for="usuario">Usuario:</label>
                <input id="usuario" type="text" name="usuario" value="<?= $_POST['usuario'] ?? '' ?>">
                <p class="error-regist"><?= $errors["usuario"][0] ?? "" ?></p>
              </p> , se saca el usuario del formulario-->
              <p>
                <label for="email">Email:</label>
                <input id="email" type="text" name="email" value="<?= $_POST['email'] ?? '' ?>">
                <p class="error-regist"><?= $errors["email"][0] ?? "" ?></p>
              </p>
              <p>
                <label for="paisNacimiento">País de Nacimiento:</label>
                <select name="paisNacimiento" id="paisNacimiento">
                  <?php foreach ($paises as $codigo => $pais):?>
                    <option value="<?= $codigo ?>" <?= isset($_POST['paisNacimiento']) && $_POST['paisNacimiento'] == $codigo ? 'selected' : '' ?>><?= $pais ?></option>
                  <?php endforeach ?>
                </select>
              </p>
              <p>
                <label for="nacimiento">Fecha de Nacimiento:</label>
                <input id="nacimiento" type="date" name="nacimiento" value="<?= $_POST['nacimiento'] ?? '' ?>">
                <p class="error-regist"><?= $errors["nacimiento"][0] ?? '' ?></p>
              </p>
              <p>
                <label>Sexo:</label>
                <div class="sexo">
                  <div class="sexo_fem">
                    <input id="mujer" type="radio" name="sexo" value="f" <?= isset($_POST['sexo']) && $_POST['sexo'] == 'f' ? 'checked' : '' ?>>
                    <label for="mujer">Femenino</label>
                  </div>
                  <div class="sexo_masc">
                    <input id="hombre" type="radio" name="sexo" value="m" <?= isset($_POST['sexo']) && $_POST['sexo'] == 'm' ? 'checked' : '' ?>>
                    <label for="hombre">Masculino</label>
                  </div>
                </div>
                <p class="error-regist"><?= $errors["sexo"][0] ?? "" ?></p>
              </p>
              <p>
                <!-- <div class="avatar_button"> -->
                  <label for="avatar">Subir una foto</label>
                  <br>
                  <!-- <div class="avatar_button_2"> -->
                    <input id="avatar" type="file" name="avatar">
                  <!-- </div> -->
                  <p class="error-regist"><?= $errors["avatar"][0] ?? "" ?></p>
                <!-- </div> -->
              </p>
              <p>
                <label for="pass">Ingresar Contraseña:</label>
                <input id="pass" type="password" name="pass" value="">
              </p>
              <p class="error-regist"><?= $errors["pass"][0] ?? "" ?></p>
              <p>
                <label for="pass2">Reingresar Contraseña:</label>
                <input id="pass2" type="password" name="pass2" value="">
                <p class="error-regist"><?= $errors["pass2"][0] ?? "" ?></p>
              </p>
              <p>
                <div class="terminos">
                  <input id="terms" type="checkbox" name="terms">
                  <label for="terms">Acepta <a href="#" id="link_hipervinculo">términos y condiciones</a></label>
                </div>
                <p class="error-regist"><?= $errors["terms"][0] ?? "" ?></p>
              </p>
              <div class="botones">
              <p>
                <input id="boton" type="submit" value="CREAR CUENTA">
              </p>
              <p>
                <input id="boton" type="reset" value="REINICIAR FORMULARIO">
              </p>
            </div>
          </fieldset>
        </form>
      </div>
      </div>

      <?php
        include('footer.php');
      ?>
    </div>
  </body>
</html>
