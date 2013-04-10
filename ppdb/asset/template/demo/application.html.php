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
        Src::css('custom');

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
        <div id="loading-progress">&nbsp;</div>
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
                <ul id="navigation" class="dropdown">

                    <?php
                    if (Session::get('__login_status')) {
                        $hostname = 'http://' . Web::getHost();
                        ?>
                        <li><a href="<?php echo $hostname . '/dashboard' ?>">Beranda</a></li>
                        <li>
                            <a>Data Sekolah Asal</a>
                            <ul style="width: 150px;">
                                <li><a href="<?php echo $hostname . '/schoolprofile'; ?>">Profile Sekolah</a></li>
                                <li><a href="<?php echo $hostname . '/schoolprofile'; ?>">Keadaan Guru</a></li>
                                <li><a href="<?php echo $hostname . '/schoolprofile'; ?>">Keadaan Siswa</a></li>
                                <li><a href="<?php echo $hostname . '/schoolprofile'; ?>">Nilai Ujian</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo $hostname . '/studentprofile' ?>">Data Pelamar</a></li>
                        <li><a href="<?php echo $hostname . '/report' ?>">Laporan</a></li>
                        <li><a href="<?php echo $hostname . '/login/stop' ?>">Logout</a></li>
                    <?php } ?>

                </ul>
                <div class="cl">&nbsp;</div>
            </div>
            <div id="content">
                {PAGE_CONTENT}
                <div class="cl">&nbsp;</div>
            </div>
        </div>
        <div id="footer">
            <b>WS Production &copy; 2013 | Develope by : </b> <b><a href="www.facebook.com/warman.suganda">Warman Suganda</a> <br>Best View</b>&nbsp;with <b><a href="www.google.com/chrome">Google Chrome</a></b>, <b>Screen Resolution</b>&nbsp;: 1280 x 800 Pixcel
        </div>

        <script>
            $(function(){
                
                $("ul.dropdown li").hover(function(){
    
                    $(this).addClass("hover");
                    $('ul:first',this).css('visibility', 'visible');
    
                }, function(){
    
                    $(this).removeClass("hover");
                    $('ul:first',this).css('visibility', 'hidden');
    
                });
               
            });
        </script>
    </body>
</html>