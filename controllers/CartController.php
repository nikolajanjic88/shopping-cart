<?php

namespace app\controllers;

use app\core\Guard;
use app\models\Cart;
use app\core\Request;
use app\core\Database;
use app\core\Controller;

class CartController extends Controller
{
  use Guard;
  
  private $db;
  private $cartModel;
  private $request;

  public function __construct()
  {
    $this->db = new Database();
    $this->cartModel = new Cart($this->db);
    $this->request = new Request();
  }

  public function index()
  {
    if($this->isGuest()) return redirect('login');
    $cart = $this->cartModel->select();
    return $this->view('cart', [
      'carts' => $cart
      ]);
  }

  public function store()
  {
    $request = $this->request->getBody();
    $this->cartModel->insert($request['qty'], $request['id'], $_SESSION['user']['id']);
    $_SESSION['add_to_cart'] = 'Product added to cart!';
    return redirect('cart');
  }

  public function destroy()
  {  
    $this->cartModel->delete($_POST['id']);
    $_SESSION['delete_from_cart'] = 'Product deleted from cart!';
    return redirect('cart');
  }
}