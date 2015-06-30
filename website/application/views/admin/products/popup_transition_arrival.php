<form name="transition_arrival" method="post" action="/admin/notify/view">
    <textarea name="ProductGUID" style="display: none;" ></textarea>
    
</form>

<script>
    $(function () {
        if( typeof(window.opener.O_PARENT.grid.getSelectedInfo) != 'undefined'){
            var _callback = function(r){
                var ProductGUID = "'";
                ProductGUID += r.map(function(elem){return elem.GUID;}).join("','");
                ProductGUID += "'";
                $('textarea[name=ProductGUID]').val(ProductGUID);
                $('form[name=transition_arrival]').submit();
            };
            window.opener.O_PARENT.grid.getSelectedInfo(_callback);
            
        }else{
            window.close();
        }
        //
    });
</script>
