<div id="box">
    <div id="box_title">
        <div class="left"><?php echo Web::getTitle(); ?></div>
        <div class="right">
            <?php
            Form::create('button', 'btnBack');
            Form::value('Kembali');
            Form::style('action_back');
            Form::properties(array('link' => $link_back));
            Form::commit();
            ?>
        </div>
    </div>
    <div id="box_content">
        <div id="message"></div>
        <?php
        Form::begin('fAdd', 'publisher/create', 'post');
        ?>
        <div>
            <table>
                <tr>
                    <td style="width: 200px;">
                        <div class="label-ina">Nama</div>
                        <div class="label-eng">Name</div>
                    </td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'name');
                        Form::tips('Masukan nama penerbit');
                        Form::size(40);
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <div class="label-ina">Keterangan</div>
                        <div class="label-eng">Description</div>
                    </td>
                    <td valign="top">:</td>
                    <td>
                        <?php
                        Form::create('textarea', 'description');
                        Form::tips('Masukan keterangan.');
                        Form::size(80, 4);
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <fieldset>
                            <legend>Keterangan Kantor</legend>
                            <div class="float-left" style="width: 600">
                                <table>
                                    <tr>
                                        <td style="width: 185px;" valign="top">
                                            <div class="label-ina">Keterangan kantor</div>
                                            <div class="label-eng">Office Description</div>
                                        </td>
                                        <td style="width: 10px;" valign="top">:</td>
                                        <td>
                                            <?php
                                            Form::create('select', 'office_description');
                                            Form::option($option_department);
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 185px;" valign="top">
                                            <div class="label-ina">Alamat</div>
                                            <div class="label-eng">Address</div>
                                        </td>
                                        <td style="width: 10px;" valign="top">:</td>
                                        <td>
                                            <?php
                                            Form::create('textarea', 'address');
                                            Form::size(75, 3);
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 185px;">
                                            <div class="label-ina">Negara</div>
                                            <div class="label-eng">Country</div>
                                        </td>
                                        <td style="width: 10px;">:</td>
                                        <td>
                                            <?php
                                            Form::create('select', 'country');
                                            Form::option($option_country, ' ');
                                            Form::properties(array('link' => $link_province));
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 185px;">
                                            <div class="label-ina">Provinsi</div>
                                            <div class="label-eng">Province</div>
                                        </td>
                                        <td style="width: 10px;">:</td>
                                        <td>
                                            <?php
                                            Form::create('select', 'province');
                                            Form::properties(array('link' => $link_city));
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 185px;">
                                            <div class="label-ina">Kota</div>
                                            <div class="label-eng">City</div>
                                        </td>
                                        <td style="width: 10px;">:</td>
                                        <td>
                                            <?php
                                            Form::create('select', 'city');
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 185px;">
                                            <div class="label-ina">Kode Pos</div>
                                            <div class="label-eng">Zip Code</div>
                                        </td>
                                        <td style="width: 10px;">:</td>
                                        <td>
                                            <?php
                                            Form::create('text', 'zipcode');
                                            Form::size(10);
                                            Form::inputType()->numeric();
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 185px;">
                                            <div class="label-ina">No. Telepon</div>
                                            <div class="label-eng">Phone Number</div>
                                        </td>
                                        <td style="width: 10px;">:</td>
                                        <td>
                                            <?php
                                            Form::create('text', 'phone');
                                            Form::size(20);
                                            Form::inputType()->numeric();
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 185px;">
                                            <div class="label-ina">Fax.</div>
                                        </td>
                                        <td style="width: 10px;">:</td>
                                        <td>
                                            <?php
                                            Form::create('text', 'fax');
                                            Form::size(20);
                                            Form::inputType()->numeric();
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 185px;">
                                            <div class="label-ina">Email</div>
                                        </td>
                                        <td style="width: 10px;">:</td>
                                        <td>
                                            <?php
                                            Form::create('text', 'email');
                                            Form::size(30);
                                            Form::validation()->email();
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 185px;">
                                            <div class="label-ina">Website</div>
                                        </td>
                                        <td style="width: 10px;">:</td>
                                        <td>
                                            <?php
                                            Form::create('text', 'website');
                                            Form::size(30);
                                            Form::validation()->url();
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>
                                            <?php
                                            Form::create('button', 'btnAddOffice');
                                            Form::value('Tambah');
                                            Form::style('action_add');
                                            Form::properties(array('link' => $link_add_office));
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="float-left" style="border-left: 1px dashed #ccc;padding-left: 10px;margin-left: 10px;">
                                <table title="Daftar Alamat Kantor" id="list-office" link_r="<?php echo $link_r_office; ?>" link_d="<?php echo $link_d_office; ?>"></table>
                            </div>
                            <div class="cl"></div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td align="right">
                        <?php
                        Form::create('submit', 'btnSave');
                        Form::value('Save');
                        Form::style('action_save');
                        Form::commit();
                        Form::create('reset', 'btnReset');
                        Form::value('Reset');
                        Form::style('action_cancel');
                        Form::commit();
                        ?>
                    </td>
                </tr>
            </table>
        </div>
        <?php
        Form::end();
        ?>
    </div>
