/**
 * Agama Admin
 *
 * @since 1.4.1
 */
( function( $ ) {
    "use strict";
    
    $( document ).ready( function() {
        
        var link    = $('a[href="admin.php?page=go_elementor_pro"]');
        var link2   = $('a.elementor-plugins-gopro');
        var link3   = $('li.e-overview__go-pro a');
        
        $(link).attr("href", "https://elementor.com/pro/?ref=2876").attr("target", "_blank").css('color', '#d54e21');
        $(link2).attr("href", "https://elementor.com/pro/?ref=2876").attr("target", "_blank");
        $(link3).attr("href", "https://elementor.com/pro/?ref=2876").attr("target", "_blank");
         
    } );
    
} )(jQuery);
