
<div style="margin-bottom: 10px;">
    <fieldset>
        <legend>Pencarian Buku</legend>
        <?php Form::begin('fBookFilter', 'catalogue/read', 'post'); ?>
        <table>
            <tr>
                <td width="150">
                    <div class="label-ina">Kategori Pencaraian</div>
                    <div class="label-eng">Search Category</div>
                </td>
                <td>:</td>
                <td>
                    <?php
                    $category_option = array('book_title' => 'Judul Buku');
                    Form::create('select', 'qtype');
                    Form::option($category_option);
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <td width="150">
                    <div class="label-ina">Kata Kunci</div>
                    <div class="label-eng">Keyword</div>
                </td>
                <td>:</td>
                <td>
                    <?php
                    Form::create('text', 'query');
                    Form::size(30);
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
                    Form::value('Cari');
                    Form::style('action_search');
                    Form::commit();
                    ?>
                </td>
            </tr>
        </table>
        <?php Form::end(); ?>
    </fieldset>
</div>

<table id="list" title="<?php echo Web::getTitle(); ?>" link_r="<?php echo $link_r; ?>" style="display: none;">
</table>

<script>
    $(function(){
           
        $('#list').flexigrid({
            url : $('#list').attr('link_r'),
            dataType : 'xml',
            colModel : [ {
                    display : 'ID', 
                    name : 'book_id', 
                    width : 70,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Keterangan Buku',
                    name : 'book_title',
                    width : 450,
                    sortable : true,
                    align : 'left'
                }, {
                    display : 'Asal',
                    name : 'resource_name',
                    width : 100,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Sumber',
                    name : 'fund_name',
                    width : 100,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Eksemplar',
                    name : 'book_quantity',
                    width : 60,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Stok',
                    name : 'length_borrowed',
                    width : 50,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Jumlah Peminjam',
                    name : 'book_entry_date',
                    width : 80,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Option',
                    name : 'option',
                    width : 80,
                    align : 'center'
                }],
            nowrap : false,
            sortname : "book_id",
            sortorder : "asc",
            usepager : true,
            title : $('#list').attr('title'),
            useRp : true,
            rp : 20,
            showTableToggleBtn : false,
            resizable : false,
            width : '100%',
            height : screen.height * 0.45,
            onSubmit: function() {
                var dt = $('#fBookFilter').serializeArray();
                $('#list').flexOptions({
                    params: dt
                });
                return true;
            }
        });
        
        $('#fBookFilter').live('submit',function(){
            $('#list').flexOptions({
                newp: 1
            }).flexReload();
            return false;
        });
    });
</script>

