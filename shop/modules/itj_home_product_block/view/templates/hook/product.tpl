{block name='product_miniature_item'}
  <div class="product top-deals">
    <article class="product-miniature js-product-miniature" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}">
      <div class="thumbnail-container">
        {block name='product_thumbnail'}
          {if $product.cover}
            <a href="{$product.url}" class="thumbnail product-thumbnail">
              <img
                src="{$product.cover.bySize.home_default.url}"
                alt="{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name|truncate:30:'...'}{/if}"
                loading="lazy"
                data-full-size-image-url="{$product.cover.large.url}"
                width="250"
                height="250"
              />
            </a>
          {else}
            <a href="{$product.url}" class="thumbnail product-thumbnail">
              <img
                src="{$urls.no_picture_image.bySize.home_default.url}"
                loading="lazy"
                width="250"
                height="250"
              />
            </a>
          {/if}
        {/block}
      </div>
      
      <div class="product-description">
        <p class="reference">{$product.reference}</p>
        {block name='product_name'}
          <h3 class="h3 product-title"><a href="{$product.url}" content="{$product.url}">{$product.name|truncate:75:'...'}</a></h3>
        {/block}

        <div class="thumbnail-container home-review">
        {block name='product_reviews'}
          {hook h='displayProductListReviews' product=$product}
        {/block}
        </div>
        
        {block name='product_price_and_shipping'}
          {if $product.show_price}
            <div class="product-price-and-shipping">
              {if $product.has_discount}
                {hook h='displayProductPriceBlock' product=$product type="old_price"}

                <span class="regular-price" aria-label="{l s='Regular price' d='Shop.Theme.Catalog'}">{$product.regular_price}</span>
                {if $product.discount_type === 'percentage'}
                  <span class="discount-percentage discount-product">{$product.discount_percentage}</span>
                {elseif $product.discount_type === 'amount'}
                  <span class="discount-amount discount-product">{$product.discount_amount_to_display}</span>
                {/if}
              {/if}

              {hook h='displayProductPriceBlock' product=$product type="before_price"}

              <span class="price" aria-label="{l s='Price' d='Shop.Theme.Catalog'}">
                {capture name='custom_price'}{hook h='displayProductPriceBlock' product=$product type='custom_price' hook_origin='products_list'}{/capture}
                {if '' !== $smarty.capture.custom_price}
                  {$smarty.capture.custom_price nofilter}
                {else}
                  {$product.price}
                {/if}
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
             

              {hook h='displayProductPriceBlock' product=$product type='unit_price'}

              {hook h='displayProductPriceBlock' product=$product type='weight'}
            </div>
          {/if}
        {/block}

      </div>

      {include file='catalog/_partials/product-flags.tpl'}

      <div class="highlighted-details">
        <a  href="{$product.url}" class="btn btn-outline">
          {l s='View more' d='Modules.Customtranslation.Hometitles'}
        </a>
      </div>   
    </article>
  </div>
{/block}
