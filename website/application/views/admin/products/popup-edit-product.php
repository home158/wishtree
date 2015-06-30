<script type="text/javascript" src="/_script/jquery.popupwindow.js"></script>
<script type="text/javascript" src="/_script/jquery-ui-1.9.2/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="/_script/jquery-ui-1.9.2/js/datepicker-zh-TW.js"></script>
<script type="text/javascript" src="/_script/draggable_background.js"></script>

<link rel="stylesheet" type="text/css" href="/_script/jquery-ui-1.9.2/css/blitzer/jquery-ui-1.9.2.custom.min.css" />

<div class="pand-console">
    <div class="pane-header">
        <h1 id="myHeader" class="trend-header">{products_edit}</h1>
    </div>

    <form enctype="multipart/form-data" id="signup-form" action="/admin/products/edit/{GUID}" method="post">
        <div class="container block blk-reg">
            <div class="inside">

                <span class="item">{products_category} : </span>
                <select name="products_category" id="products_category" >
                    {product_category_options}
                </select><br>
                <br>
                
                <span class="item">{gird_column_ProductTitle} : </span>
                <input name="product_title" id="product_title" type="text" value="<?= set_value('product_title','{Title}'); ?>" /><br>
                <?php echo form_error('product_title'); ?><br>



                <span class="item">{product_cover_image} : </span>
                <div class="product_cover_image" style="background-image:url('<?= set_value('product_cover_image','{CoverImageURLPath}'); ?>');background-position:<?= set_value('product_cover_image_position','{CoverImageBackgroundPosition}'); ?>;">
                    {product_thumb} 
                </div><br>
                &nbsp;<em class="note">1. <input target_field_id="product_cover_image" type="button" class="btn-ele" id="filemanager_product_cover_image" value="{product_image_select}"/>
                2. {product_cover_image_note}</em><br>
                <input id='product_cover_image' name="product_cover_image" type="hidden" value="{CoverImageURLPath}" />
                <input id='product_cover_image_thumb' name="product_cover_image_thumb" type="hidden" value="{CoverImageThumbURLPath}" />
                <input id='product_cover_image_position' name="product_cover_image_position" type="hidden" value="{CoverImageBackgroundPosition}" />
                &nbsp;<?php echo form_error('product_cover_image'); ?><br>

                <span class="item">{product_sub_image} 1: </span>
                <div class="product_sub_image_0" style="background-image:url('<?= set_value('product_sub_image_0','{SubImage0URLPath}'); ?>'); background-position:<?= set_value('product_sub_image_0_position','{SubImage0BackgroundPosition}'); ?>;">
                    {product_thumb} 
                </div><br>
                &nbsp;<em class="note">1. <input target_field_id="product_sub_image_0" type="button" class="btn-ele" id="filemanager_product_sub_image_0" value="{product_image_select}"/>
                2. {product_sub_image_0_note} </em><br>
                <input id='product_sub_image_0' name="product_sub_image_0" type="hidden" value="{SubImage0URLPath}" />
                <input id='product_sub_image_0_thumb' name="product_sub_image_0_thumb" type="hidden" value="{SubImage0ThumbURLPath}" />
                <input id='product_sub_image_0_position' name="product_sub_image_0_position" type="hidden" value="{SubImage0BackgroundPosition}" />
                
                <?php echo form_error('product_sub_image_0'); ?><br>
                

                <span class="item">{product_sub_image} 2: </span>
                <div class="product_sub_image_1" style="background-image:url('<?= set_value('product_sub_image_1','{SubImage1URLPath}'); ?>'); background-position:<?= set_value('product_sub_image_1_position','{SubImage1BackgroundPosition}'); ?>;">
                    {product_thumb} 
                </div><br>
                &nbsp;<em class="note">1. <input target_field_id="product_sub_image_1" type="button" class="btn-ele" id="filemanager_product_sub_image_1" value="{product_image_select}"/>
                2. {product_sub_image_1_note} </em><br>
                <input id='product_sub_image_1' name="product_sub_image_1" type="hidden" value="{SubImage1URLPath}" />
                <input id='product_sub_image_1_thumb' name="product_sub_image_1_thumb" type="hidden" value="{SubImage1ThumbURLPath}" />
                <input id='product_sub_image_1_position' name="product_sub_image_1_position" type="hidden" value="{SubImage1BackgroundPosition}" />
                
                <?php echo form_error('product_sub_image_1'); ?><br>
                
                <span class="item">{product_sub_image} 3: </span>
                <div class="product_sub_image_2" style="background-image:url('<?= set_value('product_sub_image_2','{SubImage2URLPath}'); ?>'); background-position:<?= set_value('product_sub_image_2_position','{SubImage2BackgroundPosition}'); ?>;">
                    {product_thumb} 
                </div><br>
                &nbsp;<em class="note">1. <input target_field_id="product_sub_image_2" type="button" class="btn-ele" id="filemanager_product_sub_image_2" value="{product_image_select}"/>
                2. {product_sub_image_2_note} </em><br>
                <input id='product_sub_image_2' name="product_sub_image_2" type="hidden" value="{SubImage2URLPath}" />
                <input id='product_sub_image_2_thumb' name="product_sub_image_2_thumb" type="hidden" value="{SubImage2ThumbURLPath}" />
                <input id='product_sub_image_2_position' name="product_sub_image_2_position" type="hidden" value="{SubImage2BackgroundPosition}" />
                
                <?php echo form_error('product_sub_image_2'); ?><br>
                


                <span class="item">{gird_column_ShortDesc} : </span>
                <a id="product_short_desc_tinymce" targetURL="short_desc" href ="#short_desc">{product_anchor_here_to_edit}</a><br>
                <?php echo form_error('product_short_desc'); ?><br>
                <textarea name="product_short_desc" id="product_short_desc" style="display:none;">
                    <?= set_value('product_short_desc','{ShortDesc}'); ?>
                </textarea>

                <span class="item">{gird_column_Details} : </span>
                <a id="product_details_tinymce" targetURL="details" href="#details">{product_anchor_here_to_edit}</a><br>
                <?php echo form_error('product_details'); ?><br>
                <textarea name="product_details" id="product_details" style="display:none;" >
                     <?= set_value('product_details','{Details}'); ?>
                </textarea>

                <span class="item">{gird_column_Recipe} : </span>
                <a id="product_recipe_tinymce" targetURL="recipe" href="#recipe">{product_anchor_here_to_edit}</a><br>
                <?php echo form_error('product_recipe'); ?><br>
                <textarea name="product_recipe" id="product_recipe" style="display:none;" >
                     <?= set_value('product_recipe','{Recipe}'); ?>
                </textarea>

                <span class="item">{gird_column_OrderNote} : </span>
                <a id="product_order_note_tinymce" targetURL="order_note" href="#order_note">{product_anchor_here_to_edit}</a><br>
                <?php echo form_error('product_order_note'); ?><br>
                <textarea name="product_order_note" id="product_order_note" style="display:none;" >
                     <?= set_value('product_order_note','{OrderNote}'); ?>
                </textarea>



                <span class="item">{gird_column_PriceMSRP} : </span>
                <input name="product_price_MSRP" id="product_price_MSRP" type="text" value="<?= set_value('product_price_MSRP','{PriceMSRP}'); ?>" /><br>
                <?php echo form_error('product_price_MSRP'); ?><br>

                <span class="item">{gird_column_PriceSpecial} : </span>
                <input name="product_price_special" id="product_price_special" type="text" value="<?= set_value('product_price_special','{PriceSpecial}'); ?>" /><br>
                <?php echo form_error('product_price_special'); ?><br>

                <span class="item">{gird_column_Stock} : </span>
                <input name="product_stock" id="product_stock" type="text" value="<?= set_value('product_stock','{Stock}'); ?>" /><br>    
                <?php echo form_error('product_stock'); ?><br>

                <span class="item">{gird_column_Soldout} : </span>
                <input name="product_soldout" id="product_soldout" type="text" value="<?= set_value('product_soldout','{Soldout}'); ?>" /><br>    
                <?php echo form_error('product_soldout'); ?><br>


                <span class="item">{gird_column_IsOnShelves} : </span>
                <input name="product_is_on_shelves_old" type="hidden" value="{IsOnShelves}" />
                <select name="product_is_on_shelves" id="product_is_on_shelves">
                      <option value="0" <?php echo set_select('product_is_on_shelves', '0',TRUE); ?>>{product_off_shelves}</option>
                      <option value="1" <?php echo set_select('product_is_on_shelves', '1'); ?>>{product_on_shelves}</option>
                </select><br><br>
                <!--
                <span class="item">{gird_column_OffShelfTime} : </span>
                <input style="width: 10em;" name="product_off_shelf_time_date" id="product_off_shelf_time_date" type="text" value="<?= set_value('product_off_shelf_time_date','{OffShelfTimeDate}'); ?>"  readonly/>
                <select style="width:60px;" name='product_off_shelf_time_hour'>
                      <option value="00" <?php echo set_select('product_off_shelf_time_hour', '00'); ?>>00</option>
                      <option value="01" <?php echo set_select('product_off_shelf_time_hour', '01'); ?>>01</option>
                      <option value="02" <?php echo set_select('product_off_shelf_time_hour', '02'); ?>>02</option>
                      <option value="03" <?php echo set_select('product_off_shelf_time_hour', '03'); ?>>03</option>
                      <option value="04" <?php echo set_select('product_off_shelf_time_hour', '04'); ?>>04</option>
                      <option value="05" <?php echo set_select('product_off_shelf_time_hour', '05'); ?>>05</option>
                      <option value="06" <?php echo set_select('product_off_shelf_time_hour', '06'); ?>>06</option>
                      <option value="07" <?php echo set_select('product_off_shelf_time_hour', '07'); ?>>07</option>
                      <option value="08" <?php echo set_select('product_off_shelf_time_hour', '08'); ?>>08</option>
                      <option value="09" <?php echo set_select('product_off_shelf_time_hour', '09'); ?>>09</option>
                      <option value="10" <?php echo set_select('product_off_shelf_time_hour', '10'); ?>>10</option>
                      <option value="11" <?php echo set_select('product_off_shelf_time_hour', '11'); ?>>11</option>
                      <option value="12" <?php echo set_select('product_off_shelf_time_hour', '12'); ?>>12</option>
                      <option value="12" <?php echo set_select('product_off_shelf_time_hour', '12'); ?>>12</option>
                      <option value="14" <?php echo set_select('product_off_shelf_time_hour', '14'); ?>>14</option>
                      <option value="15" <?php echo set_select('product_off_shelf_time_hour', '15'); ?>>15</option>
                      <option value="16" <?php echo set_select('product_off_shelf_time_hour', '16'); ?>>16</option>
                      <option value="17" <?php echo set_select('product_off_shelf_time_hour', '17'); ?>>17</option>
                      <option value="18" <?php echo set_select('product_off_shelf_time_hour', '18'); ?>>18</option>
                      <option value="19" <?php echo set_select('product_off_shelf_time_hour', '19'); ?>>19</option>
                      <option value="20" <?php echo set_select('product_off_shelf_time_hour', '20'); ?>>20</option>
                      <option value="21" <?php echo set_select('product_off_shelf_time_hour', '21'); ?>>21</option>
                      <option value="22" <?php echo set_select('product_off_shelf_time_hour', '22'); ?>>22</option>
                      <option value="23" <?php echo set_select('product_off_shelf_time_hour', '23',TRUE); ?>>23</option>
                </select>
                 : 
                <select style="width:60px;" name='product_off_shelf_time_minute'>
                      <option value="00" <?php echo set_select('product_off_shelf_time_minute', '00'); ?>>00</option>
                      <option value="01" <?php echo set_select('product_off_shelf_time_minute', '01'); ?>>01</option>
                      <option value="02" <?php echo set_select('product_off_shelf_time_minute', '02'); ?>>02</option>
                      <option value="03" <?php echo set_select('product_off_shelf_time_minute', '03'); ?>>03</option>
                      <option value="04" <?php echo set_select('product_off_shelf_time_minute', '04'); ?>>04</option>
                      <option value="05" <?php echo set_select('product_off_shelf_time_minute', '05'); ?>>05</option>
                      <option value="06" <?php echo set_select('product_off_shelf_time_minute', '06'); ?>>06</option>
                      <option value="07" <?php echo set_select('product_off_shelf_time_minute', '07'); ?>>07</option>
                      <option value="08" <?php echo set_select('product_off_shelf_time_minute', '08'); ?>>08</option>
                      <option value="09" <?php echo set_select('product_off_shelf_time_minute', '09'); ?>>09</option>
                      <option value="10" <?php echo set_select('product_off_shelf_time_minute', '10'); ?>>10</option>
                      <option value="11" <?php echo set_select('product_off_shelf_time_minute', '11'); ?>>11</option>
                      <option value="12" <?php echo set_select('product_off_shelf_time_minute', '12'); ?>>12</option>
                      <option value="12" <?php echo set_select('product_off_shelf_time_minute', '12'); ?>>12</option>
                      <option value="14" <?php echo set_select('product_off_shelf_time_minute', '14'); ?>>14</option>
                      <option value="15" <?php echo set_select('product_off_shelf_time_minute', '15'); ?>>15</option>
                      <option value="16" <?php echo set_select('product_off_shelf_time_minute', '16'); ?>>16</option>
                      <option value="17" <?php echo set_select('product_off_shelf_time_minute', '17'); ?>>17</option>
                      <option value="18" <?php echo set_select('product_off_shelf_time_minute', '18'); ?>>18</option>
                      <option value="19" <?php echo set_select('product_off_shelf_time_minute', '19'); ?>>19</option>
                      <option value="20" <?php echo set_select('product_off_shelf_time_minute', '20'); ?>>20</option>
                      <option value="21" <?php echo set_select('product_off_shelf_time_minute', '21'); ?>>21</option>
                      <option value="22" <?php echo set_select('product_off_shelf_time_minute', '22'); ?>>22</option>
                      <option value="22" <?php echo set_select('product_off_shelf_time_minute', '22'); ?>>22</option>
                      <option value="24" <?php echo set_select('product_off_shelf_time_minute', '24'); ?>>24</option>
                      <option value="25" <?php echo set_select('product_off_shelf_time_minute', '25'); ?>>25</option>
                      <option value="26" <?php echo set_select('product_off_shelf_time_minute', '26'); ?>>26</option>
                      <option value="27" <?php echo set_select('product_off_shelf_time_minute', '27'); ?>>27</option>
                      <option value="28" <?php echo set_select('product_off_shelf_time_minute', '28'); ?>>28</option>
                      <option value="29" <?php echo set_select('product_off_shelf_time_minute', '29'); ?>>29</option>
                      <option value="30" <?php echo set_select('product_off_shelf_time_minute', '30'); ?>>30</option>
                      <option value="31" <?php echo set_select('product_off_shelf_time_minute', '31'); ?>>31</option>
                      <option value="32" <?php echo set_select('product_off_shelf_time_minute', '32'); ?>>32</option>
                      <option value="32" <?php echo set_select('product_off_shelf_time_minute', '32'); ?>>32</option>
                      <option value="34" <?php echo set_select('product_off_shelf_time_minute', '34'); ?>>34</option>
                      <option value="35" <?php echo set_select('product_off_shelf_time_minute', '35'); ?>>35</option>
                      <option value="36" <?php echo set_select('product_off_shelf_time_minute', '36'); ?>>36</option>
                      <option value="37" <?php echo set_select('product_off_shelf_time_minute', '37'); ?>>37</option>
                      <option value="38" <?php echo set_select('product_off_shelf_time_minute', '38'); ?>>38</option>
                      <option value="39" <?php echo set_select('product_off_shelf_time_minute', '39'); ?>>39</option>
                      <option value="40" <?php echo set_select('product_off_shelf_time_minute', '40'); ?>>40</option>
                      <option value="41" <?php echo set_select('product_off_shelf_time_minute', '41'); ?>>41</option>
                      <option value="42" <?php echo set_select('product_off_shelf_time_minute', '42'); ?>>42</option>
                      <option value="42" <?php echo set_select('product_off_shelf_time_minute', '42'); ?>>42</option>
                      <option value="44" <?php echo set_select('product_off_shelf_time_minute', '44'); ?>>44</option>
                      <option value="45" <?php echo set_select('product_off_shelf_time_minute', '45'); ?>>45</option>
                      <option value="46" <?php echo set_select('product_off_shelf_time_minute', '46'); ?>>46</option>
                      <option value="47" <?php echo set_select('product_off_shelf_time_minute', '47'); ?>>47</option>
                      <option value="48" <?php echo set_select('product_off_shelf_time_minute', '48'); ?>>48</option>
                      <option value="49" <?php echo set_select('product_off_shelf_time_minute', '49'); ?>>49</option>
                      <option value="50" <?php echo set_select('product_off_shelf_time_minute', '50'); ?>>50</option>
                      <option value="51" <?php echo set_select('product_off_shelf_time_minute', '51'); ?>>51</option>
                      <option value="52" <?php echo set_select('product_off_shelf_time_minute', '52'); ?>>52</option>
                      <option value="52" <?php echo set_select('product_off_shelf_time_minute', '52'); ?>>52</option>
                      <option value="54" <?php echo set_select('product_off_shelf_time_minute', '54'); ?>>54</option>
                      <option value="55" <?php echo set_select('product_off_shelf_time_minute', '55'); ?>>55</option>
                      <option value="56" <?php echo set_select('product_off_shelf_time_minute', '56'); ?>>56</option>
                      <option value="57" <?php echo set_select('product_off_shelf_time_minute', '57'); ?>>57</option>
                      <option value="58" <?php echo set_select('product_off_shelf_time_minute', '58'); ?>>58</option>
                      <option value="59" <?php echo set_select('product_off_shelf_time_minute', '59',TRUE); ?>>59</option>
                </select><br>
                <em class="note">* yyyy-mm-dd hh:mm</em><br>
                <?php echo form_error('product_off_shelf_time_date'); ?><br>
                
                <br>
                -->
                <span class="item">{product_species} : </span>
                <input type="checkbox" name="species_display" id="species_display" value="1" <?= set_checkbox('species_display', '1'); ?>><label for="species_display">{product_species_display}</label>
                <br>
                <br>
                <div id="species_display_area" class="sub_section_area">
                    &nbsp;<span class="item">{product_species_category} : </span>
                    <select name="product_species_category_r1" id="product_species_category_r1" >
                        <option value="-1" <?= set_select('product_species_category_r1', '-1', TRUE); ?>>{product_species_category_0}</option>
                        <option value="0"  <?= set_select('product_species_category_r1', '0'); ?>>{product_species_category_1}</option>
                        <option value="1"  <?= set_select('product_species_category_r1', '1'); ?>>{product_species_category_2}</option>
                        <option value="2"  <?= set_select('product_species_category_r1', '2'); ?>>{product_species_category_3}</option>
                    </select><br>
                    &nbsp;&nbsp;<?php echo form_error('product_species_category_r1'); ?>
                    <br>&nbsp;
                    <select name="product_species_category_r2" id="product_species_category_r2" style="display:none;">
                        <option value="0" <?= set_select('product_species_category_r2', '0', TRUE); ?>>{product_species_category_4}</option>
                        <option value="1" <?= set_select('product_species_category_r2', '1'); ?>>{product_species_category_5}</option>
                        <option value="2" <?= set_select('product_species_category_r2', '2'); ?>>{product_species_category_6}</option>
                        <option value="3" <?= set_select('product_species_category_r2', '3'); ?>>{product_species_category_7}</option>
                        <option value="4" <?= set_select('product_species_category_r2', '4'); ?>>{product_species_category_8}</option>
                    </select><br>
                    <br>

                    &nbsp;<span class="item">{product_species_title} : </span>
                    <input name="product_species_title" id="product_species_title" type="text" value="<?= set_value('product_species_title' , '{SpeciesTitle}'); ?>" /><br>
                    &nbsp;&nbsp;<?php echo form_error('product_species_title'); ?><br>

                    &nbsp;<span class="item">{product_species_image} : </span>
                    <div class="product_species_image" style="background-image:url('<?php echo set_value('product_species_image','{SpeciesImageURLPath}'); ?>');background-position:<?php echo set_value('product_species_image_position','{SpeciesImageBackgroundPosition}'); ?>;)">
                        {product_thumb} 
                    </div><br>

                    &nbsp;<em class="note">1. <input target_field_id="product_species_image" type="button" class="btn-ele" id="filemanager_product_species_image" value="{product_image_select}"/>
                    2. {product_species_image_note} </em><br>
                    <input id='product_species_image' name="product_species_image" type="hidden" value="<?php echo set_value('product_species_image','{SpeciesImageURLPath}'); ?>" />
                    <input id='product_species_image_thumb' name="product_species_image_thumb" type="hidden" value="<?php echo set_value('product_species_image_thumb','{SpeciesImageThumbURLPath}'); ?>" />
                    <input id='product_species_image_position' name="product_species_image_position" type="hidden" value="<?php echo set_value('product_species_image_position','{SpeciesImageBackgroundPosition}'); ?>" />
                    &nbsp;<?php echo form_error('product_species_image'); ?><br>

                    <span class="item">{product_species_icon} : </span>
                    <input type="checkbox" name="product_species_icon" id="product_species_icon" value="/_images/product-species-crown.png" <?= set_checkbox('product_species_icon', '/_images/product-species-crown.png' ); ?>><label for="product_species_icon"><img src="/_images/product-species-crown.png"></label><br><br>

                    &nbsp;<span class="item">{product_species_content} : </span>
                    <a id="product_species_content_tinymce" targetURL="species_content" href="#species_content">{product_anchor_here_to_edit}</a><br>
                    <?php echo form_error('product_species_content'); ?><br>
                    <textarea name="product_species_content" id="product_species_content" style="display:none;" >
                        <?php echo set_value('product_species_content','{SpeciesContent}'); ?>
                    </textarea>
                </div>

        </div>
    </div>
    <div class="pane-footer">
        <input id="searchBtn" type="submit" class="btn-calm" value="&nbsp;&nbsp;{button_submit}&nbsp;&nbsp;"/>        <input id="cancelBtn" type="submit" class="btn-calm" value="&nbsp;&nbsp;{button_cancel}&nbsp;&nbsp;"/>
    </div>
   </form>  
