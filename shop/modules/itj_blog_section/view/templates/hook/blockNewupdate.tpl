{*{$blocks|@var_dump}*}
<section class="blog-update-block"> 
    <div class="container">
        <h2 class="section-title ">{l s="Tips and inspiration" d='Modules.Customtranslation.Hometitles'}</h2>
        <div class="blog-block-content d-flex"> 
            {*<div class="blog-image"> 
                <img src="{_MODULE_DIR_}itj_blog_section/img/blog_{$shop.name}.png" alt="new-to-{$shop.name}" loading="lazy"> 
            </div> *}            
            <div class="blog-content">                 
                <div class="section-details">                 
                    {foreach from=$blocks key=index item=block} 
                        {if $block.itj_blog_section_title[$language.iso_code]}                             
                            {include file="./block.tpl" block=$block index=$index} 
                        {/if} 
                    {/foreach} 
                </div> 
            </div> 
        </div>   
    </div>  
</section> 