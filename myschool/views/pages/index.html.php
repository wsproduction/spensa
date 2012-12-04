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
            $idx = 1;
            foreach ($page_menu[0] as $leve1) {
                $navposition = 'active';
                if ($idx > 1)
                    $navposition = '';
                $idx++;
                echo '<li><a target="ajax-adrress" class="' . $navposition . '" href="' . $root . '/' . $leve1['menu_link'] . '">' . $leve1['menu_title'] . '</a></li>';
            }
            ?>

            <li class="cofig">
                <div class="parent-title">Pilihan</div>
                <div class="content">
                    <ul>
                        <li>
                            <a href="<?php echo $root . '/teaching' ?>" class="black16-ic-bag">Tugas Mengajar</a>
                        </li>
                        <li>
                            <a href="<?php echo $root . '/percentase' ?>" class="black16-ic-percent">Persentase Nilai</a>
                        </li>
                        <li>
                            <a href="<?php echo $root . '/recapitulation' ?>"  class="black16-ic-cv">Rekapitulasi Nilai</a>
                        </li>
                    </ul>
                </div>
            </li>  
        </ul>
        <div class="cl">&nbsp;</div>
    </div>
    <div id="live-view-content-page" class="page-content"></div>
</div>

