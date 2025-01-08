<?php

namespace app\models;

class LoginUser extends User 
{

  public function validate($data) 
  {
    if(trim($data[$this->email]) === '') 
    {
      $this->errors[$this->email] = 'Email required';
    } 
    else if (!email($data[$this->email])) 
    {
      $this->errors[$this->email] = 'Invalid email';
    } 

    $user = $this->findUser($data[$this->email]);
    
    if(!$user) 
    {
      $this->errors[$this->email] = "User doesn't exist";
    }

    if(trim($data[$this->password]) === '') 
    {
      $this->errors[$this->password] = 'Password required';
    }   
    else if($user && !password_verify($data[$this->password], $user['password'])) 
    {
      $this->errors[$this->password] = 'Wrong password';
    }

    if(empty($this->errors))
    {
      return true;
    }

    return false;
  }

  public function findUser($email)
  {
    $sql = "SELECT * FROM $this->table WHERE email = ?";
    $user = $this->db->query($sql, [$email])->find();
    
    return $user;
  }

}