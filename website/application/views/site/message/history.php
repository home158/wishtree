{msg}
<div class="message_history" >
    <div class="clearfix" >
        <div class="fl">
            <a href="/view/{sender}"><img src="{thumb_image}" style="width:75px;height:84px;"></a>
        </div>
        <ul class="text fl">
            <li><span>{nickname}</span><span class="fr">{time}</span></li>
            <li>{content}</li>
            <div class="read_status">{read_status}</div>
        </ul>
    </div>
</div>
{/msg}
<script>

$("[name='private_photo']").bootstrapSwitch('disabled', false);
$("[name='private_photo']").bootstrapSwitch('state', {privilege_state} , true);

</script>