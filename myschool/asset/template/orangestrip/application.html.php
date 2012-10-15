<?php
Session::init();
$protection = Session::get('login_status');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <!--
        <meta http-equiv="pragma" content="no-cache">
        <meta http-equiv="cache-control" content="no-cache">
        <meta http-equiv="expires" content="0">
        -->
        <title><?php echo Web::getTitle(true, '|'); ?></title>
        <meta name="description" content="Welcome to HOTS SPENSA, Heiger Order Thinking Skill for Student SMP Negeri 1 Subang." />
        <meta name="keywords" content="hots, hots spensa, hots smpn 1 subang, smp negeri 1 subang" />

        <?php
        Src::icon('icon.png');

        /* jQuery Plugin */
        Src::plugin()->jQuery();
        Src::plugin()->jQueryUI();
        Src::plugin()->jQueryAddress();
        Src::plugin()->rLoader();

        Src::css('layout');
        Src::css('style_menu');
        Src::javascript('autoload');

        /* Loader */
        echo Src::getJavascript();
        echo Src::getCss();
        ?>

    </head>
    <body>
        <div id="outline">

            <!-- BEGIN : Loading -->
            <div id="loading-progress"> Loading...</div>
            <!-- END : Loading -->

            <!-- BEGIN : Header box fixed -->
            <div id="header">
                <div id="logo" class="fl-left">
                    MySchool<sup><span style="font-size: 11px;">&nbsp;(beta)</span></sup>
                </div>
                <?php if ($protection) { ?>
                    <div id="m-account" class="fl-right">
                        <a id="m-account-parent" class="slide-of" href="#m-account-child">My Account</a>
                        <div class="cl">&nbsp;</div>
                        <ul id="m-account-child">
                            <li><a href="#">Account Settings</a></li>
                            <li><a href="#">Privacy Settings</a></li>
                            <li><a href="http://myschool.spensa.ws/login/stop">Logout</a></li>
                        </ul>
                    </div>
                <?php } ?>
            </div>
            <!-- END : Header box fixed -->

            <!-- BEGIN : Content box -->
            <div id="content">

                <?php if ($protection) { ?>
                    <!-- BEGIN : Left box fixed -->
                    <div id="fix-left">
                        <div class="left-user-info">
                            <div class="left-thumbnail fl-left"> <?php echo Src::image('default-thumbnail-small.png', null, array('id' => 'profile-thumbnail-small')); ?> </div>
                            <div class="left-title fl-left"> 
                                <div class="left-name"><a id="profile-name-left" href="#"></a></div>
                                <div class="left-btn-blue"><a href="http://myschool.spensa.ws/profile/edit">Edit Profile</a></div>
                            </div>
                            <div class="cl">&nbsp;</div>
                        </div>
                        <ul class="m-left">
                            <li type="parent" class="toggle-on"><a href="#list-m-pages" class="pages border-bottom arrow-grey">Pages</a></li>
                            <ul id="list-m-pages" style="display: block;"></ul>
                        </ul>
                    </div>
                    <!-- END : Left box fixed -->

                    <!-- BEGIN : Live view box -->
                    <div id="live-view" class="border-left border-right">

                        <!-- BEGIN : View Page box -->
                        {PAGE_CONTENT}
                        <!-- END : View Page box -->

                        <div class="cl">&nbsp;</div>

                    </div>
                    <!-- END : Live view box -->

                    <!-- BEGIN : Right box fixed-->
                    <div id="fix-right" style="width: 235px;padding-top: 10px;">
                        <?php echo Src::image('chat-sample.png', null, array('style', 'padding:10px 10px 0 0;')); ?>
                    </div>
                    <!-- END : Left box fixed -->
                <?php } else { ?>
                    {PAGE_CONTENT}
                <?php } ?>
                <div class="cl">&nbsp;</div>

            </div>
            <!-- END : Content box -->

            <!-- BEGIN : Footer box -->
            <div id="footer" class="border-top">
                MySchool &copy; 2012 | Develope by : Warman Suganda
            </div>
            <!-- END : Footer box -->

        </div>
    </body>
</html>