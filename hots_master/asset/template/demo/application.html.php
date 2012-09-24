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
            /*
            if (Session::get('statusLogin') == true) {
                URL::link('http://' . Web::$host . '/dashboard', 'Dashboard');
                URL::link('http://' . Web::$host . '/login/stop', 'Logout');
            } else {
                URL::link('#', 'Home');
            }
             */
            URL::link('#', 'Home');
            URL::link('http://' . Web::$host . '/admin/data', 'Hots Data');
            URL::link('#', 'Logout');
            ?>
        </div>
        <div id="content">
            {PAGE_CONTENT}
        </div>
        <div id="footer">
            Copyright &copy; 2012 HOTS | Develope by : Warman Suganda
        </div>

    </body>
</html>