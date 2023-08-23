<body class="stretched">

    <!-- Document Wrapper -->
    <div id="wrapper" class="clearfix">

        <!-- Load head components -->
        <?php $this->load->view('z_template/components/headComp'); ?>

    </div>

    <!-- load breadcump component -->
    <?php
    $this->load->view('z_template/components/breadCrumbComp', $Breadcrumb); ?>

    <?php if (!count($newsData['newsImages']) <= 0) { ?>
        <section id="slider" class="slider-element slider-parallax swiper_wrapper clearfix" style="height: 600px;">
            <div class="swiper-container swiper-parent">
                <div class="swiper-wrapper">
                    <?php foreach ($newsData['newsImages'] as $image) { ?>
                        <div class="swiper-slide">
                            <div class="swiper-slide-bg" style="background-image: url(<?php echo base_url('assets/images/newsImages/') . $image['newsImageName'] . $image['newsImageType'] ?>);"></div>
                        </div>
                    <?php } ?>
                </div>
                <div class="slider-arrow-left"><i class="icon-angle-left"></i></div>
                <div class="slider-arrow-right"><i class="icon-angle-right"></i></div>
            </div>
        </section>
    <?php } ?>

    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="row gutter-40 col-mb-80">
                    <div class="postcontent col-lg-12">
                        <div class="single-event">
                            <div class="row col-mb-50 mb-0">
                                <div class="col-md-7 col-lg-8">
                                    <h3><?php echo $newsData['newsTitle']; ?></h3>
                                    <?php echo $newsData['newsDetail']; ?>
                                    <h4>คลังรูปภาพ</h4>
                                    <div class="masonry-thumbs grid-container grid-3" data-lightbox="gallery">
                                        <?php foreach ($newsData['newsImages'] as $image) { ?>
                                            <a class="grid-item" href="<?php echo base_url('assets/images/newsImages/') . $image['newsImageName'] . $image['newsImageType'] ?>" data-lightbox="gallery-item"><img class="lazy" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 3'%3E%3C/svg%3E" width="800" height="600" data-src="<?php echo base_url('assets/images/newsImages/') . $image['newsImageName'] . $image['newsImageType'] ?>" alt="news image"></a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-md-5 col-lg-4 order-md-last">
                                    <div class="card event-meta mb-3">
                                        <div class="card-body">
                                            <ul class="iconlist mb-0">
                                                <li><i class="icon-calendar3"></i> <?php echo $newsData['newsDateTH']; ?></li>
                                                <li><i class="icon-pen1"></i><?php echo $newsData['newsAuthor']; ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Load foot components -->
    <?php $this->load->view('z_template/components/footComp'); ?>

    </div>
</body>

<script>

</script>