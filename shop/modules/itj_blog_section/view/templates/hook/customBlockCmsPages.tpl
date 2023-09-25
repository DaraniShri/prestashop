{foreach from=$cms_page key=index item=cms}
<div> 
    <div class="d-flex column"> 
    <div class="blog-image"> 
        <img src="/shop/modules/itj_blog_section/img/cms/picture.jpg" alt="" width="250" height="250" /> 
    </div>    
        <div class="blog-content"> 
            <h2 class="title">
                <a  href="{$cms['page_link']}">
                {l s="{$cms['meta_title']}" mod='itj_home_product_block'}                
                </a>
            </h2> 
            <p class="section-description"> 
            {$cms['meta_description']} 
            </p>
            {if !empty($cms['page_link'])}   
                <a class="read-more" href="{$cms['page_link']}?fhp=1">{l s="View more" d='Modules.Customtranslation.Hometitles'}</a> 
            {/if}
        </div> 
    </div> 
</div>
{/foreach}    