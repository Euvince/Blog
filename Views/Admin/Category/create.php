<?php

use App\Auth;
use App\Connection;
use App\HTML\Form;
use App\Models\Category;
use App\Table\CategoryTable;
use App\Validators\CategoryValidator;
use Valitron\Validator;

Auth::check();

$success = false;

$errors = [];

$category = new Category();

if(!empty($_POST))
{
    $pdo = Connection::getPDO();
    $categoryTable = new CategoryTable($pdo);
    Validator::lang('fr');
    $v = new CategoryValidator($_POST, $categoryTable, $category->getId());
    $category
        ->setName($_POST['name'])
        ->setSlug($_POST['slug']);
    
    if ($v->validate())
    {
        $categoryTable->create($category);
        header('Location:' . $router->url('AdminCategories') . '?created=1');
        exit();
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
        La catégorie a bien été enrégistré
    </div>
<?php endif; ?>

<?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
        La catégorie n'a pas été enrégistré,corrigez vos erreurs
    </div>
<?php endif; ?>

<h1>Créer une Catégorie</h1>

<?php require('form.php'); ?>
