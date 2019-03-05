<!-- modules/TodoModule/Views/html.php -->

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" http-equiv="Cache-control" content="no-cache">
        <meta http-equiv="X-UA-Compatible" content="IE=edge;" />
        <title>Soosyze | TodoModule</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><?php echo $main_title; ?></h1>
                </div>
            </div>
        </div>
        <?php if (isset($block[ 'content' ])): ?>
            <?php echo $block[ 'content' ]; ?>
        <?php endif; ?>
    </body>
</html>
