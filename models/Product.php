<?php

namespace app\models;

use app\core\Database;

class Product
{
  private $table = 'products';
  private $join_tables = [
    'images' => 'images',
    'categories' => 'categories',
    'comments' => 'comments'
  ];
  private $db;
  public $errors = [];

  public function __construct(Database $db)
  {
    $this->db = $db;
  }

  public function selectAllProducts()
  {
    if(isset($_GET['category']))
    {
      $sql = "SELECT p.id, p.title, p.price, i.path, c.name
                    FROM $this->table p
                    JOIN {$this->join_tables['categories']} c
                    ON p.category_id = c.id
                    JOIN {$this->join_tables['images']} i
                    ON p.id = i.product_id
                    GROUP BY p.id 
                    HAVING c.name = ?";

      $products = $this->db->query($sql, [$_GET['category']])->get();
    } 
    else if(isset($_GET['search']))
    {
      $sql = "SELECT p.id, p.title, p.price, i.path 
                    FROM $this->table p
                    JOIN {$this->join_tables['images']} i
                    ON p.id = i.product_id 
                    GROUP BY p.id
                    HAVING p.title LIKE CONCAT('%',?,'%')";
          
      $products = $this->db->query($sql, [$_GET['search']])->get();
    }
    else 
    {
      $sql = "SELECT p.id, p.title, p.price, i.path 
      FROM $this->table p
      JOIN {$this->join_tables['images']} i
      ON p.id = i.product_id 
      GROUP BY p.id";

      $products = $this->db->query($sql)->get();
    }

    return $products;
  }

  public function showProduct($id)
  {
    $sql = "SELECT * FROM $this->table p 
                     JOIN {$this->join_tables['images']} i
                     ON p.id = i.product_id
                     WHERE p.id = :id";

    $result = $this->db->query($sql, ['id' => $id])->findOrFail();
    
    $sql = "SELECT path FROM {$this->join_tables['images']} WHERE product_id = :id";

    $images = $this->db->query($sql, ['id' => $id])->get();

    $product = array_merge($result, $images);

    return $product;
  }


  public function manageProducts()
  {
    $sql = "SELECT p.id, p.title, p.price, i.path 
                  FROM $this->table p
                  LEFT JOIN {$this->join_tables['images']} i
                  ON p.id = i.product_id 
                  GROUP BY p.id";

    $products = $this->db->query($sql)->get();

    return $products;
  }

  public function insert($title, $desc, $price, $category)
  {
    $sql = "INSERT INTO $this->table 
                        (title, description, price, category_id) 
                        VALUES (:title, :description, :price, :category_id)";

    $this->db->query($sql, [
              'title' => $title,
              'description' => $desc,
              'price' => $price,
              'category_id' => $category
    ]);

    //make folder with name of an ID of a product for images
    $lastID = $this->db->lastID();
    $imageFolder = BASE_PATH . "/public/images/products/$lastID";
    if(!file_exists($imageFolder))
    {
      mkdir($imageFolder);
    } 
  }

  public function find($id)
  {
    $sql = "SELECT * FROM $this->table WHERE id = ?";

    $product = $this->db->query($sql, [$id])->findOrFail();

    return $product;
  }

  public function update($title, $desc, $price, $category_id, $id)
  {
    $sql = "UPDATE $this->table SET 
                    title = :title, 
                    description = :description, 
                    price = :price,
                    category_id = :category_id
                    WHERE id = :id";

    $this->db->query($sql, [
              'title' => $title,
              'description' => $desc,
              'price' => $price,
              'category_id' => $category_id,
              'id' => $id
    ]);       
  }

  public function delete($id)
  {
    $sql = "DELETE FROM $this->table WHERE id = ?";

    $this->db->query($sql, [$id]);

    $dir = BASE_PATH . "/public/images/products/{$id}";

    delTree($dir);
  }


  public function getCategories()
  {
    $sql = "SELECT * FROM {$this->join_tables['categories']}";
    return $this->db->query($sql)->get();     
  }

  public function validate($data) 
  {
    if(trim($data['title']) === '') 
    {
      $this->errors['title'] = 'Title required';
    } 
    else if(!preg_match("/^[a-zA-Z0-9 ]+$/", $data['title']))
    {
      $this->errors['title'] = 'Invalid characters';
    }

    if(trim($data['desc']) === '') 
    {
      $this->errors['desc'] = 'Description required';
    } 

    if($data['price'] <= 0)
    {
      $this->errors['price'] = 'Price required';
    }

    if($data['category'] === '0') 
    {
      $this->errors['category'] = 'Select a category';
    } 

    if(empty($this->errors))
    {
      return true;
    }

    return false;
  }

}