<form action="" method="POST">
    <?= $form->input('name', 'Titre') ?>
    <?= $form->input('slug', 'Slug') ?>
    <button class="btn btn-primary my-3" name="btn-edit">
        <?php if ($category->getId() !== null): ?>
            Modifier
        <?php else: ?>
            Créer
        <?php endif; ?>
    </button>
</form>