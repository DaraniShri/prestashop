<div class="featured-products clearfix">
    <h2 class="products-section-title text-uppercase">{$sp_title}</h2>
</div>
<div class="multiple-items">
    {foreach $sp_banner as $slider}
        <div class="block">
            <a href="{$slider['link']}"><img class="img-thumbnail" src="/shop/modules/sp_banner/images/{$slider['image']}"/></a>
            <div class="description">
                <span>{$slider['name_slide']}</span>
            </div>
        </div>
    {/foreach}
</div>