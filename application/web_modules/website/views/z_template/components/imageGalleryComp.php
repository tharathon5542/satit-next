<div class="owl-carousel image-carousel carousel-widget" data-margin="10" data-nav="true" data-loop="false" data-pagi="false" data-items-xs="1" data-items-sm="1" data-items-md="2" data-items-lg="3" data-items-xl="3">
    <?php foreach ($imagesGalleryData as $news) {
        if (count($news['newsImages']) > 0) {
    ?>
            <div class="oc-item">
                <div class="grid-inner">
                    <div class="entry-image clearfix">
                        <div class="fslider" data-animation="fade" data-pagi="false" data-pause="6000" data-lightbox="gallery">
                            <div class="flexslider">
                                <div class="slider-wrap">
                                    <?php foreach ($news['newsImages'] as $newsImage) { ?>
                                        <div class="slide"><a href="<?php echo base_url('assets/images/newsImages/' . $newsImage['imageName'] . $newsImage['imageType']) ?>" data-lightbox="gallery-item"><img class="lazy" style="height: 275px; object-fit: cover;" src="<?php echo base_url('assets/images/newsImages/' . $newsImage['imageName'] . $newsImage['imageType']) ?>" data-src="<?php echo base_url('assets/images/newsImages/' . $newsImage['imageName'] . $newsImage['imageType']) ?>" alt="Gallery Image"></a></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="entry-title">
                        <h2>
                            <?php $this->load->helper('text');
                            echo ellipsize($news['newsTitle'], 50);
                            ?>
                        </h2>
                    </div>
                    <div class="entry-meta">
                        <ul>
                            <li><i class="icon-calendar3"></i><?php echo $news['newsDateTH'] ?></li>
                        </ul>
                    </div>
                </div>
            </div>
    <?php }
    } ?>
</div>