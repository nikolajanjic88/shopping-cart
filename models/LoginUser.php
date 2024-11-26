<?php

namespace app\models;

class LoginUser extends User 
{

  public function validate($data) 
  {
    if(trim($data['email']) === '') 
    {
      $this->errors['email'] = 'Email required';
    } 
    else if (!email($data['email'])) 
    {
      $this->errors['email'] = 'Invalid email';
    } 

    $user = $this->findUser($data['email']);
    
    if(!$user) 
    {
      $this->errors['email'] = "User doesn't exist";
    }

    if(trim($data['password']) === '') 
    {
      $this->errors['password'] = 'Password required';
    }   
    else if($user && !password_verify($data['password'], $user['password'])) 
    {
      $this->errors['password'] = 'Wrong password';
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