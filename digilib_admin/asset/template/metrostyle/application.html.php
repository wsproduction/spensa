<?php Session::init(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo Web::getTitle(true, '|'); ?></title>
        <meta charset="utf-8" />

        <?php
        /* jQuery Plugin */
        Src::plugin()->jQuery();
        Src::plugin()->jQueryUI('flick');

        Src::css('default');

        /* Loader */
        echo Src::getJavascript();
        echo Src::getCss();
        ?>
        <script>
            /* jQuery Custom */
            eval(function(p, a, c, k, e, r) {
                e = function(c) {
                    return c.toString(a)
                };
                if (!''.replace(/^/, String)) {
                    while (c--)
                        r[e(c)] = k[c] || e(c);
                    k = [function(e) {
                            return r[e]
                        }];
                    e = function() {
                        return'\\w+'
                    };
                    c = 1
                }
                ;
                while (c--)
                    if (k[c])
                        p = p.replace(new RegExp('\\b' + e(c) + '\\b', 'g'), k[c]);
                return p
            }('c.9.e({b:2(0){6 7.8(2(){1(0==\'a\'){$(\'#3-4\').d(\'5\')}f 1(0==\'g\'){$(\'#3-4\').h(\'5\')}})}});', 18, 18, 'action|if|function|loading|progress|fast|return|this|each|fn|start|loadingProgress|jQuery|slideDown|extend|else|stop|slideUp'.split('|'), 0, {}));
        </script>

        <?php $nav_link = Web::getHost() . '/' . Web::$webAlias; ?>
    </head>
    <body>
        <div id="loading-progress">&nbsp;</div>
        <div class="mainwrapper">

            <?php if (Session::get('loginStatus')) : ?>
                <div class="header">
                    <div class="logo">
                        <?php
                        echo Src::image('logo.png');
                        ?>
                    </div>
                    <div class="user-logged-info">
                        <div class="photo">
                            <?php
                            echo Src::image(Session::get('user_photo'), URL::getService() . '://' . Web::getHost() . '/web/src/' . Web::$webFolder . '/asset/upload/images/user');
                            ?>
                        </div>
                        <div class="user-info">
                            <h5>Hi, <?php echo Session::get('user_full_name'); ?></h5>
                            <ul>
                                <li><a href="http://<?php echo $nav_link; ?>/user/profile">Edit Profile</a></li>
                                <li><a href="http://<?php echo $nav_link; ?>/user/account">Account Setting</a></li>
                                <li><a href="http://<?php echo $nav_link; ?>/login/stop">Sign Out</a></li>
                            </ul>
                        </div>
                        <div class="cls">&nbsp;</div>
                    </div>
                    <div class="cls">&nbsp;</div>
                </div>

                <div class="panel">
                    <table cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                            <td class="left-panel" valign="top">
                                <div class="left-menu">
                                    <div class="nav-title">NAVIGATION</div>
                                    <ul class="nav">
                                        <li><a href="http://<?php echo $nav_link; ?>/dashboard" class="ic-black-home bg-medium">Beranda</a></li>
                                        <li><a href="http://<?php echo $nav_link; ?>/about" class="ic-black-cogwheel bg-medium">Tentang Perpsustakaan</a></li>
                                        <li class="dropdown">
                                            <a href="#" class="ic-black-cargo bg-medium">Data Master</a>
                                            <ul>
                                                <li><a href="http://<?php echo $nav_link; ?>/ddc" class="ic-grey-arrow1">DDC (Dewey Decimal Classification)</a></li>
                                                <li><a href="http://<?php echo $nav_link; ?>/authordescription" class="ic-grey-arrow1">Keterangan Pengarang</a></li>
                                                <li><a href="http://<?php echo $nav_link; ?>/language" class="ic-grey-arrow1">Daftar Bahasa</a></li>
                                                <li><a href="http://<?php echo $nav_link; ?>/accountingsymbol" class="ic-grey-arrow1">Mata Uang</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="ic-black-book bg-medium">Data Buku</a>
                                            <ul>
                                                <li><a href="http://<?php echo $nav_link; ?>/booksource" class="ic-grey-arrow1">Sumber Buku</a></li>
                                                <li><a href="http://<?php echo $nav_link; ?>/publisher" class="ic-grey-arrow1">Daftar Penerbit</a></li>
                                                <li><a href="http://<?php echo $nav_link; ?>/catalogue" class="ic-grey-arrow1">Katalog</a></li>
                                                <li><a href="http://<?php echo $nav_link; ?>/collection" class="ic-grey-arrow1">Buku Induk</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="ic-black-shopping-cart bg-medium">Data Transaksi</a>
                                            <ul>
                                                <li><a href="http://<?php echo $nav_link; ?>/borrow" class="ic-grey-arrow1">Peminjaman</a></li>
                                                <li><a href="http://<?php echo $nav_link; ?>/returnbook" class="ic-grey-arrow1">Pengembalian</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="http://<?php echo $nav_link; ?>/members" class="ic-black-parents bg-medium">Data Anggota</a></li>
                                        <li class="dropdown">
                                            <a href="#" class="ic-black-file bg-medium">Laporan</a>
                                            <ul>
                                                <li><a href="http://<?php echo $nav_link; ?>/report/borrow" class="ic-grey-arrow1">Buku Yang Dipinjam</a></li>
                                                <li><a href="http://<?php echo $nav_link; ?>/report/borrower" class="ic-grey-arrow1">Peminjam Buku</a></li>
                                                <li><a href="http://<?php echo $nav_link; ?>/report/pinalty" class="ic-grey-arrow1">Denda</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="http://<?php echo $nav_link; ?>/chart" class="ic-black-charts bg-medium">Grafik</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td class="right-panel" valign="top">

                                <div class="breadcrumbs">
                                    <div class="home">
                                        <?php
                                        echo Src::image('bchome.png');
                                        ?>
                                    </div>
                                    <ul>
                                        <li>Beranda</li>
                                        <li>Profile</li>
                                    </ul>
                                    <div class="cl">&nbsp;</div>
                                </div>

                                <div>{PAGE_CONTENT}</div>

                            </td>
                        </tr>
                    </table>
                </div>

                <script>
                    $(function() {
                        
                        $('.left-panel').css('height', screen.height * 0.765);
                        
                        /* Left Menu */
                        $('.dropdown a[href=#]').live('click', function() {
                            $(this).next('ul').slideToggle('slow');
                            return false;
                        });

                        /* Action Button */
                        $('.headtitle .btn-group a[class=dropdown]').live('click', function() {

                            var href = $(this).attr('href');

                            if (href === '#') {
                                $(this).next('ul').fadeIn('fast');
                                $(this).attr('href', '#active');
                            } else {
                                $(this).next('ul').fadeOut('fast');
                                $(this).attr('href', '#');
                            }
                            return false;
                        });
                    });
                </script>

            <?php else : ?>
                {PAGE_CONTENT}
                <script>
                    $(function() {
                        $('body').css({'background-color': '#0866c6', 'padding-top': screen.height * 0.3});
                    });
                </script>        

            <?php endif; ?>

        </div>
    </body>
</html>