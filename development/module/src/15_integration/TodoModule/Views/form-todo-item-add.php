<!-- modules/TodoModule/Views/form-todo-item-add.php -->

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <?php if ($form->form_errors()): ?>
                <?php foreach ($form->form_errors() as $error): ?>
                    <div class="alert alert-danger">
                        <p><?php echo $error; ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if ($form->form_success()): ?>
                <?php foreach ($form->form_success() as $success): ?>
                    <div class="alert alert-success">
                        <p><?php echo $success; ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php echo $form->renderForm(); ?>
        </div>
    </div>
</div>