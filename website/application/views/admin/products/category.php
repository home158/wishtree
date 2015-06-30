<style>
.CSSTableGenerator {
	margin:0px;padding:0px;
	width:50%;
	border:1px solid #000000;
	
	-moz-border-radius-bottomleft:0px;
	-webkit-border-bottom-left-radius:0px;
	border-bottom-left-radius:0px;
	
	-moz-border-radius-bottomright:0px;
	-webkit-border-bottom-right-radius:0px;
	border-bottom-right-radius:0px;
	
	-moz-border-radius-topright:0px;
	-webkit-border-top-right-radius:0px;
	border-top-right-radius:0px;
	
	-moz-border-radius-topleft:0px;
	-webkit-border-top-left-radius:0px;
	border-top-left-radius:0px;
}.CSSTableGenerator table{
    border-collapse: collapse;
        border-spacing: 0;
	width:100%;
	height:100%;
	margin:0px;padding:0px;
}.CSSTableGenerator tr:last-child td:last-child {
	-moz-border-radius-bottomright:0px;
	-webkit-border-bottom-right-radius:0px;
	border-bottom-right-radius:0px;
}
.CSSTableGenerator table tr:first-child td:first-child {
	-moz-border-radius-topleft:0px;
	-webkit-border-top-left-radius:0px;
	border-top-left-radius:0px;
}
.CSSTableGenerator table tr:first-child td:last-child {
	-moz-border-radius-topright:0px;
	-webkit-border-top-right-radius:0px;
	border-top-right-radius:0px;
}.CSSTableGenerator tr:last-child td:first-child{
	-moz-border-radius-bottomleft:0px;
	-webkit-border-bottom-left-radius:0px;
	border-bottom-left-radius:0px;
}.CSSTableGenerator tr:hover td{
	
}
.CSSTableGenerator tr:nth-child(odd){ background-color:#abd0f4; }
.CSSTableGenerator tr:nth-child(even)    { background-color:#ffffff; }.CSSTableGenerator td{
	vertical-align:middle;
	
	
	border:1px solid #000000;
	border-width:0px 1px 1px 0px;
	text-align:left;
	padding:10px;
	font-size:10px;
	font-family:Arial;
	font-weight:normal;
	color:#000000;
}.CSSTableGenerator tr:last-child td{
	border-width:0px 1px 0px 0px;
}.CSSTableGenerator tr td:last-child{
	border-width:0px 0px 1px 0px;
}.CSSTableGenerator tr:last-child td:last-child{
	border-width:0px 0px 0px 0px;
}
.CSSTableGenerator tr:first-child td{
		background:-o-linear-gradient(bottom, #003f7f 5%, #003f7f 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #003f7f), color-stop(1, #003f7f) );
	background:-moz-linear-gradient( center top, #003f7f 5%, #003f7f 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#003f7f", endColorstr="#003f7f");	background: -o-linear-gradient(top,#003f7f,003f7f);

	background-color:#003f7f;
	border:0px solid #000000;
	text-align:center;
	border-width:0px 0px 1px 1px;
	font-size:14px;
	font-family:Arial;
	font-weight:bold;
	color:#ffffff;
}
.CSSTableGenerator tr:first-child:hover td{
	background:-o-linear-gradient(bottom, #003f7f 5%, #003f7f 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #003f7f), color-stop(1, #003f7f) );
	background:-moz-linear-gradient( center top, #003f7f 5%, #003f7f 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#003f7f", endColorstr="#003f7f");	background: -o-linear-gradient(top,#003f7f,003f7f);

	background-color:#003f7f;
}
.CSSTableGenerator tr:first-child td:first-child{
	border-width:0px 0px 1px 0px;
}
.CSSTableGenerator tr:first-child td:last-child{
	border-width:0px 0px 1px 1px;
}</style>
<div class="pand-console">
    <div class="pane-header">
        <h1 id="myHeader" class="trend-header">{menu_admin_procucts_category}</h1>
    </div>
    <div>
    <form id="update_category" enctype="multipart/form-data" action="/admin/products/category" method="post">
        <input type="hidden" name="placehost" value="placehost">
        <table class="CSSTableGenerator">
            <tr>
                <th style="text-align: center;">編號</th>
                <th>類別名稱</th>
                <th style="text-align: center;">顯示</th>
                <th style="text-align: center;">順序</th>
                <th style="text-align: center;">份數</th>
                <th style="text-align: center;">運費</th>
                <th style="text-align: center;">運送方式</th>
            </tr>
            {grid_data}
            <tr>
                <td style="text-align: center;">{CategoryID}<input type="hidden" name="GUID[]" value="{GUID}" /></td>
                <td><input type="text" class="CategoryName" name="CategoryName[]" value="{CategoryName}" /></td>
                <td style="text-align: center;">
                    <select class="IsShow" name="IsShow[]">
                        <option value="0">否</option>
                        <option value="1">是</option>
                    </select>
                <td style="text-align: center;">
                    <select class="Priority" name="Priority[]">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                    </select>
                </td>
                <td style="text-align: center;">
                    <select class="ShippingLimit" name="ShippingLimit[]">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                    </select>
                </td>
                <td style="text-align: center;">
                    <select class="ShippingFare" name="ShippingFare[]">
                        <option value="0">0</option>
                        <option value="100">100</option>
                        <option value="270">270</option>
                    </select>
                </td>
                <td style="text-align: center;">
                    <select class="ShippingType" name="ShippingType[]">
                        <option value="0">免運</option>
                        <option value="1">常溫</option>
                        <option value="2">低溫</option>
                    </select>
                </td>
            </tr>

            {/grid_data}
        </table>
            <br>
            <input id="submit" type="submit" class="btn-calm" value="&nbsp;&nbsp;{button_submit}&nbsp;&nbsp;"/>
       </form>  
    </div>
</div>
<script>
$( "#update_category" ).submit(function( event ) {
    $.each($('input.CategoryName') , function(e){
        if( $(this).val() == '' ){
            alert('類別名稱('+parseInt(e+1,10)+') 必須填寫。');
            event.preventDefault();
        }
    });
});

{grid_data2}

    $('select.IsShow:eq('+parseInt({CategoryID}-1,10)+')').val({IsShow});
    $('select.Priority:eq('+parseInt({CategoryID}-1,10)+')').val({Priority});
    $('select.ShippingLimit:eq('+parseInt({CategoryID}-1,10)+')').val('{ShippingLimit}');
    $('select.ShippingFare:eq('+parseInt({CategoryID}-1,10)+')').val('{ShippingFare}');
    $('select.ShippingType:eq('+parseInt({CategoryID}-1,10)+')').val('{ShippingType}');

{/grid_data2}

</script>