<?php Session::init(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo Web::getTitle(true, '|'); ?></title>
        <meta charset="utf-8" />

        <?php
        /* Src::icon('madina_icon.png'); */

        /* jQuery Plugin */
        Src::plugin()->jQuery();
        Src::plugin()->jQueryUI('flick');

        Src::css('layout');

        /* Loader */
        echo Src::getJavascript();
        echo Src::getCss();
        ?>
        <script>
            /* jQuery Custom */
            eval(function(p,a,c,k,e,r){e=function(c){return c.toString(a)};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('c.9.e({b:2(0){6 7.8(2(){1(0==\'a\'){$(\'#3-4\').d(\'5\')}f 1(0==\'g\'){$(\'#3-4\').h(\'5\')}})}});',18,18,'action|if|function|loading|progress|fast|return|this|each|fn|start|loadingProgress|jQuery|slideDown|extend|else|stop|slideUp'.split('|'),0,{}));
        </script>
    </head>
    <body>
    <center>
        <div id="frame-template">
            <div id="header">&nbsp;</div>
            <div id="page-menu">
                <ul id="page-menu-navigation">
                    <li><a href='#gallery'>Photo</a></li>
                    <li><a href='#invitation'>Undangan</a></li>
                    <li><a href='#maps'>Peta Lokasi</a></li>
                    <li><a href='#guestbook'>Buku Tamu</a></li>
                </ul>
                <div id="box-count-down">
                    <div id="view-count-down"></div>
                </div>
                <div class="cl">&nbsp;</div>
            </div>
            <div id="page-content">{PAGE_CONTENT}</div>
        </div>
        <div id="footer"><?php echo date('Y') . ' '; ?> &copy; Warman Suganda | Powered By : WS Framework</div>
    </center>
</body>
<script>
    $(function() {
        var austDay = new Date(2013,4,8);
        /*austDay = new Date(austDay.getFullYear() + 1, 1 - 1, 26);*/
        $('#view-count-down').countdown({until: austDay});
        $('#year').text(austDay.getFullYear());
        
        var temp_page = '#gallery';
        
        $('#page-menu-navigation a').live('click', function() {
            var target = $(this).attr('href');
            $('#page-menu-navigation a').removeClass('active');
            $('a[href=' + target + ']').addClass('active');
            if (temp_page != target) {
                $(temp_page).slideUp('slow', function(){
                    temp_page = target;
                    $(target).slideDown(1000);
                }); 
            }
            return false;
        });
    });
</script>
</html>