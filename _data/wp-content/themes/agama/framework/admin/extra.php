<?php

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add Editor to the Customizer
 *
 * @since 1.3.8
 */
function agama_customizer_editor() { ?>
    <div id="wp-editor-widget-container" style="display: none;">
        <a class="close" href="javascript:WPEditorWidget.hideEditor();" title="<?php esc_attr_e( 'Close', 'agama' ); ?>"><span class="icon"></span></a>
        <div class="editor">
            <?php $settings = array( 'textarea_rows' => 55, 'editor_height' => 260 );  wp_editor( '', 'wpeditorwidget', $settings ); ?>
            <p><a href="javascript:WPEditorWidget.updateWidgetAndCloseEditor(true);" class="button button-primary"><?php esc_html_e( 'Save and close', 'agama' ); ?></a></p>
        </div>
    </div>
    <div id="wp-editor-widget-backdrop" style="display: none;"></div>

    <?php
}
	
add_action( 'widgets_admin_page', 'agama_customizer_editor', 100 );
add_action( 'customize_controls_print_footer_scripts', 'agama_customizer_editor', 1 );

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
