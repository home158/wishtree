<link rel="stylesheet" type="text/css" href="/_css/register.css" />

<script>

</script>
<div class="pand-console">
    <div class="pane-header">
        <h1 id="myHeader" class="trend-header">更改密碼</h1>
    </div>

    <form enctype="multipart/form-data" id="signup-form" action="/admin/account/change_password" method="post">
        <div class="container block blk-reg">
            <div class="inside">

              <span class="item">原始密碼 : </span>
              <input name="password_old" id="Member_name" type="password" value="" /><br>
              <?php echo form_error('password_old'); ?>
              <br> 
                   
              <span class="item">重設密碼 : </span>
              <input name="password" id="Member_name" type="password" value="" /><br>
              <em class="note">* 密碼長度8-20位，內容至少要有一個數字與英文字母</em><br>
                <?php echo form_error('password'); ?><br> 

              <span class="item">再輸入一次密碼 : </span>
              <input name="password_chk" id="Member_name" type="password" value="" /><br>
                <?php echo form_error('password_chk'); ?><br>

        </div>
    </div>
    <div class="pane-footer">
        <input id="searchBtn" type="submit" class="btn-calm" value="&nbsp;&nbsp;送出&nbsp;&nbsp;"/>        <input id="cancelBtn" type="submit" class="btn-calm" value="&nbsp;&nbsp;取消&nbsp;&nbsp;"/>
    </div>
   </form>  
</div>

