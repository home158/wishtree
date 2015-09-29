<div id="content">
    <div class="fortune_set response clearfix">
        <div class="block-wrapper clearfix">
            <ul class="tabs general" >
                <li>
                    <a data-load="main_content" href="/fortune/request" class="ctrl">{fortune_request}</a>
                </li>
                <li>
                    <a data-load="main_content" href="/fortune" class="ctrl">{fortune_teller_info}</a>
                </li>
                <li>
                    <a data-load="main_content" href="/fortune/pending" class="ctrl">{fortune_services}</a>
                </li>
                <li>
                    <a data-load="main_content" href="/fortune/reject" class="ctrl">{fortune_message_to_fortune_teller}</a>
                </li>
                <li>
                    <a data-load="main_content" href="/fortune/expire" class="ctrl">{fortune_sharing}</a>
                </li>
                <li class="active">
                    <a data-load="main_content" href="/fortune/history" class="ctrl">{fortune_history}</a>
                </li>
            </ul>
        </div>
        <div class="hd iconhead green">
            <h3>我要詢問</h3>
        </div>
        <div class="selectctr right">
            <a data-load="main_content" href="/fortune/history"><img src="/_images/ico_re_list.gif"> 回算命記錄清單</a>
        </div>

        <div class="tit-more tit-box clearfix left">
            <div>
                請輸入下列資料，我們將儘速以Email回覆您，並將命理諮詢錄保留，供您日後反覆參考。
            </div>
            <div>
                如您尚未付款欲取消，請至 <a data-load="main_content" href="/fortune/history">算命記錄</a> 點選「取消」進行相關程序。
			</div>
        </div>

        <div class="boldhead mtop25">
            <div class="wraper">
                 
            </div>
        </div>
        <form action="/fortune/new_problem/{fortune_GUID}" method="post">
        <table class="listtable infotable table-bborder">
            <colgroup>
                <col width="95">
                <col width="40%">
                <col width="95">
                <col width="40%">
            </colgroup>
            <tbody>
            {orderlist}
            <tr class="gray2">
                <th class="right dot ">訂單編號</th>
                <td class="left dot">{FortuneID}</td>
                <th class="right ">訂購日期</th>
                <td class="left">{DateCreate}</td>
            </tr>
            <tr class="gray2">
                <th class="right dot ">商品名稱</th>
                <td class="left dot">{OderTitle}</td>
                <th class="right ">訂購人姓名</th>
                <td class="left">朱育成</td>
                <input type="hidden" name="pblm_name" value="朱育成">
            </tr>
            <tr class="gray2">
                <th class="right dot v_middle">{grid_column_pblm_tel}</th>
                <td class="left dot">
                    <input type="text" name="pblm_tel" value="<?= set_value('pblm_tel','{PblmTel}'); ?>" maxlength="40">
                    <br>
                    <em class="note">範例: line:wendy787; 手機:0912345678</em>
                </td>
                <th class="right v_middle">
                    {grid_column_pblm_email}
                </th>
                <td class="left">
                    <input type="text" name="pblm_email" value="<?= set_value('pblm_email','{PblmEmail}'); ?>" class="InputTxt" maxlength="50">
                    <em class="note"></em><br>
                    <?= form_error('pblm_email'); ?><br>

                </td>
            </tr>
            {/orderlist}
            <tr class="gray2"><th class="right dot">{grid_column_fortune_pblm_code}</th>
                <td class="left" colspan="3">
                    <div class="QTd">
                        {pblm_radio}
                    </div>
                    </div>
                </td>
            </tr>
            <tr class="gray2">
                <th class="right dot" nowrap="nowrap">
                                {grid_column_fortune_pblm}<br><em>
                                  尚可輸入<input type="text" class="text_count" name="TextCount" value="{text_count}" size="2" readonly="true">字
                                </em>
                </th>
                <td class="left" colspan="3">
                    <textarea name="fortune_message" onkeydown="CheckTextLength(this.form,{text_count});" onkeyup="CheckTextLength(this.form,{text_count});" class="QTextarea"><?= set_value('fortune_message'); ?></textarea>
                    <?= form_error('fortune_message'); ?><br>

                </td>
            </tr>

            </tbody>
        </table>
        <div class="boldhead">
            <div class="wraper">
                 
            </div>
        </div>
        <div class="selectctr right">
            <a data-load="main_content" href="/fortune/history"><img src="/_images/ico_re_list.gif"> 回算命記錄清單</a>
        </div>

        <p class="tc">
          <input id="submit" type="submit" class="btn-xl btn-ele" value="{btn_submit}">
        </p>

        </form>
    </div>
</div>
<script>
function CheckTextLength(thisform, maxlen){
    if(thisform.fortune_message.value.length > maxlen)
		thisform.fortune_message.value = thisform.fortune_message.value.substring(0, maxlen);
	else
		thisform.TextCount.value = maxlen - thisform.fortune_message.value.length;
} // end of CheckTextLength
</script>