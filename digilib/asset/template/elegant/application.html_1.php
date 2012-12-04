<?php Session::init(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo Web::getTitle(true, '|'); ?></title>
        <meta charset="utf-8" />

        <?php
        Src::icon('icon.png');
        Src::css('construct.css');
        Src::css('layout.css');
        Src::css('custom.css');

        /* Loader */
        Src::getJavascript();
        Src::getCss();
        ?>
        
    </head>
    <body>
        <center>
            <div id="bones">
                <div id="header">
                    <?php Src::image('rsbi.png', null,array('style'=>'position: relative;top:-6px;float:right;margin:29px 20px 0 0;')); ?>
                    <?php Src::image('anab.png', null,array('style'=>'position: relative;top:-6px;float:right;margin:25px 10px 0 0;')); ?>
                    <?php Src::image('twh.png', null,array('style'=>'position: relative;top:-6px;float:right;margin:25px 10px 0 0;')); ?>
                </div>
                <div id="page_menu">
                    <ul id="navigation" class="dropdown">
                        <li><a href="<?php echo 'http://' . Web::$host . '/index'; ?>" style="padding: 6px 10px 5px 10px;"><?php Src::image('home.png', null); ?></a></li>
                        <li>
                            <?php URL::link('http://' . Web::$host . '/index', 'About'); ?>
                            <ul style="width: 200px;">
                                <li><a href="#">Principal Welcome</a></li>
                                <li><a href="#">MAP Location</a></li>
                                <li><a href="#">History</a></li>
                                <li><a href="#">Top Officer</a></li>
                                <li><a href="#">Teachers</a></li>
                                <li><a href="#">Staff</a></li>
                                <li><a href="#">Cooperation</a></li>
                            </ul>
                        </li>
                        <li><?php URL::link('http://' . Web::$host . '/profile', 'Awards'); ?></li>
                        <li>
                            <?php URL::link('http://' . Web::$host . '/profile', 'Facility'); ?>
                            <ul style="width: 200px;">
                                <li><a href="#">Buliding Facility</a></li>
                                <li><a href="#">Online Facility</a></li>
                            </ul>
                        </li>
                        <li><?php URL::link('http://' . Web::$host . '/profile', 'Gallery Photo'); ?></li>
                        <li><?php URL::link('http://' . Web::$host . '/profile', 'Contact Us'); ?></li>
                    </ul>
                </div>
                <div id="baner">
                    <?php Src::image('baner.jpg', null,array()); ?>
                </div>
                <div id="info">
                    <div class="navigator">
                        Home
                    </div>
                    <div class="translator">
                        <?php Src::image('english_flag.png', null,array('style'=>'margin-right:4px;','title'=>'English Language')); ?> 
                        <?php Src::image('indonesia_flag.png', null,array('title'=>'Bahasa Indonesia')); ?>
                    </div>
                    <div class="search">
                        <?php 
                            Src::image('search.png', null, array('style'=>'position:relative;top:8px;float:left;'));
                            Form::begin('searching', 'login/run', 'post');

                            Form::create('text', 'keyword');
                            Form::value('insert search keywords..');
                            Form::tips('Please enter keyword');
                            Form::commit();

                            Form::create('submit');
                            Form::value('Search');
                            Form::commit();

                            Form::end();
                        ?>
                    </div>
                </div>
                <div id="content">
                    {PAGE_CONTENT}
                </div>
                <div id="footer">
                    <div>&COPY;2010 E-Commerce Portal | Powered by WSFramework</div>
                    <div style="margin-top: 2px;">Supported :</div>
                    <div><?php Src::image('ws_black.png', null, array('style' => 'width:100px')); ?></div>
                </div>
            </div>
        </center>
    </body>
</html>