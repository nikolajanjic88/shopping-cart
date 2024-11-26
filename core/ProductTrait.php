<?php

namespace app\core;

use app\models\Comment;
use app\models\Product;

trait ProductTrait 
{
  protected $db;
  protected $commentModel;
  protected $productModel;
  protected $request;

  public function __construct()
  {
    $this->db = new Database();
    $this->commentModel = new Comment($this->db);
    $this->productModel = new Product($this->db);
    $this->request = new Request();
  }
}