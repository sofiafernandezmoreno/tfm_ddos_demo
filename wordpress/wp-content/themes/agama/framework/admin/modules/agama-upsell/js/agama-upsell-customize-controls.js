( function( api ) {

	// Extends our custom "agama-theme-info" section.
	api.sectionConstructor['agama-theme-info'] = api.Section.extend(
		{

            // No events for this type of section.
			attachEvents: function () {},

            // Always make the section active.
			isContextuallyActive: function () {
				return true;
			}
		}
	);

	// Extends our custom "agama-upsell-slider-sections" section.
	api.sectionConstructor['agama-upsell-slider-sections'] = api.Section.extend(
        {

            // No events for this type of section.
			attachEvents: function () {},

            // Always make the section active.
			isContextuallyActive: function () {
				return true;
			}
		}
	);
    
    // Extends our custom "agama-upsell-frontpage-boxes-sections" section.
	api.sectionConstructor['agama-upsell-frontpage-boxes-sections'] = api.Section.extend(
        {

            // No events for this type of section.
			attachEvents: function () {},

            // Always make the section active.
			isContextuallyActive: function () {
				return true;
			}
		}
	);

} )( wp.customize );
