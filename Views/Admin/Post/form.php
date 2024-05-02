<form action="" method="POST">
    <?= $form->input('name', 'Titre') ?>
    <?= $form->input('slug', 'Slug') ?>
    <?= $form->textarea('content', 'Contenu') ?>
    <?= $form->input('created_at', 'Date de création') ?>
    <button class="btn btn-primary my-3" name="btn-edit">
        <?php if ($post->getId() !== null): ?>
            Modifier
        <?php else: ?>
            Créer
        <?php endif; ?>
    </button>
</form>