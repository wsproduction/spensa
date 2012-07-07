<div id="border_content">
    <div id="title_content">
        <div class="left">Dewey Decimal Classification Edition 22</div>
    </div>
    <div id="board_content">
        <div id="filter_box">
            <div class="left">
                <?php
                Form::begin('fFilter', 'ddc/filter', 'post');

                Form::label('Filter | ', 'keyword');
                Form::create('text', 'keyword');
                Form::tips('Type keyword');
                Form::size(40);
                Form::commit();

                Form::create('select', 'filterCategory');
                Form::tips('Type keyword');
                Form::option(array(1 => 'Call Number', 2 => 'Title'));
                Form::commit();

                Form::create('submit', 'btnFilter');
                Form::value('Search');
                Form::style('action_search');
                Form::commit();

                Form::end();
                ?>
            </div>
            <div class="right">
                <?php
                Form::create('button', 'btnAddData');
                Form::value('Tambah Data');
                Form::style('action_add');
                Form::commit();
                Form::create('button', 'btnDeleteData');
                Form::value('Delete');
                Form::style('action_delete');
                Form::commit();
                ?>
            </div>
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
                    <th style="width: 100px;">Call Number</th>
                    <th>Title</th>
                    <th style="width: 100px;">Action</th>
                </tr>
            </thead>
            <tbody><?php echo $listData; ?></tbody>
        </table>
    </div>
</div>

