<div id="box-content">
    <table id="list" title="<?php echo Web::getTitle(); ?>" link_c="<?php echo $link_c; ?>" link_r="<?php echo $link_r; ?>" link_u="<?php echo $link_u; ?>"  link_d="<?php echo $link_d; ?>">
    </table>
    <div class="cl">&nbsp;</div>
</div>

<div id="box-form" style="display: none;">
    <div class="view_message"></div>
    <?php
    Form::begin('frm_data');
    Form::create('hidden', 'id');
    Form::commit();
    ?>
    <div class="view_message"></div>
    <table style="margin: 5px 0 0 0;">
        <tr>
            <td style="width: 150px;">
                <div class="label-ina">Asal Sekolah</div>
                <div class="label-eng">Originally School</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'originally_school');
                Form::size(15);
                Form::validation()->requaired('*');
                Form::commit();
                ?>
                <button id="btn_search_school">Cari</button>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label-ina">Nama Pelamar</div>
                <div class="label-eng">Applicant Name</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'applicant_name');
                Form::size(50);
                Form::validation()->requaired('*');
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label-ina">Jenis Kelamin</div>
                <div class="label-eng">Gender</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('select', 'gender');
                Form::option($option_gender, ' ');
                Form::validation()->requaired('*');
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label-ina">Golongan Darah</div>
                <div class="label-eng">Blood Group</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('select', 'blood_group');
                Form::option($option_blood_group, ' ');
                Form::validation()->requaired('*');
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label-ina">Agama</div>
                <div class="label-eng">Religion</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('select', 'religion');
                Form::option($option_religion, ' ');
                Form::validation()->requaired('*');
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label-ina">Tempat, Tanggal Lahir</div>
                <div class="label-eng">Place, Birth of date</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'birthplace');
                Form::size(20);
                Form::validation()->requaired('*');
                Form::commit();
                echo ', ';
                Form::create('select', 'day');
                Form::option($option_date);
                Form::validation()->requaired('*');
                Form::commit();
                Form::create('select', 'month');
                Form::option($option_moth);
                Form::validation()->requaired('*');
                Form::commit();
                Form::create('text', 'year');
                Form::size(5);
                Form::validation()->requaired('*');
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label-ina">Tinggi Badan</div>
                <div class="label-eng">Height</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'height');
                Form::size(5);
                Form::commit();
                ?> Cm
            </td>
        </tr>
        <tr>
            <td>
                <div class="label-ina">Berat Badan</div>
                <div class="label-eng">Weight</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'weight');
                Form::size(5);
                Form::commit();
                ?> Kg
            </td>
        </tr>
        <tr>
            <td>
                <div class="label-ina">Penyakit yang pernah diderita</div>
                <div class="label-eng">Had suffered</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'suffered');
                Form::size(35);
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <button id="btn_save">Simpan</button>
                <button id="btn_reset">Reset</button>
            </td>
        </tr>
    </table>
    <?php
    Form::end();
    ?>
</div>

<div id="box-filter">
    <?php
    Form::begin('frm_filter');
    ?>
    <div style="border: 1px solid #ccc; padding: 5px;margin: 5px 0 5px 0;background-color: #f9f9f9;">
        <table>
            <tr>
                <td style="width: 80px;">
                    <div class="label-ina">Kata Kunci</div>
                    <div class="label-eng">Keyword</div>
                </td>
                <td>:</td>
                <td>
                    <?php
                    Form::create('select', 'keyword_category');
                    Form::option(array('school_nss' => 'NSS', 'school_name' => 'Nama Sekolah'));
                    Form::commit();
                    Form::create('text', 'keyword_text');
                    Form::commit();
                    ?>
                    <button id="btn_filter">Cari</button>
                </td>
            </tr>
        </table>
    </div>
    <table id="list-filter" link_r="<?php echo $link_filter; ?>">
    </table>
    <?php
    Form::end();
    ?>
</div>

