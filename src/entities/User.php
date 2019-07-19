<?php

class User
{
   private $id;
   private $firstName;
   private $lastName;
   private $email;
   private $countryCode;
   private $birthDate;
   private $sex;
   private $avatarUrl;
   private $password;
   private $creationDate;

   public function __construct() {

   }

   public function getId() : int {
      return $this->id;
   }

   public function getFirstName() : string {
      return $this->firstName;
   }

   public function getLastName() : string {
      return $this->lastName;
   }

   public function getEmail() : string {
      return $this->email;
   }

   public function getCountryCode() : string {
      return $this->countryCode;
   }

   public function getBirthDate() : string {
      return $this->birthDate;
   }

   public function getCreationDate() : string {
      return $this->creationDate;
   }

   public function getSex() : string {
      return $this->sex;
   }

   public function getAvatarUrl() : string {
//     $ext = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
//       move_uploaded_file($_FILES["avatar"]["tmp_name"], "img/". $_POST["email"]. "." .$ext);

      return $this->avatarUrl;
   }

   public function getPassword() : string {
      return $this->password;
   }

   public function setId($id) : int {
      $this->id = $id;
   }
   public function setFirstName($firstName) : string {
      $this->firstName = $firstName;
   }

   public function setLastName($lastName) : string {
      $this->lastName = $lastName;
   }

   public function setEmail($email) : string {
      $this->email = $email;
   }

   public function setCountryCode($countryCode) : string {
      $this->countryCode = $countryCode;
   }

   public function setBirthDate($birthDate) : string {
      $this->birthDate = $birthDate;
   }

   public function setCreationDate($createdAt) : string {
      $this->creationDate = $createdAt;
   }

   public function setSex($sex) : string {
      $this->sex = $sex;
   }

   public function setAvatarUrl($avatarUrl) : string {
      $this->avatarUrl = $avatarUrl;
   }

   public function setPassword($password) : string {
      $this->password = $password;
   }

   public static function createInstance(array $row) : User {
      $user = new User(
         $row['id'],
         $row['first_name'],
         $row['last_name'],
         $row['email'],
         $row['country_code'],
         $row['birth_date'],
         $row['sex'],
         $row['avatar_url'],
         $row['password']
      );
      $user->creationDate = $row['created_at'];
      return $user;
   }

   private static function createArray(array $rows) : array {
      $users = [];
      foreach ($rows as $row) {
         $users[] = self::createInstance($row);
      }
      return $users;
   }

   public static function selectAll(StorageInterface $storage) : array {
      if ($storage instanceof DbStorage) {
         $storage->setQuery('SELECT * FROM users');
         $rows = $storage->select();
      }
      elseif ($storage instanceOf JsonStorage) {
         $rows = $storage->select();
      }
      else {
         $rows = [];
      }

      $users = self::createArray($rows);
      return $users;
   }

   public static function select(StorageInterface $storage, int $id) : ?User {
      if ($storage instanceof DbStorage) {
         $storage->setQuery('SELECT * FROM users WHERE id = :id');
         $rows = $storage->select([ 'id' => $id ]);
      }
      elseif ($storage instanceOf JsonStorage) {
         $rows = $storage->select([ 'id' => $id ]);
      }
      else {
         $rows = [];
      }

      if ($rows) {
         $user = self::createInstance($rows[0]);
         return $user;
      }
      return null;
   }

   public static function insert(StorageInterface $storage, array $datos) : ?User {
      if ($storage instanceof DbStorage) {
         $storage->setQuery('INSERT INTO users
            (first_name, last_name, email, country_code,
            birth_date, sex, password, avatar_url)
            VALUES (:first_name, :last_name, :email,
            :country_code, :birth_date, :sex,
            :password, :avatar_url)'
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
         $user = self::createInstance($datos);
         return $user;
      }
      return null;
   }
}
