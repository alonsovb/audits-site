$(function() {
	$sliders = $('.slider');
	$ratings = $('.rating');
	$sliders.slider({
		min: 1,
		max: 10,
		value: 10,
		slide: function(event, ui) {
			$slider = $(this);
			$slider.siblings('.rating').val( ui.value );
		}
	});
	$sliders.each(function () {
		$rating = $(this).siblings('.rating');
		$(this).slider("value", $rating.val());
	});
	$ratings.on('change', function() {
		$slider = $(this).siblings('.slider');
		$slider.slider('value', $(this).val());
	});
	if ($('.asset-list li').length > 2) {
		$('.page-wrapper').css('height', 'auto');
	}
	$('#guardar, #eliminar').button();
	$('#eliminar').on('click', function (event) {
		if (confirm('¿Desea eliminar esta auditoría?')) {
			// Eliminar auditoría
		} else {
			event.preventDefault();
		}
	});
});