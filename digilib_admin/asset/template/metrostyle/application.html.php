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
                            echo Src::image('photo.png');
                            ?>
                        </div>
                        <div class="user-info">
                            <h5>Hi, Warman Suganda</h5>
                            <ul>
                                <li><a href="">Edit Profile</a></li>
                                <li><a href="">Account Setting</a></li>
                                <li><a href="login/stop">Sign Out</a></li>
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
                                        <li><a href="" class="ic-black-home bg-medium">Beranda</a></li>
                                        <li class="dropdown"><a href="" class="ic-black-cargo bg-medium">Data Master</a></li>
                                        <li><a href="" class="ic-black-book bg-medium">Data Buku</a></li>
                                        <li><a href="" class="ic-black-shopping-cart bg-medium">Data Transaksi</a></li>
                                        <li><a href="" class="ic-black-parents bg-medium">Data Anggota</a></li>
                                        <li><a href="" class="ic-black-file bg-medium">Laporan</a></li>
                                        <li><a href="" class="ic-black-charts bg-medium">Grafik</a></li>
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

            <?php else : ?>
                {PAGE_CONTENT}
                <script>
                    $(function() {
                        $('body').css({'background-color' : '#0866c6', 'padding-top' : screen.height * 0.3});
                    });
                </script>        

            <?php endif; ?>

        </div>
    </body>
</html>