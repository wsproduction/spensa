<?php Session::init(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo Web::$title; ?></title>
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
            <div id="info_user">
                <?php 
                if (Session::get('loginStatus')){
                    echo 'Welcome, ' . Session::get('userName') . ' (' . Session::get('userGroup') . ') | Edit Account'; 
                } else {
                    echo 'Welcome !';
                }
                ?> 
            </div>
            <div id="header">
                <?php echo Web::$webName; ?>
            </div>
            <div id="page_menu">
                <?php echo $topMenu; ?>
                
            </div>
            <div id="content">
                {PAGE_CONTENT}
            </div>
            <div id="footer">
                <?php Src::image('ws.png', null, array('style' => 'width:100px')); ?>
            </div>
        </div>
    </body>
</html>