<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/<?php print UFORUM_SRC_PATH; ?>/favicon.ico">
    <title>
        <?php if(isset($title)):?>
            <?php print $title; ?>
        <?php endif; ?>
    </title>

    <link href="/<?php print UFORUM_SRC_PATH; ?>/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/<?php print UFORUM_SRC_PATH; ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/<?php print UFORUM_SRC_PATH; ?>/css/style.css">

    <script src="/<?php print UFORUM_SRC_PATH; ?>/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="/<?php print UFORUM_SRC_PATH; ?>/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/<?php print UFORUM_SRC_PATH; ?>/js/script.js"></script>

</head>
<body>
    <div class="container" id="new-container">
        <?php if(isset($header)):?>
            <?php print $header; ?>
        <?php endif; ?>

        <?php if(isset($content)):?>
            <?php print $content; ?>
        <?php endif; ?>

        <?php if(isset($footer)):?>
            <?php print $footer; ?>
        <?php endif; ?>
    </div>
</body>
</html>