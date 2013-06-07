$(function() {
	$sliders = $('.slider');
	$ratings = $('.rating');
	$save = $('#guardar');
	$sliders.slider({
		min: 1,
		max: 10,
		value: 10,
		slide: function(event, ui) {
			$slider = $(this);
			$slider.siblings('.rating').val( ui.value );
		}
	});
	$sliders.each(function() {
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

	//Evento en boton de guardar auditoria
	$save.on('click', function(){
		var assets = $('.asset-list').children();
		for(var i = 0; i < assets.length; i++){
			console.log(assets[i].id);
			var asset = $('#' + assets[i].id);
			var data = asset.data('asset');
			var id_asset = data.asset;
			data.state = $('#state' + id_asset).val();
			data.rating = $('#rating' + id_asset).val();
			data.comment = $('#comment' + id_asset).val();
			asset.data('asset', data);
			//Falta definir url correcto para la llamada POST
			var baseurl = 'http://localhost/audits-site/';
			$.post(baseurl + 'update/' + JSON.stringify(data));
		}
	});
});