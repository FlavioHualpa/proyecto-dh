<?php

require 'src/entities/User.php';
require 'src/validation/FormValidation.php';

if (!empty($_POST)) {
  $user = new User;
  $user->setEmail($_POST['email']);
  $user->setPassword($_POST['password']);

  try {
  $pdo = new PDO('mysql:dbname=queleo;host=localhost', 'root', '')
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql= 'INSERT INTO users (email, password, created_at)
  VALUES (:email, :password, :created_at)';

  $stmt = $pdo->prepare($sql);

  $stmt->bindValue('email', $user->getEmail());
  $stmt->bindValue('password', $user->getPassword());
  $stmt->created_at('created_at', $user->getRegistrationDate()->format('Y-m-s H:i:s'));

  $result = $stmt->execute();

} catch(Excepction $e) {
  echo $e = getMessage();
}

}

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
        <p class="texto-registration">¿No estás registrado? Ingresá tus datos en este <a href="registration.php" id="link_hipervinculo">link</a></p>
        <p class="error-usuario"><?= $errores['login'] ?? '' ?></p>
        <form class="login" action="login.php" method="post">
          <fieldset>
            <legend>Ingresá tus datos</legend>
            <p>
              <label for="email">Email</label>
              <input id="email" type="text" name="email" value="<?= $_POST['email'] ?? '' ?>" placeholder="user@email.com">
              <p class="error-login"><?= $errores['email'] ?? '' ?></p>
            </p>
            <p>
              <label for="pass">Contraseña</label>
              <input id="pass" type="password" name="pass" value="<?= $_POST['pass'] ?? '' ?>" placeholder="Ingresar Contraseña">
              <p class="error-login"><?= $errores['pass'] ?? '' ?></p>
            </p>
            <p>
              <input type="checkbox" name="recordar" value="si" id="recordar" <?= isset($_COOKIE['usuario']) ? 'checked' : '' ?>
              >
              <label for="recordar">Recordarme</label>
            </p>
            <div class="botones">
              <p>
                <input id="boton" type="submit" value="INGRESAR">
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

 ?>
