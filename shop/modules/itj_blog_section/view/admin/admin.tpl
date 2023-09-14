<div class="panel"> 
    <form id="module_form" class="defaultForm form-horizontal" formlang={$language_default} action="{$admin_url}" method="post" enctype="multipart/form-data" novalidate=""> 
        <div id="render-tab"> 
            <ul id="capitoolsBlockTabs" class="nav nav-tabs" data-tabs="tabs"> </ul> 
            <hr> 
            <div id="capitoolsBlockTabsContent" class="tab-content"></div> 
        </div> 

        {for $index=1 to $number_of_block} 
                {assign var="itj_blog_section" value="{'itj_blog_section_'}{$index}" } 
                {assign var="itj_blog_section_image" value="{'itj_blog_section_image_'}{$index}" } 
                {assign var="itj_blog_section_name" value="{'itj_blog_section_name_'}{$index}" } 
                {assign var="itj_blog_section_description" value="{'itj_blog_section_description_'}{$index}" } 
                {assign var="itj_blog_section_link" value="{'itj_blog_section_link_'}{$index}" } 

                <div id="block_{$index}" class="full-block"> 
                    <ul> 
                        <li id="list-block-name"> 
                            <a href="#showBlock{$index}" class="blockName btn" data-toggle="tab">BLOCK {$index}</a> 
                        </li> 
                    </ul> 

                    <div class="form-wrapper block-content tab-pane" id="showBlock{$index}"> 
                        <div class="row"> 
                            <div class="control-label label"> 
                                <label>Language </label> 
                            </div> 
                            <div class="field"> 
                                <select name="language_option" class="language-option" id="language_option"> 
                                {foreach from=$language_option item=option} 
                                    <option value="{$option['iso_code']}" {if $language_default eq $option['iso_code']}selected="selected" {/if}>{$option['name']}</option> 
                                {/foreach}> 
                                </select> 
                            </div> 
                        </div> 
                        <div class="row"> 
                            <div class="control-label label"> 
                                <label>Block Image </label> 
                            </div> 
                            <div class="field"> 
                                {foreach from=$language_option item=option} 
                                    {assign var="itj_blog_section_lang" value="{$itj_blog_section}_{$option['iso_code']}" } 
                                    {assign var="itj_blog_section_image_lang" value="{$itj_blog_section_image}_{$option['iso_code']}" } 
                                    {if $saved_data[$itj_blog_section_lang][$itj_blog_section_image_lang]} 
                                        <img class="img_{$index}_{$option['iso_code']} form-input {$option['iso_code']}" src="{_MODULE_DIR_}itj_blog_section/img/{$saved_data[$itj_blog_section_lang][$itj_blog_section_image_lang]}" width="200px" height="200px"  onError="this.onerror=null;this.style.display='none';"> 
                                        <i  id="icon_{$index}_{$option['iso_code']}" class="material-icons form-input delete-icon {$option['iso_code']}">delete</i> 
                                    {/if} 
                                    <input type="text" id="image_path_{$index}_{$option['iso_code']}" name="image_path_{$index}_{$option['iso_code']}" class="{$option['iso_code']}" style="display:none;" value="{$saved_data[$itj_blog_section_lang][$itj_blog_section_image_lang]}"> 
                                    <input class="form-input {$option['iso_code']}" name="itj_blog_section_image_{$index}_{$option['iso_code']}" type="file" value="{$saved_data[$itj_blog_section_lang][$itj_blog_section_image_lang]}" id="itj_blog_section_image_{$index}_{$option['iso_code']}" /> 
                                {/foreach} 
                            </div> 
                        </div> 
                        <div class="row"> 
                            <div class="control-label label"> 
                                <label>Block Name </label> 
                            </div> 
                            <div class="field"> 
                                {foreach from=$language_option item=option} 
                                    {assign var="itj_blog_section_lang" value="{$itj_blog_section}_{$option['iso_code']}" } 
                                    {assign var="itj_blog_section_name_lang" value="{$itj_blog_section_name}_{$option['iso_code']}" } 
                                    <input class="form-input {$option['iso_code']}" name="itj_blog_section_name_{$index}_{$option['iso_code']}" value="{$saved_data[$itj_blog_section_lang][$itj_blog_section_name_lang]}" id="itj_blog_section_name_{$index}_{$option['iso_code']}" /> 
                                {/foreach} 
                            </div> 
                        </div>  
                        <div class="row"> 
                            <div class="control-label label"> 
                                <label>Block Description </label> 
                            </div> 
                            <div class="field"> 
                                {foreach from=$language_option item=option} 
                                    {assign var="itj_blog_section_lang" value="{$itj_blog_section}_{$option['iso_code']}" } 
                                    {assign var="itj_blog_section_description_lang" value="{$itj_blog_section_description}_{$option['iso_code']}" } 
                                    <textarea class="form-input {$option['iso_code']}" name="itj_blog_section_description_{$index}_{$option['iso_code']}" id="itj_blog_section_description_{$index}_{$option['iso_code']}" name="w3review" rows="8" cols="50">{$saved_data[$itj_blog_section_lang][$itj_blog_section_description_lang]}</textarea> 
                                {/foreach} 
                            </div> 
                        </div>  
                        <div class="row"> 
                            <div class="control-label label"> 
                                <label>Block Link </label> 
                            </div> 
                            <div class="field"> 
                                {foreach from=$language_option item=option} 
                                    {assign var="itj_blog_section_lang" value="{$itj_blog_section}_{$option['iso_code']}" } 
                                    {assign var="itj_blog_section_link_lang" value="{$itj_blog_section_link}_{$option['iso_code']}" } 
                                    <input class="form-input {$option['iso_code']}" name="itj_blog_section_link_{$index}_{$option['iso_code']}" value="{$saved_data[$itj_blog_section_lang][$itj_blog_section_link_lang]}" id="itj_blog_section_link_{$index}_{$option['iso_code']}" /> 
                                {/foreach} 
                            </div> 
                        </div>  
                    </div> 
                </div> 
        {/for}     
        <div class="panel-footer"> 
            <button type="submit" value="1" id="saveBlocks" name="submititjonctionblockproducts" class="btn btn-default button"> 
            <i class="process-icon-save"></i> Save </button> 
        </div>  
    </form> 
</div> 