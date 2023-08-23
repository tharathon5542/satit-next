<section id="slider" class="slider-element swiper_wrapper customjs h-auto">
    <div class="swiper-container swiper-parent slider-top">
        <div class="swiper-wrapper h-auto">
            <?php foreach ($bannerData as $banner) { ?>
                <div class="swiper-slide" style="background-image: url('<?php echo $banner['bannerPath'] ?>')"></div>
            <?php } ?>
        </div>
        <div class="slider-arrow-left"><i class="icon-angle-left"></i></div>
        <div class="slider-arrow-right"><i class="icon-angle-right"></i></div>
    </div>
    <div class="swiper-container slider-thumbs">
        <div class="swiper-wrapper h-auto">
            <?php foreach ($bannerData as $banner) { ?>
                <div class="swiper-slide"><img src="<?php echo $banner['bannerPath'] ?>" alt="Image"></div>
            <?php } ?>
        </div>
    </div>
</section>