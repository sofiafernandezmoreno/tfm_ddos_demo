/**
 * File customize-controls.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
(function( $ ) {
    
    var pageBuilderDropdown = "select[data-id=agama_page_builder_page]";
    
    $(document.body).on("change", pageBuilderDropdown, function() {
        var e = $(this).val(),
            i = "sidebar-widgets-page-widget-" + e,
            t = {
                action: "agama_ajax_get_permalink",
                id: e
            };
        
        $.post(agama_builder.ajax_url, t, function(e) {
            wp.customize.previewer.previewUrl.set(e);
            wp.customize.previewer.bind("focus-on-widget", function(e) {
                $("#sub-accordion-section-" + e + " button.add-new-widget").click()
            })
        });
        
        wp.customize.section(i).activate();
        wp.customize.section(i).focus();
        
        $("#sub-accordion-section-" + i + " .customize-section-back").on("click", function() {
            wp.customize.section("agama_page_builder_section").focus();
        });
    });
    
    $(document.body).on("change", function() {
        wp.customize.previewer.bind("focus-on-widget", function(e) {
            wp.customize.section(e).focus();
            $("#sub-accordion-section-" + e + " button.add-new-widget").click();
        })
    });
    
    // Media Devices Logo
    wp.customize( 'agama_media_logo', function( value ) {
        value.bind( function( device ) {
            if( device == 'desktop' ) {
                $('.devices .preview-desktop').click();
            }
            if( device == 'tablet' ) {
                $('.devices .preview-tablet').click();
            }
            if( device == 'mobile' ) {
                $('.devices .preview-mobile').click();
            }
        });
    });
    
})( jQuery );

/**
 * Agama Dummy Widgets
 *
 * Display dummy widgets inside customizer widgets area.
 *
 * @since 1.3.8
 */
jQuery( document ).ready(function( $ ) {
    "use strict";
    
    /**
     * Add Dummy Widget
     *
     * Adds a dummy widget to customize Agama widgets.
     *
     * @since 1.3.8
     */
    function addDummyWidget( label, id ) {
        return '<div id="widget-tpl-agama-' + id + '-1" class="widget-tpl pro-widget">' +
                    '<a href="https://theme-vision.com/agama-pro/" target="_blank">' +
                        '<div class="widget-overlay">' + agama_builder.proWidgetDesc + '</div>' +
                    '</a>' +
                    '<div id="widget-3-agama-' + id + '-__i__" class="widget">' +
                        '<div class="widget-top">' +
                            '<div class="widget-title">' +
                                '<h3>' + label + '<span class="in-widget-title"></span></h3>' +
                            '</div>' +
                        '</div>' +
                        '<div class="widget-description">' + agama_builder.proWidgetDesc + '</div>' +
                    '</div>' +
                '</div>';
    }
    
    // Add Agama widgets tab.
    $("#available-widgets-list").prepend(
        '<ul id="agama-widgets-selector">' +
            '<li class="agama-widgets active"><span>' + agama_builder.agamaWidgetsLabel + '</span></li>' +
            '<li class="other-widgets"><span>' + agama_builder.otherWidgetsLabel + '</span></li>' +
        '</ul>'
    );
    
    // Add Agama widgets custom wrappers.
    $('#available-widgets-list [id*="widget-tpl-agama_"]').wrapAll('<div class="agama-widgets-wrapper"></div>');
    $("#available-widgets-list > .widget-tpl").wrapAll('<div class="other-widgets-wrapper"></div>');
    
    // Add Agama dummy widgets.
    $("#available-widgets-list .agama-widgets-wrapper").append(addDummyWidget(agama_builder.testimonialLabel, "testimonial"));
    $("#available-widgets-list .agama-widgets-wrapper").append(addDummyWidget(agama_builder.portfolioLabel, "portfolio")); 
    $("#available-widgets-list .agama-widgets-wrapper").append(addDummyWidget(agama_builder.countdownLabel, "countdown")); 
    $("#available-widgets-list .agama-widgets-wrapper").append(addDummyWidget(agama_builder.mapsLabel, "maps"));
    $("#available-widgets-list .agama-widgets-wrapper").append(addDummyWidget(agama_builder.contactLabel, "contact")); 
    
    // Agama widgets tab switching.
    $("#agama-widgets-selector li").click(function() {
        $(this).siblings().removeClass("active");
        $(this).addClass("active");
        if( $(this).hasClass("other-widgets") ) {
            $(".agama-widgets-wrapper").fadeOut(); 
            $(".other-widgets-wrapper").fadeIn();
        } else {
            $(".other-widgets-wrapper").fadeOut(); 
            $(".agama-widgets-wrapper").fadeIn();
        }
    });
    
} );
