jQuery(document).ready(function() {
	jQuery("span").each(function(i, e) {
		if ( (jQuery(e).attr('class') == "price") && (jQuery(e).text() == "\u20ac0.00") ) {
			jQuery(e).text("Quote for price !");
		}
	})
})
