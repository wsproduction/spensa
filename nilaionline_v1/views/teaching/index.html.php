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
        <table id="teacher-information" cellspacing="6" cellpadding="5" style="width: 100%;">
            <tr>
                <td><b>Tahun Akademik</b></td>
                <td><b>:</b></td>
                <td id="view-period"><?php echo $default_option_period_value; ?></td>
            </tr>
            <tr>
                <td style="width: 120px;"><b>NIP</b></td>
                <td><b>:</b></td>
                <td>
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
                <td style="width: 120px;"><b>Nama Lengkap</b></td>
                <td><b>:</b></td>
                <td><?php echo $teacher_info['employess_name']; ?></td>
            </tr>
            <tbody id="guardian-information" link_r="<?php echo $link_guardian_information; ?>" style="display: none;">
                <tr>
                    <td style="width: 120px;padding-bottom: 5px;"><b>Wali Kelas</b></td>
                    <td style="padding-bottom: 5px;"><b>:</b></td>
                    <td  style="padding-bottom: 5px;"id="view-guardian-information"></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;border-top:1px dashed green;padding-top: 10px;">
                        <div class="fl-left" style="padding-top: 5px;font-style: italic;font-weight: bold;color: green;">
                            Untuk masuk ke halaman wali kelas silahkan klik tombol di samping kanan!
                        </div>
                        <div class="fl-right">
                            <?php
                            Form::create('button', 'btn-guardian-page');
                            Form::value('Halaman Wali Kelas [+]');
                            Form::style('btn-blue');
                            Form::properties(array('link' => $link_guardian));
                            Form::commit();
                            ?>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="cl"></div>
    </div>
    <div class="description">Berikut adalah daftar tugas mengajar : </div>
    <div style="padding: 5px;"><b>&bullet; MATA PELAJARAN</b></div>
    <div>
        <table id="list-teaching" cellspacing="0" cellpadding="0" link_r="<?php echo $link_r_teaching; ?>">
            <thead>
                <tr>
                    <td class="first" style="width: 40px;text-align: center;">No.</td>
                    <td>Mata Pelajaran</td>
                    <td style="width: 240px;text-align: center;">Kelas</td>
                    <td style="width: 100px;text-align: center;">Total Mengajar</td>
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
    <div style="padding: 5px;"><b>&bullet; PENDIDIKAN BERBASIK KEUNGGULAN LOKAL (PBKL)</b></div>
    <div style="padding: 5px;">
        <table id="list-teaching-pbkl" style="width: 100%" class="table-list"  cellspacing="0" cellpadding="0" link_r="<?php echo $link_r_teaching_pbkl; ?>">
            <thead>
                <tr>
                    <td class="first" style="width: 50px;text-align: center;">No.</td>
                    <td>Nama PBKL</td>
                    <td style="width: 100px;text-align: center;">Total Mengajar</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="first" colspan="3">
                        <div class="information-box">
                            Data mengajar tidak ditemukan.
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="padding: 5px;"><b>&bullet; PENGEMBANGAN DIRI</b></div>
    <div style="padding: 5px;">
        <table id="list-teaching-ekskul" style="width: 100%" class="table-list"  cellspacing="0" cellpadding="0" link_r="<?php echo $link_r_teaching_ekskul; ?>">
            <thead>
                <tr>
                    <td class="first" style="width: 50px;text-align: center;">No.</td>
                    <td>Nama Kegiatan</td>
                    <td style="width: 100px;text-align: center;">Total Mengajar</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="first" colspan="3">
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
        
        var read_guardian_information = function() {
            var link = $('#guardian-information').attr('link_r');       
            var period = $('#hidden_option_period').val();
            
            var period_split = period.split('_');
            $(this).loadingProgress('start');
            
            $.post(link, { p : period_split[0],  s : period_split[1]}, function (o){
                if (o[0]) {
                    var info = o[1];
                    var class_info = info['grade_title'] + ' (' + info['grade_name'] + ') ' + info['classroom_name'];
                    $('#btn-guardian-page').attr('guardian_id', info['classgroup_id']);
                    $('#view-guardian-information').text(class_info);
                    $("#guardian-information").fadeIn("slow");
                } else {
                    $("#guardian-information").fadeOut("slow");
                }
            }, 'json');
        };
        
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
        
        var read_pbkl = function() {
            var link = $('#list-teaching-pbkl').attr('link_r');       
            var period = $('#hidden_option_period').val();
            
            var period_split = period.split('_');
            
            $(this).loadingProgress('start');
            
            $.post(link, { p : period_split[0],  s : period_split[1]}, function (o){
                $('#list-teaching-pbkl').children('tbody').attr('count',o['count']);
                $('#list-teaching-pbkl').children('tbody').html(o['row']);
                
                $(this).loadingProgress('stop');
                
            }, 'json');
        };
        
        var read_eksul = function() {
            var link = $('#list-teaching-ekskul').attr('link_r');       
            var period = $('#hidden_option_period').val();
            
            var period_split = period.split('_');
            
            $(this).loadingProgress('start');
            
            $.post(link, { p : period_split[0],  s : period_split[1]}, function (o){
                $('#list-teaching-ekskul').children('tbody').attr('count',o['count']);
                $('#list-teaching-ekskul').children('tbody').html(o['row']);
                
                $(this).loadingProgress('stop');
                
            }, 'json');
        };
        
        read_guardian_information();
        read_teaching();
        /* read_pbkl(); */
        read_eksul();
        
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
                read_guardian_information();
                read_teaching();
                read_eksul();
            }
            
            return false;
        });
        
        $('#btn-guardian-page').live('click',function() {
            window.location = $(this).attr('link') + '/' + $(this).attr('guardian_id');
        });
    });
</script>