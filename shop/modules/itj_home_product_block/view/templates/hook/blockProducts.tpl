<section class="home-module featured-products clearfix"  id="itJonactionBlockProducts">
    {* {foreach from=$blocks key=index item=single_block}
        {assign var="products" value=$single_block.products }
        {if isset($products) && $products}
           
            <div class="block">    
                <div class="right-block ">
                     <h2 class="section-title text-left">{l s="{$single_block.title}" d='Modules.Customtranslation.Hometitles'}</h2>
              
                     <div class="products" id="ajax-block-products">
                        {foreach from=$single_block.products item="product"}
                            <div>
                                {include file="./product.tpl" product=$product}
                            </div>
                        {/foreach}
                    </div>
                </div>
            </div>    
        {/if}
    {/foreach} *}
</section>
