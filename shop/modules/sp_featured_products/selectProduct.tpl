<div class="container">
    <label for="products[]">Select the product</label>
    <select id="products" name="products[]" multiple="true" >
    {foreach $dbData as $rows}
        <option values="{$rows['id_product']}">{$rows['name']}</option>
    {/foreach}
    </select>
</div>

