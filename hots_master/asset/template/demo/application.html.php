<?php Session::init(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo Web::getTitle(true, '|'); ?></title>
        <meta charset="utf-8" />

        <?php
        Src::css('custom.css');

        /* Loader */
        Src::getJavascript();
        Src::getCss();
        ?>

    </head>
    <body>
        <div id="header">
            <h1>HOTS Administrator</h1>
        </div>
        <div id="page_menu">
            <?php
            if (Session::get('statusLogin') == true) {
                URL::link('http://' . Web::$host . '/' . Web::$webAlias . '/home', 'Home');
                URL::link('http://' . Web::$host . '/' . Web::$webAlias . '/data', 'Hots Data');
                URL::link('http://' . Web::$host . '/' . Web::$webAlias . '/logout', 'Logout');
            } else {
                URL::link('#', 'Login');
            }
            ?>
        </div>
        <div id="content">
            {PAGE_CONTENT}
        </div>
        <div id="footer">
            Copyright &copy; 2012 HOTS SPENSA | Develope by : Warman Suganda
        </div>

    </body>
</html>