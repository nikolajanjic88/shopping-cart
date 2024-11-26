<?php

namespace app\core;

class Router extends Controller
{
  protected array $routes = [];
  public Request $request;
  public Response $response;

  public function __construct(Request $request, Response $response)
  {
    $this->request = $request;
    $this->response = $response;
  }

  public function get($path, $callback)
  {
    $this->routes['get'][$path] = $callback;
  }

  public function post($path, $callback)
  {
    $this->routes['post'][$path] = $callback;
  }

  public function resolve()
  {
    $path = $this->request->getPath();   
    $method = $this->request->method();
    $callback = $this->routes[$method][$path] ?? false;

    if($callback === false) 
    {
      $this->response->setStatusCode(404);
      return $this->view('404');
    }
    
    return call_user_func($callback);
  }
 
}