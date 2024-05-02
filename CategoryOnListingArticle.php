<?php

$ids = [];
$postByID = [];
foreach($posts as $post)
{
    $ids[] = $post->getId();
}
foreach($posts as $post)
{
    $postByID[$post->getId()] = $post;
}
dd($postByID);
$categories = $pdo
    ->query('SELECT c.*, pc.post_id
             FROM post_category pc
             JOIN category c ON c.id = pc.category_id
             WHERE pc.post_id IN (' .implode(',', $ids). ')'
    )->fetchAll(PDO::FETCH_CLASS, Category::class);