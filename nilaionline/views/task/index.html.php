<div class="box-static">
    <div class="title">
        <div class="fl-left"><?php echo Web::getTitle(false); ?></div>
        <div class="fl-right">
            <a href="#box-add-data" rel="dialog" class="btn-blue">Tambah Data</a>&nbsp;<a href="../../teaching" class="btn-blue">Kembali</a>
        </div>
        <div class="cl">&nbsp;</div>
    </div>

    <div class="class-info box-green">
        <table class="fl-left" cellspacing="5" cellpadding="0">
            <tr>
                <td style="width: 120px;"><b>Mata Pelajaran</b></td>
                <td><b>:</b></td>
                <td>
                    <?php
                    Form::create('hidden', 'hidden_subject_id');
                    Form::value($subject_info['subject_id']);
                    Form::commit();
                    echo $subject_info['subject_name'];
                    ?>
                </td>
            </tr>
            <tr>
                <td><b>Tahun Akademik</b></td>
                <td><b>:</b></td>
                <td>
                    <?php
                    Form::create('hidden', 'hidden_period_id');
                    Form::value($period_info['period_id']);
                    Form::commit();
                    Form::create('hidden', 'hidden_semester_id');
                    Form::value($semester_info['semester_id']);
                    Form::commit();
                    echo $period_info['period_years_start'] . ' / ' . $period_info['period_years_end'] . ' - ' . $semester_info['semester_name'];
                    ?>
                </td>
            </tr>
            <tr>
                <td><b>Kelas</b></td>
                <td><b>:</b></td>
                <td>
                    <?php
                    Form::create('hidden', 'hidden_grade_id');
                    Form::value($grade_info['grade_id']);
                    Form::commit();
                    echo $grade_info['grade_title'] . ' (' . $grade_info['grade_name'] . ')';
                    ?>
                </td>
            </tr>
        </table> 
        <div class="cl">&nbsp;</div>
    </div>

    <div class="description">Berikut adalah daftar tugas :</div>
    <div style="padding: 5px;">
        <table id="list-task" style="width: 100%" class="table-list" cellspacing="0" cellpadding="0" link_r="<?php echo $link_r_task; ?>" link_d="<?php echo $link_d_task; ?>">
            <thead>
                <tr>
                    <td class="first" style="width: 50px;text-align: center;" >No.</td>
                    <td>Keterangan Tugas</td>
                    <td style="width: 100px;text-align: center;">Last Update</td>
                    <td style="width: 100px;text-align: center;">Pilihan</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="first" colspan="5">
                        <div class="information-box">
                            Loading...
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div id="box-add-data">
    <?php
    Form::begin('fAddData', 'task/create', 'post', true);
    ?>

    <table cellspacing="2" cellpadding="2">
        <tr>
            <td style="width: 120px;">Judul</td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'task_title');
                Form::size(50);
                Form::validation()->requaired();
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td>
                <?php
                Form::create('textarea', 'task_description');
                Form::size(50,3);
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>
                <?php
                Form::create('submit');
                Form::value('Simpan');
                Form::commit();
                echo '&nbsp;';
                Form::create('reset');
                Form::value('Batal');
                Form::commit();
                ?>
            </td>
        </tr>
    </table>

    <?php
    Form::end();
    ?>
</div>

<div id="box-edit-data">
    <?php
    Form::begin('fEditData', 'task/update', 'post', true);
    Form::create('hidden', 'base_competence_id');
    Form::commit();
    ?>

    <table cellspacing="2" cellpadding="2">
        <tr>
            <td style="width: 120px;">Judul</td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'task_title');
                Form::size(50);
                Form::validation()->requaired();
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td>
                <?php
                Form::create('textarea', 'task_description');
                Form::size(50,3);
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>
                <?php
                Form::create('submit');
                Form::value('Simpan');
                Form::commit();
                echo '&nbsp;';
                Form::create('reset');
                Form::value('Batal');
                Form::commit();
                ?>
            </td>
        </tr>
    </table>

    <?php
    Form::end();
    ?>
</div>

<div id="dialog-confirm-delete">
    Anda yakin akan menghapus?