</div>

<script>
    $(function(){  
    
        var form_requaired_validation = function(id,status) {
            $(id).rules("add",{
                required : status
            });
        };
    
        var listId2 = '#list-office';
        var title2 = $(listId2).attr('title');
        var link_r2 = $(listId2).attr('link_r');
        var link_d2 = $(listId2).attr('link_d');
    
        var option2 = {
            url : link_r2,
            dataType : 'xml',
            colModel : [ {
                    display : 'ID', 
                    name : 'publisher_office_temp_id', 
                    width : 50,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Keterangan Kantor',
                    name : 'publisher_office_department_name',
                    width : 90,
                    sortable : true,
                    align : 'left'
                }, {
                    display : 'Alamat',
                    name : 'publisher_office_temp_address',
                    width : screen.width * 0.35,
                    sortable : true,
                    align : 'left',
                    hide : true
                } ],
            buttons : [ {
                    name : 'Hapus',
                    bclass : 'delete',
                    onpress : function() {
                        var leng = $(listId2 + ' .trSelected').length;
                        var conf = confirm('Delete ' + leng + ' items?');
                
                        if (conf) {
                            if (leng > 0) {
                                var tempId = [];
                                $(listId2 + ' .trSelected td[abbr=publisher_office_temp_id] div').each(function() {
                                    tempId.push(parseInt($(this).text()));
                                });
                        
                                $.post(link_d2, {
                                    id : tempId.join(',')
                                }, function(o){
                                    if (o) {
                                        $(listId2).flexReload();
                                    } else {
                                        alert('Process delete failed.');
                                    }                            
                                }, 'json');
                            }
                        }
                    }
                }, {
                    separator : true
                } ],
            nowrap : false,
            sortname : "publisher_office_temp_id",
            sortorder : "asc",
            usepager : true,
            title : title2,
            useRp : false,
            rp : 15,
            showTableToggleBtn : false,
            resizable : false,
            width : screen.width * 0.47,
            height : 340
        };
    
        $(listId2).flexigrid(option2);
    
        /* FILTER ADDRESS */
        $('#country').live('change',function(){
            var url = $(this).attr('link');
            var id = $(this).val();
            $('#province').html('<option>Loading...</option>');
            $.get(url, {
                id:id
            }, function(o){
                $('#province').html(o);
            }, 'json');
        });
        $('#province').live('change',function(){
            var url = $(this).attr('link');
            var id = $(this).val();
            $('#city').html('<option>Loading...</option>');
            $.get(url, {
                id:id
            }, function(o){
                $('#city').html(o);
            }, 'json');
        });
        
        /* SUBMIT ACTIONS */    
        $('#fAdd').live('submit',function(){
            frmID = $(this);
            msgID = $('#message');
            var url =  $(frmID).attr('action');
            var data =  $(frmID).serialize();
        
            $(msgID).fadeOut('slow');
            $.post(url, data, function(o){
                if (o[0]) {
                    if (o[1]) {
                        $(frmID)[0].reset();
                    }
                }
                $(msgID).html(o[2]).fadeIn('slow');
            }, 'json');
        
            return false;
        });
    
        /* BUTTON ACTION */
        $('#btnBack').live('click',function(){
            window.location = $(this).attr('link');
        });
        $('#btnAddOffice').live('click',function(){
            var url = $(this).attr('link');
            var data = $('#fAdd').serialize();
        
            form_requaired_validation('#country',true);
            form_requaired_validation('#city',true);
            form_requaired_validation('#province',true);
        
            if ($('#country').valid() && $('#city').valid() && $('#province').valid()) {
                $.post(url, data, function(o){
                    if (o) {
                        $('#list-office').flexReload();
                    } else {
                        alert('Process tambah failed.');
                    }  
                }, 'json');
            }
        
        });
    
    });
</script>
