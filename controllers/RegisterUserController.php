<?php

namespace app\controllers;

use app\core\Database;
use app\core\Controller;
use app\core\Guard;
use app\core\Request;
use app\models\RegisterUser;

class RegisterUserController extends Controller
{
  use Guard; 
  
  private Database $db;
  private RegisterUser $user;
  private Request $request;

  public function __construct()
  {
    $this->db = new Database();
    $this->user = new RegisterUser($this->db);
    $this->request = new Request();
  }

  public function create()
  {
    if(!$this->isGuest()) return redirect('products');
    return $this->view('register');
  }

  public function store()
  {   
    $request = $this->request->getBody();
    $name = $request['name'];
    $email = $request['email'];
    $password = $this->user->hash($request['password']);
   
    if($this->user->validate($_POST))
    {
      $this->user->register($name, $email, $password);

      $_SESSION['register'] = 'You have registered successfully!';
      return redirect('login');
    }
    return $this->view('register', [
                  'errors' => $this->user->errors
                ]);
  }
}