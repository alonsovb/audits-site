$(function() {
	$historyItem = $('.history-item');
	$.each($historyItem, function (index, value) {
		$element = $(this);
		$icon = $element.find('.ui-icon');
		if ($element.data('finished') == 0) {
			$icon.addClass('ui-icon-check');
		} else {
			$icon.addClass('ui-icon-pencil');
		}
	});
	$historyItem.hover(function() {
		$(this).find('.ui-icon').addClass('ui-state-highlight');
	}, function() {
		$(this).find('.ui-icon').removeClass('ui-state-highlight');
	});
});