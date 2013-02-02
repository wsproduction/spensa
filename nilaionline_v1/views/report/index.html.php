<div class="box-static">
    <div class="title"><?php echo Web::getTitle(false); ?></div>
    <div class="class-info box-green">
        <table id="teacher-information" cellspacing="6" cellpadding="5" style="width: 100%;">
            <tr>
                <td class="label" style="width: 120px;">TAHUN AKADEMIK</td>
                <td class="sparator">:</td>
                <td class="content">
                    <?php
                    echo $guardian_info['period_years_start'] . '/' . $guardian_info['period_years_end'] . ' - ' . $guardian_info['semester_name'];
                    ?>
                </td>
            </tr>
            <tr>
                <td class="label">KELAS</td>
                <td class="sparator">:</td>
                <td class="content">
                    <?php
                    echo $guardian_info['grade_title'] . ' (' . $guardian_info['grade_name'] . ') ' . $guardian_info['classroom_name'];
                    ?>
                </td>
            </tr>
            <tr>
                <td class="label">JUMLAH SISWA</td>
                <td class="sparator">:</td>
                <td class="content">
                    <?php
                    echo $guardian_info['student_count'] . ' Siswa';
                    ?>
                </td>
            </tr>
        </table>
    </div>
    <div class="description">Berikut adalah daftar tugas mengajar : </div>
    
    
    
</div>

<script type="text/javascript">
    $(function(){
        var read_subject = function() {
            var link = $('#list-teaching').attr('link_r');
            $(this).loadingProgress('start');
            
            $.post(link, {id:1}, function (o){
                $('#list-teaching').children('tbody').html(o);
                $(this).loadingProgress('stop');
                
            }, 'json');
        };
        
        var read_eskul = function() {
            var link = $('#list-teaching-ekskul').attr('link_r');
            $(this).loadingProgress('start');
            
            $.post(link, {id:1}, function (o){
                $('#list-teaching-ekskul').children('tbody').html(o);
                $(this).loadingProgress('stop');
                
            }, 'json');
        };
        
        read_subject();
        read_eskul();
        
        $("#btn-rapor").live('click', function() {
            window.location = $(this).attr('link');
        });
    });
</script>