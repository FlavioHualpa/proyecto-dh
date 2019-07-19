<?php

require 'funciones.php';

$db = get_connection('test2');

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
        die($e->getMessage());
      }
   }

   importarDeJson();
}

header('location: migracion.php');
exit();
