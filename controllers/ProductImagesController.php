<?php

namespace app\controllers;

use app\core\Guard;
use app\core\Request;
use app\core\Database;
use app\core\Controller;
use app\models\ProductImages;

class ProductImagesController extends Controller
{
  use Guard;

  private Database $db;
  private ProductImages $productImages;
  private Request $request;

  public function __construct()
  {
    $this->db = new Database();
    $this->productImages = new ProductImages($this->db);
    $this->request = new Request($this->db);
  }
  
  public function index()
  {
    if(!$this->isAdmin()) return redirect('products');
    
    return $this->view('images', [
      'images' => $this->productImages->select($_GET['id'])
    ]);
  }

  public function store()
  {
    $image = $_FILES['image'];
    $path = BASE_PATH . "/public/images/products/{$_GET['id']}/" . $image['name'];
    $tmp = $image['tmp_name'];

    if($this->productImages->validate($image))
    {
      $this->productImages->insert($tmp, $image['name'], $path, $_GET['id']);
      return header("Refresh:0");
    }
    
    return $this->view('images', [
      'errors' => $this->productImages->errors,
      'images' => $this->productImages->select($_GET['id'])
    ]);
  }

  public function destroy()
  {   
    $request = $this->request->getBody();
    $productImage = $this->productImages->find($request['id']);
    $this->productImages->delete($request['id']);
    unlink($productImage['path']);
    return redirect('upload?id=' . $request['product_id']);
  }
}