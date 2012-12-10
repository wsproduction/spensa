<div id="cb-period">
    <a id="cb-period-parent" class="slide-of">
        <span class="fl-left"><b>Tahun Akademik :</b></span>
        <span class="fl-right">2012 / 2013 - Semester 1</span>
    </a>
    <div class="cl">&nbsp;</div>
    <ul id="cb-period-child">
        <?php
        $list_period = '';
        foreach ($option_period as $keyperiod => $rowperiod) {
            $list_period .= '<li>';
            $list_period .= '   <a rel="#' . $keyperiod . '">';
            $list_period .= '       <span id="201220131" class="fl-right">' . $rowperiod . '</span>';
            $list_period .= '   </a>';
            $list_period .= '</li>';
        }
        echo $list_period;
        ?>
    </ul>
</div>

<div class="hr"></div>

<div class="box-static">
    <div class="title"><?php echo Web::getTitle(false); ?></div>
    <div class="description">Berikut adalah daftar mengajar Warman Suaganda Pada Tahun Akademik 2012/2013.</div>
    <div>
        <table id="list-teaching" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <td class="first" style="width: 50px;text-align: center;">No.</td>
                    <td>Mata Pelajaran</td>
                    <td style="width: 240px;text-align: center;">Kelas</td>
                    <td style="width: 100px;text-align: center;">Total Mengajar</td>
                </tr>
            </thead>
            <tbody>
                <?php echo $teaching_list; ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        
        /* Checkbox Period */
        $('#cb-period').live('click',function(){
            $(this).children('#cb-period-parent').removeClass().addClass('slide-on');
            $(this).children('#cb-period-child').slideDown('fast');
        }).mouseleave(function(){
            $(this).children('#cb-period-parent').removeClass().addClass('slide-of');
            $(this).children('#cb-period-child').slideUp('fast');
        });
        
        $('#cb-period #cb-period-child ul li a').live('click',function(){
            alert('ss');
        })
        
    });
</script>