<?php

namespace app\models;

use app\core\Database;

abstract class User 
{
  protected Database $db;
  protected string $table = 'users';
  public array $errors = [];
  protected string $email = 'email';
  protected string $password = 'password';
  protected string $name = 'name';

  public function __construct(Database $db)
  {
    $this->db = $db;  
  }

  abstract function validate($data);
}