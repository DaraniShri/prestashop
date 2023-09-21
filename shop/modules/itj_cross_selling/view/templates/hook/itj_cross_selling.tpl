<section class="cross-sells">
    <div class="container">
        <h2 class="section-title ">Cross Sells</h2>
        <div class="cross-section-content d-flex">
            <div class="cross-content">
                <div class="section-details">
                    {foreach from=$products key=index item=product}
                        <div> 
                            <div class="d-flex column"> 
                                <div class="blog-content">
                                    <img src="{$product['image']}" alt="" width="250" height="250" />
                                    <p class="section-description">{$product['name']}</p>
                                    
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