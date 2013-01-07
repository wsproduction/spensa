<?php Session::init(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo Web::getTitle(true, '|'); ?></title>
        <meta charset="utf-8" />

        <?php
        /* jQuery Plugin */
        Src::plugin()->jQuery();
        Src::plugin()->jQueryUI();

        Src::css('layout');
        Src::css('custom');
        Src::javascript('autoload');

        /* Loader */
        echo Src::getJavascript();
        echo Src::getCss();
        ?>
    </head>
    <body>
        <div id="bound">
            <div id="header">
                <div class="float-left title">
                    <?php echo Web::$webName; ?>
                </div>
                <div class="float-right btn-top-bar" style="display: none;">
                    &nbsp;
                </div>
                <div class="cl">&nbsp;</div>
            </div>
            <div id="page_menu">
                <?php echo $topMenu; ?>
                <div class="cl">&nbsp;</div>
            </div>
            <div id="content">
                {PAGE_CONTENT}
                <div class="cl">&nbsp;</div>
            </div>
        </div>
        <div id="footer">
            <b>Digilib &copy; 2012 | Develope by : </b> <u>Warman Suganda</u>
        </div>
        
        <script>
        $(function(){
            $('#navigation li').live('click', function(){
                $(this).children('ul').slideDown('fast');
                $(this).mouseleave(function(){
                    $(this).children('ul').slideUp('fast');
                });
            });
            
        });
        </script>
    </body>
</html>