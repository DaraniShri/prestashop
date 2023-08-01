<div class="featured-products clearfix">
    <h2 class="products-section-title text-uppercase">featured products</h2>
</div>
<div class="featured-products-custom">
    {foreach $productsDetailsArray as $productsArray}
        <div class="img-products">
            <img class="img-thumbnail" src="{$productsArray['path']}">
            <div class="name-products">
                <p>{$productsArray['name']}</p>
            </div>
        </div>
    {/foreach}
</div>
