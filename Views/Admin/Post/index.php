<?php


use App\Auth;
use App\Connection;
use App\Helper;
use App\Table\PostTable;

Auth::check();

$title = 'Gestion des Articles';
$pdo = Connection::getPDO();
[$posts, $pagination] = (new PostTable($pdo))->findPaginated();

$link = $router->url('AdminPosts');

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
        <th>
            <a href="<?= $router->url('AdminPostCreate'); ?>" class="btn btn-primary">Nouveau</a>
        </th>
    </thead>
    <tbody>
        <?php foreach($posts as $post): ?>
            <tr>
                <td>#<?= $post->getId() ?></td>
                <td>
                    <a href="<?= $router->url('AdminPostEdit',['id' => $post->getId()]) ?>">
                        <?= Helper::e($post->getName()) ?>
                    </a>
                </td>
                <td>
                    <a href="<?= $router->url('AdminPostEdit',['id' => $post->getId()]) ?>" class="btn btn-warning">
                        Editer
                    </a>
                    <form action="<?= $router->url('AdminPostDelete',['id' => $post->getId()]) ?>" method="POST"
                        onsubmit="return confirm('Voulez vous vraiment effectuer cette action ?');" style="display:inline">
                        <button type="submit"  class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="d-flex justify-content-between my-4">
    <?= $pagination->previousLink($link); ?>
    <?= $pagination->nextLink($link); ?>
</div>