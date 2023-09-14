<div> 
  <div class="d-flex column">    
   <div class="blog-image"> 
      {if $index==1}
        <img src="/img/cms/{$block.cover_image}" alt="" onError="this.onerror=null;this.style.display='none';" loading="lazy"> 
        {else}
          <img loading="lazy" data-lazy="/img/cms/{$block.cover_image}" alt="" />  
        {/if}  
    </div> 
    <div class="blog-content"> 
        <h2 class="title">
           <a  href="{$block.page_link}">
           {l s="{$block.meta_title}" mod='itj_home_product_block'}
           </a>
        </h2> 
        <p class="section-description"> 
          {$block.short_description} 
        </p>
          {if !empty($block.page_link)}   
            <a class="read-more" href="{$block.page_link}?fhp=1">{l s="View more" d='Modules.Customtranslation.Hometitles'}</a> 
          {else}
            <a class="read-more" href="{$block.page_link}">{l s="View more" d='Modules.Customtranslation.Hometitles'}</a> 
          {/if}  
    </div> 
  </div> 
</div>