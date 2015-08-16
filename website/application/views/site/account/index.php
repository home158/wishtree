<div id="content">
    <div class="account_set clearfix">
        <div class="contentl fl">
            <!-- main content -->
            <div >
                <p class="hd">個人帳戶 {Nickname}</p>
                <ul>
                    <li>會員資格：{member_ship}</li>
                    <li>帳戶類型：{role}</li>
                    <li></li>
                </ul>
                <p class="hd">帳戶統計資料</p>
                <ul>
                    <li>{account_public_photo}</li>
                    <li>{account_private_photo}</li>
                    <li>{account_priviliege_check_my_private_photo}</li>
                    <li>{account_has_been_added_to_white_list}</li>
                    <li>{account_my_favorite}</li>
                    <li>{account_my_blocked_list}</li>
    
                </ul>
                <p class="hd">提醒設置</p>
                <p class="hd">管理您的帳戶</p>
                <ul>
                    <li>更改密碼</li>
                    <li>刪除帳號</li>
                    <li><a href="/account/update_profile">編輯您的個人檔案</a> {profile_latest_update_date}</li>
                    <li><a href="/account/profile">瀏覽我的主頁</a></li>
                </ul>
                <p class="hd">審核狀態</p>
                <ul>
                    <li>電子郵件認證：{email_validated} {send_email_validated_again}</li>
                    <li>資料審核：{profile_review} {profile_review_date}</li>
                    
                    <li>公開照片：{public_photo_review}</li>
                </ul>




            </div>
        </div>
        <!-- sidebar -->

            
            <div class="wrap-box fr">
                    <div class="wrap-inner">
                        <h3>{login_form_title}</h3>
                    </div>
            </div>
        
    </div>
 </div>

<script>
$(function() {
    $('input[name=email]').val($.cookie("WG_email"));
    $('input[name=password]').val($.cookie("WG_password"));
    $('input[name=password_encrypt]').val($.cookie("WG_password"));
});
    
</script>