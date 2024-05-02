<?php

use App\Helper;

?>
<div class="col-3">
    <div class="card bg-light mb-3" style="max-width: 20rem;">
        <div class="card-header"><?= Helper::e($post->getName()); ?></div>
        <div class="card-body">
            <h4 class="card-title">Light card title</h4>
            <p class="card-text">
                <?= $post->getCreatedAt()->format('d F Y') ?> ::
                <?php foreach ($post->getCategories() as $k => $category): ?>
                    <?php if ($k > 0): ?>
                    ,
                    <?php endif; 
                        $category_url = $router->url('Category', ['id' => $category->getId(), 'slug' => $category->getSlug()]);
                    ?>
                    <a href="<?= $category_url; ?>"><?= $category->getName(); ?></a>
                <?php endforeach; ?>
            </p>
            <p><?= $post->getExcerpt() ?></p>
            <p>
                <a href="<?= $router->url('Post', ['id' => $post->getId(), 'slug' => $post->getSlug()]) ?>" class="btn btn-primary">Voir plus</a>
            </p>
        </div>
    </div>
</div>