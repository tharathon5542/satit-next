<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="<?php echo $author; ?>" />
    <meta name="description" content="<?php echo $description; ?>">
    <meta name="keywords" content="<?php foreach ($keywords as $keyword) echo $keyword . ',' ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url('assets/images/logo-mini-cwie.png'); ?>">
    <title><?php echo $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Stylesheets
	============================================= -->
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo CANVAS ?>css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo CANVAS ?>style.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo CANVAS ?>css/onepage.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo CANVAS ?>css/dark.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo CANVAS ?>css/font-icons.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo CANVAS ?>css/animate.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo CANVAS ?>css/magnific-popup.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo CANVAS ?>css/custom.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo CANVAS ?>css/et-line.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo CANVAS ?>css/onepage/fonts.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo CANVAS ?>css/medical-icons.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo CANVAS ?>css/estate-icons.css" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" type="text/css" />
    <!-- sweet alerts CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo ELITEADMIN ?>css/sweetalert2.min.css">
    <!-- Data table -->
    <link rel="stylesheet" type="text/css" href="<?php echo ELITEADMIN ?>css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="<?php echo ELITEADMIN ?>css/responsive.dataTables.min.css">

    <style>
        body:not(.modal-open) {
            padding-right: 0px !important;
        }
    </style>
</head>