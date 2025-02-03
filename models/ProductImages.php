<?php

namespace app\models;

use app\core\Database;

class ProductImages 
{
  private $table = 'images';
  private $db;
  public $errors = [];

  public function __construct(Database $db)
  {
    $this->db = $db;
  }

  public function select($id)
  {
    $sql = "SELECT * FROM $this->table WHERE product_id = :id";
    $images = $this->db->query($sql, ['id' => $id])->get();
    return $images;
  }

  public function find($id)
  {
    $sql = "SELECT * FROM $this->table where id = :id";
    $image = $this->db->query($sql, ['id' => $id])->findOrFail();
    return $image;
  }

  public function insert($tmp, $name, $path, $id)
  {
    move_uploaded_file($tmp, $path);

    $folder = "images/products/{$id}/";
    
    $sql = "INSERT INTO $this->table (path, product_id)
                        VALUES (:path, :product_id)";

    $this->db->query($sql, [
        'path' => $folder . $name,
        'product_id' => $id
    ]); 
  }

  public function delete($id)
  {
    $sql = "DELETE FROM $this->table WHERE id = ?";
    $this->db->query($sql, [$id]);
  }

  public function validate($image)
  {      
    if(empty($image['tmp_name'])) 
    {
      $this->errors['image'] = 'No File chosen';
    }
    else if(!is_image($image['tmp_name']))
    {
      $this->errors['image'] = 'Invalid format';
    }
    else if($image['size'] > 150000) 
    {
      $this->errors['image'] = 'Must be 150kb or less';
    }
    else if(!validImageDimensions($image['tmp_name'], 1000, 1000))
    {
      $this->errors['image'] = 'Width & height must be less than 1000 pixels';
    }

    return empty($this->errors);
  }
}