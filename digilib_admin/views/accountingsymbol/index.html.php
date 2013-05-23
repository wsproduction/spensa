<div class="maincontent">
    <div class="maincontentinner">
        <center>
            <table id="list" title="<?php echo Web::getTitle(); ?>" link_c="<?php echo $link_c; ?>" link_r="<?php echo $link_r; ?>" link_d="<?php echo $link_d; ?>" style="display: none;">
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
                    name: 'accounting_symbol_id',
                    width: 40,
                    sortable: true,
                    align: 'center'
                }, {
                    display: 'Nama Mata Uang',
                    name: 'accounting_symbol_title',
                    width: 450,
                    sortable: true,
                    align: 'left'
                }, {
                    display: 'Symbol',
                    name: 'accounting_symbol',
                    width: 80,
                    sortable: true,
                    align: 'center'
                }, {
                    display: 'Status',
                    name: 'accounting_symbol_status',
                    width: 60,
                    sortable: true,
                    align: 'center',
                    hide: true
                }, {
                    display: 'Tanggal Input',
                    name: 'accounting_symbol_entry',
                    width: 100,
                    sortable: true,
                    align: 'center'
                }, {
                    display: 'Tanggal Update',
                    name: 'accounting_symbol_entry_update',
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
                                $('#list .trSelected td[abbr=accounting_symbol_id] div').each(function() {
                                    tempId.push(parseInt($(this).text()));
                                });

                                $(this).loadingProgress('start');
                                $.post($('#list').attr('link_d'), {
                                    id: tempId.join(',')
                                }, function(o) {
                                    $(this).loadingProgress('stop');
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
                    name: 'accounting_symbol_id',
                    isdefault: true
                }, {
                    display: 'Nama Mata Uang',
                    name: 'accounting_symbol_title'
                }, {
                    display: 'Symbol',
                    name: 'accounting_symbol'
                }],
            nowrap: false,
            sortname: "accounting_symbol_id",
            sortorder: "asc",
            usepager: true,
            title: $('#list').attr('title'),
            useRp: true,
            rp: 15,
            showTableToggleBtn: false,
            resizable: false,
            width: screen.width * 0.76,
            height: screen.height * 0.52
        });
    });
</script>

