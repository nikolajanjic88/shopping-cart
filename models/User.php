<?php

namespace app\models;

use app\core\Database;

abstract class User 
{
  protected $db;
  protected $table = 'users';
  public $errors = [];
  protected $email = 'email';
  protected $password = 'password';
  protected $name = 'name';

  public function __construct(Database $db)
  {
    $this->db = $db;  
  }

  abstract function validate($data);
}