<?php foreach ($videoData as $video) { ?>
    <div class="oc-item">
        <div class="portfolio-item">
            <div class="portfolio-image">
                <?php if ($video['videoType'] == 'youtube') { ?>
                    <img class="lazy" data-src="<?php echo $video['videoThumbnailName'] ?>" src="<?php echo $video['videoThumbnailName'] ?>" alt="CWIE Video">
                    <div class="bg-overlay">
                        <div class="bg-overlay-content dark" data-hover-animate="fadeIn" data-hover-speed="350">
                            <a href="<?php echo $video['videoName'] ?>" class="overlay-trigger-icon bg-light text-dark youtube" data-hover-animate="fadeInDownSmall" data-hover-animate-out="fadeInUpSmall" data-hover-speed="350" data-lightbox="iframe"><i class="icon-line2-magnifier"></i></a>
                        </div>
                        <div class="bg-overlay-bg dark" data-hover-animate="fadeIn" data-hover-speed="350"></div>
                    </div>
                <?php } else { ?>
                    <img class="lazy" data-src="<?php echo base_url('assets/images/videoThumbnail/' . $video['videoThumbnailName'] . $video['videoThumbnailType']) ?>" src="<?php echo base_url('assets/images/videoThumbnail/' . $video['videoThumbnailName'] . $video['videoThumbnailType']) ?>" alt="CWIE Video">
                    <div class="bg-overlay">
                        <div class="bg-overlay-content dark" data-hover-animate="fadeIn" data-hover-speed="350">
                            <a href="<?php echo base_url('assets/videos/' . $video['videoName'] . $video['videoType']) ?>" class="overlay-trigger-icon bg-light text-dark youtube" data-hover-animate="fadeInDownSmall" data-hover-animate-out="fadeInUpSmall" data-hover-speed="350" data-lightbox="iframe"><i class="icon-line2-magnifier"></i></a>
                        </div>
                        <div class="bg-overlay-bg dark" data-hover-animate="fadeIn" data-hover-speed="350"></div>
                    </div>
                <?php } ?>
            </div>
            <div class="portfolio-desc">
                <span>
                    <?php echo $video['videoTitle'] ?><br>
                    <small><?php echo $video['videoAuthor'] ?></small><br>
                    <small>วันที่ : <?php echo $video['videoDateTH'] ?> เวลา : <?php echo $video['videoTime'] ?></small>
                </span>
            </div>

        </div>
    </div>
<?php } ?>