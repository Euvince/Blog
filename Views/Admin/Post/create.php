<?php

use App\Connection;
use App\HTML\Form;
use App\Models\Post;
use App\Table\PostTable;
use App\Validators\PostValidator;
use Valitron\Validator;
use App\Auth;

Auth::check();

$success = false;

$errors = [];

$post = new Post();
$post->setCreatedAt(date('Y-m-d H:i:s'));

if(!empty($_POST))
{
    $pdo = Connection::getPDO();
    $postTable = new PostTable($pdo);
    Validator::lang('fr');
    $v = new PostValidator($_POST, $postTable, $post->getId());
    $post
        ->setName($_POST['name'])
        ->setContent($_POST['content'])
        ->setSlug($_POST['slug'])
        ->setCreatedAt($_POST['created_at']);
    
    if ($v->validate())
    {
        $postTable->create($post);
        header('Location:' . $router->url('AdminPosts', ['id' => $post->getId()]) . '?created=1');
        exit();
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
        L'article a bien été enrégistré
    </div>
<?php endif; ?>

<?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
        L'article n'a pas été enrégistré,corrigez vos erreurs
    </div>
<?php endif; ?>

<h1>Créer un Article</h1>

<?php require('form.php'); ?>
