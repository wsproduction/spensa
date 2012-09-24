<!-- Box  -->
<div class="simple" style="min-height: 800px;">
    <h2><?php echo Web::getTitle(); ?></h2>
    <div style="margin-top:10px;">
        <iframe src="http://docs.google.com/gview?url=http://hots.smpn1subang.sch.id/hots/asset/web/upload/file/hots_help.pdf&embedded=true" style="width:600px; height:500px;" frameborder="0"></iframe>
    </div>
    <div style="margin: 0 10px 10px 0;padding: 10px 0;border-top:1px solid #ccc;">
        This link for Download Hots Helps : 
        <?php
        echo URL::link('http://' . Web::$host . '/project/download/hots_help.pdf','Click Here');
        ?>
    </div>
    <div>
        If you have any question about <b>HOTS SPENSA</b>, Please send Message to <u>hots@smpn1subang.sch.id</u>
    </div>
</div>
<!-- End Box  -->