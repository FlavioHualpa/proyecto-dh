<?php

class Pais
{
   private $id;
   private $nombre;
   private $codigo;

   public function __construct(int $id, string $nombre, string $codigo) {
      $this->id = $id;
      $this->nombre = $nombre;
      $this->codigo = $codigo;
   }

   public function getId() : int {
      return $this->id;
   }

   public function getNombre() : string {
      return $this->nombre;
   }

   public function getCodigo() : string {
      return $this->codigo;
   }

   private static function createInstance(array $row) : Pais {
      $pais = new Pais(
         $row['id'],
         $row['nombre'],
         $row['codigo']
      );
      return $pais;
   }

   private static function createArray(array $rows) : array {
      $paises = [];
      foreach ($rows as $row) {
         $paises[] = self::createInstance($row);
      }
      return $paises;
   }

   public static function selectAll(StorageInterface $storage) : array {
      if ($storage instanceof DbStorage) {
         $storage->setQuery('SELECT * FROM paises');
         $rows = $storage->select();
      }
      elseif ($storage instanceOf JsonStorage) {
         $rows = $storage->select();
      }
      else {
         $rows = [];
      }

      $paises = self::createArray($rows);
      return $paises;
   }

   public static function select(StorageInterface $storage, int $id) : ?Pais {
      if ($storage instanceof DbStorage) {
         $storage->setQuery('SELECT * FROM paises WHERE id = :id');
         $rows = $storage->select([ 'id' => $id ]);
      }
      elseif ($storage instanceOf JsonStorage) {
         $rows = $storage->select([ 'id' => $id ]);
      }
      else {
         $rows = [];
      }

      if ($rows) {
         $pais = self::createInstance($rows[0]);
         return $pais;
      }
      return null;
   }

   public static function insert(StorageInterface $storage, array $datos) : ?Pais {
      if ($storage instanceof DbStorage) {
         $storage->setQuery('INSERT INTO paises
            (nombre, codigo)
            VALUES (:nombre, :codigo)'
         );
         $exito = $storage->insert($datos);
      }
      elseif ($storage instanceOf JsonStorage) {
         $exito = $storage->insert($datos);
      }
      else {
         $exito = false;
      }

      if ($exito) {
         $datos['id'] = $storage->getLastInsertId();
         $pais = self::createInstance($datos);
         return $pais;
      }
      return null;
   }
}
