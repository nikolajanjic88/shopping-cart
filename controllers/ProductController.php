<?php

namespace app\controllers;

use app\core\Guard;
use app\core\Controller;
use app\core\ProductTrait;

class ProductController extends Controller
{
  use ProductTrait, Guard;

  public function index()
  {   
    $products = $this->productModel->selectAllProducts();
    $categories = $this->productModel->getCategories();

    return $this->view('products', [
        'products' => $products,
        'categories' => $categories
    ]);
  }

  public function show()
  {
    $product = $this->productModel->showProduct($_GET['id']);
    $comments = $this->commentModel->select($_GET['id']);
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
        'comments' => $comments
    ]);
  }

  public function admin()
  {
    if(!$this->isAdmin()) return redirect('products');

    $products = $this->productModel->manageProducts();
    return $this->view('manage', [
        'products' => $products
      ]);
  }

  public function create()
  {
    if(!$this->isAdmin()) return redirect('products');

    return $this->view('create', [
      'categories' => $this->productModel->getCategories()
    ]);
  }

  public function store()
  {
    $request = $this->request->getBody();
    $title = $request['title'];
    $desc = $request['desc'];
    $price = $request['price'];
    $category = $request['category'];
    if($this->productModel->validate($_POST))
    {
      $this->productModel->insert($title, $desc, $price, $category);
      $lastID = $this->db->lastID();
      $_SESSION['product_created'] = 'Product created successfully!';
      return redirect('upload?id=' . $lastID);
    }
    return $this->view('create', [
                  'errors' => $this->productModel->errors,
                  'categories' => $this->productModel->getCategories()
                ]);
  }

  public function edit()
  {
    if(!$this->isAdmin()) return redirect('products');
    
    $product = $this->productModel->find($_GET['id']);
    return $this->view('edit', [
      'product' => $product,
      'categories' => $this->productModel->getCategories()
    ]);
  }

  public function update()
  {
    $product = $this->productModel->find($_GET['id']);
    $request = $this->request->getBody();
    $title = $request['title'];
    $desc = $request['desc'];
    $price = $request['price'];
    $category = $request['category'];
  
    if($this->productModel->validate($_POST))
    {
      $this->productModel->update($title, $desc, $price, $category, $_GET['id']);
      $_SESSION['product_updated'] = 'Product updated successfully!';
      return redirect('manage');
    }

    return $this->view('edit', [
        'product' => $product,
        'errors' => $this->productModel->errors,
        'categories' => $this->productModel->getCategories()
    ]);
  
  }

  public function destroy()
  {
    $request = $this->request->getBody();
    $this->productModel->delete($request['id']);
    $_SESSION['product_deleted'] = 'Product deleted successfully!';
    return redirect('manage');
  }

}