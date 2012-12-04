<?php Session::init(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo Web::$title; ?></title>
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
            <h1>WSFramework</h1>
        </div>
        <div id="page_menu">
            <?php
            URL::link('http://' . Web::$host . '/index', 'Beranda');
            URL::link('http://' . Web::$host . '/profile', 'Profile');

            if (Session::get('statusLogin') == true) {
                URL::link('http://' . Web::$host . '/dashboard', 'Dashboard');
                URL::link('http://' . Web::$host . '/login/stop', 'Logout');
            } else {
                URL::link('http://' . Web::$host . '/login', 'Login');
            }
            ?>
        </div>
        <div id="content">
            {PAGE_CONTENT}
        </div>
        <div id="footer">
            <?php Src::image('ws.png', null, array('style' => 'width:100px')); ?>
        </div>

    </body>
</html>