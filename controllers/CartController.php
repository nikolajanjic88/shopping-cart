<?php

namespace app\controllers;

use app\core\Guard;
use app\models\Cart;
use app\core\Request;
use app\core\Database;
use app\models\Comment;
use app\models\Product;
use app\core\Controller;

class CartController extends Controller
{
  use Guard;
  
  private $db;
  private $cartModel;
  private $request;
  private $productModel;
  private $commentModel;

  public function __construct()
  {
    $this->db = new Database();
    $this->cartModel = new Cart($this->db);
    $this->request = new Request();
    $this->productModel = new Product($this->db);
    $this->commentModel = new Comment($this->db);
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
    $quantity = $this->cartModel->limit($_SESSION['user']['id'], $_GET['id']);

    if($this->cartModel->validate($request)) 
    {
      if((int) $request['qty'] + (int) $quantity <= 10)
      {
        $this->cartModel->insert($request['qty'], $request['id'], $_SESSION['user']['id']);
        $_SESSION['add_to_cart'] = 'Product added to cart!';
        return redirect('cart');
      }  
      else 
      {
        $this->cartModel->errors['qty'] = 'Can not have more than 10';
      } 
    }
 
    $product = $this->productModel->showProduct($request['id']);
    $comments = $this->commentModel->select($request['id']);
    $images = [];
    foreach($product as $value)
    {
        if(is_array($value))
        {
            $images[] = $value;
        }
    }
    
    return $this->view('product', [
        'product' => $product,
        'images' => $images,
        'comments' => $comments,
        'errors' => $this->cartModel->errors
        ]);
  }

  public function destroy()
  {  
    $this->cartModel->delete($_POST['id']);
    $_SESSION['delete_from_cart'] = 'Product deleted from cart!';
    return redirect('cart');
  }
}