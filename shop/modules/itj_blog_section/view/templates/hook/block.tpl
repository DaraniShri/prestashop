<div> 
  <div class="d-flex column">    
   <div class="blog-image"> 
      {if $index==1}
        <img src="{_MODULE_DIR_}itj_blog_section/img/{$block.itj_blog_section_image[$language.iso_code]}" alt="{$block.itj_blog_section_image[$language.iso_code]}" onError="this.onerror=null;this.style.display='none';" loading="lazy"> 
        {else}
          <img loading="lazy" data-lazy="{_MODULE_DIR_}itj_blog_section/img/{$block.itj_blog_section_image[$language.iso_code]}" alt="{$block.itj_blog_section_image[$language.iso_code]}" />  
        {/if}  
    </div> 
    <div class="blog-content"> 
        <h2 class="title">
           <a  href="/{$block.itj_blog_section_link[$language.iso_code]}">
           {l s="{$block.itj_blog_section_title[$language.iso_code]}" mod='itj_home_product_block'}
           </a>
        </h2> 
        <p class="section-description"> 
          {$block.itj_blog_section_description[$language.iso_code]} 
        </p>  
          {if !empty($block.itj_blog_section_link[$language.iso_code])}   
            <a class="read-more" href="/{$block.itj_blog_section_link[$language.iso_code]}?fhp=1">{l s="View more" d='Modules.Customtranslation.Hometitles'}</a> 
          {else}
            <a class="read-more" href="/{$block.itj_blog_section_link[$language.iso_code]}">{l s="View more" d='Modules.Customtranslation.Hometitles'}</a> 
          {/if}  
    </div> 
  </div> 
</div>
  {* <div class="accordion">                        
      {if $block.itj_blog_section_link[$language.iso_code]=="/" || $block.itj_blog_section_link[$language.iso_code]==""} 
        <input type='checkbox' name='checkbox-accordion-{$index}' id="checkbox-accordion-{$index}" />
        <label for="checkbox-accordion-{$index}" class="btn btn-outline">{l s="View more" d='Modules.Customtranslation.Hometitles'}</label>
      {else}
        <a class="btn btn-outline" href="/{$block.itj_blog_section_link[$language.iso_code]}">{l s="View more" d='Modules.Customtranslation.Hometitles'}</a>
      {/if} 
      <div class="accordion__content">
          <h2 class="title">{l s="{$block.itj_blog_section_title[$language.iso_code]}" mod='itj_home_product_block'}</h2> 
          <p class="section-description"> 
            {$block.itj_blog_section_description[$language.iso_code]} 
          </p> 
      </div>
  </div> *}