<?php

use App\Connection;
use App\HTML\Form;
use App\Models\User;
use App\Table\Exception\NotFoundException;
use App\Table\UserTable;

$user = new User();
$errors = [];

if (!empty($_POST)){
    $user->setUsername($_POST['username']);
    $errors['password'] = 'Informations incorrects';

    if (empty($_POST['username']) || empty($_POST['password'])){
        $table = new UserTable(Connection::getPDO());
        try{
            $user_finded = $table->findByUsername($_POST['username']);
            if(password_verify($_POST['password'], $user_finded->getPassword()) === true){
                session_start();
                $_SESSION['auth'] = $user_finded->getId();
                header('Location: ' . $router->url('AdminPosts'));
                exit();
            }
        }catch (NotFoundException $e){
            
        }
    }
    
}

$form = new Form($user, $errors);

?>

<h1>Se Connecter</h1>

<form action="" method="POST">
    <?= $form->input('username', 'Nom d\'Utilisateur'); ?>
    <?= $form->input('password', 'Mot de Passe'); ?>
    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>