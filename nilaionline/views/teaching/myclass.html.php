
<div class="box-static">
    <div>
        <div class="title fl-left"><?php echo Web::getTitle(false); ?></div>
        <div class="box-button fl-right">
            <a href="../../teaching" class="btn-nav-grey">Daftar Siswa</a>
            <a href="../../teaching" class="btn-nav-grey">Penilaian</a> &nbsp;
            <a href="../../teaching" class="btn-blue">Keluar Kelas</a>
        </div>
        <div class="cl"></div>
    </div>
    <div class="class-info box-green">
        <table class="fl-left" cellspacing="5" cellpadding="0">
            <tr>
                <td><b>Wali Kelas</b></td>
                <td><b>:</b></td>
                <td><?php echo $class_info['employess_name']; ?></td>
            </tr>
            <tr>
                <td><b>Total Mengajar</b></td>
                <td><b>:</b></td>
                <td><?php echo $class_info['teaching_total_time'] . ' Jam'; ?></td>
            </tr>
        </table>
        <table class="fl-right" cellspacing="5" cellpadding="0">
            <tr>
                <td><b>Tahun Akademik</b></td>
                <td><b>:</b></td>
                <td>
                    <?php
                    Form::create('hidden', 'hidden_period_id');
                    Form::value($class_info['period_id']);
                    Form::commit();
                    echo $class_info['period_years_start'] . '/' . $class_info['period_years_end'] . ' - Semester 1';
                    ?>
                </td>
            </tr>
            <tr>
                <td><b>Mata Pelajaran</b></td>
                <td><b>:</b></td>
                <td><?php echo $class_info['subject_name']; ?></td>
            </tr>
            <tr>
                <td><b>KKM</b></td>
                <td><b>:</b></td>
                <td>
                    <?php
                    echo $class_info['mlc_value'];
                    Form::create('hidden', 'hidden_mlc');
                    Form::value($class_info['mlc_value']);
                    Form::commit();
                    ?>
                </td>
            </tr>
        </table>
        <div class="cl"></div>
    </div>
    <div id="box-student-list" style="display: none;">
        <table class="table-list" style="width: 100%" cellspacing="0" cellpading="0">
            <thead>
                <tr>
                    <td style="width: 50px;" align="center" class="first">No</td>
                    <td style="width: 100px;" align="center" >NIS</td>
                    <td style="width: 120px;" align="center" >NISN</td>
                    <td>Nama</td>
                    <td style="width: 120px;" align="center" >Jenis Kelamin</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $html_list = '';
                $no = 1;
                foreach ($student_list as $row) {
                    $html_list .= '<tr>';
                    $html_list .= '     <td align="center" class="first">' . $no . '</td>';
                    $html_list .= '     <td align="center">' . $row['student_nis'] . '</td>';
                    $html_list .= '     <td align="center">' . $row['student_nisn'] . '</td>';
                    $html_list .= '     <td>' . $row['student_name'] . '</td>';
                    $html_list .= '     <td align="center">' . $row['gender_title'] . '</td>';
                    $html_list .= '</tr>';
                    $no++;
                }
                echo $html_list;
                ?>
            </tbody>
        </table>
    </div>
    <div id="box-score">
        <div id="tabs-score" style="width: 99%;">
            <ul>
                <li><?php URL::link('#fragment-1', 'Nilai Harian') ?></li>
                <li><?php URL::link('#fragment-2', 'Tugas') ?></li>
                <li><?php URL::link('#fragment-3', 'Sikap') ?></li>
                <li><?php URL::link('#fragment-3', 'Ulangan Tengah Semester') ?></li>
                <li><?php URL::link('#fragment-3', 'Ulangan Umum') ?></li>
            </ul>
            <div id="fragment-1">
                <?php
                Form::begin('fFilterDailyScore', 'teaching/readdailyscore/' . $class_info['classgroup_id'], 'post', true);
                ?>
                <table style="width: 100%">
                    <tr>
                        <td style="width: 210px;">Kompetensi Dasar :</td>
                        <td style="width: 60px;">Type :</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            Form::create('select', 'base_competence');
                            Form::option($option_basecompetance);
                            Form::properties(array('style' => 'width:200px;'));
                            Form::commit();
                            ?>
                        </td>
                        <td>
                            <?php
                            Form::create('select', 'score_type');
                            Form::option($option_scoretype);
                            Form::properties(array('style' => 'width:50px;'));
                            Form::commit();
                            ?>
                        </td>
                        <td>
                            <?php
                            Form::create('submit', 'base_competence');
                            Form::value('Filter');
                            Form::commit();
                            ?>
                        </td>
                        <td align="right">
                            <?php
                            Form::create('button', 'button_save');
                            Form::value('Simpan');
                            Form::properties(array('link' => $link_save_daily_score));
                            Form::commit();
                            echo ' | ';
                            Form::create('button', 'button_export');
                            Form::properties(array('link' => $link_export_dailyscore));
                            Form::value('Export');
                            Form::commit();
                            echo ' ';
                            Form::create('button', 'button_import');
                            Form::value('Import');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                </table>
                <?php
                Form::end();
                ?>
                <table id="list-daily-score" class="table-list" style="width: 100%;margin: 5px 0;" cellspacing="0" cellpading="0">
                    <thead>
                        <tr>
                            <td align="center" class="first" colspan="3" style="border-bottom: none;">NOMOR</td>
                            <td rowspan="2" align="center">NAMA SISWA</td>
                            <td style="width: 100px;" align="center" rowspan="2">NILAI</td>
                            <td style="width: 100px;" align="center" rowspan="2">KETERANGAN</td>
                        </tr>
                        <tr>
                            <td style="width: 40px;" align="center" class="first">URUT</td>
                            <td style="width: 80px;" align="center" >INDUK</td>
                            <td style="width: 80px;" align="center" >NISN</td>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div id="fragment-2">2</div>
            <div id="fragment-3">3</div>
        </div>
    </div>
