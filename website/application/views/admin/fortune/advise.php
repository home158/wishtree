<div>
    <div class="panel panel-default">
        <div class="panel-body">
            <label>發表時間：{DateCreate}</label>
            <span class="label {label_fortune_publish}">{label_fortune_publish_text}</span>

            <span class="btn-publish-togger btn btn-default btn-xs" data-guid="{db_GUID}" data-value="{Publish}">
                <span class="glyphicon glyphicon-{btn_publish_or_anti_publish_glyphicon}" aria-hidden="true"></span> {btn_publish_or_anti_publish}
            </span>
            <span class="btn-advise-edit btn btn-default btn-xs" data-guid="{db_GUID}">
                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> {btn_edit}
            </span>
            <span class="btn-advise-delete btn btn-default btn-xs" data-guid="{db_GUID}">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> {btn_delete}
            </span>
        </div>
        <div class="panel-footer">
            <div class="reply_message ">
                {AdviseMessage}
            </div>
        </div>
    </div>


</div>

