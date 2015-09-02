<link rel="stylesheet" href="/_css/bootstrap-switch.min.css">
<div id="content">
    <div class="action_set clearfix">
        <div class="block-wrapper clearfix">
                <ul class="tabs general" >
                    <li>
                        <a data-load="main_content" href="/account/private_all" class="ctrl">{account_private_all}</a>
                    </li>
                    <li>
                        <a data-load="main_content" href="/account/private_approved" class="ctrl">{account_private_approved}</a>
                    </li>
                    <li>
                        <a data-load="main_content" href="/account/private_reject" class="ctrl">{account_private_reject}</a>
                    </li>
                    <li class="active">
                        <a data-load="main_content" href="/account/private_pendding" class="ctrl">{account_private_pendding}</a>
                    </li>
                </ul>
        </div>

        <ul>
            {pending_list}
            <li class="user clearfix">
                <div class="avatar">
                    <a data-load="main_content" href="/view/{TrackUserGUID}"><img src="{ThumbBasename}"></a>
                </div>
                <div class="message-info">
                    <div class="identity">
                        <div class="identity-content">
                            <a data-load="main_content" href="/view/{TrackUserGUID}">{db_Nickname}</a>,
                            <strong>{YearsOld}</strong> {view_years_old},
                            {City}                              
                        </div>
                        {message_approve_for_private_photo} <input type="checkbox" data-tracker="{TrackUserGUID}" name="private_photo" {Privilege_checkbox}>

                    </div>
                </div>
                      
            </li>
            {/pending_list}
        </ul>
    </div>
 </div>
<script src="/_js/bootstrap-switch.min.js"></script>

<script>
$(function() {
    $("[name='private_photo']").bootstrapSwitch({
        onText: '{message_approve}',
        offText: '{message_reject}',
        onSwitchChange:function(event, state){
            var trackUserGUID = $(this).attr('data-tracker');
            $.ajax({
                url: '/action/set_privilege',
                dataType: 'json',
                type: 'POST',
                data: {
                    privilege : state?2:1,
                    trackUserGUID : trackUserGUID
                },
                success: function(r) {
               
                }
            });
            
        }
    });
});
</script>