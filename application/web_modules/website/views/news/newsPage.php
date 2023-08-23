<body class="stretched">

    <!-- Document Wrapper -->
    <div id="wrapper" class="clearfix">

        <!-- Load head components -->
        <?php $this->load->view('z_template/components/headComp'); ?>

    </div>

    <!-- load breadcump component -->
    <?php
    $this->load->view('z_template/components/breadCrumbComp', $Breadcrumb); ?>

    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="row gutter-40 col-mb-80">
                    <div class="postcontent col-lg-12">
                        <?php foreach ($newsData as $news) { ?>
                            <div class="row gutter-40 mb-0">
                                <div class="entry event  col-12">
                                    <div class="grid-inner row g-0">
                                        <div class="col-md-4">
                                            <div>
                                                <div class="fslider" data-arrows="false" data-lightbox="gallery">
                                                    <div class="flexslider">
                                                        <div class="slider-wrap">
                                                            <?php foreach ($news['newsImages']  as $newsImage) { ?>
                                                                <div class="slide"><a href="<?php echo base_url('assets/images/newsImages/' . $newsImage['newsImageName'] . $newsImage['newsImageType']) ?>" data-lightbox="gallery-item"><img class="lazy" style="height: 250px; object-fit: cover;" src="<?php echo base_url('assets/images/newsImages/' . $newsImage['newsImageName'] . $newsImage['newsImageType']) ?>" data-src="<?php echo base_url('assets/images/newsImages/' . $newsImage['newsImageName'] . $newsImage['newsImageType']) ?>" alt="news image"></a></div>
                                                            <?php } ?>
                                                            <?php echo count($news['newsImages']) <= 0 ? '<div class="slide"><a href="' . base_url('assets/images/image-holder.jpg') . '" data-lightbox="gallery-item"><img style="object-fit: cover;" src="' . base_url('assets/images/image-holder.jpg') . '" alt="news image"></a></div>' : ''; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8 ps-md-4 py-4">
                                            <div class="entry-title title-sm">
                                                <h2><a href="<?php echo base_url('news/detail/' . $news['newsURL']) ?>"><?php echo $news['newsTitle']; ?></a></h2>
                                            </div>
                                            <div class="entry-meta">
                                                <ul>
                                                    <li><i class="icon-calendar3"></i><?php echo $news['newsDateTH']; ?></li>
                                                    <li><i class="icon-pen1"></i><?php echo $news['newsAuthor']; ?></li>
                                                </ul>
                                            </div>
                                            <div class="entry-content ">
                                                <a href="<?php echo base_url('news/detail/' . $news['newsURL']) ?>" class="button button-border button-rounded mb-4">ดูรายละเอียดเพิ่มเติม</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }  ?>
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