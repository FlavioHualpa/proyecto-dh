<?php

require 'funciones.php';

$db = get_connection('test1');

if ($db) {
   $tables = testTables(
      $db,
      [
         'users', 'genres', 'authors', 'publishers', 'languages',
         'paises', 'books', 'purchases', 'books_purchases'
      ]
   );

   $allTablesOk = allTablesOk($tables);
}
else {
   $tables = null;
   $allTablesOk = false;
}

?>

<!DOCTYPE html>
<html lang="es">
<?php
   $styles = [
      '../css/styles.css',
      '../css/migracion.css',
   ];
   require '../head.php';
?>

<body>
   <div id="contenedor">
      <header class="encabezado">
         <h1>¿Qué Leo?</h1>
         <p>Un espacio para descubrir</p>
      </header>
      <section class="principal">
         <h2>Migración de datos</h2>
         <?php if ($db) : ?>
            <?php if ($allTablesOk) : ?>
               <div class="exito">
                  <img src="https://www.clipartmax.com/png/small/35-355975_certainly-clipart-thumbs-up-thumbs-down-printable.png" alt="Certainly Clipart - Thumbs Up Thumbs Down Printable @clipartmax.com">
                  <span>La migración a MySql se realizó exitosamente!</span>
                  <br>
                  <a href="..">Ir al inicio</a>
               </div>
            <?php else : ?>
               <div class="no-tables">
                  <img src="https://www.clipartmax.com/png/small/12-127151_attendance-data-for-central-database-web-server-and-database-server-on-same.png" alt="Attendance Data For Central Database - Web Server And Database Server On Same Machine @clipartmax.com">
                  <p>Se ha generado la base de datos del sistema</p>
                  <a href="generarTablas.php">Generar las tablas del sistema</a>
               </div>
            <?php endif ?>
         <?php else : ?>
            <div class="no-db">
               <img src="https://www.clipartmax.com/png/small/12-127151_attendance-data-for-central-database-web-server-and-database-server-on-same.png" alt="Attendance Data For Central Database - Web Server And Database Server On Same Machine @clipartmax.com">
               <p>La base de datos del sistema no existe en el servidor</p>
               <a href="generarBase.php">Generar la base de datos</a>
            </div>
         <?php endif ?>
      </section>
   </div>
</body>
</html>
