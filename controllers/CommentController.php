<?php

namespace app\controllers;

use app\core\Guard;
use app\core\Controller;
use app\core\ProductTrait;

class CommentController extends Controller
{
  use ProductTrait, Guard;

  public function index()
  {
    $product = $this->productModel->showProduct($_GET['id']);
    $comments = $this->commentModel->select($_GET['id']);

    return $this->view('product', [
        'product' => $product,
        'comments' => $comments
    ]);
  }

  public function create()
  {
    if($this->isGuest()) return redirect('login');
    return $this->view('add-comment');
  }

  public function store()
  {
    $request = $this->request->getBody();

    if($this->commentModel->validate($_POST))
    {
      $this->commentModel->insert($request['body'], $request['product_id'], $_SESSION['user']['id']);
      return redirect('product?id=' . $request['product_id']);
    }

    return $this->view('add-comment', [
                  'errors' => $this->commentModel->errors
    ]);   
  }

  public function destroy()
  { 
    $request = $this->request->getBody();
    $this->commentModel->delete($request['id']);
    
    return redirect('product?id=' . $request['product_id']);
  }
}