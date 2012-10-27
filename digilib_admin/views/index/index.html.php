<div id="box">
    <div id="box_title">
        <div class="left"><?php echo Web::getTitle(); ?></div>
    </div>
    <div id="board_content">
        <div id="message"></div>
        <?php
        Form::begin('fLogin', 'login/run', 'post');
        ?>
        <table>
            <tr>
                <td style="width: 100px;">Username</td>
                <td>:</td>
                <td>
                    <?php
                    Form::create('text', 'username');
                    Form::tips('Enter your username');
                    Form::size(30);
                    Form::validation()->requaired();
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <td>Password</td>
                <td>:</td>
                <td>
                    <?php
                    Form::create('password', 'password');
                    Form::tips('Enter your password');
                    Form::size(30);
                    Form::validation()->requaired();
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <?php
                    Form::create('submit', 'btnLgoin');
                    Form::value('Login');
                    Form::style('action_login');
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