</div>

<div id="box-import-daily-score">Import</div>

</div>

<script type="text/javascript">
    $(function(){
        
        var $score_list = $('.score_list');
        
        $("#tabs-score").tabs();
       
        $score_list.live('change', function() {
            var mlc = $('#hidden_mlc').val();
            var val = $(this).val();
            var order = $(this).attr('order');
            var desc = '-';
            if (val!='') {
                if (parseInt(val) > parseInt(mlc)) {
                    desc = 'Terlampaui';
                } else if (parseInt(val) == parseInt(mlc)){
                    desc = 'Tercapai';
                } else {
                    desc = 'Tidak Tercapai';
                }
            }
            
            $('.desc_' + order).html(desc);
        });
        
        $('#button_save').live('click', function(){
            var url = $(this).attr('link');
            var id = new Array();
            var val, nis;
            var period = $('#hidden_period_id').val();
            var base_competence = $('#base_competence').val();
            var score_type = $('#score_type').val();
            var error_count = 0;
            
            $(this).loadingProgress('start');
            
            for (var i = 1 ; i <= $('#list-daily-score').children('tbody').attr('count');i++) {
                $list = $('#score_list_' + i);
                nis = $list.attr('order');
                val = $list.val();
                id[i] = [nis,val];
                if ( parseInt(val) >= 0 && parseInt(val) <= 100) {
                    $list.css('border','1px solid #ccc');
                } else {
                    $list.css('border','1px solid red');
                    error_count++;
                }
            }
                
            if (error_count == 0) {
                $.post(url, {period:period, data:id, base_competence:base_competence, score_type:score_type}, function(o){
                    if (o) {
                        alert('Data Nilai Telah Disimpan.');
                    } else {
                        alert('Data Nilai Gagal Disimpan.');
                    }
                    $(this).loadingProgress('stop');
                }, 'json');
            }
            
            error_count = 0;
        });
        
        var readDailyScore = function() {
            var link = $('#fFilterDailyScore').attr('action');
            var period = $('#hidden_period_id').val();
            var base_competence = $('#base_competence').val();
            var score_type = $('#score_type').val();
            var mlc = $('#hidden_mlc').val();
            
            $(this).loadingProgress('start');
            
            $.post(link, {period:period, base_competence:base_competence, score_type:score_type, mlc:mlc}, function (o){
                $('#list-daily-score').children('tbody').attr('count',o['count']);
                $('#list-daily-score').children('tbody').html(o['row']);
                
                $(this).loadingProgress('stop');
                
            }, 'json');
        };
        
        readDailyScore();
        
        $('#fFilterDailyScore').submit(function(){
            readDailyScore();
            return false;
        });
        
        $('#box-import-daily-score').dialog({
            closeOnEscape: false,
            autoOpen: false,
            height: screen.height - 200,
            width: 700,
            modal: true,
            resizable: false,
            draggable: false,
            open : function() {
                $(this).parent().children().children('.ui-dialog-titlebar-close').hide();
            }
        });
        
        $('#button_import').live('click', function(){
            $("#box-import-daily-score").dialog( "open" );
        });
        
        $('#button_export').live('click', function(){
            var base_competence = $('#base_competence').val();
            var score_type = $('#score_type').val();
            window.location =  $(this).attr('link') + '_' + base_competence + '_' + score_type;
        });
        
    });
</script>