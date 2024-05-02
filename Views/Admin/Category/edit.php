<?php

use App\Auth;
use App\Connection;
use App\Helper;
use App\HTML\Form;
use App\Table\CategoryTable;
use App\Validators\CategoryValidator;
use Valitron\Validator;

Auth::check();

$pdo = Connection::getPDO();
$categoryTable = new CategoryTable($pdo);
$category = $categoryTable->find($params['id']);
$success = false;

$errors = [];

if(!empty($_POST))
{
    Validator::lang('fr');
    $v = new CategoryValidator($_POST, $categoryTable, $category->getId());
    $category
        ->setName($_POST['name'])
        ->setContent($_POST['content'])
        ->setSlug($_POST['slug'])
        ->setCreatedAt($_POST['created_at']);
    
    if ($v->validate())
    {
        $categoryTable->update($category);
        $success = true;
    }
    else
    {
        $errors = $v->errors();
    }
}

$form = new Form($category, $errors);

?>

<?php if($success): ?>
    <div class="alert alert-success">
        La catégorie a bien été modifié
    </div>
<?php endif; ?>

<?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
        La catégorie n'a pas été modifié,corrigez vos erreurs
    </div>
<?php endif; ?>

<h1>Editer la catégorie <?= Helper::e($category->getName()) ?></h1>

<?php require('form.php'); ?>