<div class="maincontent">
    <div class="maincontentinner">
        <table id="list" title="<?php echo Web::getTitle(); ?>" link_c="<?php echo $link_c; ?>" link_r="<?php echo $link_r; ?>" link_d="<?php echo $link_d; ?>">
        </table>
    </div>
</div>

<script>
    $(function() {
        var option = {
            url: $('#list').attr('link_r'),
            dataType: 'xml',
            colModel: [{
                    display: 'ID',
                    name: 'publisher_id',
                    width: 40,
                    sortable: true,
                    align: 'center'
                }, {
                    display: 'Nama Penerbit',
                    name: 'publisher_name',
                    width: 250,
                    sortable: true,
                    align: 'left'
                }, {
                    display: 'Keterangan',
                    name: 'publisher_description',
                    width: 450,
                    sortable: true,
                    align: 'left',
                    hide: true
                }, {
                    display: 'Jumlah Kantor',
                    name: 'publisher_address',
                    width: 100,
                    sortable: true,
                    align: 'center'
                }, {
                    display: 'Tanggal Input',
                    name: 'publisher_address',
                    width: 100,
                    sortable: true,
                    align: 'center'
                }, {
                    display: 'Tanggal Update',
                    name: 'publisher_address',
                    width: 100,
                    sortable: true,
                    align: 'center'
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
                        window.location = $('#list').attr('link_c');
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
                                $('#list .trSelected td[abbr=publisher_id] div').each(function() {
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
                }, {
                    separator: true
                }],
            searchitems: [{
                    display: 'Nama Penerbit',
                    name: 'publisher_name'
                }],
            nowrap: false,
            sortname: "publisher_id",
            sortorder: "asc",
            usepager: true,
            title: $('#list').attr('title'),
            useRp: true,
            rp: 20,
            showTableToggleBtn: false,
            resizable: false,
            width: screen.width * 0.76,
            height: screen.height * 0.52
        };

        $('#list').flexigrid(option);
    });
</script>

