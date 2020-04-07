<?php
/**
 * The sidebar containing the main widget area
 * 
 * If no active widgets are in the sidebar, hide it completely.
 *
 * @package Theme-Vision
 * @subpackage Agama Blue
 * @since 1.0.1
 */

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

<?php if ( is_active_sidebar( 'sidebar-1' ) && ! is_home() ) : ?>
    <div id="secondary" class="widget-area tv-col-md-3" role="complementary">
        <?php dynamic_sidebar( 'sidebar-1' ); ?>
    </div>
<?php endif; ?>