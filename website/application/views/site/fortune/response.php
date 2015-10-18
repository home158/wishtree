<div id="content">
    <div class="fortune_set response clearfix ">
        <div class="block-wrapper clearfix site">
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
        <div class="hd iconhead green ">
            <h3>諮詢紀錄</h3>
        </div>
        <div class="selectctr right site">
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
        <div class="boldhead mtop25 mbtn20">
            <div class="wraper">
                命格分析(以下是命理師針對您的命盤的建議與分析)
            </div>
        </div>
        <div>
        {advise_list}
            {AdviseMessage}
        {/advise_list}
        {__advise_no_data_to_display__}
        </div>
        <div class="admin">
            <div>
                <span id="btn-new-advise" class="btn btn-default btn-s" data-value="{fortune_GUID}">
                    <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> 新增
                </span>
            </div>

        </div>
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
                    <th class="left NoDotV" colspan="2">
                        <div class="fl">
                            以下是您的詢問與回覆紀錄：
                        </div>
                        <div class="fr IWantQbtn site">
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
                        <div class="reply_message">{FortuneMessage}</div>
                        <div class="admin">
                            <span class="btn-reply btn btn-default btn-s" data-value="{MessageID}">
                                <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> 回覆
                            </span>
                        </div>
                    </td>
                </tr>
                <tr class="gray2 _default_hidden_" id="{MessageID}">
                    <th class="right dot">
                        回覆
                    </th>
                    <td class="left dot">
                        <div>
                            <form action="/admin/fortune/reply/{fortune_GUID}" method="POST">
                                <input type="text" name="reply_parent" value="{db_GUID}" />
                                <textarea class="QTextarea" name="fortune_message"></textarea>
                                <input type="submit" value="{btn_submit}" class="btn-relax btn-m">
                            </form>
                        </div>
                    </td>
                </tr>
                        {MessageReply}


                {/message_list}

            </tbody>
        </table>
        {__message_no_data_to_display__}
        <div class="selectctr right site">
            <a data-load="main_content" href="/fortune/history"><img src="/_images/ico_re_list.gif"> 回算命記錄清單</a>
        </div>
    </div>
</div>
<script type="text/javascript" src="/_js/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="/_js/jquery.popupwindow.js"></script>

<script>
$(function () {
    //tinyMCE init
    tinyMCE.init({                'selector' : "textarea",
                'theme' : "modern",
                'language' : 'zh_TW',
                'width' : '100%',
                'height' : '100%',
                'toolbar1' : "responsivefilemanager insertfile undo redo | styleselect  | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor",
                'plugins' : [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table contextmenu directionality",
                    "paste textcolor colorpicker textpattern autoresize"
                ],
                menubar : false,
                fontsize_formats : "8pt 10pt 12pt 14pt 16pt 18pt 20pt 24pt 36pt",
                setup : function(ed)
                {
                    ed.on('init', function() 
                    {
                        this.getDoc().body.style.fontSize = '16px';
                        this.getDoc().body.style.fontFamily = '14px/1.8 "Gotham Narrow SSm", "Microsoft YaHei", "微軟雅黑", "Microsoft Jhenghei", "Helvetica Neue", HelveticaNeue, Arial, sans-serif';
                    });
                }
                
    });


    $('.btn-reply').on('click',function(){
       $('#'+$(this).attr('data-value')).toggle();
    });
    $('#btn-new-advise').on('click', function () {
        
        $.popupWindow('/admin/fortune/advise/'+$(this).attr('data-value'), { 
            height: 600, 
            width: 880,
            createNew: true,
            resizable:   true,
            onUnload: function(){
                
            }
        });
    });
    $('.btn-publish-togger').on('click', function () {
            var GUID = $(this).attr('data-guid');
            var status = ($(this).attr('data-value') == '1') ? 0 : 1;
            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/admin/fortune/publish',
                dataType: 'json',
                type: 'POST',
                data: {
                    status: status,
                    GUID:GUID
                },
                success: function(r) {
                    window.location.reload();
                }
            });

    });
        $('.btn-advise-delete').on('click', function () {
            var r = confirm('{fortune_advise_delete_confirm}');
            if(r){
                var GUID = $(this).attr('data-guid');
                $.ajax({
                    //must to set synchronous, otherwise your need good design concept
                    url: '/admin/fortune/advise_delete',
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        GUID:GUID
                    },
                    success: function(r) {
                        window.location.reload();
                    }
                });
            }
    });
    $('.btn-advise-edit').on('click', function () {
        $.popupWindow('/admin/fortune/advise/{fortune_GUID}/'+$(this).attr('data-guid'), { 
            height: 600, 
            width: 880,
            createNew: true,
            resizable:   true,
            onUnload: function(){
                
            }
        });

    });
    
});

</script>
