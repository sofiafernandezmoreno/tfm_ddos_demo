<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package Theme-Vision
 * @subpackage Agama
 * @since Agama 1.0
 */

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}  ?>

                <?php do_action( 'agama_customize_page_builder_action_end' ); ?>

			</div><!-- Vision Row End -->
		  </div>
	   </div>
	
	<?php 
	if( 
		is_active_sidebar( 'footer-widget-1' ) || 
		is_active_sidebar( 'footer-widget-2' ) || 
		is_active_sidebar( 'footer-widget-3' ) || 
		is_active_sidebar( 'footer-widget-4' )
	  ): ?>
	<!-- Footer Widgets Start -->
	<div class="footer-widgets">
        <div class="tv-container">
            <div class="tv-row">

                <?php if( is_active_sidebar( 'footer-widget-1' ) ): ?>
                <div class="<?php Agama_Helper::get_fwidgets_bs_class(); ?>">
                    <?php dynamic_sidebar( 'footer-widget-1' ); ?>
                </div>
                <?php endif; ?>

                <?php if( is_active_sidebar( 'footer-widget-2' ) ): ?>
                <div class="<?php Agama_Helper::get_fwidgets_bs_class(); ?>">
                    <?php dynamic_sidebar( 'footer-widget-2' ); ?>
                </div>
                <?php endif; ?>

                <?php if( is_active_sidebar( 'footer-widget-3' ) ): ?>
                <div class="<?php Agama_Helper::get_fwidgets_bs_class(); ?>">
                    <?php dynamic_sidebar( 'footer-widget-3' ); ?>
                </div>
                <?php endif; ?>

                <?php if( is_active_sidebar( 'footer-widget-4' ) ): ?>
                <div class="<?php Agama_Helper::get_fwidgets_bs_class(); ?>">
                    <?php dynamic_sidebar( 'footer-widget-4' ); ?>
                </div>
                <?php endif; ?>

            </div>
        </div>
	</div><!-- Footer Widgets End -->
	<?php endif; ?>
	
	<!-- Footer Start -->
	<footer id="agama-footer" class="tv-d-block" role="contentinfo">
		<div class="tv-container tv-p-0 tv-d-flex tv-justify-content-between tv-align-items-center">
			
            <div class="site-info">
				<?php do_action('agama_credits'); ?>
			</div>
			
			<?php if( get_theme_mod('agama_footer_social', true) ): ?>
			<div class="social">
				<?php Agama::social_icons('top'); ?>
			</div>
			<?php endif; ?>
			
		</div>
	</footer><!-- Footer End -->
	
</div><!-- Main Wrapper End -->

<?php if( get_theme_mod('agama_to_top', true) ): ?>
	<?php echo sprintf( '<a id="%s"><i class="%s"></i></a>', 'toTop', 'fa fa-angle-up' ); ?>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>