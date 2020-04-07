<?php
/**
 * The Sidebar
 *
 * The sidebar containing the main widget area
 *
 * If no active widgets are in the sidebar, hide it completely.
 *
 * @package Theme Vision
 * @subpackage Agama
 * @since 1.0.0
 */

// No direct access allowed.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
<div id="secondary" class="widget-area tv-col-md-3" role="complementary">
    
    <?php dynamic_sidebar( 'sidebar-1' ); ?>
    
</div>
<?php endif; ?>
