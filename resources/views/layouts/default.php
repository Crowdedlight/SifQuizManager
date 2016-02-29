<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SIF Quiz</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="<?= URL::asset('css/style.css'); ?>">

</head>
<body>
<div id="wrap">
    <?php echo $navigation; ?>

    <div class="container content">
        <?php echo $content; ?>
    </div>
</div>

<?php echo $footer; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="<?= URL::asset('js/script.js') ?>"></script>
</body>
</html>