<div id="box-report-score">
    <?php
    Form::begin('frm_report_score', 'studentprofile/createreportscore', 'post');
    Form::create('hidden', 'brc_id');
    Form::commit();
    Form::create('hidden', 'brc_tempid');
    Form::commit();
    ?>

    <div class="view_message"></div>
    <div style="border: 1px solid #ccc; padding: 5px;margin: 5px 0 5px 0;background-color: #f9f9f9;">
        <table>
            <tr>
                <td style="width: 150px;">
                    <div class="label-ina">NISN</div>
                </td>
                <td>:</td>
                <td id="brc_nisn"></td>
            </tr>
            <tr>
                <td>
                    <div class="label-ina">Nama Pelamar</div>
                    <div class="label-eng">Applicant Name</div>
                </td>
                <td>:</td>
                <td id="brc_name"></td>
            </tr>
            <tr>
                <td>
                    <div class="label-ina">Jenis Kelamin</div>
                    <div class="label-eng">Gender</div>
                </td>
                <td>:</td>
                <td id="brc_gender"></td>
            </tr>
            <tr>
                <td>
                    <div class="label-ina">Asal Sekolah</div>
                    <div class="label-eng">Originally School</div>
                </td>
                <td>:</td>
                <td id="brc_originally_school"></td>
            </tr>
        </table>
    </div>
    <table id="brc_list" class="list-report-score">
        <thead>
            <tr>
                <td align="center" class="first" rowspan="2" >No.</td>
                <td align="center" rowspan="2" style="width: 200px;">Mata Pelajaran</td>
                <td align="center" colspan="2" style="border-bottom: none;">Kelas 4</td>
                <td align="center" colspan="2" style="border-bottom: none;">Kelas 5</td>
                <td align="center" style="border-bottom: none;">Kelas 6</td>
            </tr>
            <tr>
                <td align="center" style="width: 70px;" >SMT. 1</td>
                <td align="center" style="width: 70px;" >SMT. 2</td>
                <td align="center" style="width: 70px;" >SMT. 1</td>
                <td align="center" style="width: 70px;" >SMT. 2</td>
                <td align="center" style="width: 70px;" >SMT. 1</td>
            </tr>
        </thead>
        <?php echo $table_report_score; ?>
    </table>

    <div style="padding: 10px 0;">
        <button id="btn_save_report_score">Simpan</button>
        <button id="btn_reset_report_score">Reset</button>
    </div>

    <?php
    Form::end();
    ?>
</div>

<div id="box-rank-class">
    <?php
    Form::begin('frm_rank_class', 'studentprofile/createrankclass', 'post');
    Form::create('hidden', 'brank_id');
    Form::commit();
    ?>

    <div class="view_message"></div>
    <div style="border: 1px solid #ccc; padding: 5px;margin: 5px 0 5px 0;background-color: #f9f9f9;">
        <table>
            <tr>
                <td style="width: 150px;">
                    <div class="label-ina">NISN</div>
                </td>
                <td>:</td>
                <td id="brank_nisn"></td>
            </tr>
            <tr>
                <td>
                    <div class="label-ina">Nama Pelamar</div>
                    <div class="label-eng">Applicant Name</div>
                </td>
                <td>:</td>
                <td id="brank_name"></td>
            </tr>
            <tr>
                <td>
                    <div class="label-ina">Jenis Kelamin</div>
                    <div class="label-eng">Gender</div>
                </td>
                <td>:</td>
                <td id="brank_gender"></td>
            </tr>
            <tr>
                <td>
                    <div class="label-ina">Asal Sekolah</div>
                    <div class="label-eng">Originally School</div>
                </td>
                <td>:</td>
                <td id="brank_originally_school"></td>
            </tr>
        </table>
    </div>
    <table id="brank_list" class="list-report-score">
        <thead>
            <tr>
                <td align="center" class="first">No.</td>
                <td align="center" style="width: 100px;">Kelas</td>
                <td align="center" style="width: 80px;">Semester</td>
                <td align="center">No. Peringkat di Kelas</td>
                <td align="center">Jumlah Siswa dalam Kelas</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td align="center" rowspan="2" class="first">1.</td>
                <td align="center" rowspan="2">Kelas 4</td>
                <td align="center">SMT. 1</td>
                <td align="center">
                    <?php
                    Form::create('text', 'brank_r_smt1');
                    Form::properties(array('style' => 'text-align:center;'));
                    Form::style('brank_input');
                    Form::commit();
                    ?>
                </td>
                <td align="center">
                    <?php
                    Form::create('text', 'brank_s_smt1');
                    Form::properties(array('style' => 'text-align:center;'));
                    Form::style('brank_input');
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <td align="center">SMT. 2</td>
                <td align="center">
                    <?php
                    Form::create('text', 'brank_r_smt2');
                    Form::properties(array('style' => 'text-align:center;'));
                    Form::style('brank_input');
                    Form::commit();
                    ?>
                </td>
                <td align="center">
                    <?php
                    Form::create('text', 'brank_s_smt2');
                    Form::properties(array('style' => 'text-align:center;'));
                    Form::style('brank_input');
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <td align="center" rowspan="2" class="first">2.</td>
                <td align="center" rowspan="2">Kelas 5</td>
                <td align="center">SMT. 1</td>
                <td align="center">
                    <?php
                    Form::create('text', 'brank_r_smt3');
                    Form::properties(array('style' => 'text-align:center;'));
                    Form::style('brank_input');
                    Form::commit();
                    ?>
                </td>
                <td align="center">
                    <?php
                    Form::create('text', 'brank_s_smt3');
                    Form::properties(array('style' => 'text-align:center;'));
                    Form::style('brank_input');
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <td align="center">SMT. 2</td>
                <td align="center">
                    <?php
                    Form::create('text', 'brank_r_smt4');
                    Form::properties(array('style' => 'text-align:center;'));
                    Form::style('brank_input');
                    Form::commit();
                    ?>
                </td>
                <td align="center">
                    <?php
                    Form::create('text', 'brank_s_smt4');
                    Form::properties(array('style' => 'text-align:center;'));
                    Form::style('brank_input');
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <td align="center" rowspan="2" class="first">3.</td>
                <td align="center" rowspan="2">Kelas 6</td>
                <td align="center">SMT. 1</td>
                <td align="center">
                    <?php
                    Form::create('text', 'brank_r_smt5');
                    Form::properties(array('style' => 'text-align:center;'));
                    Form::style('brank_input');
                    Form::commit();
                    ?>
                </td>
                <td align="center">
                    <?php
                    Form::create('text', 'brank_s_smt5');
                    Form::properties(array('style' => 'text-align:center;'));
                    Form::style('brank_input');
                    Form::commit();
                    ?>
                </td>
            </tr>
        </tbody>
    </table>

    <div style="padding: 10px 0;">
        <button id="btn_save_rank_class">Simpan</button>
        <button id="btn_reset_rank_class">Reset</button>
    </div>

    <?php
    Form::end();
    ?>
