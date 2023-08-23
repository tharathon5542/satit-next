    <div class="col-md-12">
        <div id="oc-posts" class="owl-carousel posts-carousel carousel-widget posts-md" data-margin="20" data-nav="true" data-pagi="true" data-items-xs="1" data-items-sm="2" data-items-md="3" data-items-xl="4">

            <?php foreach ($newsData as $news) { ?>
                <div class="oc-item">
                    <div class="entry">
                        <div class="entry-image">
                            <div class="fslider" data-arrows="false" data-lightbox="gallery">
                                <div class="flexslider">
                                    <div class="slider-wrap">
                                        <?php foreach ($news['newsImages'] as $image) { ?>
                                            <div class="slide"><a href="<?php echo base_url('assets/images/newsImages/' . $image['newsImageName'] . $image['newsImageType']) ?>" data-lightbox="gallery-item"><img class="img-fluid lazy" style="height: 250px; object-fit: cover;" src="<?php echo base_url('assets/images/newsImages/' . $image['newsImageName'] . $image['newsImageType']) ?>" data-src="<?php echo base_url('assets/images/newsImages/' . $image['newsImageName'] . $image['newsImageType']) ?>" alt="news image"></a></div>
                                        <?php } ?>

                                        <?php echo count($news['newsImages']) <= 0 ? '<div class="slide"><a href="' . base_url('assets/images/image-holder.jpg') . '" data-lightbox="gallery-item"><img style="object-fit: cover;" src="' . base_url('assets/images/image-holder.jpg') . '" alt="news image"></a></div>' : ''; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="entry-title title-sm nott">
                            <?php  ?>
                            <h3>
                                <a href="<?php echo base_url('news/detail/' . $news['newsURL']) ?>" title="<?php echo str_replace('"', '', $news['newsTitle']); ?>">
                                    <?php
                                    $this->load->helper('text');
                                    echo ellipsize($news['newsTitle'], 50);
                                    ?>
                                </a>
                            </h3>
                        </div>
                        <div class="entry-meta">
                            <ul>
                                <li><?php echo $news['newsDateTH']; ?> เวลา <?php echo $news['newsTime'] ?></li>
                                <li><?php echo $news['newsAuthor']; ?></li>
                            </ul>
                        </div>
                        <div class="entry-content ">
                            <a href="<?php echo base_url('news/detail/' . $news['newsURL']) ?>" target="_blank" class="button button-border button-rounded">ดูรายละเอียดเพิ่มเติม</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>