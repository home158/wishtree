<div id="content">    <div class="ct clearfix">
        <div class="msg">
            <p class="hd">{register_step2}</p>
            <p></p>
        </div>
        <div class="login_gp">
            <div class="login_type borR tc">
                
                <div class="well well-lg tc msg clearfix">
                    <p class="hd">我是</p>
                    <div class="daddy fl" >
                        <p class="hd">{role_male_long}</p>
                        <img src="/_images/2226915_799548833454678_472896375_n.jpg">
                        <p class="hd roll-desc">你可能沒有時間陪伴baby,但是你願意用其他的補償方式(ex:可能是一頓大餐或是贊助學費)</p>
                        
                    </div>
                    <div class="fl">
                    </div>
                    <div class="girl fr">
                        <p class="hd">{role_female_long}</p>
                        <img src="/_images/11116915_799548833454678_472896375_n.jpg">
                        <p class="hd roll-desc">你聰明又美麗,但是你厭倦出門總是各付各,而且你也希望男友有一定經濟上的能力</p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
<script>
$(function(){
    
	$(".daddy").hover(function(){
        $(this).css('background-color','#ff5b7e');
    },function(){
        $(this).css('background-color','transparent');
    }).click(function(){
        $.cookie("WG_role", 'male' , {
           expires : 1,           
           path    : '/'
        });
		window.location.href="/register/step_3";
	});
	$(".girl").hover(function(){
        $(this).css('background-color','#ff5b7e');
    },function(){
        $(this).css('background-color','transparent');
    }).click(function(){
        $.cookie("WG_role", 'female' , {
           expires : 1,           
           path    : '/'
        });
		window.location.href="/register/step_3";
	});
    
});
	
</script>