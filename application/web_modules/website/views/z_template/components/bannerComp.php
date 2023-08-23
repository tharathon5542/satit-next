<section id="slider" class="slider-element slider-parallax swiper_wrapper min-vh-75" data-loop="true">
    <div class="swiper-container swiper-parent">
        <div class="swiper-wrapper">
            <div class="swiper-slide" id="sliderVideo">
                <div class="video-wrap">
                    <video id="slide-video" poster="<?php echo base_url('assets/images/bannerSlider/loading.jpg') ?>" preload="auto" loop autoplay muted>
                        <source src='<?php echo base_url('assets/videos/cwie_clli.mp4') ?>' type='video/mp4' />
                    </video>
                    <div class="video-overlay" style="background-color: rgba(0,0,0,0.1);"></div>
                </div>
            </div>
            <!-- Set Banner Data  -->
            <?php foreach ($bannerData as $banner) { ?>
                <div class="swiper-slide">
                    <div class="swiper-slide-bg" style="background-image: url('<?php echo $banner['bannerPath'] ?>'); background-position: center bottom;"></div>
                </div>
            <?php } ?>
        </div>
        <div class="slider-arrow-left"><i class="icon-angle-left"></i></div>
        <div class="slider-arrow-right"><i class="icon-angle-right"></i></div>
    </div>
</section>