<?php

use App\Connection;
use App\Table\PostTable;

$pdo = Connection::getPDO();

$postTable = new PostTable($pdo);
[$posts, $pagination] = $postTable->findPaginated();

$link = $router->url('Home');

?>

<h1><strong>BIENVENUE SUR MON BLOG</strong></h1>
<div class="row mt-4">
    <?php foreach ($posts as $post): ?>
        <?php require "card.php"; ?>
    <?php endforeach; ?>
</div>

<div class="d-flex justify-content-between my-4">
    <?= $pagination->previousLink($link); ?>
    <?= $pagination->nextLink($link); ?>
</div>