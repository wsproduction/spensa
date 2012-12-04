<?php Session::init(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo Web::getTitle(true, '|'); ?></title>
        <meta charset="utf-8" />

        <?php
        Src::icon('icon.png');
        Src::css('construct.css');
        Src::css('layout.css');
        Src::css('custom.css');

        /* Loader */
        Src::getJavascript();
        Src::getCss();
        ?>
        
    </head>
    <body>
    <center><h1><i>Under Construction</i></h1></center>
    </body>
</html>