<!-- modules/TodoModule/Views/page-todo-index.php -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php if ($todo): ?>
                <ul>
                    <?php foreach ($todo as $value): ?>
                        <?php if ($value[ 'achieve' ]): ?>
                            <li><s><?php echo $value[ 'title' ]; ?></s></li>
                        <?php else: ?>
                            <li><?php echo $value[ 'title' ]; ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucun élément existant.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
