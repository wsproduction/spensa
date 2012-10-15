<?php
$info = $page_info[0];
$root = '/pages/load/' . $info['page_alias'];
?>

<div id="for-css"></div>
<div id="for-script"></div>

<div class="page">
    <div class="page-banner">
        <div class="page-title">
            <?php echo $info['page_name']; ?>
        </div>
        <div class="page-description">
            <?php echo $info['page_short_description'] ?>
        </div>
    </div>
    <div id="list-m-nav-page-top" class="page-menu">
        <ul>
            <?php
            foreach ($page_menu[0] as $leve1) {
                echo '<li><a target="ajax-adrress" class="active" href="' . $root . '/' . $leve1['menu_link'] . '">' . $leve1['menu_title'] . '</a></li>';
            }
            ?>
        </ul>
        <div class="cl">&nbsp;</div>
    </div>
    <div id="live-view-content-page" class="page-content"></div>
</div>

