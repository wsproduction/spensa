<div class="maincontent">
    <div class="maincontentinner">
        <center>
            <table id="list" title="<?php echo Web::getTitle(); ?>" link_c="<?php echo $link_c; ?>" link_r="<?php echo $link_r; ?>" link_d="<?php echo $link_d; ?>" link_pl="<?php echo $link_pl; ?>" style="display: none;">
            </table>
        </center>
    </div>
</div>

<script>
    $(function() {

        $('#list').flexigrid({
            url: $('#list').attr('link_r'),
            dataType: 'xml',
            colModel: [{
                    display: 'ID',
                    name: 'book_id',
                    width: 70,
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
                    display: 'Eksemplar',
                    name: 'book_quantity',
                    width: 60,
                    sortable: true,
                    align: 'center',
                    hide: true
                }, {
                    display: 'Stok',
                    name: 'length_borrowed',
                    width: 50,
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
                    display: 'Tanggal Update',
                    name: 'book_entry_date',
                    width: 80,
                    sortable: true,
                    align: 'center',
                    hide: true
                }, {
                    display: 'Option',
                    name: 'option',
                    width: 80,
                    align: 'center'
                }],
            buttons: [{
                    name: 'Tambah',
                    bclass: 'add',
                    onpress: function() {
                        window.location = $('#list').attr('link_c')
                    }
                }, {
                    name: 'Hapus',
                    bclass: 'delete',
                    onpress: function() {
                        var leng = $('#list .trSelected').length;
                        var conf = confirm('Delete ' + leng + ' items?');

                        if (conf) {
                            if (leng > 0) {
                                var tempId = [];
                                $('#list .trSelected td[abbr=book_id] div').each(function() {
                                    tempId.push(parseInt($(this).text()));
                                });

                                $.post($('#list').attr('link_d'), {
                                    id: tempId.join(',')
                                }, function(o) {
                                    if (o) {
                                        $('#list').flexReload();
                                    } else {
                                        alert('Process delete failed.');
                                    }
                                }, 'json');
                            }
                        }
                    }
                }],
            searchitems: [{
                    display: 'ID',
                    name: 'book_id',
                    isdefault: true
                }, {
                    display: 'Judul Buku',
                    name: 'book_title'
                }, {
                    display: 'Pengarang',
                    name: 'ddc_title'
                }, {
                    display: 'Penerbit',
                    name: 'ddc_title'
                }, {
                    display: 'Asal',
                    name: 'ddc_title'
                }, {
                    display: 'Sumber',
                    name: 'ddc_level'
                }],
            nowrap: false,
            sortname: "book_id",
            sortorder: "asc",
            usepager: true,
            title: $('#list').attr('title'),
            useRp: true,
            rp: 20,
            showTableToggleBtn: false,
            resizable: false,
            width: screen.width * 0.76,
            height: screen.height * 0.52
        });
    });
</script>