</div>

<script type="text/javascript">
    $(function(){
        
        var read_base_competence = function() {
            var link = $('#list-task').attr('link_r');       
            var subject_id = $('#hidden_subject_id').val();
            var period_id = $('#hidden_period_id').val();
            var semester_id = $('#hidden_semester_id').val();
            var grade_id = $('#hidden_grade_id').val();            
            
            $(this).loadingProgress('start');
            
            $.post(link, { subject : subject_id,  period : period_id,  semester : semester_id, grade : grade_id}, function (o){
                $('#list-task').children('tbody').attr('count',o['count']);
                $('#list-task').children('tbody').html(o['row']);
                $(this).loadingProgress('stop');
            }, 'json');
        };
        
        read_base_competence();
        
        var delete_base_competence = function(id) {
            var link = $('#list-task').attr('link_d');
            $(this).loadingProgress('start');
            $.post(link, { id : id}, function (o){
                if (o) {
                    $( "#dialog-confirm-delete" ).dialog('close');
                    read_base_competence();
                }
            }, 'json');
        };
        
        $('#box-add-data').dialog({
            title : 'Tambah Tugas',
            closeOnEscape: false,
            autoOpen: false,
            height: 180,
            width: 500,
            modal: true,
            resizable: false,
            draggable: true
        });
        
        $('#box-edit-data').dialog({
            title : 'Edit Tugas',
            closeOnEscape: false,
            autoOpen: false,
            height: 180,
            width: 500,
            modal: true,
            resizable: false,
            draggable: true
        });
        
        $( "#dialog-confirm-delete" ).dialog({
            autoOpen: false,
            resizable: false,
            height:140,
            modal: true
        });
        
        $('a[rel=dialog]').live('click',function() {
            $('#box-add-data').dialog('open');
            return false;
        });
        
        $('a[rel=edit]').live('click',function() {
            var id = $(this).attr('href');
            var title = $('#list-task #row_' + id).children('.competence_title').text();
            var mlc = $('#list-task #row_' + id).children('.competence_mlc').text();
            
            $('#fEditData #base_competence_id').val(id);
            $('#fEditData #base_competence').val(title);
            $('#fEditData #base_mlc').val(mlc);
            
            $('#box-edit-data').dialog('open');
            return false;
        });
        
        $('a[rel=delete]').live('click',function() {
            var id = $(this).attr('href');
            $( "#dialog-confirm-delete" ).dialog({
                buttons: {
                    Hapus : function() {
                        delete_base_competence(id);
                    },
                    Batal : function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
            $('#dialog-confirm-delete').dialog('open');
            return false;
        });
        
        $('#fAddData').live('submit',function(){
            var link = $(this).attr('action');            
            
            var subject_id = $('#hidden_subject_id').val();
            var period_id = $('#hidden_period_id').val();
            var semester_id = $('#hidden_semester_id').val();
            var grade_id = $('#hidden_grade_id').val();   
            var title = $('#fAddData #base_competence').val();   
            var mlc = $('#fAddData #base_mlc').val();   
            
            $(this).loadingProgress('start');
            
            $.post(link, { 
                subject : subject_id,  
                period : period_id,  
                semester : semester_id, 
                grade : grade_id,
                title : title,
                mlc : mlc
            }, function (o){
                if (o){
                    $('#fAddData')[0].reset();
                    $('#box-add-data').dialog('close');
                    read_base_competence();
                }
            }, 'json');
            return false;
        });
        
        $('#fEditData').live('submit',function(){
            var link = $(this).attr('action');            
               
            var id = $('#fEditData #base_competence_id').val();   
            var title = $('#fEditData #base_competence').val();   
            var mlc = $('#fEditData #base_mlc').val();   
            
            $(this).loadingProgress('start');
            
            $.post(link + '/' + id, {
                title : title,
                mlc : mlc
            }, function (o){
                if (o){
                    $('#fAddData')[0].reset();
                    $('#box-edit-data').dialog('close');
                    read_base_competence();
                }
            }, 'json');
            return false;
        });
    });
</script>