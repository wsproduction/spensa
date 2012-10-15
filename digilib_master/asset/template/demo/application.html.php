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
        
        
        Src::css('layout');
        Src::css('custom');

        /* Loader */
        echo Src::getJavascript();
        echo Src::getCss();
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
                <?php echo Src::image('ws.png', null, array('style' => 'width:45px')); ?>
            </div>
        </div>
    </body>
</html>