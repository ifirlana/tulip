function masking(selector) {
	// USING CLASS
	$(selector).each(function(i) {
		var $item = $(this);
		var digit_decimal = $item.attr('digit_decimal');
		var digit_length = $item.attr('digit_length');
		if (!digit_decimal) {
			if ($item.hasClass('currency')) {
				digit_decimal = 2;
			} else {
				digit_decimal = 0;
			}
		}
		if (!digit_length) {
			if ($item.hasClass('currency')) {
				digit_length = 9;
			} else {
				digit_length = 9;
			}
		}
		
		$item.attr('alt','p'+digit_length+'c3p'+digit_decimal+'S').autoNumeric().blur(function() {
			var strip = $.fn.autoNumeric.Strip(this.id);
			if ($item.val() != '') {
				$item.val($.fn.autoNumeric.Format(this.id,strip));
			}
		});
	}).css('text-decoration','right');
	return false;
}

function unmasking(selector) {
	$(selector).each(function(i) {
		val = $(this).val();
		if (val != '') {
			val = parseFloat(val.replace(/,/g,''));
			$(this).val(val);
			//return val;
		}
	});
	
	return false;
}

$(document).ready(function() {
	$(':input').attr('maxlength','50');/*.addClass('ui-widget-content');*/
});