<?php

require dirname(__DIR__). '/vendor/autoload.php';

use App\Router;

define('DEBUG_TIME', microtime(true));

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

if (isset($_GET['page']) && $_GET['page'] === '1')
{
    $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
    $get = $_GET;
    unset($get['page']);
    $query = http_build_query($get);
    if(!empty($query))
    {
        $uri = $uri . '?' .$query;
    }
    http_response_code(301);
    header('Location: ' . $uri);
    exit();
}

$router = new Router(dirname(__DIR__). '/Views');
$router
    ->get('/Blog', 'Post/index', 'Home')
    ->get('/Blog/Category/[*:slug]-[i:id]', 'Category/show', 'Category') 
    ->get('/Blog/[*:slug]-[i:id]', 'Post/show', 'Post')
    ->match('/Login', 'Auth/login', 'Login')
    /* ADMINISTRATION */
    //Gestion des Articles
    ->get('/Admin', 'Admin/Post/index', 'AdminPosts')
    ->match('/Admin/Post/[i:id]', 'Admin/Post/edit', 'AdminPostEdit')
    ->post('/Admin/Post/[i:id]/delete', 'Admin/Post/delete', 'AdminPostDelete')
    ->match('/Admin/Post/Create', 'Admin/Post/create', 'AdminPostCreate')
    //Gestion des Catégories
    ->get('/Admin/Categories', 'Admin/Category/index', 'AdminCategories')
    ->match('/Admin/Category/[i:id]', 'Admin/Category/edit', 'AdminCategoryEdit')
    ->post('/Admin/Category/[i:id]/delete', 'Admin/Category/delete', 'AdminCategoryDelete')
    ->match('/Admin/Category/Create', 'Admin/Category/create', 'AdminCategoryCreate')
    ->run();