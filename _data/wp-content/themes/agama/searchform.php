<?php 

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="vision-search-form">
        <span class="screen-reader-text"><?php echo _x( 'Search for:', 'screen-reader', 'agama' ) ?></span>
        <input type="text" class="vision-search-field" placeholder="<?php _e( 'Search', 'agama' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'Search for', 'agama' ) ?>" />
        <input type="submit" class="vision-search-submit" value="&#xf002;" />
	</div>
</form>