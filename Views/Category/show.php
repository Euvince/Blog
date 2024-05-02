<?php

use App\Connection;
use App\Helper;
use App\Table\CategoryTable;
use App\Table\PostTable;

$id = (int)($params['id']);
$slug = $params['slug'];

$pdo = Connection::getPDO();
$category = (new CategoryTable($pdo))->find($id);

if ($category->getSlug() !== $slug)
{
   $url = $router->url('Category', ['id' => $id, 'slug' => $category->getSlug()]);
   http_response_code(301);
   header('Location : ' . $url);
}

$title = "Catégorie {$category->getName()}";

[$posts, $paginatedQuery] = (new PostTable($pdo))->findPaginatedForCategory($category->getId());

$link =  $router->url('Category', ['id' => $category->getId(), 'slug' => $category->getSlug()]);

?>

<h2><?= Helper::e($title) ?></h2>

<div class="row mt-4">
    <?php foreach ($posts as $post): ?>
        <?php require dirname(__DIR__) . "/Post/card.php"; ?>
    <?php endforeach; ?>
</div>

<div class="d-flex justify-content-between my-4">
    <?= $paginatedQuery->previousLink($link) ?>
    <?= $paginatedQuery->nextLink($link) ?>
</div>