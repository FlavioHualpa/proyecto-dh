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

   public function getAvatarUrl() : ?string {
//     $ext = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
//       move_uploaded_file($_FILES["avatar"]["tmp_name"], "img/". $_POST["email"]. "." .$ext);

      return $this->avatarUrl;
   }

   public function getPassword() : string {
      return $this->password;
   }

   public function setId($id) : int {
      $this->id = $id;
      return $this;
   }
   public function setFirstName($firstName) {
      $this->firstName = $firstName;
      return $this;
   }

   public function setLastName($lastName) {
      $this->lastName = $lastName;
      return $this;
   }

   public function setEmail($email)
   {
      $this->email = $email;
      return $this;
    }

   public function setCountryCode($countryCode) {
      $this->countryCode = $countryCode;
      return $this;
   }

   public function setBirthDate($birthDate) {
      $this->birthDate = $birthDate;
      return $this;
   }

   public function setCreationDate($createdAt) {
      $this->creationDate = $createdAt;
      return $this;
   }

   public function setSex($sex) {
      $this->sex = $sex;
      return $this;
   }

   public function setAvatarUrl($avatarUrl) {
      $this->avatarUrl = $avatarUrl;
      return $this;
   }

   public function setPassword($password) {
      $this->password = $password;
      return $this;
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

   public static function select(StorageInterface $storage, array $condicion) : ?User {
      if ($storage instanceof DbStorage) {
         $storage->setQuery('SELECT * FROM users WHERE ' . $condicion[0] . '= :id');
         $rows = $storage->select([ $condicion[0] => $condicion[1] ]);
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
            birth_date, sex, password, avatar_url, created_at)
            VALUES (:first_name, :last_name, :email,
            :country_code, :birth_date, :sex,
            :password, :avatar_url, :created_at)'
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
      var_dump($storage->getErrorInfo());
      return null;
   }
}
