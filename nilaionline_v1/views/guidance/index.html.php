<div id="cb-period">
    <?php
    $default_option_period_key = '';
    $default_option_period_value = '';
    if (count($option_period) > 0) {
        reset($option_period);
        $default_option_period_key = key($option_period);
        $default_option_period_value = current($option_period);
    }
    Form::create('hidden', 'hidden_option_period');
    Form::value($default_option_period_key);
    Form::commit();
    ?>
    <a id="cb-period-parent" class="slide-of">
        <span class="fl-left"><b>Tahun Akademik :</b></span>
        <span class="fl-right"><?php echo $default_option_period_value; ?></span>
    </a>
    <div class="cl">&nbsp;</div>
    <ul id="cb-period-child">
        <?php
        $list_period = '';
        foreach ($option_period as $keyperiod => $rowperiod) {
            $list_period .= '<li>';
            $list_period .= '   <a href="' . $keyperiod . '">';
            $list_period .= '       <span class="fl-right">' . $rowperiod . '</span>';
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
    <div class="class-info box-green">
        <table id="teacher-information" style="width: 100%;">
            <tr>
                <td class="label" style="width: 150px;">TAHUN AKADEMIK</td>
                <td class="sparator">:</td>
                <td id="view-period" class="content"><?php echo $default_option_period_value; ?></td>
            </tr>
            <tr>
                <td class="label">NIP</td>
                <td class="sparator">:</td>
                <td class="content">
                    <?php
                    $nip = '-';
                    if (!empty($teacher_info['employees_nip'])) {
                        $nip = $teacher_info['employees_nip'];
                    }
                    echo $nip;
                    ?>
                </td>
            </tr>
            <tr>
                <td class="label">NAMA LENGKAP</td>
                <td class="sparator">:</td>
                <td class="content"><?php echo $teacher_info['employess_name']; ?></td>
            </tr>
        </table>
        <div class="cl"></div>
    </div>
    <div class="description">Berikut adalah daftar tugas mengajar : </div>
    
    <div>
        <table id="list-teaching" cellspacing="0" cellpadding="0" link_r="<?php echo $link_r_teaching; ?>">
            <thead>
                <tr>
                    <td class="first" style="width: 40px;text-align: center;">No.</td>
                    <td style="width: 100px;text-align: center;">Nama Kelas</td>
                    <td style="width: 80px;text-align: center;">Jumlah Siswa</td>
                    <td>Wali Kelas</td>
                    <td style="width: 80px;text-align: center;">Last Update</td>
                    <td style="width: 200px;text-align: center;">Pilihan</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="first" colspan="4">
                        <div class="information-box">
                            Loading...
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
        
</div>

<script type="text/javascript">
    $(function(){
              
        var read_teaching = function() {
            var link = $('#list-teaching').attr('link_r');       
            var period = $('#hidden_option_period').val();
            
            var period_split = period.split('_');
            
            $(this).loadingProgress('start');
            
            $.post(link, { p : period_split[0],  s : period_split[1]}, function (o){
                $('#list-teaching').children('tbody').attr('count',o['count']);
                $('#list-teaching').children('tbody').html(o['row']);
                
                $(this).loadingProgress('stop');
                
            }, 'json');
        };
        
        read_teaching();
        
        /* Checkbox Period */
        $('#cb-period').live('click',function(){
            $(this).children('#cb-period-parent').removeClass().addClass('slide-on');
            $(this).children('#cb-period-child').slideDown('fast');
        }).mouseleave(function(){
            $(this).children('#cb-period-parent').removeClass().addClass('slide-of');
            $(this).children('#cb-period-child').slideUp('fast');
        });
        
        $('#cb-period #cb-period-child li a').live('click',function(){
            var oldid = $('#hidden_option_period').val();
            var newid = $(this).attr('href');
            var text = $(this).children('span').text();
            
            $('#view-period').text(text);
            
            $('#hidden_option_period').val(newid);
            $('#cb-period-parent').children('.fl-right').html($(this).children('.fl-right').html());
            
            $('#cb-period').children('#cb-period-parent').removeClass().addClass('slide-of');
            $('#cb-period').children('#cb-period-child').slideUp('fast');
            
            if (newid != oldid) {
                read_teaching();
            }
            
            return false;
        });
        
        $('#btn-guardian-page').live('click',function() {
            window.location = $(this).attr('href') + '/' + $(this).attr('guardian_id');
            return false;
        });
    });
</script>