<div id="box">
    <div id="box_title">
        <div class="left"><?php echo Web::getTitle(); ?></div>
        <div class="right">
            <?php
            Form::create('button', 'btnBack');
            Form::value('Back');
            Form::style('action_back');
            Form::properties(array('link' => $link_back));
            Form::commit();
            ?>
        </div>
    </div>
    <div id="box_content">
        <div id="tab_detail">
            <ul>
                <li><a href="#tabs-1">1. Rincian Buku</a></li>
                <li><a href="#tabs-2">2. Koleksi Buku</a></li>
            </ul>
            <div id="tabs-1">
                <?php
                /*
                  Form::create('button', 'btnPrintLabel');
                  Form::value('Print Label');
                  Form::style('action_print');
                  Form::properties(array('link' => $link_print_label));
                  Form::commit();
                 * 
                 */
                ?>
                <table style="width: 100%;" class="detail_form" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="width: 250px;">
                            <div class="label-ina">ID Buku</div>
                            <div class="label-eng">Book ID</div>
                        </td>
                        <td style="width: 20px;">:</td>
                        <td>
                            <?php
                            $book_id = '-';
                            if (!empty($data['book_id']))
                                $book_id = $data['book_id'];
                            echo $book_id;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="label-ina">Judul Buku</div>
                            <div class="label-eng">Book Title</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            $book_title = '-';
                            if (!empty($data['book_title']))
                                $book_title = $data['book_title'];
                            echo $book_title;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="label-ina">Judul Bahasa Lain</div>
                            <div class="label-eng">Foreign Title</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            $book_foreign_title = '-';
                            if (!empty($data['book_foreign_title']))
                                $book_foreign_title = $data['book_foreign_title'];
                            echo $book_foreign_title;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="label-ina">Bahasa</div>
                            <div class="label-eng">Language</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            $language = '-';
                            $language_count = count($language_list);
                            if ($language_count > 0) {
                                $language = '';
                                $idx = 1;
                                foreach ($language_list as $row_language) {
                                    $language .= $row_language['language_name'];
                                    if ($idx < $language_count)
                                        $language .= ', ';
                                    $idx++;
                                }
                            }
                            echo $language;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="label-ina">Edisi / Centakan</div>
                            <div class="label-eng">Edition / Copies</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            $edition = '-';
                            $copies = '-';
                            if (!empty($data['book_edition']))
                                $edition = $data['book_edition'];
                            if (!empty($data['book_copy']))
                                $copies = $data['book_copy'];
                            echo $edition . ' / ' . $copies;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="label-ina">ISBN</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            $book_isbn = '-';
                            if (!empty($data['book_isbn']))
                                $book_isbn = $data['book_isbn'];
                            echo $book_isbn;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="label-ina">Halaman Angka / Halaman Romawi</div>
                            <div class="label-eng">Page Number / Page Romance</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            $page_romance = '-';
                            $page_number = '-';
                            if (!empty($data['book_roman_number']))
                                $page_romance = $data['book_roman_number'];
                            if (!empty($data['book_pages_number']))
                                $page_number = $data['book_pages_number'];
                            echo $page_number . ' / ' . $page_romance . ' Halaman';
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="label-ina">Bibliografi</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            $book_bibliography = '-';
                            if (!empty($data['book_bibliography']))
                                $book_bibliography = 'Hlm. ' . $data['book_bibliography'];
                            echo $book_bibliography;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="label-ina">Ilustrasi / Index</div>
                            <div class="label-eng">Ilustration / Index</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            $ilustration = 'Tidak Ada';
                            $index = 'Tidak Ada';
                            if ($data['book_ilustration'])
                                $ilustration = 'Ada';
                            if ($data['book_index'])
                                $index = 'Ada';
                            echo $ilustration . ' / ' . $index;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="label-ina">Ukuran / Berat</div>
                            <div class="label-eng">Size / Weight</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php echo $data['book_width'] . 'x' . $data['book_height'] . 'Cm / ' . $data['book_weight'] . 'Kg'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="label-ina">Eksemplar</div>
                            <div class="label-eng">Quantity</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            $book_quantity = '-';
                            if (!empty($data['book_quantity']))
                                $book_quantity = $data['book_quantity'] . ' Buku';
                            echo $book_quantity;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="label-ina">Harga</div>
                            <div class="label-eng">Price</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            $price = '-';
                            if ($data['book_price'] > 0)
                                $price = $data['accounting_symbol'] . ' ' . $data['book_price'];
                            echo $price;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="label-ina">Asal / Sumber</div>
                            <div class="label-eng">Source / Fund</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            $fund = '-';
                            $book_resource = '-';
                            if (!empty($data['fund']))
                                $fund = $data['fund'];
                            if (!empty($data['resource']))
                                $book_resource = $data['resource'];
                            echo $book_resource . ' / ' . $fund;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="label-ina">Tahun Terbit</div>
                            <div class="label-eng">Publish Years</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php echo $data['book_publishing']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">
                            <div class="label-ina">Penanggung Jawab</div>
                            <div class="label-eng">Author</div>
                        </td>
                        <td valign="top">:</td>
                        <td>
                            <?php
                            $author = '';
                            foreach ($author_list as $value) {
                                $author .= '<div style="font-weight:bold;text-decoration:underline;">' . $value['title'] . ' : </div>';
                                $author .= '<ol style="padding-left:20px;">';
                                foreach ($value['name'] as $row) {
                                    $author .= '<li>' . $row['first_name'] . ' ' . $row['last_name'] . '</li>';
                                }
                                $author .= '</ol>';
                            }
                            echo $author;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">
                            <div class="label-ina">Klasifikasi Buku</div>
                            <div class="label-eng">Book Classification</div>
                        </td>
                        <td valign="top">:</td>
                        <td>
                            <?php
                            $book_classification = '<div style="font-weight:bold;text-decoration:underline;">' . $data['ddc_classification_number'] . $callnumber_extention . '</div>';

                            $ddcparent = $ddc_list[0];
                            $book_classification .= '<div>' . $ddcparent['cn1'] . ' &rAarr; ' . $ddcparent['main_class'] . ' </div>';
                            $book_classification .= '<div style="padding-left:40px;">&rdsh;' . $ddcparent['cn2'] . ' &rAarr; ' . $ddcparent['sub_class'] . '</div>';
                            $book_classification .= '<div style="padding-left:80px;">&rdsh;' . $data['ddc_classification_number'] . ' &rAarr; ' . $data['ddc_title'] . '</div>';
                            echo $book_classification;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">
                            <div class="label-ina">Resensi</div>
                            <div class="label-eng">Book Review</div>
                        </td>
                        <td valign="top">:</td>
                        <td>
                            <?php
                            $review = '-';
                            if (!empty($data['book_review']))
                                $review = $data['book_review'];
                            echo $review;
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="tabs-2">
                <table id="list-collection" link_r="<?php echo $link_r_collection; ?>" link_p="<?php echo $link_p_collection; ?>" link_pl="<?php echo $link_pl_collection; ?>"></table>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    $(function(){
        $('#tab_detail').tabs();
        $('#list-collection').flexigrid({
            url : $('#list-collection').attr('link_r'),
            dataType : 'xml',
            colModel : [ {
                    display : 'Nomor Induk Buku', 
                    name : 'book_register_id', 
                    width : 170,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Kondisi Buku',
                    name : 'language_name',
                    width : 100,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Jumlah Pemipinjam',
                    name : 'language_name',
                    width : 150,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Terakhir Dipinjam',
                    name : 'language_name',
                    width : 200,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Tanggal Input',
                    name : 'language_name',
                    width : 150,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Opsi',
                    width : 150,
                    sortable : false,
                    align : 'center'
                }],
            buttons : [{
                    name : 'Tambah',
                    bclass : 'add',
                    onpress : function() {
                        
                    }
                }, {
                    name : 'Hapus',
                    bclass : 'delete',
                    onpress : function() {
                        var leng = $('#list-collection .trSelected').length;
                        var conf = confirm('Delete ' + leng + ' items?');
                
                        if (conf) {
                            if (leng > 0) {
                                var tempId = [];
                                $('#list-collection .trSelected td[abbr=book_register_id] div').each(function() {
                                    tempId.push(parseInt($(this).text()));
                                });
                                
                                $(this).loadingProgress('start');
                                $.post($('#list-collection').attr('link_d'), {
                                    id : tempId.join(',')
                                }, function(o){
                                    if (o) {
                                        alert(leng + ' Item has deleted.');
                                        $('#list-collection').flexReload();
                                    } else {
                                        alert('Process delete failed.');
                                    }                            
                                }, 'json');
                            }
                        }
                    }
                }, {
                    separator : true
                }, {
                    name : 'Tambah Ke Daftar Print',
                    bclass : 'issue',
                    onpress : function() {
                        var leng = $('#list-collection .trSelected').length;
                        var conf = confirm('Print ' + leng + ' items?');
                
                        if (conf) {
                            if (leng > 0) {
                                var tempId = [];
                                $('#list-collection .trSelected td[abbr=book_register_id] div').each(function() {
                                    tempId.push(parseInt($(this).text()));
                                });
                                
                                $(this).loadingProgress('start');
                                $.post($('#list-collection').attr('link_p'), {
                                    id : tempId.join(',')
                                }, function(o){
                                    $(this).loadingProgress('stop');
                                    if (o) {
                                        alert(leng + ' Item has saved.');
                                        $('#list-collection').flexReload();
                                    } else {
                                        alert('Process saved failed.');
                                    }                            
                                }, 'json');
                            }
                        }
                    }
                }, {
                    name : 'Lihat Daftar Print',
                    bclass : 'card',
                    onpress : function() {
                        window.location = $('#list-collection').attr('link_pl');
                    }
                }],searchitems : [ {
                    display : 'Nomor Induk',
                    name : 'book_register_id',
                    isdefault : true
                }],
            nowrap : false,
            sortname : "book_register_id",
            sortorder : "asc",
            usepager : true,
            title : 'Daftar Koleksi Buku',
            useRp : true,
            rp : 15,
            showTableToggleBtn : false,
            resizable : false,
            width : '100%',
            height : screen.height * 0.45
        });
    });
</script>
