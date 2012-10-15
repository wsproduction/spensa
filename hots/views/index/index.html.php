


<div class="box">
    <div class="top">
        <div class="bottom">
            <div id="bigPic" style="float: left;">
                <?php
                $pic = '';
                foreach ($winners as $value) {
                    $profil = $value[1];
                    if ($profil['pic'] == '-')
                            $pic .= Src::image('face.gif', null, array('style' => 'width:280px;height:380px;', 'title' => $profil['name']));
                        else
                            $pic .= Src::image($profil['pic'], 'http://' . Web::$host . '/web/src/hots/asset/upload/images', array('style' => 'width:280px;height:380px;', 'title' => $profil['name']));

                }
                echo $pic;
                ?>
                <div id="info-slide">Warman Suganda</div>
            </div>    
            

            <!-- Videos -->
            <div class="right-col">
                <h2><a href="#" class="rss">&nbsp;</a> HOTS' WINNERS ( LAST WEEK )</h2>	

                <ul id="thumbs">
                    <?php
                    $thumbs = '';
                    $idx = 1;
                    foreach ($winners as $value) {
                        if ($idx == 1)
                            $thumbs .= '<li class="active" rel="' . $idx . '">';
                        else
                            $thumbs .= '<li rel="' . $idx . '">';

                        $thumbs .= '<div>';

                        $profil = $value[1];

                        if ($profil['pic'] == '-')
                            $thumbs .= Src::image('face.gif', null, array('style' => 'width:100px;height:135px;margin-right:20px;', 'title' => $profil['name']));
                        else
                            $thumbs .= Src::image($profil['pic'], 'http://' . Web::$host . '/web/src/hots/asset/upload/images', array('style' => 'width:100px;height:135px;margin-right:20px;', 'title' => $profil['name']));

                        $thumbs .= '</div>';
                        $thumbs .= '<div>' . strtoupper($value[0]) . '</div>';
                        $thumbs .= '</li>';
                        $idx++;
                    }
                    echo $thumbs;
                    ?>
                </ul>

            </div>
            <!-- End Videos -->
            <div class="cl">&nbsp;</div>
        </div>
    </div>
</div>

<!-- Box  -->
<div class="simple">
    <h2 class="no-border">HOTS CHART</h2>
    <div id="view_statistic"></div>
    <div class="cl">&nbsp;</div>
</div>
<!-- End Box  -->