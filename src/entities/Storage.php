<?php

require 'StorageInterface.php';
require 'Factory.php';
require 'User.php';

try {
  $storage = Factory::getDataSource('db');

  $user->createInstance($_POST);
  $user->insert($storage);

} catch (Exception $e) {
  die($e->getMessage());

}
 ?>
