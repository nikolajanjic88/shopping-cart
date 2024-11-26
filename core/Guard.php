<?php

namespace app\core;

trait Guard 
{
  public function isAdmin()
  {
    return isset($_SESSION['user']) && $_SESSION['user']['is_admin'] == 1;
  }


  public function isGuest()
  {
    return !isset($_SESSION['user']);
  }
}