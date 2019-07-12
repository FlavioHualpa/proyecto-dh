<?php

require 'funciones.php';

$db = get_connection();

if ($db) {
   $tablas = [
      'users', 'genres', 'authors', 'publishers', 'languages',
      'paises', 'books', 'purchases', 'books_purchases'
   ];

   foreach ($tablas as $tabla) {
      try {
         $query = file_get_contents('scripts/' . $tabla . '.sql');
         $stmt = $db->prepare($query);
         $stmt->execute();
      } catch (\Exception $e) {

      }
   }

   importarDeJson();
}

header('location: migracion.php');
exit();
