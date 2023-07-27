<div class="panel">
<form action="{$admin_url}" method="POST">
    <label for="products">Select the product</label>
    <select id="products" class='products' name="products[]" multiple="multiple">
    {* {foreach $dbData as $rows}
        <option values="{$rows['id_product']}">{$rows['name']}</option>
        {var_dump($rows['id_product'])}
        {var_dump($rows['name'])}
    {/foreach} *}
    </select>
    <input type="submit" name="submit" value="save" class="btn btn-primary">
</form>
</div>