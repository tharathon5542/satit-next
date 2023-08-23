<?php
// load text helper to reduce display long text
$this->load->helper('text');
?>
<section id="page-title">
    <div class="container clearfix">
        <h1><?php echo $Breadcrumb['title']; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">หน้าหลัก </a></li>
            <?php if (isset($Breadcrumb['sub'])) { ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo base_url($Breadcrumb['mainURL']) ?>"><?php echo $Breadcrumb['main']; ?></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <?php echo ellipsize($Breadcrumb['sub'], 20, 1); ?>
                </li>
            <?php } else { ?>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $Breadcrumb['main']; ?></li>
            <?php } ?>

        </ol>
    </div>
</section>