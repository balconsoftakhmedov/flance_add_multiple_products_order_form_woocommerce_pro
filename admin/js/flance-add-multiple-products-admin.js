(function( $ ) {
	'use strict';

	$(function(){
		$('select#flance_amp_product_cat, select#flance_amp_user_role').select2({ 
			width: '300px', 
			dropdownCssClass: 'bigdrop',
			minimumResultsForSearch: 7
		});

		// Enable and disable user checkbox.
		$('input[name=flance_amp_user_check]').on('click', function(){
			var $this = $(this);
			var value = $this.val();
			if ( value != 1 ) {
				$('select#flance_amp_user_role').attr('disabled', true);
			} else {
				$('select#flance_amp_user_role').attr('disabled', false);
			}
		});
	});

})( jQuery );
