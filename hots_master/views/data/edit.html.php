<div class="myBox">
    <div class="title"><?php echo Web::$title; ?></div>
    <div class="content">
        <div id="message"></div>
        <?php
        Form::begin('fAdd', 'data/update/' . $tempId, 'post');
        ?>
        <table>
            <tr>
                <th style="width: 200px;">Subject</th>
                <th>:</th>
                <td>
                    <?php
                    Form::create('select', 'subject');
                    Form::option($listSubject, ' ', $listQuestion['question_subject']);
                    Form::validation()->requaired();
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px;">Title Question</th>
                <th>:</th>
                <td>
                    <?php
                    Form::create('text', 'title_question');
                    Form::size(40);
                    Form::value($listQuestion['question_title']);
                    Form::validation()->requaired();
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <th valign="top">Content Question</th>
                <th valign="top">:</th>
                <td>
                    <?php
                    Form::create('textarea', 'content_question');
                    Form::value(trim(stripslashes($listQuestion['question_description']),'"'));
                    Form::validation()->requaired();
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <th>Start Date</th>
                <th>:</th>
                <td>
                    <?php
                    Form::create('text', 'start_date');
                    Form::value(date('m/d/Y', strtotime($listQuestion['question_start_date'])));
                    Form::validation()->requaired();
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <th>End Date</th>
                <th>:</th>
                <td>
                    <?php
                    Form::create('text', 'end_date');
                    Form::value(date('m/d/Y', strtotime($listQuestion['question_end_date'])));
                    Form::validation()->requaired();
                    Form::validation()->largerDateFrom('#start_date');
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <th>Status</th>
                <th>:</th>
                <td>
                    <?php
                    Form::create('select', 'status');
                    Form::option(array("0" => "Disabled", "1" => "Enabled"), '', $listQuestion['question_status']);
                    Form::validation()->requaired();
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <td>
                    <?php
                    Form::create('submit', 'title_question');
                    Form::validation()->requaired();
                    Form::value('Submit');
                    Form::commit();
                    Form::create('reset', 'title_question');
                    Form::validation()->requaired();
                    Form::value('Reset');
                    Form::commit();
                    ?>
                </td>
            </tr>
        </table>
        <?php
        Form::end();
        ?>
    </div>
</div>