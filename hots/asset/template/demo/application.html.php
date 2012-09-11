<?php Session::init(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo Web::getTitle(true, '|'); ?></title>
        <meta charset="utf-8" />

        <?php
        Src::css('layout.css');
        Src::css('custom.css');

        /* Loader */
        Src::plugin()->flexDropDown();
        Src::getJavascript();
        Src::getCss();
        ?>

    </head>
    <body>
        <div id="bound">
            <div id="header">
                <div class="h1">Welcome to <?php echo Web::$webName; ?></div>
                <div class="h2">[ SMP Negeri 1 Subang ]</div>
            </div>
            <div id="content">
                {PAGE_CONTENT}
            </div>
            <div id="footer">
                Copyright &copy; 2012 SMP Negeri 1 Subang | Develop by Warman Suganda
            </div>
        </div>
    </body>
</html>