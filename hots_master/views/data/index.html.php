<div class="myBox">
    <div class="title"><?php echo Web::$title; ?></div>
    <div class="content">
        <div class="boxfilter">
            <?php
            Form::begin('frmFilter');
            echo 'HOTS Subject : ';

            Form::create('select', 'hots_subject');
            Form::option($listSubject, 'All');
            Form::commit();

            Form::create('submit', 'btnFilter');
            Form::value('Filter');
            Form::commit();

            Form::end();
            ?>
        </div>
        <table class="flexme3" link="<?php echo $link; ?>" style="display: none;"></table>
    </div>
</div>