</div>

<script>
    $(function() {
        
        var is_empty = function(val) {
            if (val == '' || val == ' ' || val == null || typeof val == 'undefined') {
                return true;
            } else {
                return false;
            }
        };
        
        var y = screen.height * 0.70;
        $('#box-content').css('min-height',  y + "px");
        
        var form_status = 'add';
        var data;
        var set_form = function(data) {          
            $('#id').val(data['applicant_id']);
            $('#originally_school').val(data['applicant_school']);
            $('#applicant_name').val(data['applicant_name']);
            $('#gender').val(data['applicant_gender']);
            $('#blood_group').val(data['applicant_blood_group']); 
            $('#religion').val(data['applicant_religion']); 
            $('#birthplace').val(data['applicant_birthplace']); 
            $('#day').val(data['applicant_birthdate_d']); 
            $('#month').val(data['applicant_birthdate_m']); 
            $('#year').val(data['applicant_birthdate_y']); 
            $('#height').val(data['applicant_height']); 
            $('#weight').val(data['applicant_weight']); 
            $('#suffered').val(data['applicant_disease']); 
        };
        
        /* INDEX */
        $('#list').flexigrid({
            url : $('#list').attr('link_r'),
            dataType : 'xml',
            colModel : [ {
                    display : 'ID', 
                    name : 'applicant_id', 
                    width : 60,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Nama Pelamar',
                    name : 'product_name',
                    width : 120,
                    sortable : true,
                    align : 'left'
                },{
                    display : 'Asal Sekolah',
                    name : 'category_name',
                    width : 100,
                    sortable : true,
                    align : 'left',
                    hide : true
                }, {
                    display : 'Jenis Kelamin',
                    name : 'category_name',
                    width : 65,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Agama',
                    name : 'category_name',
                    width : 80,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Golongan Darah',
                    name : 'category_name',
                    width : 80,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Tempat, Tanggal Lahir',
                    name : 'category_name',
                    width : 150,
                    sortable : true,
                    align : 'left',
                    hide : true
                },  {
                    display : 'Tinggi / Berat',
                    name : 'category_name',
                    width : 80,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Penyakit yang pernah diderita',
                    name : 'category_name',
                    width : 200,
                    sortable : true,
                    align : 'left',
                    hide : true
                }, {
                    display : 'Tanggal Input',
                    name : 'language_entry',
                    width : 80,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Tanggal Update',
                    name : 'language_entry_update',
                    width : 80,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Option',
                    name : 'option',
                    width : 150,
                    align : 'center'
                }],
            buttons : [ {
                    name : 'Tambah',
                    bclass : 'add',
                    onpress : function() {
                        form_status = 'add';
                        $('#frm_data .view_message').html('');
                        $('#frm_data')[0].reset();
                        $('#box-form').dialog('open');
                        
                    }
                }, {
                    name : 'Hapus',
                    bclass : 'delete',
                    onpress : function() {
                        var leng = $('#list .trSelected').length;
                        var conf = confirm('Delete ' + leng + ' items?');
                
                        if (conf) {
                            if (leng > 0) {
                                var tempId = [];
                                $('#list .trSelected td[abbr=applicant_id] div').each(function() {
                                    tempId.push(parseInt($(this).text()));
                                });
                                
                                $(this).loadingProgress('start');
                                $.post($('#list').attr('link_d'), {
                                    id : tempId.join(',')
                                }, function(o){
                                    $(this).loadingProgress('stop');
                                    if (o) {
                                        $('#list').flexReload();
                                    } else {
                                        alert('Proses hapus gagal.');
                                    }                            
                                }, 'json');
                            }
                        }
                    }
                } ],
            searchitems : [ {
                    display : 'ID',
                    name : 'applicant_id',
                    isdefault : true
                }, {
                    display : 'Nama Produk',
                    name : 'product_name'            
                } ],
            nowrap : false,
            sortname : "applicant_id",
            sortorder : "asc",
            usepager : true,
            title : $('#list').attr('title'),
            useRp : true,
            rp : 15,
            showTableToggleBtn : false,
            resizable : false,
            width : '100%',
            height : screen.height * 0.55
        });
        
        /* EDIT */
        $('.edit').live('click', function(){
            
            form_status = 'edit';
            $('#frm_data .view_message').html('');
            $('#frm_data')[0].reset();
            
            $(this).loadingProgress('start');
            
            var url = $(this).attr('href');
            $.post(url, function(o){
                $(this).loadingProgress('stop');
                
                if (o[0]) {
                    data = o[1];
                    set_form(data);
                    $('#box-form').dialog('open');                 
                } else {
                    alert('Maaf, data tidak ditemukan.');
                }
            }, 'json');            
            
            return false;
        });
        
        /* FORM DATA */
        $('#frm_data').live('submit', function() {
            var parent = $(this);
            var url;
            var data = parent.serialize();
            
            url = $('#list').attr('link_c');
            if (form_status == 'edit') {
                url = $('#list').attr('link_u');                
            }
            
            $.post(url, data, function(o){
                $('.view_message', parent).html(o[1]);
            }, 'json');
            return false;
        });
        
        $('#box-form').dialog({
            title : '',
            closeOnEscape: true,
            autoOpen: false,
            height: 500,
            width: 620,
            modal: false,
            resizable: false,
            draggable: true,
            open : function() {
                if (form_status == 'add') {
                    $('#box-form').dialog('option', 'title', 'Tambah Data Biodata Pelamar');
                } else {
                    $('#box-form').dialog('option', 'title', 'Edit Data Biodata Pelamar');
                }
            }
        });       
                
        $('#btn_save').button({
            icons: {
                primary: "ui-icon-disk"
            }
        });
        
        $('#btn_reset').button({
            icons: {
                primary: "ui-icon-refresh"
            }
        }).live('click', function(){
            if (form_status == 'add') {
                $('#frm_data')[0].reset();
            } else {
                set_form(data   );
            }
            return false;
        });
        
        $('#btn_search_school').button({
            icons: {
                primary: "ui-icon-search"
            },
            text: false
        }).live('click', function(){
            $('#box-filter').dialog('open');
            return false;
        });
        
        /* FILTER SCHOOL */
        $('#list-filter').flexigrid({
            url : $('#list-filter').attr('link_r'),
            dataType : 'xml',
            colModel : [ {
                    display : 'ID', 
                    name : 'school_id', 
                    width : 50,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'NSS',
                    name : 'product_name',
                    width : 75,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Nama Sekolah',
                    name : 'product_name',
                    width : 120,
                    sortable : true,
                    align : 'left'
                },{
                    display : 'Alamat',
                    name : 'category_name',
                    width : 205,
                    sortable : true,
                    align : 'left',
                    hide : true
                }],
            buttons : [ {
                    name : 'Insert Pilihan',
                    bclass : 'tick',
                    onpress : function() {
                        var leng = $('#list-filter .trSelected').length;
                        if (leng > 0) {
                            var tempId;
                            $('#list-filter .trSelected td[abbr=school_id] div').each(function() {
                                tempId = parseInt($(this).text());
                            });
                            $('#originally_school').val(tempId).focus();
                            $('#box-filter').dialog('close');
                        } else {
                            alert('Belum ada reseller yang dipilih.');
                        }
                    }
                } ],
            nowrap : false,
            sortname : "school_id",
            sortorder : "asc",
            usepager : true,
            title : 'DAFTAR SEKOLAH',
            useRp : true,
            rp : 15,
            showTableToggleBtn : false,
            resizable : false,
            width : '100%',
            height : 170, 
            singleSelect:true,
            onSubmit: function() {
                var dt = $('#frm_filter').serializeArray();
                $('#list-filter').flexOptions({
                    params: dt
                });
                return true;
            }
        });
        
        $('#box-filter').dialog({
            title : 'Filter Sekolah Asal',
            closeOnEscape: true,
            autoOpen: false,
            height: 400,
            width: 550,
            modal: false,
            resizable: false,
            draggable: true
        });  
        
        $('#btn_filter').button({
            icons: {
                primary: "ui-icon-search"
            }
        }).live('click', function(){
            $('#list-filter').flexOptions({
                newp: 1
            }).flexReload();
            return false;
        });
        
        /* REPORT SCORE */
        var data_info_box_report;
        var set_info_box_report = function(data) {
            $('#brc_id').val(data['applicant_id']);
            $('#brc_nisn').text();
            $('#brc_name').text(data['applicant_name']);
            $('#brc_gender').text(data['gender_title']);
            $('#brc_originally_school').text(data['school_name']);
        };
        
        var set_val_report_score = function(list_report_score) {
            var temp_id = $('#brc_list').children('tbody').attr('temp_id');
            var id = temp_id.split(',');
                    
            $('#brc_tempid').val(temp_id);
                    
            var i = 0;
            $.each(id, function(){
                
                var smt1 = '';
                var smt2 = '';
                var smt3 = '';
                var smt4 = '';
                var smt5 = '';
                
                if (typeof list_report_score[id[i]] != 'undefined') {
                    smt1 = list_report_score[id[i]]['smt1'];
                    smt2 = list_report_score[id[i]]['smt2'];
                    smt3 = list_report_score[id[i]]['smt3'];
                    smt4 = list_report_score[id[i]]['smt4'];
                    smt5 = list_report_score[id[i]]['smt5'];
                }
                
                $('#frm_report_score #smt_1_' + id[i]).val(smt1);
                $('#frm_report_score #smt_2_' + id[i]).val(smt2);
                $('#frm_report_score #smt_3_' + id[i]).val(smt3);
                $('#frm_report_score #smt_4_' + id[i]).val(smt4);
                $('#frm_report_score #smt_5_' + id[i]).val(smt5);
                
                i++;
            });
        };
        
        $('.report_score').live('click', function(){ 
            $('#frm_report_score .view_message').html('');
            $('#frm_report_score')[0].reset();
            
            $(this).loadingProgress('start');
            
            var url = $(this).attr('href');
            $.post(url, function(o){
                $(this).loadingProgress('stop');
                
                if (o[0]) {
                    data_info_box_report = o[1];
                    set_info_box_report(data_info_box_report);
                    set_val_report_score(data_info_box_report['list_report_score']);
                    
                    $('#box-report-score').dialog('open');                  
                } else {
                    alert('Maaf, data tidak ditemukan.');
                }
            }, 'json');            
            
            return false;
        });
        
        $('#box-report-score').dialog({
            title : 'Nilai Rapor',
            closeOnEscape: true,
            autoOpen: false,
            height: 555,
            width: 620,
            modal: false,
            resizable: false,
            draggable: true
        }); 
        
        $('#btn_save_report_score').button({
            icons: {
                primary: "ui-icon-disk"
            }
        });
        
        $('#btn_reset_report_score').button({
            icons: {
                primary: "ui-icon-refresh"
            }
        }).live('click', function(){
            $('#frm_report_score')[0].reset();
            set_info_box_report(data_info_box_report);
            set_val_report_score(data_info_box_report['list_report_score']);
            return false;
        });
        
        $('#frm_report_score').live('submit', function(){
            
            var parent = $(this);
            var url = parent.attr('action');
            var data = parent.serialize();
            
            var error_log = 0;
            $('#frm_report_score .brc_val').each(function() {
                var val = $(this).val();
                if (is_empty(val)) {
                    error_log++;
                    $(this).attr('style','border-color:red;');
                } else {
                    $(this).attr('style','border-color:#ccc;');
                }
            });
            
            if (error_log == 0) {
                $.post(url, data, function(o){
                    $('.view_message', parent).html(o[1]);
                }, 'json');
            }
            return false;
        });
        
        $('#frm_report_score .brc_val').live('change', function() {
            var val = $(this).val();
            if (is_empty(val)) {
                $(this).attr('style','border-color:red;');
            } else {
                $(this).attr('style','border-color:#ccc;');
            }
        });
        
        /* RANK CLASS */
        var data_info_rank_class;
        var set_info_rank_class = function(data) {
            $('#brank_id').val(data['applicant_id']);
            $('#brank_nisn').text();
            $('#brank_name').text(data['applicant_name']);
            $('#brank_gender').text(data['gender_title']);
            $('#brank_originally_school').text(data['school_name']);
        };
        
        var set_form_rank_class = function(data) {
            if (data.length != 0) {
                $('#brank_r_smt1').val(data[1]['r_smt1']);
                $('#brank_s_smt1').val(data[1]['s_smt1']);
                $('#brank_r_smt2').val(data[1]['r_smt2']);
                $('#brank_s_smt2').val(data[1]['s_smt2']);
                $('#brank_r_smt3').val(data[1]['r_smt3']);
                $('#brank_s_smt3').val(data[1]['s_smt3']);
                $('#brank_r_smt4').val(data[1]['r_smt4']);
                $('#brank_s_smt4').val(data[1]['s_smt4']);
                $('#brank_r_smt5').val(data[1]['r_smt5']);
                $('#brank_s_smt5').val(data[1]['s_smt5']);
            }
        };
        
        $('#box-rank-class').dialog({
            title : 'Peringkat di Kelas',
            closeOnEscape: true,
            autoOpen: false,
            height: 585,
            width: 620,
            modal: false,
            resizable: false,
            draggable: true
        }); 
        
        $('.rank_class').live('click', function(){ 
            
            $('#frm_rank_class .view_message').html('');
            $('#frm_rank_class')[0].reset();
            
            $(this).loadingProgress('start');
            
            var url = $(this).attr('href');
            $.post(url, function(o){
                $(this).loadingProgress('stop');
                if (o[0]) {  
                    data_info_rank_class = o[1];
                    set_info_rank_class(data_info_rank_class);
                    set_form_rank_class(data_info_rank_class['list_rank_class']);
                    $('#box-rank-class').dialog('open');                   
                } else {
                    alert('Maaf, data tidak ditemukan.');
                }
            }, 'json');  
            return false;
        });
        
        $('#btn_save_rank_class').button({
            icons: {
                primary: "ui-icon-disk"
            }
        });
        
        $('#btn_reset_rank_class').button({
            icons: {
                primary: "ui-icon-refresh"
            }
        }).live('click', function(){
            $('#frm_rank_class')[0].reset();
            set_info_rank_class(data_info_rank_class);
            set_form_rank_class(data_info_rank_class['list_rank_class']);
            return false;
        });
        
        $('#frm_rank_class').live('submit', function(){
            
            var parent = $(this);
            var url = parent.attr('action');
            var data = parent.serialize();
            
            var error_log = 0;
            $('#frm_rank_class .brank_input').each(function() {
                var val = $(this).val();
                if (is_empty(val)) {
                    error_log++;
                    $(this).attr('style','border-color:red;text-align:center;');
                } else {
                    $(this).attr('style','border-color:#ccc;text-align:center;');
                }
            });
            
            if (error_log == 0) {
                $.post(url, data, function(o){
                    $('.view_message', parent).html(o[1]);
                }, 'json');
            }
            return false;
        });
        
        $('#frm_rank_class .brank_input').live('change', function() {
            var val = $(this).val();
            if (is_empty(val)) {
                $(this).attr('style','border-color:red;text-align:center;');
            } else {
                $(this).attr('style','border-color:#ccc;text-align:center;');
            }
        });
        
    });
</script>