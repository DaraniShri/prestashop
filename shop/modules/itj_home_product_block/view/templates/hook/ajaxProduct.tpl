{foreach from=$blocks key=index item=single_block}
{assign var="products" value=$single_block.products }
<div class="block">    
    <div class="right-block">
        <h2 class="section-title text-left">{$single_block.title}</h2>
        <div class="products">
        {foreach from=$single_block.products item="product"}
            <div>
            {block name='product_miniature_item'}
                <div class="product top-deals">
                    <article class="product-miniature js-product-miniature" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}">
                    <div class="thumbnail-container">
                        {block name='product_thumbnail'}
                            {if $product.cover}
                                <a href="{$product.url}" class="thumbnail product-thumbnail">
                                    <img src="{$product.cover.bySize.home_default.url}" alt="" width="250" height="250"/>
                                </a>
                            {/if}
                        {/block}
                    </div>

                    <div class="product-description">
                        <p class="reference">{$product.reference}</p>
                        {block name='product_name'}
                        <h3 class="h3 product-title"><a href="{$product.url}">{$product.name}</a></h3>
                        {/block}

                        {block name='product_price_and_shipping'}
                            {if $product.show_price}
                                <div class="product-price-and-shipping">
                                    {if $product.has_discount}
                        
                                        <span class="regular-price" aria-label="Regular price">{$product.regular_price}</span>
                                        {if $product.discount_type === 'percentage'}
                                        <span class="discount-percentage discount-product">{$product.discount_percentage}</span>
                                        {elseif $product.discount_type === 'amount'}
                                        <span class="discount-amount discount-product">{$product.discount_amount_to_display}</span>
                                        {/if}
                                    {/if}  
                                                          
                                    <span class="price" aria-label="Price">
                                        {$product.price}
                                    </span>
                                    
                                    {if $product.discount_type === 'percentage'}
                                        <span class="percentage">
                                            {$product.discount_percentage}
                                        </span>
                                    {elseif $product.discount_type === 'amount'}
                                        <span class="percentage">
                                        -{math equation="((x-y)/x) * 100" x=$product.price_without_reduction y=$product.price_amount format="%d"}%
                                        </span>
                                    {/if}                         
                                </div>
                            {/if}
                            {/block}
                    </div>
                    <div class="highlighted-details">
                        <a  href="{$product.url}" class="btn btn-outline">View more</a>
                    </div> 
                    </article>
                </div>
            {/block}
            </div>
        {/foreach}
        </div>
    </div>
</div>          
{/foreach}