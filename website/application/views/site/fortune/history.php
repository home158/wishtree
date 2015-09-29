<div id="content">
    <div class="fortune_set clearfix">
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
    </div>
    <div class="history">
        <div class="boldhead">
            <div class="wraper">
                <span class="pagenum">第 <strong>1</strong> 頁 ，共 1 頁 （共 1 筆）</span>
            </div>
        </div>
        <table class="listtable">
            <colgroup>
                    <col width="13%">
                    <col width="26%">
                    <col width="13%">
                    <col width="8%">
                    <col width="8%">
                    <col width="8%">
                    <col width="8%">
                    <col width="8%">
                    <col width="8%">
            </colgroup>
            <thead class="gray">
                <tr>
                    <th>訂單編號</th>
                    <th>商品名稱</th>
                    <th>訂購日期</th>
                    <th>總金額</th>
                    <th>訂單狀態</th>
                    <th>論命狀態</th>
                    <th>取消</th>
                    <th>滿意度</th>
                    <th>命理諮詢</th>
                    	
                </tr>
            </thead>
            <tbody>
                {orderlist}
                <tr>
                    <td>{FortuneID}</td>
                    <td>{OderTitle}</td>
                    <td>{DateCreate}</td>
                    <td>USD 19.99</td>
                    <td>{OderStatus}</td>
                    <td>{FortuneStatus}</td>
                    <td>{ST}</td>
                    <td>滿意度</td>
                    <td>
                        {Discussion}
                    </td>

                </tr>
                {/orderlist}
                <tr>
                    <th>YM1509060072971</th>
                    <th>alpha 先生,批流年,乙亥(豬)年 二月初一寅時</th>
                    <td>2015-10-06 18:23</td>
                    <th>600</th>
                    <th>
                        等待付款
                        <br>
                        通知已付款

                    </th>
                    <th>等待定盤</th>
                    <th>取消</th>
                    <th>滿意度</th>
                    <th>
                        詢問
                        <br/>
                        查看
                    </th>
                    	
                </tr>
            </tbody>
        </table>
        <div class="boldhead">
            <div class="wraper">
                <span class="pagenum">第 <strong>1</strong> 頁 ，共 1 頁 （共 1 筆）</span>
            </div>
        </div>
    </div>
    <div>
        <ol>
            <li>
                論命前請先繳清費用，並輸入個人論命資料，資料確認後，命理師會先以Line或電話為您定盤，確認您的命盤才開始批命。
            </li>
            <li>
	            付款前請確認您的生辰八字是否正確，如有錯誤請勿付款並取消訂單再次填寫表單。
            </li>
            <li>
	            付款成功不可取消訂單亦不可更改生辰八字。
            </li>
                
            <li>
                如有問題想要命理諮詢請選訂單欄位中命理諮詢/詢問。
            </li>
            <li>
	            如欲辦理訂單取消，請點選訂單欄位中的相關連結，即可線上進行申請。
            </li>
            <li>
	            提醒您，我們不會要求您變更ATM匯款帳號、更改付款方式、重新設定信用卡，或電話指示您操作使用ATM櫃員機。
            </li>
        </ol>
    <div>
</div>