{* smarty *}
{load_presentation_object filename="main_categories" assign="obj"}
{literal}
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function(){
            $('.slider').bxSlider({
                slideWidth: 700,
                adaptiveHeight: true,
                adaptiveHeightSpeed: 500,
                auto: true,
                mode: 'fade',
                minSlides: 1,
                maxSlides: 1,
                startSlide: 0,
                slideMargin: 0,
                infiniteLoop: true,
                slideMargin: 0,
                autoControls: false,
                pager: false,
                easing: null,
                controls: true
            });
        });
    </script>
{/literal}
<!-- Main content Section -->



<div id="main">

    {if ($obj->mBanners|@count) eq 1}
        {section name=i loop=$obj->mBanners}
            <div id="banner" class="grid_9">
                <a href="{$obj->mAnnouncementLink[i]}"><img class="max-img" src="images/{$obj->mBanners[i].banner_image}" alt="images/{$obj->mBanners[i].banner_image}"/></a>
                <div id="moto">
                    <div class="text">
                        <a href="{$obj->mAnnouncementLink[i]}">{$obj->mBanners[i].banner_title}</a>
                        {$obj->mBanners[i].banner_text}
                    </div>
                </div>
            </div>
        {/section}
    {else}
        <div class="slider">
            {section name=i loop=$obj->mBanners}
                <div id="banner" class="grid_9">
                    <a href="{$obj->mAnnouncementLink[i]}"><img class="max-img" src="images/{$obj->mBanners[i].banner_image}" alt="images/{$obj->mBanners[i].banner_image}"/></a>
                    <div id="moto">
                        <div class="text">
                            <a href="{$obj->mAnnouncementLink[i]}">{$obj->mBanners[i].banner_title}</a>
                            {$obj->mBanners[i].banner_text}
                        </div>
                    </div>
                </div>
            {/section}
        </div>
        </br>
    {/if}


    <div class="clear"></div>
    {section name=i loop=$obj->mCategories}
    {if $obj->mCategories[i].is_edu eq 0}

    {if $obj->mCategories[i].category_id eq 4}
    <div class="block last">
        {else}
        <div class="block">
            {/if}

            <div class="grid_3">
                <a href="{$obj->mCategories[i].link_to_category}"><img class="max-img" alt="{$obj->mCategories[i].name}" src="images/{$obj->mCategories[i].image}" /></a>
                <div class="text">
                    <h4><a href="{$obj->mCategories[i].link_to_category}">{$obj->mCategories[i].name}</a></h4>
                    <p>{$obj->mCategories[i].description}</p>
                </div>
            </div>
        </div>
        {/if}
        {/section}

    </div>

</div>