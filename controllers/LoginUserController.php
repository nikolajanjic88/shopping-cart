<?php

namespace app\controllers;

use app\core\Guard;
use app\core\Request;
use app\core\Database;
use app\core\Controller;
use app\models\LoginUser;

class LoginUserController extends Controller
{
  use Guard;
  
  private $db;
  private $user;
  private $request;

  public function __construct()
  {
    $this->db = new Database();
    $this->user = new LoginUser($this->db);
    $this->request = new Request();
  }

  public function create()
  {
    if(!$this->isGuest()) return redirect('products');
    return $this->view('login');
  }

  public function login()
  { 
    $request = $this->request->getBody();
    if(!$this->user->validate($request))
    {
      return $this->view('login', [
        'errors' => $this->user->errors
      ]);
    }
    $user = $this->user->findUser($_POST['email']);
    $_SESSION['user'] = [
      'id' => $user['id'],
      'name' => $user['name'],
      'is_admin' => $user['is_admin']
    ];
    $_SESSION['login'] = 'Welcome ' . $_SESSION['user']['name'] . '!';
    
    return redirect('products'); 
  }

  public function destroy()
  {
    session_unset();
    return redirect('login');
  }

}