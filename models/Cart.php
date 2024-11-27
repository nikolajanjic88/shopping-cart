<?php

namespace app\models;

use app\core\Database;

class Cart 
{
  private $table = 'cart';
  private $join_tables = [
    'products' => 'products',
    'images' => 'images'
  ];
  private $db;
  public $errors = [];

  public function __construct(Database $db)
  {
    $this->db = $db;
  }

  public function select()
  {
    $sql = "SELECT c.id, c.quantity, p.title, p.price, i.path, c.user_id
                  FROM {$this->join_tables['products']} p
                  JOIN $this->table c 
                  ON c.product_id = p.id 
                  JOIN {$this->join_tables['images']} i
                  ON p.id = i.product_id
                  GROUP BY c.id HAVING c.user_id = ?";

    $cart = $this->db->query($sql, [$_SESSION['user']['id']])->get();
    return $cart;
  }

  public function insert($qty, $product_id, $user_id)
  {
    $sql = "INSERT INTO $this->table (product_id, quantity, user_id) 
                      VALUES (:product_id, :qty, :user_id)";
 
    $this->db->query($sql, ['product_id' => $product_id, 
                            'qty' => $qty, 
                            'user_id' => $user_id]);
  }

  public function limit($user_id, $product_id)
  {
    $sql = "SELECT product_id, user_id, SUM(quantity) as qty 
                    FROM $this->table
                    WHERE user_id = :user_id
                    AND product_id = :product_id";
    $res = $this->db->query($sql, ['user_id' => $user_id, 'product_id' => $product_id])->findOrFail();
    return $res['qty'];
  }

  public function validate($data)
  {
    if(empty($data['qty'])) $this->errors['qty'] = 'Insert quantity';

    if(empty($this->errors))
    {
      return true;
    }

    return false;
  }

  public function delete($id)
  {
    $sql = "DELETE FROM $this->table WHERE id = ?";

    $this->db->query($sql, [$id]);
  }
}