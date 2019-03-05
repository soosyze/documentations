<!-- modules/TodoModule/Views/page-todo-admin.php -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="?todo/item" class="btn btn-primary">Ajouter un item</a>
        </div>

        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Action</th>
                        <th>Réalisé</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($todo): ?>
                        <?php foreach ($todo as $value): ?>
                            <tr>
                                <td><?php echo $value[ 'title' ]; ?></td>
                                <td>
                                    <form method="post" action="?todo/item/<?php echo $value[ 'id' ]; ?>/delete" class="form-inline">
                                        <a class="btn btn-default" href="?todo/item/<?php echo $value[ 'id' ]; ?>/edit">
                                            Éditer 
                                        </a>
                                        <input type="submit" name="delete" class="btn btn-default" value="Supprimer">
                                    </form>
                                </td>
                                <td>
                                    <?php if ($value[ 'achieve' ]): ?>
                                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                    <?php else: ?>
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="info">
                            <td colspan="3">Aucun élément existant.</td>
                        </tr>
                    <?php endif; ?>
                <tbody>
            </table>
        </div>
    </div>
</div>