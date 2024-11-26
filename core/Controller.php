<?php

namespace app\core;

class Controller 
{
  public function view($path, $params = [])
  {
      extract($params);
      require BASE_PATH . "/views/$path.php";
  }
}