<?php Session::init(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title><?php echo Web::getTitle(true, '|'); ?></title>
        <!--[if IE 6]>
                <style type="text/css" media="screen">
                        #main .box .holder a.play{background-image: none;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='css/images/play.png', sizingMethod='image');}	
                        #main .box .holder .stripe{background-image: none;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='css/images/dot.png', sizingMethod='scale');}	
                </style>
        <![endif]-->

        <?php
        Src::css('style.css');
        Src::css('custom.css');

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
                <h1 id="logo"><a href="#">wbfashion</a></h1>
                <div class="right-part">
                    <p>
                        <?php
                        URL::link('http://' . Web::$host . '/signin', 'sign in');
                        URL::link('http://' . Web::$host . '/signup', 'create account');
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
                        <li><?php URL::link('http://' . Web::$host . '/signin', 'Hots News'); ?></li>
                        <li><?php URL::link('http://' . Web::$host . '/signin', 'Help'); ?></li>
                        <li><?php URL::link('http://' . Web::$host . '/signin', 'About Us'); ?></li>
                        <li><?php URL::link('http://' . Web::$host . '/signin', 'Testimony'); ?></li>
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
                        <h2>HOTS STATISTIC</h2>
                        <ul class="blue">
                            <li><a href="#">Lorem ipsum dolor sit amet, consectetur <br />adipiscing elit. </a></li>
                            <li><a href="#">Summer uni 2009!</a></li>
                            <li><a href="#">The singular suit project</a></li>
                            <li><a href="#">Eva models</a></li>
                            <li><a href="#">Try me by faah damji</a></li>
                            <li><a href="#">Purus vitae urna molesti </a></li>
                            <li><a href="#">Quisque elementum purus vita</a></li>
                            <li><a href="#">Ipsum dolor sit consectetur</a></li>
                            <li><a href="#">Ac diam pulvinar porttitor</a></li>
                        </ul>
                        <h2>HOTS ROLL</h2>
                        <ul class="blue">
                            <li>
                                <small>21.05.09 | posted by <a href="#">admin</a></small>
                                <a href="#">Lorem ipsum dolor sit amet, consectetur <br />adipiscing elit. </a>
                            </li>
                            <li>
                                <small>21.05.09 | posted by <a href="#">admin</a></small>
                                <a href="#">Nulla ipsum magna pellentesque et imperdiet<br /> eget, intercedm sed neque </a>
                            </li>
                            <li>
                                <small>21.05.09 | posted by <a href="#">admin</a></small>
                                <a href="#">Consecettur adipsicing elit pellentesque turpis<br /> unra tempus.</a>
                            </li>
                            <li>
                                <small>21.05.09 | posted by <a href="#">admin</a></small>
                                <a href="#">Curabitu eleifend , diam ac pulvinar portititor, <br />massa elit lobortis ligula a blandit</a>
                            </li>
                            <li>
                                <small>21.05.09 | posted by <a href="#">admin</a></small>
                                <a href="#">Lorem ipsum dolor sit amet, consectetur <br />adipiscing elit. </a>
                            </li>
                            <li>
                                <small>21.05.09 | posted by <a href="#">admin</a></small>
                                <a href="#">Lorem ipsum dolor sit amet, consectetur <br />adipiscing elit. </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- End Sidebar -->

            </div>
            <!-- End Content -->
            <div class="cl">&nbsp;</div>

            <!-- Footer -->
            <div id="footer">
                <div class="right-area">
                    <p>HOTS SPENSA &copy; 2012 | Develop By <a href="#">Warman Suganda</a>  |  Design by <a href="http://chocotemplates.com">ChocoTemplates.com</a></p>
                </div>
                <div class="cl">&nbsp;</div>
            </div>
            <!-- End Footer -->
        </div>
        <!-- End Shell -->
    </body>
</html>