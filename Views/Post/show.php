<?php

use App\Connection;
use App\Models\Category;
use App\Table\PostTable;

$id = (int)($params['id']);
$slug = $params['slug'];

$pdo = Connection::getPDO();
$post = (new PostTable($pdo))->find($id);

if ($post->getSlug() !== $slug)
{
   $url = $router->url('Post', ['id' => $id, 'slug' => $post->getSlug()]);
   http_response_code(301);
   header('Location : ' . $url);
}

$query = $pdo->prepare("
SELECT c.id, c.slug, c.name
FROM post_category pc 
JOIN category c ON pc.category_id = c.id
WHERE pc.post_id = :id"
);
$query->execute(['id' => $post->getId()]);
$query->setFetchMode(PDO::FETCH_CLASS, Category::class);
/** @var Category[] */
$categories = $query->fetchAll();

?>

<h1><strong>Article : <?= $id ?></strong></h1>

<h3 class="card-title">Light card title</h3>
<p class="card-text"><?= $post->getCreatedAt()->format('d F Y') ?></p>
<?php foreach ($categories as $k => $category): ?>
    <?php if ($k > 0): ?>
    ,
    <?php endif; 
        $category_url = $router->url('Category', ['id' => $category->getId(), 'slug' => $category->getSlug()]);
    ?>
    <a href="<?= $category_url; ?>"><?= $category->getName(); ?></a>
<?php endforeach; ?>
<p><?= $post->getFormattedContent() ?></p>