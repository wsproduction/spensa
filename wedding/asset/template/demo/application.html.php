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
        Src::plugin()->jQueryAddress();

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
                    <li><a href='/gallery' ref='#gallery' title="Welcome">Photo</a></li>
                    <li><a href='/invitation' ref='#invitation' title="Undangan">Undangan</a></li>
                    <li><a href='/maps' ref='#maps' title="Peta Lokasi">Peta Lokasi</a></li>
                    <li><a href='/guestbook' ref='#guestbook' title="Buku Tamu">Buku Tamu</a></li>
                    <li><a href='/aboutaour' ref='#aboutaour' title="Tentang Kami">Tentang Kami</a></li>
                </ul>
                <div id="box-count-down">
                    <div id="view-count-down"></div>
                </div>
                <div class="cl">&nbsp;</div>
            </div>
            <div id="page-content">{PAGE_CONTENT}</div>
        </div>
        <div id="footer">
            <div style="text-align: center;margin-top: 5px;float: left;margin-left: 38px;">
                <div class="fb-like" data-href="http://www.warmanandfinny.tk" data-send="true" data-width="250" data-show-faces="false" data-font="arial"></div>
            </div>
            <div style="float: right;margin-right: 38px;padding-top: 8px;color: #333333;"><?php echo date('Y') . ' '; ?> &copy; Warman Suganda | <b> Developed by </b> : Warman Suganda with <u>WSFramework</u></div>
            <div class="cl"></div>
        </div>
    </center>
</body>
<script>
    $(function() {
        
        /* Jquery Address Configuration */
        
        var temp_page = '#gallery';
        var slide_efect = function(old_target, new_target) {
                           
            $('#page-menu-navigation a').removeClass('active');
            $('a[ref=' + new_target + ']').addClass('active');
                
            var title = $('a[ref=' + new_target + ']').attr('title');
            document.title = 'Official Website Pernikahan Warman Suganda & Finny Alviani | ' + title;
            
            $(old_target).fadeOut(400, function(){
                $(new_target).fadeIn(400);
            }); 
        };
        
        var handler = function(event) {
            var val = event.value;
            var target = '#' + val.replace('/','');
                                        
            if (target == '#' || target == temp_page) {
                target = temp_page;
                slide_efect(temp_page, target);
            } else {
                slide_efect(temp_page, target);
                temp_page = target;
            }
        };
        
        $.address.init(function(event) {
            $('#page-menu-navigation a').address(function() {
                return $(this).attr('href').replace(location.pathname, '');
            });
        }).change(function(event) {
            handler(event);
        });
        
        var austDay = new Date(2013,4,8);
        /*austDay = new Date(austDay.getFullYear() + 1, 1 - 1, 26);*/
        $('#view-count-down').countdown({until: austDay});
        $('#year').text(austDay.getFullYear());
        
        /*
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
         */
    });
</script>
<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=448958111808939";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
</html>