</div>

<script>
    $('#species_display').bind('click',function(){
        if($(this).attr('checked') ){
            $('#species_display_area').show();
        }else{
            $('#species_display_area').hide();
        }
    });
    $('#product_species_category_r1').change(function(){
        if( $('#product_species_category_r1').val() == '1' ){
            $('#product_species_category_r2').show();
        }else{
            $('#product_species_category_r2').hide();
        }
    });
    function responsive_filemanager_callback(field_id){ 
        var img_url = $('#'+field_id).val() || '';
        var img_thumbs = img_url.replace('/repositories/','/repositories/thumbs/');
        switch(field_id){
            case 'product_cover_image':
                $('#product_cover_image_position').val('0px 0px');
                $('div.product_cover_image').html("&nbsp;").css('background-image','url('+img_url+')').backgroundDraggable({                    done:function(e){                        $('#product_cover_image_position').val($(e).css('backgroundPosition'));                    }                });
                $('#product_cover_image_thumb').val(img_thumbs);
    
            break;
            case 'product_sub_image_0':
                $('#product_sub_image_0_position').val('0px 0px');
                $('div.product_sub_image_0').html("&nbsp;").css('background-image','url('+img_url+')').backgroundDraggable({                    done:function(e){                        $('#product_sub_image_0_position').val($(e).css('backgroundPosition'));                    }                });
                $('#product_sub_image_0_thumb').val(img_thumbs);
            break;
            case 'product_sub_image_1':
                $('#product_sub_image_1_position').val('0px 0px');
                $('div.product_sub_image_1').html("&nbsp;").css('background-image','url('+img_url+')').backgroundDraggable({                    done:function(e){                        $('#product_sub_image_1_position').val($(e).css('backgroundPosition'));                    }                });
                $('#product_sub_image_1_thumb').val(img_thumbs);
            break;
            case 'product_sub_image_2':
                $('#product_sub_image_2_position').val('0px 0px');
                $('div.product_sub_image_2').html("&nbsp;").css('background-image','url('+img_url+')').backgroundDraggable({                    done:function(e){                        $('#product_sub_image_2_position').val($(e).css('backgroundPosition'));                    }                });
                $('#product_sub_image_2_thumb').val(img_thumbs);
            break;
            case 'product_species_image':
                $('#product_species_image_position').val('0px 0px');
                $('div.product_species_image').html("&nbsp;").css('background-image','url('+img_url+')').backgroundDraggable({                    done:function(e){                        $('#product_species_image_position').val($(e).css('backgroundPosition'));                    }                });
                $('#product_species_image_thumb').val(img_thumbs);
            break;
        }
    }
    $(function () {
        if( '{SpeciesCategoryR1}' == '1' ){
            $('#product_species_category_r2').show();
        }else{
            $('#product_species_category_r2').hide();
        }
        if( '{SpeciesDisplay}' == '1'){
            $('#species_display_area').show();
            $('#species_display').attr('checked','checked');
        }else{
            $('#species_display_area').hide();

        }
        if( '{SpeciesIcon}' == '/_images/product-species-crown.png'){
            $('#product_species_icon').attr('checked','checked');
        }else{
            $('#product_species_icon').prop('checked',false);

        }
        if( '{CoverImageURLPath}' != '' && '{CoverImageURLPath}' != ''){
            $('div.product_cover_image').html("&nbsp;").css({                //'background-image':'url({CoverImageURLPath})',                //'background-position':'{CoverImageBackgroundPosition}'            }).backgroundDraggable({                done:function(e){                    $('#product_cover_image_position').val($(e).css('backgroundPosition'));                }            });
        }
        if( '{SubImage0URLPath}' != '' && '{SubImage0ThumbURLPath}' != ''){
            $('div.product_sub_image_0').html("&nbsp;").css({                //'background-image':'url({SubImage0URLPath})',                //'background-position':'{SubImage0BackgroundPosition}'            }).backgroundDraggable({                done:function(e){                    $('#product_sub_image_0_position').val($(e).css('backgroundPosition'));                }            });
        }
        if( '{SubImage1URLPath}' != '' && '{SubImage1ThumbURLPath}' != ''){
            $('div.product_sub_image_1').html("&nbsp;").css({                //'background-image':'url({SubImage1URLPath})',                //'background-position':'{SubImage1BackgroundPosition}'            }).backgroundDraggable({                done:function(e){                    $('#product_sub_image_1_position').val($(e).css('backgroundPosition'));                }            });
        }
        if( '{SubImage2URLPath}' != '' && '{SubImage2ThumbURLPath}' != ''){
            $('div.product_sub_image_2').html("&nbsp;").css({                //'background-image':'url({SubImage2URLPath})',                //'background-position':'{SubImage2BackgroundPosition}'            }).backgroundDraggable({                done:function(e){                    $('#product_sub_image_2_position').val($(e).css('backgroundPosition'));                }            });
        }
        if( '{SpeciesImageURLPath}' != '' && '{SpeciesImageThumbURLPath}' != ''){
            $('div.product_species_image').html("&nbsp;").css({                //'background-image':'url({SpeciesImageURLPath})',                //'background-position':'{SpeciesImageBackgroundPosition}'            }).backgroundDraggable({                done:function(e){                    $('#product_species_image_position').val($(e).css('backgroundPosition'));                }            });
        }
        

        $('#filemanager_product_cover_image , #filemanager_product_sub_image_0 , #filemanager_product_sub_image_1 , #filemanager_product_sub_image_2 , #filemanager_product_species_image').bind('click', function (e) {
           
            $.popupWindow('/filemanager/dialog.php?type=1&popup=1&field_id='+$(this).attr('target_field_id'), { 
                height: 600, 
                width: 880,
                createNew: true,
                resizable:   true,
                onUnload: function(){
                    
                }
            });
        });
        $('#product_short_desc_tinymce , #product_details_tinymce , #product_recipe_tinymce, #product_order_note_tinymce, #product_species_content_tinymce').bind('click', function () {
            $.popupWindow('/admin/products/mce/'+$(this).attr('targetURL'), { 
                height: 600, 
                width: 880,
                createNew: true,
                resizable:   true,
                onUnload: function(){
                    
                }
            });
        });
        $( "#product_off_shelf_time_date" ).datepicker({
                "dateFormat" : "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                defaultDate: '+0y',
                constrainInput: true,
                minDate: new Date()
        });

        $('select[name=products_category]').val('<?= set_value('products_category','{Category}'); ?>');
        //$('select[name=product_off_shelf_time_hour]').val(<?= set_value('product_off_shelf_time_hour','{OffShelfTimeHour}'); ?> );
        //$('select[name=product_off_shelf_time_minute]').val(<?= set_value('product_off_shelf_time_minute','{OffShelfTimeMinute}'); ?>);
        $('select[name=product_is_on_shelves]').val(<?= set_value('product_is_on_shelves','{IsOnShelves}'); ?>);
        $('select[name=product_species_category_r1]').val('<?= set_value('product_species_category_r1','{SpeciesCategoryR1}'); ?>');
        $('select[name=product_species_category_r2]').val('<?= set_value('product_species_category_r2','{SpeciesCategoryR2}'); ?>');
        
    });

</script>
