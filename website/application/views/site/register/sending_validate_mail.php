<div id="content">
    <div class="ct bg clearfix">
        <div class="msg deal_msg">
          <p class="hd">{register_sending_validate_mail}</p>
          <p class="redF"> </p>
        </div>
        <div class="well well-lg">
           {register_sent_email_verification}
	              <div class="tc next">
                      <input id="go_home" type="button" class="btn-xl btn-ele" value="{btn_continue}">
                  </div>
        </div>
    </div>
</div>
<script>
$(function(){
	$("#go_home").click(function(){
		window.location.href = "/account";
	});

});
	
</script>