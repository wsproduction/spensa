<?php Session::init(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title><?php echo Web::getTitle(true, '|'); ?></title>
        <meta name="description" content="Welcome to HOTS SPENSA, Heiger Order Thinking Skill for Student SMP Negeri 1 Subang." />
        <meta name="keywords" content="hots, hots spensa, hots smpn 1 subang, smp negeri 1 subang" />

        <!--[if IE 6]>
                <style type="text/css" media="screen">
                        #main .box .holder a.play{background-image: none;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='css/images/play.png', sizingMethod='image');}	
                        #main .box .holder .stripe{background-image: none;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='css/images/dot.png', sizingMethod='scale');}	
                </style>
        <![endif]-->

        <?php
        Src::css('style');
        Src::css('custom');

        /* Loader */
        Src::plugin()->flexDropDown();
        Src::getJavascript();
        Src::getCss();
        ?>

    </head>
    <body>
        <!-- Shell -->
        <div class="shell">

            <!-- Header -->
            <div id="header">
                <h1 id="logo"><?php echo Src::image('logo.png'); ?></h1>
                <div class="right-part">
                    <p>
                        <?php
                        if (Session::get('loginStatus')) {
                            echo 'Welcome, <b>' . Session::get('name') . '</b>';
                            echo '&nbsp;&nbsp;&nbsp; |';
                            URL::link('http://' . Web::$host . '/account', 'Account');

                            URL::link('http://' . Web::$host . '/signin/stop', 'Sign Out');
                        } else {
                            URL::link('http://' . Web::$host . '/signin', 'sign in');
                        }
                        ?>
                    </p>
                    <form action="" class="search" method="post">
                        <div class="fld">
                            <input type="text" class="field blink" title="search" value="search" />
                        </div>
                        <div class="btnp"><input type="submit" value="Submit" /></div>
                    </form>
                </div>
            </div>
            <!-- End Header -->

            <!-- Navigation -->
            <div id="nav">
                <div class="inner">
                    <ul>
                        <li><?php URL::link('http://' . Web::$host . '/index', 'Home'); ?></li>
                        <li><?php URL::link('http://' . Web::$host . '/news', 'Hots News'); ?></li>
                        <li><?php URL::link('http://' . Web::$host . '/help', 'Help'); ?></li>
                        <li><?php URL::link('http://' . Web::$host . '/aboutus', 'About Us'); ?></li>
                    </ul>
                </div>
            </div>
            <!-- End Navigation -->

            <!-- Content -->
            <div id="content">

                <!-- Main -->
                <div id="main">
                    {PAGE_CONTENT}
                </div>
                <!-- End Main -->

                <!-- Sidebar -->
                <div id="sidebar">
                    <div class="top">
                        <h2>HOTS SUBJECT</h2>
                        <ul class="pink">
                            <?php echo $hotsSubject; ?>
                        </ul>
                        <h2>HOTS CHAT</h2>
                        <div class="blue">
                            <div style="margin-bottom: 10px;">
                                <b>NB : </b> Use polite language in use chat box, thank you!!
                            </div>
                            
                            <!-- BEGIN CBOX - www.cbox.ws - v001 -->
                            <div id="cboxdiv" style="text-align: center; line-height: 0">
                                <div><iframe frameborder="0" width="260" height="362" src="http://www7.cbox.ws/box/?boxid=568567&amp;boxtag=r7n089&amp;sec=main" marginheight="2" marginwidth="2" scrolling="auto" allowtransparency="yes" name="cboxmain7-568567" style="border:#ababab 1px solid;" id="cboxmain7-568567"></iframe></div>
                                <div><iframe frameborder="0" width="260" height="90" src="http://www7.cbox.ws/box/?boxid=568567&amp;boxtag=r7n089&amp;sec=form" marginheight="2" marginwidth="2" scrolling="no" allowtransparency="yes" name="cboxform7-568567" style="border:#ababab 1px solid;border-top:0px" id="cboxform7-568567"></iframe></div>
                            </div>
                            <!-- END CBOX -->
                            <li style="display: none;">
                                <small>21.05.09 | posted by <a href="#">admin</a></small>
                                <a href="#">Lorem ipsum dolor sit amet, consectetur <br />adipiscing elit. </a>
                            </li>
                        </div>
                        <div class="cl" style="height: 30px;">&nbsp;</div>
                        <h2>HOTS STATISTIC</h2>
                        <div class="blue">
                            <table class="statistic" style="display: none;">
                                <tr>
                                    <th>Onlie</th>
                                    <td>:</td>
                                    <td>2</td>
                                </tr>
                                <tr>
                                    <th>Today Visitor</th>
                                    <td>:</td>
                                    <td>2</td>
                                </tr>
                                <tr>
                                    <th>Total Visitor</th>
                                    <td>:</td>
                                    <td>2</td>
                                </tr>
                            </table>
                            <div style="height:134px;margin:10px;">
                                <a href="http://www.alexa.com/siteinfo/hots.smpn1subang.sch.id">
                                    <script type='text/javascript' src='http://xslt.alexa.com/site_stats/js/s/a?url=hots.smpn1subang.sch.id'></script>
                                </a>
                            </div
                        </div>
                    </div>
                </div>
                <!-- End Sidebar -->

            </div>
            <!-- End Content -->
            <div class="cl">&nbsp;</div>

            <!-- Footer -->
            <div id="footer">
                <div class="right-area">
                    <p>HOTS SPENSA &copy; 2012 | Develop By <a href="#">Warman Suganda</a></p>
                </div>
                <div class="cl">&nbsp;</div>
            </div>
            <!-- End Footer -->
        </div>
        <!-- End Shell -->
    </body>
</html>