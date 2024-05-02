<?php

use App\Connection;
use App\Helper;
use App\HTML\Form;
use App\Table\PostTable;
use App\Validators\PostValidator;
use Valitron\Validator;
use App\Auth;

Auth::check();

$pdo = Connection::getPDO();
$postTable = new PostTable($pdo);
$post = $postTable->find($params['id']);
$success = false;

$errors = [];

if(!empty($_POST))
{
    Validator::lang('fr');
    $v = new PostValidator($_POST, $postTable, $post->getId());
    $post
        ->setName($_POST['name'])
        ->setContent($_POST['content'])
        ->setSlug($_POST['slug'])
        ->setCreatedAt($_POST['created_at']);
    if ($v->validate())
    {
        $postTable->update($post);
        $success = true;
    }
    else
    {
        $errors = $v->errors();
    }
}

$form = new Form($post, $errors);

?>

<?php if($success): ?>
    <div class="alert alert-success">
        L'article a bien été modifié
    </div>
<?php endif; ?>

<?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
        L'article n'a pas été modifié,corrigez vos erreurs
    </div>
<?php endif; ?>

<h1>Editer l'article <?= Helper::e($post->getName()) ?></h1>

<?php require('form.php'); ?>