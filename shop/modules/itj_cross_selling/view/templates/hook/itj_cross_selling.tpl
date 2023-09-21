<section class="cross-sells">
    <div class="container">
        <h2 class="section-title ">Products bought together</h2>
        <div class="cross-section-content d-flex">
            <div class="cross-content">
                <div class="section-details">
                    {foreach $products as $product}
                        <div> 
                            <div class="d-flex column"> 
                                <div class="section-content">
                                    <a href="{$product['url']}"><img src="{$product['image']}" alt="" width="250" height="250" /></a>
                                    <a href="{$product['url']}"><h3>{$product['name']}</h3></a>
                                    <p class="section-description">{$product['description']|strip_tags:'UTF-8'|truncate:360:'...'}</p>
                                    <h5>₹{$product['price']}</h5>                                    
                                </div>
                            </div>
                        </div>
                    {/foreach}
                </div>
            </div>        
        </div>
    </div>
</section>