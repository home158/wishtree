<script>
    $(function () {
    });
</script>
<div class="pand-console">
    <div class="pane-header">
        <h1 id="myHeader" class="trend-header">{members_details}</h1>
    </div>

    <form enctype="multipart/form-data" id="signup-form" action="/admin/members/edit/{GUID}" method="post">
        <div class="container block blk-reg">
            <div class="inside">
                <span class="item">{gird_column_Rank} : </span>
                <span>{Rank}</span>
                <br><br>


                <span class="item">{gird_column_Email} : </span>
                {Email}
                <input name="email" id="Member_email" type="hidden" value="{Email}" />

                <em></em>
                <em></em>
                <em class="note"></em>
                <br><br>
                    

                <span class="item">{gird_column_Name} : </span>
                <span>{Name} {Gender}</span>
                <br><br>
              
           
                <span class="item">{gird_column_City} : </span>
                <span>{City}</span>
                <br><br>


                <span class="item">{gird_column_RegisterType} : </span>
                <span>{RegisterType}</span>
                <br><br>


                <span class="item">{gird_column_DateCreate} : </span>
                <span>{DateCreate}</span>
                <br><br>

                <span class="item">{gird_column_DateModify} : </span>
                <span>{DateModify}</span>
                <br><br>

                <span class="item">{gird_column_LastLoginTime} : </span>
                <span>{LastLoginTime}</span>
                <br><br>
        </div>
    </div>
    <div class="pane-footer">
        <input id="cancelBtn" type="submit" class="btn-calm" value="&nbsp;&nbsp;{button_close}&nbsp;&nbsp;"/>
    </div>
   </form>  
</div>

