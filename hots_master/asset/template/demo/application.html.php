<?php Session::init(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo Web::getTitle(true, '|'); ?></title>
        <meta charset="utf-8" />

        <?php
        
        /* jQuery Plugin*/
        Src::plugin()->jQuery();
        Src::plugin()->jQueryCookie();
        Src::plugin()->jQueryJson();
        Src::plugin()->jQueryUI();
        Src::plugin()->jDialogBox(); 
        Src::plugin()->flexDropDown();
        
        Src::css('custom');

        /* Loader */
        echo Src::getJavascript();
        echo Src::getCss();
        ?>

    </head>
    <body>
        <div id="header">
            <h1>HOTS Administrator</h1>
        </div>
        <div id="page_menu">
            <?php
            if (Session::get('loginStatus') == true) {
                URL::link('http://' . Web::$host . '/' . Web::$webAlias . '/home', 'Home');
                URL::link('http://' . Web::$host . '/' . Web::$webAlias . '/data', 'Hots Data');
                URL::link('http://' . Web::$host . '/' . Web::$webAlias . '/login/stop', 'Logout');
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