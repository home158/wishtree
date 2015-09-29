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
            <h3>諮詢紀錄</h3>
        </div>
        <div class="selectctr right">
            <a data-load="main_content" href="/fortune/history"><img src="/_images/ico_re_list.gif"> 回算命記錄清單</a>
        </div>

        <div class="boldhead mtop25">
            <div class="wraper">
                訂單資料
            </div>
        </div>
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
                        {PblmTel}
                    </td>
                    <th class="right v_middle">
                        {grid_column_pblm_email}
                    </th>
                    <td class="left">
                        {PblmEmail}

                    </td>
                </tr>
                {/orderlist}
            </tbody>
        </table>

        <div class="boldhead mtop25">
            <div class="wraper">
                諮詢紀錄
            </div>
        </div>
        <table class="listtable infotable table-bborder">
            <colgroup>
                <col width="20%">
                <col width="80%">
            </colgroup>
            <thead class="gray">
                <tr>
                    <th class="left NoDotV">
                        以下是您的詢問與回覆紀錄：
                    </th>
                    <th class="right NoDotV">
                        <div class="IWantQbtn">
                            <a href="/fortune/new_problem/{fortune_GUID}">我要詢問</a>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                {message_list}
                <tr class="gray2">
                    <th class="right dot">
                        您的問題<br>{MessageID}
                    </th>
                    <td class="left dot">
                        <div>
                            <em>發問時間：{DateCreate}(問題類別：{PblmCode})</em>
                        </div>
                        <div>{FortuneMessage}</div>
                    </td>
                </tr>

                        {MessageReply}
                {/message_list}

            </tbody>
        </table>
        <div class="selectctr right">
            <a data-load="main_content" href="/fortune/history"><img src="/_images/ico_re_list.gif"> 回算命記錄清單</a>
        </div>
    </div>
</div>