<section id="slider" class="slider-element slider-parallax min-vh-100 dark include-header">
    <div class="slider-inner" style="background: url('<?php echo isset($facultyData['facultyCoverImageName']) ? base_url('assets/images/cover/') . $facultyData['facultyCoverImageName'] . $facultyData['facultyCoverImageType'] : base_url('assets/images/image-holder.jpg') ?>') bottom center no-repeat; background-size: cover;">
        <div class="vertical-middle">
            <div class="container p-4 rounded" style="background-color: rgba(0,0,0,0.5);">
                <div class="emphasis-title mb-0">
                    <h1 class="fw-bold text-uppercase ls3 bottommargin-sm">
                        <span class="<?php echo $facultyData['facultyNameEN'] ? 'text-rotater' : '' ?> nocolor" data-separator="|" data-rotate="fadeInLeft" data-speed="5000">
                            <span class="t-rotate" style="text-shadow: 2px 4px 4px rgba(46,91,173,0.6);"><?php echo !$facultyData['facultyNameEN'] ? $facultyData['facultyNameTH'] : $facultyData['facultyNameTH'] . '|' . $facultyData['facultyNameEN'] ?></span>
                        </span>
                    </h1>
                    <?php
                    if ($facultyData['facultyWelcomeVideoName'] != null) { ?>
                        <div class="inline-block"><a id="play-hero-video" href="<?php echo $facultyData['facultyWelcomeVideoType'] == 'youtube' ? $facultyData['facultyWelcomeVideoName'] : $facultyData['facultyWelcomeVideoName'] . $facultyData['facultyWelcomeVideoType'] ?>" class="big-video-button small-video-button pulse animated infinite" data-lightbox="iframe"><i class="icon-line-play"></i></a><span style="font-size:20px; margin-left:15px;">วิดิโอหน่วยงานการศึกษา</span></div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <a href="#" data-scrollto="#section-detail" data-easing="easeInOutExpo" data-speed="1250" data-offset="65" class="one-page-arrow dark"><i class="icon-angle-down infinite animated fadeInDown"></i></a>
    </div>
</section>