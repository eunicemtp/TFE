( function( api ) {

	// Extends our custom "taxi-booking" section.
	api.sectionConstructor['taxi-booking'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );