<?php

require 'funciones.php';

$db = get_connection('test2');

if ($db) {
   $query = 'CREATE DATABASE test1 CHARACTER SET = utf8';
   $stmt = $db->prepare($query);
   $stmt->execute();
}

header('location: migracion.php');
exit();
