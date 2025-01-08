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
    if(trim($data[$this->email]) === '') 
    {
      $this->errors[$this->email] = 'Email required';
    } 
    else if (!email($data[$this->email])) 
    {
      $this->errors[$this->email] = 'Invalid email';
    }

    if(trim($data[$this->name]) === '') 
    {
      $this->errors[$this->name] = 'Name required';
    }
    else if(!preg_match("/^[a-zA-Z ]+$/", $data[$this->name]))
    {
      $this->errors[$this->name] = 'Name and last name must have only letters';
    }

    if(trim($data[$this->password]) === '') 
    {
      $this->errors[$this->password] = 'Password required';
    }    
    else if(!passwordLength($data[$this->password])) 
    {
      $this->errors[$this->password] = 'Password must have between 6 and 20 characters';
    }

    if(!compareValues($data[$this->password], $data['confirm_password'])) 
    {
      $this->errors[$this->password] = 'Passwords are not matching';
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