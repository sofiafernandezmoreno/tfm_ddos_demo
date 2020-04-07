<?php

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

<div class="agama-header-overlay">
    
    <div class="tv-container tv-d-flex tv-justify-content-between tv-align-items-center">
        
        <!-- Logo -->
        <div id="agama-logo">
            <?php agama_logo(); ?>
        </div><!-- Logo End -->

        <!-- Primary Navigation -->
        <nav id="agama-primary-nav" class="tv-d-none tv-d-lg-block" role="navigation">
            <?php echo Agama::menu( 'primary', 'agama-navigation' ); ?>
        </nav><!-- Primary Navigation End -->

        <!-- Mobile Menu Trigger -->
        <div class="tv-d-md-block tv-d-lg-none">
            <?php Agama_Helper::get_mobile_menu_toggle_icon(); ?>
        </div><!-- Mobile Menu Trigger End -->
        
    </div>
    
    <!-- Mobile Navigation -->
    <nav id="agama-mobile-nav" class="mobile-menu tv-collapse" role="navigaiton">
        <?php echo Agama::menu( 'primary', 'menu' ); ?>
    </nav><!-- Mobile Navigation End -->
    
</div>
