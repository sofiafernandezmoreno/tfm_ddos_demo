wp.customize.controlConstructor['agip'] = wp.customize.Control.extend({
    
	ready: function() {
		'use strict';

		var control = this,
			element = 'customize-control-'+control.id;
        
        jQuery( '#'+ element +' .agama-icon-picker' ).on( 'change', function() {
            var value = jQuery( this ).val();
            control.setting.set( value );
        });
	}

});