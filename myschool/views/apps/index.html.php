<?php
$info = $apps_info[0];
$root = '/apps/load/' . $info['apps_alias'];
?>

<div id="for-css"></div>
<div id="for-script"></div>

<div class="apps">
    <div class="apps-banner">
        <div class="apps-title">
            <?php echo $info['apps_name']; ?>
        </div>
        <div class="apps-description">
            <?php echo $info['apps_short_description'] ?>
        </div>
    </div>
    <div id="list-m-nav-apps-top" class="apps-menu">
        <ul>
            <?php
            $idx = 1;
            foreach ($apps_menu[0] as $leve1) {
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
    <div id="live-view-content-apps"></div>
    <div class="cl">&nbsp;</div>
</div>

