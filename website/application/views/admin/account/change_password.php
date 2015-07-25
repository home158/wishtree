<div class="wrap account_set">
    <div class="panel panel-warning">
      <div class="panel-heading"><strong>{account_change_password}</strong></div>
      <div class="panel-body">
                <div class="clearfix blk-reg">
                    <form name="register" action="/admin/account/change_password" method="post">
                        <div>
                            <span class="item">{grid_column_OldPassword}</span>
                            <input name="old_password" type="password" value="" /><br>
                            <?= form_error('old_password'); ?><br>

                            <span class="item">{grid_column_NewPassword}</span>
                            <input name="password" type="password" value="" /><br>
                            <em class="note">{member_password_8_20_length}</em><br>
                            <?= form_error('password'); ?><br>
            
                            <span class="item">{grid_column_PasswordCheck}</span>
                            <input name="password_chk" type="password" value="" /><br>
                            <?= form_error('password_chk'); ?><br>

                            <input type="submit" value="{btn_submit}" class="btn-relax btn-x">
                        </div>
                    </form>
                </div>
      </div>
    </div>
</div>