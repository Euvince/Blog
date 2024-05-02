<?php


use App\Auth;
use App\Connection;
use App\Helper;
use App\Table\CategoryTable;

Auth::check();

$title = 'Gestion des Catégories';
$pdo = Connection::getPDO();
$categories = (new CategoryTable($pdo))->all();

$link = $router->url('AdminCategories');

?>

<?php if(isset($_GET['delete'])): ?>
    <div class="alert alert-success">
        L'enrégistrement a bien été supprimé
    </div>
<?php endif; ?>

<table class="table table-striped">
    <thead>
        <th>Id</th>
        <th>Titre</th>
        <th>Slug</th>
        <th>
            <a href="<?= $router->url('AdminCategoryCreate'); ?>" class="btn btn-primary">Nouveau</a>
        </th>
    </thead>
    <tbody>
        <?php foreach($categories as $category): ?>
            <tr>
                <td>#<?= $category->getId() ?></td>
                <td>
                    <a href="<?= $router->url('AdminCategoryEdit',['id' => $category->getId()]) ?>">
                        <?= Helper::e($category->getName()) ?>
                    </a>
                </td>
                <td><?= $category->getSlug(); ?></td>
                <td>
                    <a href="<?= $router->url('AdminCategoryEdit',['id' => $category->getId()]) ?>" class="btn btn-warning">
                        Editer
                    </a>
                    <form action="<?= $router->url('AdminCategoryDelete',['id' => $category->getId()]) ?>" method="POST"
                        onsubmit="return confirm('Voulez vous vraiment effectuer cette action ?');" style="display:inline">
                        <button type="submit"  class="btn btn-danger">Supprimer</button>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>