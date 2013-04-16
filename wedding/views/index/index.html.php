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

<div id="maps" class="content">Peta</div>

<div id="guestbook" class="content">
    <div class="fb-comments" data-href="http://www.warmanandfinny.tk" data-width="735" data-num-posts="3"></div>
    <div id="fb-root"></div>
</div>

<script type="text/javascript">
    $(function(){
        
        $('#gallery').fadeIn('slow');
        $('a[href=#gallery]').addClass('active');
        
        $('#slider').nivoSlider({
            animSpeed:1000,
            pauseTime:5000
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