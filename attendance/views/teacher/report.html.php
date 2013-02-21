<div id="tabs-report">
    <ul>
        <li><?php URL::link('#fragment-4', 'Laporan Harian') ?></li>
        <li><?php URL::link('#fragment-5', 'Rekapitulasi Absen') ?></li>
    </ul>
    <div id="fragment-4" style="background: #fff;">
        <fieldset>
            <legend>Filter Laporan</legend>
            <div>
                <?php Form::begin('fReport', 'teacher/reportpreview', 'post', true); ?>

                <table>
                    <tr>
                        <td style="width: 150px;"><?php Form::label('Nama', 'sdate'); ?></td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('select', 'name');
                            Form::option($option_name);
                            Form::properties(array('multiple' => 'multiple'));
                            Form::commit();

                            Form::create('hidden', 'nameid');
                            Form::value(0);
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php Form::label('Tanggal ', 'sdate'); ?> <font color="#999">(mm/dd/yy)</font></td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('text', 'sdate');
                            Form::validation()->requaired();
                            Form::commit();

                            Form::label(' s.d ', 'fdate');

                            Form::create('text', 'fdate');
                            Form::validation()->requaired();
                            Form::validation()->largerDateFrom('#sdate');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>
                            <?php
                            Form::create('submit', 'bSubmit');
                            Form::value('Pratinjau');
                            Form::style('action_preview');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                </table>

                <?php Form::end(); ?>
            </div>
        </fieldset>
        <br>
        <iframe id="viewreport" frameborder="0" style="width: 100%;height: 400px;"></iframe>
    </div>
    <div id="fragment-5" style="background: #fff;">
        <fieldset>
            <legend>Filter Rekapitulasi Absen</legend>
            <div>
                <?php Form::begin('fRecapitulation', 'teacher/recapitulationpreview', 'post', true); ?>

                <table>
                    <tr>
                        <td style="width: 150px;"><?php Form::label('Nama', 'sdate'); ?></td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('select', 'name2');
                            Form::option($option_name);
                            Form::properties(array('multiple' => 'multiple'));
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php Form::label('Jenis Rekap ', 'report_type'); ?></td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('select', 'report_type');
                            Form::option(array('1' => 'Per Bulan', '2' => 'Per Semester'));
                            Form::validation()->requaired();
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr id="tr_month">
                        <td><?php Form::label('Bulan ', 'month'); ?></td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('select', 'month');
                            Form::option($option_month_name);
                            Form::validation()->requaired();
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr id="tr_semester">
                        <td><?php Form::label('Semester ', 'semester'); ?></td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('select', 'semester');
                            Form::option(array('1' => 'Semester 1', '2' => 'Semester 2'));
                            Form::validation()->requaired();
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php Form::label('Tahun ', 'years'); ?></td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('select', 'years');
                            Form::option($option_years);
                            Form::validation()->requaired();
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>
                            <?php
                            Form::create('submit', 'bSubmit');
                            Form::value('Pratinjau');
                            Form::style('action_preview');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                </table>

                <?php Form::end(); ?>
            </div>
        </fieldset>
        <br>
        <iframe id="viewrecapitulation" frameborder="0" style="width: 100%;height: 400px;"></iframe>

    </div>
</div>
<script>
    $(function(){
        
        $("#tabs-report").tabs();
        
        /* Report Script */
        $("#fReport #name").multiselect({
            selectedText: "# dari # dipilih",
            noneSelectedText: 'Pilih Nama Guru'
        }).multiselectfilter();
        
        $('#fReport #sdate').datepicker({
            changeMonth: true,
            changeYear: true
        });
    
        $('#fReport #fdate').datepicker({
            changeMonth: true,
            changeYear: true
        });
        
        $('#fReport').live('submit',function(){
            
            var array_of_checked_values = $("#name", this).multiselect("getChecked").map(function(){
                return this.value;	
            }).get();
                        
            var url =  $(this).attr('action');
            
            var id = array_of_checked_values.join(',');
            var sdate = $('#sdate', this).val();
            var fdate = $('#fdate', this).val();
            
            $('#viewreport').attr('src', url + '?nameid=' + id + '&sdate=' + sdate + '&fdate=' + fdate);
            return false;
        });
        
        /* Recapitulation Script */
        $("#fRecapitulation #name2").multiselect({
            selectedText: "# dari # dipilih",
            noneSelectedText: 'Pilih Nama Guru'
        }).multiselectfilter();
        
        var report_type = function() {
            var type_value = $('#report_type').val();
            
            if (type_value == '1') {
                $('#tr_semester').fadeOut('fast', function(){
                    $('#tr_month').fadeIn('fast');
                });
            } else {
                $('#tr_month').fadeOut('fast', function(){
                    $('#tr_semester').fadeIn('fast');
                });
                
            }
        };
        
        report_type();
        
        $('#fRecapitulation #report_type').live('change', function() {
            report_type();
        });
        
        
        $('#fRecapitulation').live('submit',function(){
            
            var array_of_checked_values = $("#name2", this).multiselect("getChecked").map(function(){
                return this.value;	
            }).get();
                        
            var url =  $(this).attr('action');
            
            var id = array_of_checked_values.join(',');
            var report_type = $('#report_type',this).val();
            var month = $('#month', this).val();
            var semester = $('#semester', this).val();
            var years = $('#years', this).val();
            
            $('#viewrecapitulation').attr('src', url + '?nameid=' + id + '&report_type=' + report_type + '&month=' + month + '&semester=' + semester + '&years=' + years);
            
            return false;
        });
    });
</script>