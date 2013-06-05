$(function() {
	$.each($('.history-item'), function (index, value) {
		$element = $(this);
		$icon = $element.find('.ui-icon');
		if ($element.data('finished') == 0) {
			$icon.addClass('ui-icon-check');
		} else {
			$icon.addClass('ui-icon-pencil');
		}
	});
});