$(function () {
	$('input[type=button], input[type=submit], button').button();
	$regButton = $('#auditoria-boton-registrar').button('disable');

	var $headquarters	= $('#headquarter'),
		$buildings		= $('#building'),
		$rooms			= $('#room');
	headquarters(function (data) {
		var hqs = eval( '(' + data + ') ');
		for (var i in hqs) {
			var option = $('<option>', {
				"text": hqs[i].name,
				"value": hqs[i].id_hq
			});
			$headquarters.append(option);
		}
		$headquarters.trigger('change');
	});
	$headquarters.on('change', function(data) {
		$buildings.empty();
		var hq = parseInt($headquarters.val(), 10);
		buildings(hq, function(data) {
			var bs = eval( '(' + data + ') ');
			for (var i in bs) {
				var option = $('<option>', {
					"text": bs[i].name,
					"value": bs[i].id_building
				});
				$buildings.append(option);
			}
			$buildings.trigger('change');
		});
	});
	$buildings.on('change', function(data) {
		$rooms.empty();
		var building = parseInt($buildings.val(), 10);
		rooms(building, function(data) {
			var rs = eval( '(' + data + ') ');
			for (var i in rs) {
				var option = $('<option>', {
					"text": rs[i].name,
					"value": rs[i].id_room
				});
				$rooms.append(option);
			}
			$rooms.trigger('change');
		});
	});
	$rooms.on('change', function(data) {
		if ($rooms.val() === null) {
			$regButton.button('disable');
		} else {
			$regButton.button('enable');
		}
	});
});