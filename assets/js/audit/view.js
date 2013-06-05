$(function() {
	$('.slider').slider({
		min: 1,
		max: 10,
		slide: function(event, ui) {
			$slider = $(this);
			$slider.siblings('.rating').val( ui.value );
		}
	});
});