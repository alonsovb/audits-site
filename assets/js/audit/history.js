$(function() {
	$historyItem = $('.history-item');
	$.each($historyItem, function (index, value) {
		$element = $(this);
		$icon = $element.find('.history-item-state');
		if ($element.data('finished') == 0) {
			$icon.addClass('ui-icon-check');
		} else {
			$icon.addClass('ui-icon-pencil');
		}
	});
	$historyItem.hover(function() {
		$(this).find('.history-item-state').addClass('ui-state-focus');
	}, function() {
		$(this).find('.history-item-state').removeClass('ui-state-focus');
	});
	$historyItemDelete = $('.history-item-delete');
	$historyItemDelete.hover(function () {
		$(this).addClass('ui-state-highlight');
	}, function () {
		$(this).removeClass('ui-state-highlight');
	});
	$historyItemDelete.on('click', function() {
		if (confirm('¿Desea eliminar la auditoría seleccionada?')) {
			// Eliminar auditoría desde acá
		}
	});
});