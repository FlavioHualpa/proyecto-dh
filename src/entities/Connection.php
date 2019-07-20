<?php

abstract class Connection
{
   public static function connect(string $host, string $dbName, string $user, string $password) : PDO
   {
      $cstring = 'mysql:host=' . $host . ';dbname=' . $dbName;
      try {
         $pdo = new PDO($cstring, $user, $password);
         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }
      catch (Exception $e)
      {
         die($e->getMessage());
      }

      return $pdo;
   }
}
