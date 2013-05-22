<div class="maincontent">
    <div class="maincontentinner">

        <div class="headtitle">
            <div class="widgettitle"><?php echo Web::getTitle(); ?></div>
            <div class="btn-group">
                <a href="#" class="dropdown">Aksi</a>
                <ul>
                    <li><a href="#">Kembali</a></li>
                    <li><a href="#">Hapus</a></li>
                </ul>
            </div>
            <div class="cls">&nbsp;</div>
        </div>

        <div class="widgetcontent">
            <div id="message"></div>
            <?php
            Form::begin('fAdd', 'ddc/update/' . $id, 'post');
            ?>
            <div>
                <table>
                    <tr>
                        <td style="width: 200px;">
                            <div class="label-ina">Nomor Klasifikasi</div>
                            <div class="label-eng">Classification Number</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('text', 'callNumber');
                            Form::tips('Enter Call Number');
                            Form::value($dataEdit['ddc_classification_number']);
                            Form::validation()->requaired();
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>        
                    <tr>
                        <td>
                            <div class="label-ina">Level</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('select', 'level');
                            Form::tips('Chose Level DDC');
                            Form::validation()->requaired();
                            Form::option($ddcLevel, ' ', $dataEdit['ddc_level']);
                            Form::properties(array('link' => $link_sub1));
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr class="sub1" style="display: none;">
                        <td>
                            <div class="label-ina">Kelas Utama</div>
                            <div class="label-eng">Main Class</div>
                        </td>
                        <td>:</td>
                        <td class="sub1">
                            <?php
                            Form::create('select', 'sub1');
                            Form::tips('Chose Level DDC');
                            Form::option($listSub1[0], '', $listSub1[1]);
                            Form::properties(array('link' => $link_sub2));
                            Form::validation()->requaired();
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr class="sub2" style="display: none;">
                        <td>
                            <div class="label-ina">Sub Kelas</div>
                            <div class="label-eng">Sub Class</div>
                        </td>
                        <td>:</td>
                        <td class="sub2">
                            <?php
                            Form::create('select', 'sub2');
                            Form::tips('Chose Level DDC');
                            Form::option($listSub2[0], '', $listSub2[1]);
                            Form::validation()->requaired();
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="label-ina">Judul</div>
                            <div class="label-eng">Title</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('textarea', 'title');
                            Form::tips('Enter titel DDC');
                            Form::size(80, 4);
                            Form::validation()->requaired();
                            Form::value($dataEdit['ddc_title']);
                            Form::style('form-grey');
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
                            Form::tips('Enter Description');
                            Form::value($dataEdit['ddc_description']);
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <?php
                            Form::create('submit', 'btnSave');
                            Form::value('Save');
                            Form::style('button-mid-solid-blue');
                            Form::commit();
                            Form::create('reset', 'btnReset');
                            Form::value('Reset');
                            Form::style('button-mid-solid-red');
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
</div>

<script>
    $(function() {
        /* Action Button */
        $('.headtitle .btn-group a[class=dropdown]').live('click', function() {

            var href = $(this).attr('href');

            if (href === '#') {
                $(this).next('ul').fadeIn('fast');
                $(this).attr('href', '#active');
            } else {
                $(this).next('ul').fadeOut('fast');
                $(this).attr('href', '#');
            }
            return false;
        });
        
        if ($('#level').val() == 2) {
            $('tr.sub1').fadeIn('slow');
        } else if ($('#level').val() == 3) {
            $('tr.sub1').fadeIn('slow');
            $('tr.sub2').fadeIn('slow');
        }

        /* WYSIWYG elRTE */
        elRTE.prototype.options.panels.web2pyPanel = [
            'bold', 'italic', 'underline', 'forecolor', 'justifyleft', 'justifyright',
            'justifycenter', 'justifyfull', 'formatblock', 'insertorderedlist', 'insertunorderedlist',
            'link', 'image'
        ];
        elRTE.prototype.options.toolbars.web2pyToolbar = ['web2pyPanel', 'tables'];

        var opts = {
            cssClass: 'el-rte',
            height: 180,
            width: 600,
            toolbar: 'web2pyToolbar',
            cssfiles: ['css/elrte-inner.css']
        };

        $('#description').elrte(opts);

        /* BUTTON ACTION */
        $('#btnBack').live('click', function() {
            window.location = $(this).attr('link');
        });

        /* SUBMIT ACTIONS */
        $('#fAdd').live('submit', function() {
            frmID = $(this);
            msgID = $('#message');
            var url = $(frmID).attr('action');
            var data = $(frmID).serialize();

            $(msgID).fadeOut('slow');
            $(this).loadingProgress('start');
            $.post(url, data, function(o) {
                $(this).loadingProgress('stop');
                if (o[0]) {
                    if (o[1]) {
                        $('#description').elrte('val', ' ');
                        $(frmID)[0].reset();
                    }
                }
                $(msgID).html(o[2]).fadeIn('slow');
            }, 'json');

            return false;
        });

        /* CHANGE VALUE ACTIONS */
        $('#level').live('change', function() {
            var url = $(this).attr('link');
            if ($(this).val() == 2) {
                $('tr.sub1 td.sub1').html('<select id="sub1" class="form-grey"><option value="">Loading...</option></select>');
                form_tips('sub1');
                $("#fAdd #sub1").rules("add", {
                    required: true
                });

                $.get(url, function(o) {
                    $('tr.sub1 td.sub1').html(o);
                }, 'json');

                $('tr.sub1').fadeIn('slow');
            } else if ($(this).val() == 3) {
                $('tr.sub1 td.sub1').html('<select id="sub1" class="form-grey"><option value="">Loading...</option></select>');
                form_tips('sub1');
                $("#fAdd #sub1").rules("add", {
                    required: true
                });

                $.get(url, function(o) {
                    $('tr.sub1 td.sub1').html(o);
                }, 'json');


                var sub2 = '<select id="sub2" name="sub2" tips="Chose Level DDC" class="form-grey">';
                sub2 += '   <option value="" selected></option>';
                sub2 += '</select>';
                $('tr.sub2 td.sub2').html(sub2);
                form_tips('sub2');
                $("#fAdd #sub2").rules("add", {
                    required: true
                });

                $('tr.sub1').fadeIn('slow');
                $('tr.sub2').fadeIn('slow');
            } else {
                $("#fAdd #sub1").rules("add", {
                    required: false
                });
                $("#fAdd #sub2").rules("add", {
                    required: false
                });
                $('tr.sub1').fadeOut('slow');
                $('tr.sub2').fadeOut('slow');
            }
        });
        $('#sub1').live('change', function() {
            var url = $(this).attr('link');
            $('tr.sub2 td.sub2').html('<select id="sub2" class="form-grey"><option value="">Loading...</option></select>');

            form_tips('sub2');
            $("#fAdd #sub2").rules("add", {
                required: true
            });

            $.get(url, {
                id: $(this).val()
            }, function(o) {
                $('tr.sub2 td.sub2').html(o);
            }, 'json');

        });
    });
</script>
