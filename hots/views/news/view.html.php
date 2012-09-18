<!-- Box  -->
<div class="simple" style="min-height: 800px;">
    <h2><?php echo Web::getTitle(); ?></h2>
    <div style="margin: 10px 0;" class="view-news">
        <div class="title"><?php echo $dataNews['news_title'] ?></div>
        <div><?php echo date('l, d.m.Y',  strtotime($dataNews['news_title'])); ?> | Posted by admin</div>
        <div class="content"><?php echo $dataNews['news_content'] ?></div>
    </div>
</div>
<!-- End Box  -->