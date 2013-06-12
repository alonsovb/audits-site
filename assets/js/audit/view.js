$(function() {
	var updateUrl 	= $('#ajax-url').val(),
		historyUrl 	= $('#history-url').val(),
		deleteUrl 	= $('#delete-url').val(),
		idAudit  	= $('#id-audit').val();
		disabled 	= $('#audit-complete').val();
	$sliders = $('.slider');
	$ratings = $('.rating');
	
	$saveButtons = $('#guardar, #completar');
	
	// Crear los sliders
	$sliders.slider({
		min: 1,
		max: 10,
		value: 10,
		slide: function(event, ui) {
			$slider = $(this);
			$slider.siblings('.rating').val( ui.value );
		}
	});

	// Si la auditoría está completa, deshabilitar todos los inputs
	// y ocultar los botones de guardado
	if (disabled == 'disabled') {
		$sliders.slider({ disabled: true });
		$saveButtons.hide();
	}

	// Cambiar inputs al usar cada slider
	$sliders.each(function() {
		$rating = $(this).siblings('.rating');
		$(this).slider("value", $rating.val());
	});

	// Al cambiar el rating, modificar el valor del slider
	$ratings.on('change', function() {
		$slider = $(this).siblings('.slider');
		$slider.slider('value', $(this).val());
	});
	if ($('.asset-list li').length > 2) {
		$('.page-wrapper').css('height', 'auto');
	}

	// Crear botones con formato de UI
	$('#guardar, #eliminar, #completar').button();

	// Al hacer clic en eliminar
	$('#eliminar').on('click', function (event) {
		// Evitar seguir dirección
		event.preventDefault();

		// Confirmar mediante cuadro de diálogo
		if (confirm('¿Desea eliminar esta auditoría?')) {
			// Enviar solicitud de eliminación por AJAX
			$.ajax({
				type: 'post',
				url: deleteUrl,
				data: {
					"audit_id": idAudit
				}
			}).done(function(data) {
				// Si se elimina correctamente, volver al historial
				if (data == 'true') {
					window.location.href = historyUrl;
				}
			});
		}
	});

	// Evento en botones de guardar auditoria
	// (Guardar y completar)
	$saveButtons.on('click', function(){
		// Obtener lista de activos de auditoría
		var assets = $('.asset-item');
		// Para cada activo, obtener información y actualizarla
		$.each(assets, function(index, asset) {
			present = $(asset).find('.present').is(':checked');
			state 	= $(asset).find('.state').is(':checked');
			rating 	= $(asset).find('.rating').val();
			comment = $(asset).find('.comment').val();
			asset 	= $(asset).data('asset');
			// Enviar solicitud de actualización de cada
			// activo por AJAX
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
		
		// Indica si la auditoría está finalizada
		completar = $(this).data('completar');
		
		// Enviar solicitud de actualización de auditoría
		// mediante AJAX
		$.ajax({
			type: 'post',
			url: updateUrl + '/audit',
			data: {
				"audit_id": idAudit,
				"comment": $('#audit-comment').val(),
				"completed": completar
			}
		}).done(function(data) {
			// Cuando se actualiza, volver al historial
			window.location.href = historyUrl;
		});
	});
});