<div class="box-static">
    <div class="title">
        <div class="fl-left"><?php echo Web::getTitle(false); ?></div>
        <div class="fl-right">
            <a href="<?php echo $link_back; ?>" class="btn-red">Kembali</a>
        </div>
        <div class="cl">&nbsp;</div>
    </div>

    <div class="class-info box-green">
        <table class="fl-left" cellspacing="5" cellpadding="0">
            <tr>
                <td class="label">WALI KELAS</td>
                <td class="sparator">:</td>
                <td class="content"><?php echo $class_info['employess_name']; ?></td>
            </tr>
            <tr>
                <td class="label">TOTAL MENGAJAR</td>
                <td class="sparator">:</td>
                <td class="content"><?php echo $class_info['teaching_total_time'] . ' Jam'; ?></td>
            </tr>
        </table>
        <table class="fl-right" cellspacing="5" cellpadding="0">
            <tr>
                <td class="label">TAHUN AKADEMIK</td>
                <td class="sparator">:</td>
                <td class="content">
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
                <td class="label">MATA PELAJARAN</td>
                <td class="sparator">:</td>
                <td class="content">
                    <?php
                    Form::create('hidden', 'hidden_subject_id');
                    Form::value($class_info['subject_id']);
                    Form::commit();
                    echo $class_info['subject_name'];
                    ?>
                </td>
            </tr>
            <tr>
                <td class="label">KKM</td>
                <td class="sparator">:</td>
                <td class="content">
                    <?php
                    Form::create('hidden', 'hidden_mlc');
                    Form::value($class_info['mlc_value']);
                    Form::commit();
                    echo $class_info['mlc_value'];
                    ?>
                </td>
            </tr>
        </table>
        <div class="cl"></div>
    </div>

    <div class="description">Berikut adalah daftar nilai raport :</div>
    <div style="padding: 5px;">
        <table id="list-class" style="width: 100%" class="table-list" cellspacing="0" cellpadding="0" link_r="<?php echo $link_r; ?>">
            <thead>
                <tr>
                    <td align="center" class="first" colspan="3" style="border-bottom: none;">NOMOR</td>
                    <td rowspan="2" align="center">NAMA SISWA</td>
                    <td style="border-bottom: none;" align="center" colspan="4">NILAI AKHIR</td>
                </tr>
                <tr>
                    <td style="width: 30px;" align="center" class="first">URUT</td>
                    <td style="width: 60px;" align="center" >INDUK</td>
                    <td style="width: 65px;" align="center" >NISN</td>
                    <td style="width: 65px;" align="center" >RTS</td>
                    <td style="width: 65px;" align="center" >KETERANGAN</td>
                    <td style="width: 65px;" align="center" >RAS</td>
                    <td style="width: 65px;" align="center" >KETERANGAN</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="first" colspan="9">
                        <div class="information-box">
                            Loading...
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div id="box-detail" link="<?php echo $link_detail; ?>"></div>

<script type="text/javascript">
    $(function(){
        var read_base_competence = function() {
            var link = $('#list-class').attr('link_r');       
            var subject_id = $('#hidden_subject_id').val();
            var period_id = $('#hidden_period_id').val();
            var semester_id = $('#hidden_semester_id').val();
            var mlc = $('#hidden_mlc').val();            
            
            $(this).loadingProgress('start');
            
            $.post(link, { subject : subject_id,  period : period_id,  semester : semester_id, mlc : mlc}, function (o){
                $('#list-class').children('tbody').attr('count',o['count']);
                $('#list-class').children('tbody').html(o['row']);
                $("#list-class tbody tr td").css({"padding-top":"10px", "padding-bottom":"10px"});
                $(this).loadingProgress('stop');
            }, 'json');
        };
        
        read_base_competence();
        
        $('#box-detail').dialog({
            closeOnEscape: false,
            autoOpen: false,
            height: screen.height * 0.7,
            width: 700,
            modal: true,
            resizable: false,
            draggable: false,
            title : "Detail Nilai"
        });
        
        $('#list-class .detail').live('click',function(){
            $('#box-detail').html("Loading...").dialog('open').load($(this).attr('href'),{id : 1});
            return false;
        });
        
    });
</script>