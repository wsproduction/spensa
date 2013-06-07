<div class="maincontent">
    <div class="maincontentinner">
        <center>
            <table id="printlist" title="<?php echo Web::getTitle(); ?>" link_r="<?php echo $link_r; ?>" link_p="<?php echo $link_p; ?>" link_d="<?php echo $link_d; ?>" style="display: none;">
            </table>
        </center>
    </div>
</div>

<div id="box-print">
    <iframe frameborder="0"></iframe>
</div>

<script>
    $(function() {
        $('#printlist').flexigrid({
            url: $('#printlist').attr('link_r'),
            dataType: 'xml',
            colModel: [{
                    display: 'ID',
                    name: 'members_id',
                    width: 60,
                    sortable: true,
                    align: 'center'
                }, {
                    display: 'Nama Lengkap',
                    name: 'members_name',
                    width: 180,
                    sortable: true,
                    align: 'left'
                }, {
                    display: 'Jenis Kelamin',
                    name: 'gender_title',
                    width: 100,
                    sortable: true,
                    align: 'center'
                }, {
                    display: 'Tempat/Tgl. Lahir',
                    name: 'members_birthplace',
                    width: 150,
                    sortable: true,
                    align: 'left'
                }, {
                    display: 'Alamat',
                    name: 'members_address',
                    width: 350,
                    sortable: true,
                    align: 'left'
                }, {
                    display: 'Golongan',
                    name: 'members_isa',
                    width: 100,
                    sortable: true,
                    align: 'left'
                }, {
                    display: 'Keterangan',
                    name: 'members_desc',
                    width: 120,
                    sortable: true,
                    align: 'left'
                }, {
                    display: 'Option',
                    name: 'members_desc',
                    width: 80,
                    sortable: true,
                    align: 'center'
                }],
            buttons: [{
                    name: 'Delete',
                    bclass: 'delete',
                    onpress: function() {
                        var leng = $('#printlist .trSelected').length;
                        var conf = confirm('Hapus ' + leng + ' items?');

                        if (conf) {
                            if (leng > 0) {
                                var tempId = [];
                                $('#printlist .trSelected td[abbr=members_id] div').each(function() {
                                    tempId.push(parseInt($(this).text()));
                                });

                                $(this).loadingProgress('start');
                                $.post($('#printlist').attr('link_d'), {
                                    id: tempId.join(',')
                                }, function(o) {
                                    $(this).loadingProgress('stop');
                                    if (o) {
                                        alert(leng + ' Item telah dihapus.');
                                        $('#printlist').flexReload();
                                    } else {
                                        alert('Proses Hapus Gagal.');
                                    }
                                }, 'json');
                            }
                        }
                    }
                }, {
                    name: 'Delete All',
                    bclass: 'earse',
                    onpress: function() {
                        var conf = confirm('Hapus Semua Item?');
                        if (conf) {
                            $(this).loadingProgress('start');
                            $.post($('#printlist').attr('link_d'), {
                                action: 'all'
                            }, function(o) {
                                $(this).loadingProgress('stop');
                                if (o) {
                                    alert('Semua Item Telah Dihapus.');
                                    $('#printlist').flexReload();
                                } else {
                                    alert('Proses Hapus Gagal.');
                                }
                            }, 'json');
                        }
                    }
                }, {
                    separator: true
                }, {
                    name: 'Print Card',
                    bclass: 'print',
                    onpress: function() {
                        $("#box-print").dialog("open");
                        $("#box-print iframe").attr('src', $('#printlist').attr('link_p')).css({'width': '675px', 'height': screen.height - 300});
                    }
                }],
            searchitems: [{
                    display: 'ID',
                    name: 'members_id',
                    isdefault: true
                }, {
                    display: 'Nama Anggota',
                    name: 'members_name'
                }],
            nowrap: false,
            sortname: "members_id",
            sortorder: "asc",
            usepager: true,
            title: $('#printlist').attr('title'),
            useRp: true,
            rp: 15,
            showTableToggleBtn: false,
            resizable: false,
            width: screen.width * 0.76,
            height: screen.height * 0.52
        });

        $('#box-print').dialog({
            closeOnEscape: false,
            autoOpen: false,
            height: screen.height - 240,
            width: 700,
            modal: true,
            resizable: false,
            draggable: false
        });
    });
</script>

