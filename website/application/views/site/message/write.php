<script src="/_js/jquery.Jcrop.min.js"></script>
<link rel="stylesheet" href="/_css/jquery.Jcrop.min.css" type="text/css" />
<div id="content">
    <div class="write_set bg">
        <div class="well well-lg  clearfix">
            <div class="write_left fl">
                <img src="{CropBasename}">
            </div>
            <div class="write_right fr">
                
                    <p><b>注意事項:</b>根據我們的用戶協議,如果您發送垃圾郵件或攻擊性語言,我們將有權停止/刪除您的帳號.</p>
                    <p><b>注意事項:</b>如果您不希望收到垃圾郵件,請不要隨意將您的常用 Email 發送給不太認識的人.</p>
                <form action="/message/write/{GUID}" method="POST">
                    <textarea name="message_content" id="message_content"></textarea>
                    <em class="note"></em><br>
                    <?= form_error('message_content'); ?><br>
                    <div class="tr">
                    <input type="submit" class="btn-xl btn-emp" value="{btn_submit}">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
