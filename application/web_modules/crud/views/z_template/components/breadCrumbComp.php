<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-12">
        <h4 class="text-white"><?php echo isset($page) ? $page : 'Null';  ?></h4>
    </div>
    <div class="col-md-12">
        <ol class="breadcrumb justify-content-end">
            <li class="breadcrumb-item"><a href="<?php echo base_url('crud/index') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active"><?php echo isset($page) ? $page : 'Null';  ?></li>
        </ol>
    </div>
</div>