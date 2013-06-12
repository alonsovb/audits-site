$(function() {
	
	// Todos los elementos auditorías en el historial
	$historyItem = $('.history-item');

	// URL para realizar eliminaciones de auditorías
	var deleteUrl = $('#delete-url').val();

	// Para cada elemento en el historial, buscar el icono adecuado
	$.each($historyItem, function (index, value) {
		
		$element = $(this);
		
		$icon = $element.find('.history-item-state');
		
		// Icono basado en la propiedad "data-finished"
		// 1 para auditorías finalizadas
		// 0 para las que aún no están finalizadas
		if ($element.data('finished') == '1') {
			$icon.addClass('ui-icon-check');
		} else {
			$icon.addClass('ui-icon-pencil');
		}
	});

	// Marcar elemento activo
	$historyItem.hover(function() {
		$(this).find('.history-item-state').addClass('ui-state-focus');
	}, function() {
		$(this).find('.history-item-state').removeClass('ui-state-focus');
	});

	// Botón de eliminar auditoría
	$historyItemDelete = $('.history-item-delete');
	$historyItemDelete.hover(function () {
		$(this).addClass('ui-state-highlight');
	}, function () {
		$(this).removeClass('ui-state-highlight');
	});

	// Al hacer click en el botón de eliminar
	$historyItemDelete.on('click', function() {
		// Confirmar mediante un cuadro de diálogo
		if (confirm('¿Desea eliminar la auditoría seleccionada?')) {
			// Obtener ID de la auditoría que se quiere eliminar
			$item = $(this).closest('.history-item');
			idAudit = $item.data('id');
			// Enviar solicitud de eliminación por AJAX
			$.ajax({
				type: 'post',
				url: deleteUrl,
				data: {
					"audit_id": idAudit
				}
			}).done(function(data) {
				// Si se eliminó correctamente, quitar elemento de la lista
				if (data == 'true') {
					// Remove li.history-item element
					$item.remove();
				}
			});
		}
	});
});