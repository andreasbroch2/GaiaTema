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
            </div>
            <?php
                wp_nav_menu( array(
                    'theme_location' => 'top-menu',
                    'container_class' => 'nav-links'
                ));
            ?>
        </nav>
        <div class="main-header__logo">
            <a href="/test"><img data-lazyloaded="1" src="https://i1.wp.com/gaiamadservice.dk/wp-content/uploads/2021/01/BedsteLogo.png" data-was-processed="true">
               </a>
        </div>
        <div class="main-header__tools">
            <a href="#" class="tools-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </a>
            <a href="<?php echo wc_get_cart_url(); ?>" class="tools-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
            </a>
        </div>

    </header>