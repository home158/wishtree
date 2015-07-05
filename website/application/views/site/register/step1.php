<div id="content">
    <div class="ct bg clearfix">
        <div class="msg deal_msg">
          <p class="hd">{register_step1}</p>
          <p class="redF"> </p>
        </div>
        <div class="well well-lg">
            <p>{register_read_term_desc}</p>
            <div class="contract">
              <div class="deal_in">
                  {terms_content}

              </div>
            </div>
              <div class="msg deal_msg ">
              <p class="redF">{register_agree_note}</p>
              <form name="register" action="/register/step_1" method="post">
                  <p class="tc">
	                  <label class="vm" for="agree-1"><input type="radio" id="agree-1" value="1" name="agree">{register_agree}</label>
	                  <label class="vm" for="agree-0"><input type="radio" id="agree-0" value="0" name="agree" checked="">{register_decline}</label>
	              </p>
	              <div class="tc next">
                      <input id="go_step2" type="button" class="btn-xl btn-ele" value="{register_next}">
                  </div>
	              <div id="agree_error_msg" class="redF tc hide" >{register_agree_error_msg}</div>
              </form>
            </div>
        </div>
    </div>
</div>
<script>
$(function(){
    
	$("#go_step2").click(function(){
		if($('input[name=agree]:checked').val()!=1){
			$("#agree_error_msg").removeClass('hide');
			return;
		}
		$("form[name=register]").submit();
	});
});
	
</script>