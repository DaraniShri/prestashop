<div class="container">
<form>
    <label for="products">Select the product</label>
    <select id="products" class='products'name="products[]" multiple="multiple">
    {* {foreach $dbData as $rows}
        <option values="{$rows['id_product']}">{$rows['name']}</option>
        {var_dump($rows['id_product'])}
        {var_dump($rows['name'])}
    {/foreach} *}
    </select>
</form>
</div>

