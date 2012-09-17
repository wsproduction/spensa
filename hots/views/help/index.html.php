<!-- Box  -->
<div class="simple" style="min-height: 800px;">
    <h2><?php echo Web::getTitle(); ?></h2>
    <div style="margin-top:10px;">
        <iframe src="http://docs.google.com/gview?url=http://hots.smpn1subang.sch.id/hots/asset/web/upload/file/help_201209161347813537.pdf&embedded=true" style="width:600px; height:500px;" frameborder="0"></iframe>
    </div>
    <div style="margin: 0 10px 10px 0;padding: 10px 0;border-top:1px solid #ccc;">
        This link for Download Hots Helps : 
        <?php
        echo URL::link('http://' . Web::$host . '/project/download/help_201209161347813537.pdf','Click Here');
        ?>
    </div>
    <div>
        If you have any question about <b>HOTS SPENSA</b>, Please send Message to <u>hots@smpn1subang.sch.id</u><br>
        Or put message on <u>Testimony</u>
    </div>
</div>
<!-- End Box  -->