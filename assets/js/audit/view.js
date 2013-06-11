$(function() {
	var updateUrl 	= $('#ajax-url').val(),
		historyUrl 	= $('#history-url').val(),
		deleteUrl 	= $('#delete-url').val(),
		idAudit  	= $('#id-audit').val();
		disabled 	= $('#audit-complete').val();
	$sliders = $('.slider');
	$ratings = $('.rating');
	$saveButtons = $('#guardar, #completar');
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
	if (disabled == 'disabled') {
		$sliders.slider({ disabled: true });
		$saveButtons.hide();
	}
	$ratings.on('change', function() {
		$slider = $(this).siblings('.slider');
		$slider.slider('value', $(this).val());
	});
	if ($('.asset-list li').length > 2) {
		$('.page-wrapper').css('height', 'auto');
	}
	$('#guardar, #eliminar, #completar').button();
	$('#eliminar').on('click', function (event) {
		event.preventDefault();
		if (confirm('¿Desea eliminar esta auditoría?')) {
			$.ajax({
				type: 'post',
				url: deleteUrl,
				data: {
					"audit_id": idAudit
				}
			}).done(function(data) {
				if (data == 'true') {
					window.location.href = historyUrl;
				}
			});
		}
	});

	//Evento en boton de guardar auditoria
	$saveButtons.on('click', function(){
		var assets = $('.asset-item');
		$.each(assets, function(index, asset) {
			present = $(asset).find('.present').is(':checked');
			state 	= $(asset).find('.state').is(':checked');
			rating 	= $(asset).find('.rating').val();
			comment = $(asset).find('.comment').val();
			asset 	= $(asset).data('asset');
			$.ajax({
				type: 'post',
				url: updateUrl + '/asset',
				data: {
					"present": present,
					"state": state,
					"rating": rating,
					"comment": comment,
					"asset": asset,
					"audit": idAudit
				}
			});
		});
		completar = $(this).data('completar');
		$.ajax({
			type: 'post',
			url: updateUrl + '/audit',
			data: {
				"audit_id": idAudit,
				"comment": $('#audit-comment').val(),
				"completed": completar
			}
		}).done(function(data) {
			window.location.href = historyUrl;
		});
	});
});