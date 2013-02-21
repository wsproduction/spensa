<?php Session::init(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo Web::getTitle(true, '|'); ?></title>
        <meta charset="utf-8" />

        <?php
        /* jQuery Plugin */
        Src::plugin()->jQuery();
        Src::plugin()->jQueryUI('ui-lightness');

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
                <?php
                if (Session::get('login_status')) {
                    ?>
                    <ul id="navigation" class="dropdown">
                        <?php
                        $hostname = 'http://' . Web::getHost();
                        ?>
                        <li><a href="<?php echo $hostname . '/dashboard'; ?>">Beranda</a></li>
                        <li><a href="<?php echo $hostname . '/dashboard'; ?>">Hari Libur</a></li>
                        <li>
                            <a style="cursor: pointer;">Dispensasi</a>
                            <ul>
                                <li><a href="<?php echo $hostname . '/student/dispensation'; ?>">Siswa</a></li>
                                <li><a href="<?php echo $hostname . '/teacher/dispensation'; ?>">Guru</a></li>
                                <li><a href="<?php echo $hostname . '/tu/dispensation'; ?>">Tata Usaha</a></li>
                            </ul>
                        </li>
                        <li>
                            <a style="cursor: pointer;">Data Absensi</a>
                            <ul>
                                <li><a href="<?php echo $hostname . '/student'; ?>">Siswa</a></li>
                                <li><a href="<?php echo $hostname . '/teacher'; ?>">Guru</a></li>
                                <li><a href="<?php echo $hostname . '/tu'; ?>">Tata Usaha</a></li>
                            </ul>
                        </li>
                        <li>
                            <a style="cursor: pointer;">Laporan Absensi</a>
                            <ul>
                                <li><a href="<?php echo $hostname . '/student/report'; ?>">Siswa</a></li>
                                <li><a href="<?php echo $hostname . '/teacher/report'; ?>">Guru</a></li>
                                <li><a href="<?php echo $hostname . '/tu/report'; ?>">Tata Usaha</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo $hostname . '/chart'; ?>">Grafik</a></li>
                        <li><a href="<?php echo $hostname . '/account'; ?>">Pengaturan Akun</a></li>
                        <li><a href="<?php echo $hostname . '/login/stop'; ?>">Logout</a></li>
                        <?php
                    }
                    ?>
                </ul>             
                <div class="cl">&nbsp;</div>
            </div>
            <div id="content">
                {PAGE_CONTENT}
                <div class="cl">&nbsp;</div>
            </div>
        </div>
        <div id="footer">
            <div>
                <b>SMP Negeri 1 Subang &copy; 2012 | Develope by : </b> <b><a href="www.facebook.com/warman.suganda">Warman S. & Novie H.P.</a></b> &nbsp; Members of SiFTech (Solution of Information Technology) 
            </div>
            <div>
                <table border="0" cellpadding="1" cellspacing="0" align="right">
                    <tr>
                        <td><b>Best View & Stable</b>&nbsp;with : </td>
                        <td>
                            <?php
                            echo Src::image('chrome.png', null, array('title' => 'Google Chrome'));
                            echo Src::image('firefox.png', null, array('title' => 'Firefox'));
                            echo Src::image('opera.png', null, array('title' => 'Opera'));
                            echo Src::image('safari.png', null, array('title' => 'Safari'));
                            ?>
                        </td>
                        <td>, <b>Resolution</b>&nbsp;: 1280 x 800 Pixcel</td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>