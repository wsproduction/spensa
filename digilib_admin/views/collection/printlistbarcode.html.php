<div class="maincontent">
    <div class="maincontentinner">
        <center>
            <table id="printlist" title="<?php echo Web::getTitle(); ?>" link_r="<?php echo $link_r; ?>" link_p="<?php echo $link_p; ?>" link_d="<?php echo $link_d; ?>" link_da="<?php echo $link_da; ?>" style="display: none;">
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
                    name: 'book_temp_barcodeprint',
                    width: 60,
                    sortable: true,
                    align: 'center'
                }, {
                    display: 'Nomor Induk',
                    name: 'book_register_id',
                    width: 80,
                    sortable: true,
                    align: 'center'
                }, {
                    display: 'Keterangan Buku',
                    name: 'book_title',
                    width: 450,
                    sortable: true,
                    align: 'left'
                }, {
                    display: 'Asal',
                    name: 'resource_name',
                    width: 100,
                    sortable: true,
                    align: 'center',
                    hide: true
                }, {
                    display: 'Sumber',
                    name: 'fund_name',
                    width: 100,
                    sortable: true,
                    align: 'center',
                    hide: true
                }, {
                    display: 'Kondisi Buku',
                    name: 'book_quantity',
                    width: 60,
                    sortable: true,
                    align: 'center',
                    hide: true
                }, {
                    display: 'Jumlah Peminjam',
                    name: 'length_borrowed',
                    width: 90,
                    sortable: true,
                    align: 'center',
                    hide: true
                }, {
                    display: 'Terakhir Dipinjam',
                    name: 'book_entry_date',
                    width: 80,
                    sortable: true,
                    align: 'center',
                    hide: true
                }, {
                    display: 'Tanggal Input',
                    name: 'book_entry_date',
                    width: 80,
                    sortable: true,
                    align: 'center',
                    hide: true
                }, {
                    display: 'Jml. Print Barcode',
                    name: 'book_entry_date',
                    width: 100,
                    sortable: true,
                    align: 'center',
                    hide: true
                }],
            buttons: [{
                    name: 'Hapus',
                    bclass: 'delete',
                    onpress: function() {
                        var leng = $('#printlist .trSelected').length;
                        var conf = confirm('Delete ' + leng + ' items?');

                        if (conf) {
                            if (leng > 0) {
                                var tempId = [];
                                $('#printlist .trSelected td[abbr=book_temp_barcodeprint] div').each(function() {
                                    tempId.push(parseInt($(this).text()));
                                });

                                $(this).loadingProgress('start');
                                $.post($('#printlist').attr('link_d'), {
                                    id: tempId.join(',')
                                }, function(o) {
                                    $(this).loadingProgress('stop');
                                    if (o) {
                                        alert(leng + ' Item has deleted.');
                                        $('#printlist').flexReload();
                                    } else {
                                        alert('Process delete failed.');
                                    }
                                }, 'json');
                            }
                        }
                    }
                }, {
                    name: 'Hapus Semua',
                    bclass: 'earse',
                    onpress: function() {
                        var conf = confirm('Are you delete all items?');
                        if (conf) {
                            $(this).loadingProgress('start');
                            $.post($('#printlist').attr('link_da'), {
                                action: 'all'
                            }, function(o) {
                                $(this).loadingProgress('stop');
                                if (o) {
                                    alert('All Item has deleted.');
                                    $('#printlist').flexReload();
                                } else {
                                    alert('Process delete failed.');
                                }
                            }, 'json');
                        }
                    }
                }, {
                    separator: true
                }, {
                    name: 'Print Barcode',
                    bclass: 'print',
                    onpress: function() {
                        $("#box-print").dialog("open");
                        $("#box-print iframe").attr('src', $('#printlist').attr('link_p')).css({'width': '675px', 'height': screen.height - 300});
                    }
                }],
            searchitems: [{
                    display: 'Nomor Induk Buku',
                    name: 'book_temp_barcodeprint',
                    isdefault: true
                }],
            nowrap: false,
            sortname: "book_temp_barcodeprint",
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