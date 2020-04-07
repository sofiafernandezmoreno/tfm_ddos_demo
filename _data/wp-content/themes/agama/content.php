<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package Theme-Vision
 * @subpackage Agama
 * @since Agama 1.0
 */

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

$blog_layout = esc_attr( get_theme_mod('agama_blog_layout', 'list') ); ?>

<div class="article-wrapper <?php agama_article_wrapper_class(); ?> tv-d-flex"<?php Agama_Helper::get_data_animated(); ?>>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	/**
	 * Select Blog Layout
	 *
	 * @since 1.1.1
	 * @updated 1.3.0
	 */
	switch( $blog_layout ):
		case 'list':
			get_template_part('framework/blog/list');
		break;
		case 'grid':
			get_template_part('framework/blog/grid');
		break;
		case 'small_thumbs':
			get_template_part('framework/blog/small_thumbs');
		break;
	endswitch; ?>
	</article>
</div>