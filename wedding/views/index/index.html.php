<div id="gallery" class="content">
    <div class="slider-wrapper theme-default">
        <div class="ribbon" style="display: none;">For Infromation</div>
        <div id="slider" class="nivoSlider">
            <?php
            echo Src::image('gallery/g3.jpg', null, array('style' => 'height:372px;'));
            echo Src::image('gallery/g1.jpg', null, array('style' => 'height:372px;'));
            echo Src::image('gallery/g8.jpg', null, array('style' => 'height:372px;'));
            echo Src::image('gallery/g4.jpg', null, array('style' => 'height:372px;'));
            echo Src::image('gallery/g5.jpg', null, array('style' => 'height:372px;'));
            echo Src::image('gallery/g7.jpg', null, array('style' => 'height:372px;'));
            echo Src::image('gallery/g9.jpg', null, array('style' => 'height:372px;'));
            echo Src::image('gallery/g2.jpg', null, array('style' => 'height:372px;'));
            echo Src::image('gallery/g6.jpg', null, array('style' => 'height:372px;'));
			
            ?>
        </div>
    </div>
</div>

<div id="invitation" class="content">
    <div style="text-align: center;">
        <?php
        echo Src::image('undangan_small.jpg', null, array('style' => 'height:370px;', 'class'=>'invitation'));
        ?>
    </div>
    <div class="cl">&nbsp;</div>
</div>

<div id="maps" class="content">
    <div class="title">Peta Lokasi</div>
    <div class="view-map">
        <div class="small">
            <?php
            echo Src::image('maps.jpg');
            ?>
        </div>
        <div class="big" style="display: none;">
            <?php
            echo Src::image('big_maps.jpg');
            ?>
        </div>
    </div>
    <div class="note">
        <div><b>Catatan :</b></div>
        <div>Klik pada gambar untuk memperbesar peta, untuk mendownload peta siliah klik tombol dibawah ini!</div>
        <div class="box-button"><button id="button-download">Donwload</button></div>
    </div>
    <div class="cl">&nbsp;</div>
</div>

<div id="guestbook" class="content">
    <div class="title">
        Buku Tamu
    </div>
    <div class="list">
        <div class="fb-comments" data-href="http://www.warmanandfinny.tk" data-width="735" data-num-posts="2"></div>
        <div id="fb-root"></div>
    </div>
</div>

<div id="aboutaour" class="content">
    <div class="title">Profile :</div>
    <div>
        <div style="float: left;">
            <table style="width: 350px;" >
                <tr>
                    <td style="width: 125px;">
                        <?php
                        echo Src::image('w.jpg', null, array('class' => 'pp'));
                        ?>
                    </td>
                    <td valign="top">
                        <div class="label">Nama:</div>
                        <div class="content-text">Warman Suganda, S.Kom.</div>
                        <div class="label" style="margin-top: 5px;">Tempat & Tanggal Lahir:</div>
                        <div class="content-text">Subang, 24 September 1988</div>
                        <div class="label" style="margin-top: 5px;">Anak dari:</div>
                        <div class="content-text">Bp. Rustim & Ibu. Engkal</div>
                        <div class="label" style="margin-top: 5px;">Alamat:</div>
                        <div class="content-text">Kp. Jawura RT. 08/03 Ds. Sumbersari Kec. Pagaden Kab. Subang, Jawa Barat.</div>
                    </td>
                </tr>
            </table>
        </div>
        <div style="float: right;">
            <table style="width: 350px;" >
                <tr>
                    <td style="width: 125px;">
                        <?php
                        echo Src::image('f.jpg', null, array('class' => 'pp'));
                        ?>
                    </td>
                    <td valign="top">
                        <div class="label">Nama:</div>
                        <div class="content-text">Finny Alviani, A.Md.Keb</div>
                        <div class="label" style="margin-top: 5px;">Tempat & Tanggal Lahir:</div>
                        <div class="content-text">Subang, 24 September 1988</div>
                        <div class="label" style="margin-top: 5px;">Anak dari:</div>
                        <div class="content-text">Bp. Dadang Priadi & Ibu. Atin Suhartini</div>
                        <div class="label" style="margin-top: 5px;">Alamat:</div>
                        <div class="content-text">Kp. Nanggerang RT. 03/01 Ds. Karangsari Kec. Binong Kab. Subang, Jawa Barat.</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="cl">&nbsp;</div>
    </div>
    <div class="title" style="margin-top: 10px;">Thanks to :</div>
    <div class="content-text">
        Puji syukur kami panjatkan kepada Allah SWT yang telah memberikan rahmat dan karunianya kepada kami, Solawat serta salam kami ucapkan kepada junjungan Nabi besar Muhammad SAW yang telah menunjukkan kami dari jalan yang gelap gulita menuju jalan yang terang benderang.
        Segenap keluarga besar yang senantiasa membantu baik berupa moril maupun materil, Saudara, Sahabat, Teman dan Rekan-rekan yang tidak dapat disebutkan satu persatu.
        Dan tak lupa pula kami ucapkan terimakasih kepada Rd. Rahadian Kusuma (Pre Wedding Photographer), Warman Suganda (Photo Editing), Mamah Icha (Tata Rias), dll. Thanks All...
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $('a[href=#gallery]').addClass('active');
        
        $('#slider').nivoSlider({
            animSpeed:1000,
            pauseTime:4000
        });
        
        $('.view-map').live('click', function() {
            $('.big').dialog('open');
        });
        
        $('.big').dialog({
            title : 'Peta Lokasi',
            closeOnEscape: true,
            autoOpen: false,
            height: 560,
            width: 930,
            modal: true,
            resizable: false,
            draggable: false
        }); 
        
        $('#button-download').button({
            icons: {
                primary: "ui-icon-image"
            }
        }).live('click', function(){
            window.location = 'index/download/big_maps.jpg';
        });
    });
</script>
<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>