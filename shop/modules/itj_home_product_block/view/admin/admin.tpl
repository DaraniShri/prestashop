<div class="panel">
    <form id="module_form" data-shopid="{$shop_id}" class="defaultForm form-horizontal" action="{$admin_url}" method="post" enctype="multipart/form-data" novalidate="">
        <div id="render-tab">
            <ul id="capitoolsBlockTabs" class="nav nav-tabs" data-tabs="tabs">
                
            </ul>
            <hr>
            <div id="capitoolsBlockTabsContent" class="tab-content"></div>
            
        </div>
        {for $index=1 to $number_of_block}
                {assign var="block" value="{'block_'}{$index}" }
                {assign var="block_name" value="{'block_name_'}{$index}" }
                {assign var="product_ids" value="{'product_ids_'}{$index}" }
                {assign var="selected_ids" value=$saved_data[$block][$product_ids] }
                {*{$saved_data[$block][$block_name]|@var_dump}
                {$saved_data[$block][$product_ids]|@var_dump}*}
                <div id="block_{$index}" class="full-block">
                    <ul>
                        <li id="list-block-name">
                            <a href="#showBlock{$index}" class="blockName btn" data-toggle="tab">BLOCK {$index}</a>
                        </li>
                    </ul>
                    
                    <div class="form-wrapper block-content tab-pane" id="showBlock{$index}">
                        <div class="row">
                            <div class="control-label label">
                                <label>Block Name </label>
                            </div>
                            <div class="field">
                                <input name="block_name_{$index}" value="{$saved_data[$block][$block_name]}" id="block_name_{$index}" />
                            </div>
                        </div> 
                        <div class="row">
                            <div class="control-label label">
                                <label>Search Product </label>
                            </div>
                            <div class="field">
                                <select id="selected_product_{$index}" class="select-home-product" name="product_ids_{$index}[]" multiple data-order="8726,8755" >
                                    {if $selected_ids|@count gt 0}
                                        {foreach from=$selected_ids key=pID item=pName}
                                            <option selected value="{$pID}">{$pName}</option>
                                        {/foreach}
                                    {/if}

                                </select>
                            </div>

                        </div> 
                        <div id="selectedProduct">
                        </div>
                            {*<input type="hidden" name="product_ids_{$index}" value="" id="product_ids_{$index}" />*}
                    </div>
                </div>
        {/for}    
        
        <div class="panel-footer">
            <button type="submit" value="1" id="saveBlocks" name="submititjonctionblockproducts" class="btn btn-default button">
		<i class="process-icon-save"></i> Save
            </button>
        </div>	
    </form>
</div>


