<?php

use app\core\App;
use app\controllers\CartController;
use app\controllers\CommentController;
use app\controllers\HomeController;
use app\controllers\ProductController;
use app\controllers\LoginUserController;
use app\controllers\RegisterUserController;
use app\controllers\ProductImagesController;

$app = new App();

$app->router->get('/', [new HomeController(), 'index']);

$app->router->get('/products', [new ProductController(), 'index']);
$app->router->get('/product', [new ProductController(), 'show']);
$app->router->get('/manage', [new ProductController(), 'admin']);
$app->router->get('/create', [new ProductController(), 'create']);
$app->router->post('/create', [new ProductController(), 'store']);
$app->router->get('/edit', [new ProductController(), 'edit']);
$app->router->post('/edit', [new ProductController(), 'update']);
$app->router->post('/manage', [new ProductController(), 'destroy']);

$app->router->get('/upload', [new ProductImagesController(), 'index']);
$app->router->post('/upload', [new ProductImagesController(), 'store']);
$app->router->post('/delete-image', [new ProductImagesController(), 'destroy']);

$app->router->get('/add-comment', [new CommentController(), 'create']);
$app->router->post('/add-comment', [new CommentController(), 'store']);
$app->router->post('/delete-comment', [new CommentController(), 'destroy']);

$app->router->get('/cart', [new CartController(), 'index']);
$app->router->post('/product', [new CartController(), 'store']);
$app->router->post('/cart', [new CartController(), 'destroy']);


$app->router->get('/register', [new RegisterUserController(), 'create']);
$app->router->post('/register', [new RegisterUserController(), 'store']);
$app->router->get('/login', [new LoginUserController(), 'create']);
$app->router->post('/login', [new LoginUserController(), 'login']);
$app->router->post('/logout', [new LoginUserController(), 'destroy']);