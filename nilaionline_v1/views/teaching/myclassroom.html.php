<div class="box-static">
    <div>
        <div class="title fl-left"><?php echo Web::getTitle(false); ?></div>
        <div class="box-button fl-right">
            <a href="../../teaching" class="btn-green">Refresh</a>&nbsp;|
            <a id="button_save_mid_score" href="<?php echo $link_save_mid_score; ?>" class="btn-blue">Simpan</a>&nbsp;
            <a id="button_export_mid_score" href="<?php echo $link_export_midscore; ?>" class="btn-blue">Export</a>&nbsp;
            <a id="button_import_mid_score" href="#" class="btn-blue">Import</a>&nbsp;|
            <a id="" href="../../teaching" class="btn-red">Keluar</a>
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
                    Form::create('hidden', 'hidden_semester_id');
                    Form::value($class_info['semester_id']);
                    Form::commit();
                    echo $class_info['period_years_start'] . '/' . $class_info['period_years_end'] . ' - ' . $class_info['semester_name'];
                    ?>
                </td>
            </tr>
            <tr>
                <td><b>Mata Pelajaran</b></td>
                <td><b>:</b></td>
                <td>
                    <?php
                    Form::create('hidden', 'hidden_subject_id');
                    Form::value($class_info['subject_id']);
                    Form::commit();
                    echo $class_info['subject_name'];
                    ?>
                </td>
            </tr>
            <tr>
                <td><b>KKM</b></td>
                <td><b>:</b></td>
                <td>
                    <?php
                    Form::create('hidden', 'hidden_mlc');
                    Form::value($mlc_info['mlc_value']);
                    Form::commit();
                    echo $mlc_info['mlc_value'];
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
        <table id="list-mid-score" class="table-list" style="width: 100%;margin: 5px 0;" cellspacing="0" cellpading="0" action="<?php echo $link_red_mid_score; ?>">
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
            <tbody>
                <tr>
                    <td class="first" colspan="6">
                        <div class="information-box">
                            Loading...
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div id="box-import-mid-score">
    <?php
    Form::begin('form-import-mid-score', 'teaching/importmidscore', 'post', true);
    ?>
    <div>File Nilai :</div>
    <div>
        <?php
        Form::create('file', 'file');
        Form::validation()->requaired();
        Form::validation()->accept('xls');
        Form::commit();
        ?>
    </div>
    <div style="margin: 5px 0;">
        <?php
        Form::create('submit');
        Form::value('Upload');
        Form::commit();
        echo ' ';
        Form::create('button');
        Form::value('Tutup');
        Form::commit();
        ?>
    </div>
    <?php
    Form::end();
    ?>
</div>

<script type="text/javascript">
    $(function(){
        
        var is_empty = function(val) {
            if (val == '' || val == ' ' || val == null) {
                return true;
            } else {
                return false;
            }
        };
               
        $('.score_list').live('change', function() {
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
        
        var disabled_button = function(bool, button_id) {
            var $btn_save;
            for (var idx = 0; idx < button_id.length; idx++){
            
                $btn_save = $(button_id[idx]);
                
                if (bool) {
                    $btn_save.attr('disabled', 'disabled');
                    $btn_save.css({'opacity':'0.8','filter':'alpha(opacity=80)'});
                } else {
                    $btn_save.removeAttr('disabled');
                    $btn_save.css({'opacity':'1','filter':'alpha(opacity=100)'});
                }
            }
        };
        
        
        /* FINAL SCORE */
        
        disabled_button(true,['#button_save_mid_score','#button_export_mid_score','#button_import_mid_score']);
        
        var readMidScore = function() {
            var link = $('#list-mid-score').attr('action');
            var subject = $('#hidden_subject_id').val();
            var period = $('#hidden_period_id').val();
            var semester = $('#hidden_semester_id').val();
            var mlc = $('#hidden_mlc').val();
            
            $(this).loadingProgress('start');
            
            $.post(link, {subject:subject, period:period, semester:semester, mlc:mlc}, function (o){
                $('#list-mid-score').children('tbody').attr('count',o.count);
                $('#list-mid-score').children('tbody').html(o.row);
                
                $(this).loadingProgress('stop');
                disabled_button(false,['#button_save_mid_score','#button_export_mid_score','#button_import_mid_score']);
                if (o.count > 0) {
                    
                }
                
            }, 'json');
        };
        
        readMidScore();
        
        $('#fFilterMidScore').submit(function(){
            readMidScore();
            return false;
        });
        
        $('#button_save_mid_score').live('click', function(){
            var url = $(this).attr('link');
            var id = new Array();
            var val, nis;
            var subject = $('#hidden_subject_id').val();
            var period = $('#hidden_period_id').val();
            var semester = $('#hidden_semester_id').val();
            var error_count = 0;
            var $list;
            
            $(this).loadingProgress('start');
            
            for (var i = 1 ; i <= $('#list-mid-score').children('tbody').attr('count');i++) {
                $list = $('#list-mid-score #score_list_' + i);
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
                $.post(url, {subject:subject, period:period, semester:semester, data:id}, function(o){
                    if (o) {
                        alert('Data Nilai Telah Disimpan.');
                    } else {
                        alert('Data Nilai Gagal Disimpan.');
                    }
                    $(this).loadingProgress('stop');
                }, 'json');
            } else {
                $(this).loadingProgress('stop');
            }
            
            error_count = 0;
        });
                
        $('#button_export_mid_score').live('click', function(){
            var semester = $('#hidden_semester_id').val();
            window.location =  $(this).attr('link') + '_' + semester;
        });
        
        $('#box-import-mid-score').dialog({
            title : 'Import Nilai UTS',
            closeOnEscape: false,
            autoOpen: false,
            height: 180,
            width: 300,
            modal: true,
            resizable: false,
            draggable: true,
            open : function() {
                $(this).parent().children().children('.ui-dialog-titlebar-close').hide();
            }
        });
        
        $('#button_import_mid_score').live('click', function(){
            $("#box-import-mid-score").dialog( "open" );
        });
        
        $('#form-import-mid-score input[type=button]').live('click', function(){
            $("#box-import-mid-score").dialog( "close" );
        });
        
        $('#form-import-mid-score').live('submit',function(){
            disabled_button(true,['#form-import-mid-score input[type=button]','#form-import-mid-score input[type=submit]']);
            $(this).ajaxSubmit({
                success : function(o) {
                    disabled_button(false,['#form-import-mid-score input[type=button]','#form-import-mid-score input[type=submit]']);
                    $("#box-import-mid-score").dialog( "close" );
                    readMidScore();
                }
            });
            return false;
        });
        
    });
</script>