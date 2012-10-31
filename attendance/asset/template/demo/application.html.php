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
            <div id="header">
                <div class="float-left title">
                    <?php 
                        echo Web::$webName; 
                        if (Session::get('login_status')) {
                            echo ' | Welcome, ' . Session::get('name') . '!';
                        }
                    ?>
                </div>
                <div class="float-right btn-top-bar" style="display: none;">
                    &nbsp;
                </div>
                <div class="cl">&nbsp;</div>
            </div>
            <div id="page_menu">
                <ul id="navigation" class="dropdown">
                    <?php
                    if (Session::get('login_status')) {
                        $link_path = 'http://' . Web::getHost();
                    ?>
                        <li><?php URL::link($link_path . '/dashboard', 'Dashboard'); ?></li>
                        <li>
                            <?php URL::link('#', 'Daftar Hadir'); ?>
                            <ul>
                                <li><?php URL::link($link_path . '/teacher', 'Guru'); ?></li>
                                <li><?php URL::link($link_path . '/staff', 'Tata Usaha'); ?></li>
                                <li><?php URL::link($link_path . '/student', 'Siswa'); ?></li>
                            </ul>
                        </li>
                        <li>
                            <?php URL::link('#', 'Laporan'); ?>
                            <ul style="width: 150px;">
                                <li>
                                    <?php URL::link('#', 'Kehadiran Guru'); ?>
                                    <ul style="width: 150px;">
                                        <li><?php URL::link($link_path . '/teacher/treport', 'Waktu Absen'); ?></li>
                                        <li><?php URL::link($link_path . '/teacher/rreport', 'Rekap Absen'); ?></li>
                                    </ul>
                                </li>
                                <li>
                                    <?php URL::link('#', 'Kehadiran Tata Usaha'); ?>
                                    <ul style="width: 150px;">
                                        <li><?php URL::link($link_path . '/teacher/treport', 'Waktu Absen'); ?></li>
                                        <li><?php URL::link($link_path . '/teacher/rreport', 'Rekap Absen'); ?></li>
                                    </ul>
                                </li>
                                <li>
                                    <?php URL::link('#', 'Kehadiran Siswa'); ?>
                                    <ul style="width: 150px;">
                                        <li><?php URL::link($link_path . '/teacher/treport', 'Waktu Absen'); ?></li>
                                        <li><?php URL::link($link_path . '/teacher/rreport', 'Rekap Absen'); ?></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><?php URL::link($link_path . '/login/stop', 'Logout'); ?></li>
                    <?php
                    } else {
                        echo '<li>' . URL::link('#', 'Login',false) . '</li>';
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
            <b>Attendance &copy; 2012 | Develope by : </b> <u>Warman Suganda</u>
        </div>
    </body>
</html>