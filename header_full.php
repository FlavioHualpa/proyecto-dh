<?php

  session_start();

  if (isset($_COOKIE['id'])) {
    $usuario = usuario_por_id($_COOKIE['id']);
    if ($usuario) {
      set_session_data($usuario);
    }
  }

  if (isset($_SESSION['id'])) {

    if (isset($_SESSION['genero'])) {
      if ($_SESSION['genero'] == 'f') {
        $saludo = 'Bienvenida,';
      } else {
        $saludo = 'Bienvenido,';
      }
    }

    if (isset($_SESSION['avatar']) && !empty($_SESSION['avatar'])) {
      $avatar_url = 'uploads/' . $_SESSION['avatar'];
    } else {
      if ($_SESSION['genero'] == 'f') {
        $avatar_url = 'uploads/generic_female_avatar.png';
      } else {
        $avatar_url = 'uploads/generic_male_avatar.png';
      }
    }

    /*
    $avatar_style = "width: 40px; height: 40px; background-image: url('" . $avatar_url . "'); background-size: 38px; background-repeat: no-repeat; background-position: center; border: 1px solid #b09090; border-radius: 50%; margin-right: 6px; margin-top: 2px;";
    */
  }

  require_once 'src/entities/Genre.php';

  $genres = Genre::selectAll($storage);
?>

<header id="navegador">
   <div id="home-generos">
      <div id="boton-home">
         <a href=".">
            <i class="fas fa-home"></i>
         </a>
      </div>
      <div id="boton-generos">
         <span>
            <i class="fas fa-list"></i>
            géneros
         </span>
         <i class="fas fa-arrow-down"></i>
      </div>
   </div>
   <div id="buscador">
      <form action="resultados.php" method="get">
         <input type="text" name="keywords" placeholder="busque por título, autor o editorial">
         <button type="submit"><i class="fas fa-search"></i></button>
      </form>
   </div>
   <?php if (isset($_SESSION['id'])) : ?>
      <div>
         <div id="user-options">
            <div class="avatar" style="background-image: url('<?= $avatar_url ?>')">
            </div>
            <span>
               <?= $_SESSION['nombre'] ?? 'usuario' ?>
            </span>
         </div>
         <div id="cart">
            <i class="fas fa-shopping-cart"></i>
            <!--
                 en próximas versiones aquí vamos a consultar
                 el carrito del usuario en la base de datos
                 y traer la cantidad de productos guardados
                 en el carrito de compras
            -->
            <span>0</span>
         </div>
      </div>
   <?php else : ?>
      <div id="user">
         <a href="login.php" class="user-login">
            <i class="fas fa-sign-in-alt"></i>
            ingresar
         </a>
         <a href="registration.php" class="user-register">
            <i class="fas fa-user-plus"></i>
            crear cuenta
         </a>
      </div>
   <?php endif ?>

   <!--
      El listado de géneros se va a traer
      de la base de datos luego
   -->
   <ul id="menu-generos">
      <!--
      <?php foreach($genres as $genre) : ?>
         <li>
            <a href="porgenero.php?genderid=<?= $genre->getId() ?>">
               <i class="fas fa-list"></i>
               <?= $genre->getName() ?>
            </a>
         </li>
      <?php endforeach ?>
      -->
      <li>
         <a href="porgenero.php?genderid=1">
            <i class="fas fa-list"></i>
            arte y diseño
         </a>
      </li>
      <li>
         <a href="porgenero.php?genderid=2">
            <i class="fas fa-list"></i>
            autoayuda
         </a>
      </li>
      <li>
         <a href="porgenero.php?genderid=3">
            <i class="fas fa-list"></i>
            ciencias
         </a>
      </li>
      <li>
         <a href="porgenero.php?genderid=4">
            <i class="fas fa-list"></i>
            computación
         </a>
      </li>
      <li>
         <a href="porgenero.php?genderid=5">
            <i class="fas fa-list"></i>
            ficción y literatura
         </a>
      </li>
      <li>
         <a href="porgenero.php?genderid=6">
            <i class="fas fa-list"></i>
            gastronomía
         </a>
      </li>
      <li>
         <a href="porgenero.php?genderid=7">
            <i class="fas fa-list"></i>
            infantil y juvenil
         </a>
      </li>
      <li>
         <a href="porgenero.php?genderid=8">
            <i class="fas fa-list"></i>
            turismo
         </a>
      </li>
   </ul>

   <ul id="menu-usuario">
      <li>
         <a href="editarPerfil.php?userid=1">
            <i class="fas fa-edit"></i>
            edite su perfil
         </a>
      </li>
      <li>
         <a href="misLibros.php?userid=1">
            <i class="fas fa-bookmark"></i>
            mis libros
         </a>
      </li>
      <li>
         <a href="cerrar.php?userid=1">
            <i class="fas fa-sign-out-alt"></i>
            cerrar sesión
         </a>
      </li>
   </ul>
</header>
<header id="encabezado">
   <h1>¿Qué Leo?</h1>
</header>

<!--
<header id="encabezado">
  <h1>¿Qué Leo?</h1>
  <nav>
    <ul>
      <li>
        <div>
          <i class="fas fa-home"></i>
          <a href="index.php">Inicio</a>
        </div>
      </li>
      <li>
        <div>
          <?php if (isset($_SESSION['id'])) : ?>
            <div style="display: inline-block;">
              <div style="<?= $avatar_style ?>">
              </div>
            </div>
            <div style="display: inline-block; vertical-align: top;">
              <span><?= $saludo ?></span>
              <br>
              <span><?= $_SESSION['nombre'] ?></span>
            </div>
          <?php else : ?>
            <i class="fas fa-sign-in-alt"></i>
            <a href="login.php">Ingresar</a>
          <?php endif; ?>
        </div>
      </li>
      <li>
        <div>
          <?php if (isset($_SESSION['id'])) : ?>
            <i class="fas fa-sign-out-alt"></i>
            <a href="cerrar.php">Cerrar Sesión</a>
          <?php else : ?>
            <i class="fas fa-user-plus"></i>
            <a href="registration.php">Crear una cuenta</a>
          <?php endif; ?>
        </div>
      </li>
    </ul>
  </nav>
</header>
-->
