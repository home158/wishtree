<div class="container">
    <div class="banner-label banner-label-member">
        <img src="/_images/banner-label-vegetable-center.png "/>
    </div>
    <div class="content block blk-reg">
        <div class="inside" style="text-align:center;">
            <ul class="vegetable-r">
                <li><a class="list-0-0" href="/notepad/vegetable/0/0"></a></li>
                <li><a class="list-1-0" href="/notepad/vegetable/1/2"></a></li>
                <li><a class="list-2-0" href="/notepad/vegetable/2/0"></a></li>
            </ul>
            <ul class="vegetable-p">
                <li><a class="list-1-0-0" href="/notepad/vegetable/1/0"></a></li>
                <li><a class="list-1-0-1" href="/notepad/vegetable/1/1"></a></li>
                <li><a class="list-1-0-2" href="/notepad/vegetable/1/2"></a></li>
                <li><a class="list-1-0-3" href="/notepad/vegetable/1/3"></a></li>
                <li><a class="list-1-0-4" href="/notepad/vegetable/1/4"></a></li>
            </ul>
            {grid_data}
            <div class="species-list clr" id="{GUID}">
                    <div class="species_image" style="border-radius: 10px; background-repeat: no-repeat;background-image: url('{SpeciesImageURLPath}');background-position: {SpeciesImageBackgroundPosition};"></div>
                    <div class="species_title">{SpeciesTitle}</div>
                    <div class="species_icon"></div>
                    <div class="species_ready_buy"><a href="/market/product/{GUID}"><img src="/_images/product-species-ready_buy.png" /></a></div>
                    <div class="species_content">{SpeciesContent}</div>

            </div>
            {/grid_data}
        </div>
    </div>
    <div class="footer">
        <a data-scroll data-options='{ "easing": "easeOutCubic" }' class="go_top" href="#"></a>
    </div>
</div>
<script>
$(function() {
  $('li a.list-{r}-{p}').addClass('hover');
  $('li a.list-{m}-0-{n}').addClass('hover');
  {grid_data_jquery}
    if('{SpeciesIcon}' != '0' ){
        $('<img src="{SpeciesIcon}" />').appendTo($('#{GUID} .species_icon'));
    }
  {/grid_data_jquery}
});

</script>
