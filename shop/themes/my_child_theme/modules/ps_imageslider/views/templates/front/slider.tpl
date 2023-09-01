{if $homeslider.slides}
    <div class="homeslider-container" data-interval="{$homeslider.speed}" data-wrap="{$homeslider.wrap}" data-pause="{$homeslider.pause}">
      <ul class="rslides">
        {foreach from=$homeslider.slides item=slide}
          <li class="slide">
          <p>kjsndjwnfejknf3ekjfnkerjwifn3j</p>

            {if $slide.new_tab==1}
              <a href="{$slide.url}" target="_blank">
                <img src="{$slide.image_url}" alt="{$slide.legend|escape}" />
                {if $slide.title || $slide.description }
                  <span class="caption">
                    <h2>{$slide.title}</h2>
                    <div>{$slide.description nofilter}</div>
                  </span>
                {/if}
              </a>
              {/if}
          </li>
        {/foreach}
      </ul>
    </div>
  {/if}