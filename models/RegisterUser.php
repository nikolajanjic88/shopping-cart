<?php

namespace app\models;

class RegisterUser extends User 
{
  
  public function hash($password)
  {
    return password_hash($password, PASSWORD_DEFAULT);
  }

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

    if(trim($data['name']) === '') 
    {
      $this->errors['name'] = 'Name required';
    }
    else if(!preg_match("/^[a-zA-Z ]+$/", $data['name']))
    {
      $this->errors['name'] = 'Name and last name must have only letters';
    }

    if(trim($data['password']) === '') 
    {
      $this->errors['password'] = 'Password required';
    }    
    else if(!passwordLength($data['password'])) 
    {
      $this->errors['password'] = 'Password must have between 6 and 20 characters';
    }

    if(!compareValues($data['password'], $data['confirm_password'])) 
    {
      $this->errors['confirm_password'] = 'Passwords are not matching';
    }

    $sql = "SELECT email FROM $this->table where email = ?";
    $user = $this->db->query($sql, [$data['email']])->find();
    
    if($user) 
    {
      $this->errors['email'] = 'User already exists';
    }

    if(empty($this->errors))
    {
      return true;
    }

    return false;

  }

  public function register($name, $email, $password)
  {  
    $sql = "INSERT INTO $this->table 
                   (name, email, password) 
                   VALUES (:name, :email, :password)";
                   
    $this->db->query($sql, [
      'name' => $name, 
      'email' => $email, 
      'password' => $password]);
  }
}