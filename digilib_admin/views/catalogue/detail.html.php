<div id="box">
    <div id="box_title">
        <div class="left"><?php echo Web::getTitle(); ?></div>
        <div class="right">
            <?php            
            Form::create('button', 'btnBack');
            Form::value('Back');
            Form::style('action_back');
            Form::properties(array('link'=>$link_back));
            Form::commit();
            ?>
        </div>
    </div>
    <div id="box_content">
        <div id="detailTab">
            <ul>
                <li><?php URL::link('#fragment-1', 'Detail Buku'); ?></li>
                <li><?php URL::link('#fragment-2', 'Katalog'); ?></li>
                <li><?php URL::link('#fragment-3', 'Koleksi Buku'); ?></li>
            </ul>
            <div id="fragment-1">
                <?php
                Form::create('button','btnPrintLabel');
                Form::value('Print Label');
                Form::style('action_print');
                Form::properties(array('link'=>$link_print_label));
                Form::commit();
                ?>
                <br><br>
                Underconstruction!!!
            </div>
            <div id="fragment-2">
                Underconstruction!!!
            </div>
            <div id="fragment-3">
                <div style="margin-bottom: 10px;text-align: right;">
                    <?php
                    Form::create('button', 'btnPrintBarcode');
                    Form::value('Print Barcode');
                    Form::style('action_print');
                    Form::properties(array('link'=>$link_print_barcode));
                    Form::commit();
                    ?>
                </div>
                
                <table id="list" class="list" style="width: 100%;" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 10px;" class="first" >
                                <?php
                                Form::create('checkbox', 'cbSelectAll');
                                Form::commit();
                                ?>
                            </th>
                            <th style="width: 100px;">No. Indux</th>
                            <th style="width: 100px;">Call Number</th>
                            <th>Detail</th>
                            <th style="width: 100px;">Kondisi</th>
                            <th style="width: 100px;">Tanggal</th>
                            <th style="width: 100px;">Status</th>
                            <th style="width: 100px;">Pinj. Terakhir</th>
                            <th style="width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody><?php echo $listDataCollection; ?></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
