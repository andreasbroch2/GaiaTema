<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/4bf89719e2.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- TrustBox script -->
<script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>
<!-- End TrustBox script -->
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="main-header">
    <nav class="main-header__nav">
        <input type="checkbox" id="hamburger1" />
        <label for="hamburger1"></label>
            <?php
                wp_nav_menu( array(
                    'theme_location' => 'top-menu',
                    'container_class' => 'nav-links'
                ));
            ?>
    </nav>
    <div class="main-header__logo">
        <a href="/test"><img data-lazyloaded="1" src="https://i1.wp.com/gaiamadservice.dk/wp-content/uploads/2021/01/BedsteLogo.png" data-was-processed="true"></a>
    </div>
    <div class="main-header__tools">
        <a href="#" class="tools-icon">
            <i class="far fa-user-circle"></i>
        </a>
    </div>
</header>