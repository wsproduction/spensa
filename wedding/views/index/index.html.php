<div id="gallery" class="content">
    <div class="slider-wrapper theme-default">
        <div class="ribbon" style="display: none;">For Infromation</div>
        <div id="slider" class="nivoSlider">
            <?php
            echo Src::image('gallery/g1.jpg', null, array('style' => 'height:372px;'));
            ?>
        </div>
    </div>
</div>

<div id="invitation" class="content">Undangan</div>

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
            echo Src::image('big_map.jpg');
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

<div id="aboutaour" class="content">Tentang Kami</div>

<script type="text/javascript">
    $(function(){
        $('a[href=#gallery]').addClass('active');
        
        $('#slider').nivoSlider({
            animSpeed:1000,
            pauseTime:5000
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