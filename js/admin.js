jQuery(function($) {
	$( '#swp-ie-select-all' ).click( function () {
		$( '#swp-ie-form input[type="checkbox"]' ).prop('checked', this.checked)
	})
})