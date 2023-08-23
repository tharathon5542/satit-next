<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="<?php echo $author; ?>" />
    <meta name="description" content="<?php echo $description; ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url('assets/images/logo-mini-cwie.png'); ?>">
    <title><?php echo $title ?></title>

    <!-- custom page css -->
    <?php if ($page == 'Dashboard') { ?>
        <!-- dashboard -->
        <link rel="stylesheet" type="text/css" href="<?php echo ELITEADMIN ?>css/pages/dashboard4.css">
    <?php } else if ($page == 'Auth') { ?>
        <!-- auth page -->
        <link rel="stylesheet" type="text/css" href="<?php echo ELITEADMIN ?>css/pages/login-register-lock.css">
        <link rel="stylesheet" type="text/css" href="<?php echo ELITEADMIN ?>css/pages/tab-page.css">
    <?php } ?>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo ELITEADMIN ?>css/style.min.css">
    <!-- sweet alerts CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo ELITEADMIN ?>css/sweetalert2.min.css">
    <!-- Data table -->
    <link rel="stylesheet" type="text/css" href="<?php echo ELITEADMIN ?>css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="<?php echo ELITEADMIN ?>css/responsive.dataTables.min.css">
    <!-- step wizard -->
    <link rel="stylesheet" type="text/css" href="<?php echo ELITEADMIN ?>css/steps.css">
    <!-- Calendar CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo ELITEADMIN ?>css/fullcalendar.css">
    <!-- User profile image overlay -->
    <link rel="stylesheet" type="text/css" href="<?php echo ELITEADMIN ?>css/pages/user-card.css">
    <!-- Popup CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo ELITEADMIN ?>css/magnific-popup.css">
    <!-- dropify CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo ELITEADMIN ?>css/dropify.min.css">
    <!-- select 2 -->
    <link rel="stylesheet" type="text/css" href="<?php echo ELITEADMIN ?>css/select2.min.css" />
    <!-- tags input -->
    <link rel="stylesheet" type="text/css" href="<?php echo ELITEADMIN ?>css/bootstrap-tagsinput.css" />
    <!-- Custom CSS, Add your custom css code in custom.css file. -->
    <link rel="stylesheet" type="text/css" href="<?php echo ELITEADMIN ?>css/custom.css" />
    <!-- chat css -->
    <link rel="stylesheet" type="text/css" href="<?php echo ELITEADMIN ?>css/chat-app-page.css">
</head>

<body class="fixed-layout skin-default rmv-right-panel">

    <!-- load session timeout component -->
    <?php $this->load->view('z_template/components/sessionTimeOutComp'); ?>