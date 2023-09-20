{if !empty($cms_page)}
<h2 class="section-title ">
    <a href="/blog/category/3-porady-i-inspiracje">Tips and inspiration</a>
</h2>
<div class="blog-block-content d-flex">  
    <div class="blog-content">                 
        <div class="section-details" id="cms-block-details"> 
            {foreach from=$cms_page key=index item=cms}
            <div> 
                <div class="d-flex column"> 
                <div class="blog-image"> 
                    <img src="/shop/modules/itj_blog_section/img/cms/picture.jpg" alt="" width="250" height="250" /> 
                </div>    
                    <div class="blog-content"> 
                        <h2 class="title">
                            <a  href="{$cms['page_link']}">
                            {$cms['meta_title']}
                            </a>
                        </h2> 
                        <p class="section-description"> 
                        {$cms['meta_description']} 
                        </p>
                        {if !empty($cms['page_link'])}   
                            <a class="read-more" href="{$cms['page_link']}?fhp=1">View More</a> 
                        {/if}
                    </div> 
                </div> 
            </div>
            {/foreach}
        </div> 
    </div> 
</div> 
{/if} 
                
