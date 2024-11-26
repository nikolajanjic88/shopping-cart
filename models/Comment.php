<?php

namespace app\models;

use app\core\Database;

class Comment
{
  private $table = 'comments';
  private $join_tables = [
    'users' => 'users',
  ];
  private $db;
  public $errors = [];

  public function __construct(Database $db)
  {
    $this->db = $db;
  }

  public function select($product_id)
  {
    $sql = "SELECT c.id, c.body, c.created_at, c.product_id, c.user_id, u.name 
                    FROM $this->table c
                    JOIN {$this->join_tables['users']} u 
                    ON c.user_id = u.id
                    WHERE product_id = :product_id";
    
    $comments = $this->db->query($sql, ['product_id' => $product_id])->get();

    return $comments;
  }


  public function insert($body, $product_id, $user_id)
  {
    $sql = "INSERT INTO $this->table
                        (body, product_id, user_id)
                        VALUES (:body, :product_id, :user_id)";

    $this->db->query($sql, [
                    'body' => $body,
                    'product_id' => $product_id,
                    'user_id' => $user_id
    ]);
  }


  public function delete($id)
  {
    $sql = "DELETE FROM $this->table WHERE id = ?";

    $this->db->query($sql, [$id]);
  }


  public function validate($data)
  {
    if(trim($data['body']) === '') 
    {
      $this->errors['body'] = 'Comment required';
    } 
    
    if(empty($this->errors))
    {
      return true;
    }

    return false;
  }
}