$(function () {

	$('input[type=button], input[type=submit], button').button();
	
	// Botón de registro de nueva auditoría
	$regButton = $('#auditoria-boton-registrar').button('disable');

	// Selects de sedes, edificios y salas
	var $headquarters	= $('#headquarter'),
		$buildings		= $('#building'),
		$rooms			= $('#room');
	var baseUrl = $('#base-url').val();

	// Obtener datos de sedes y mostrarlas en Select
	headquarters(baseUrl, function (data) {
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

	// Obtener datos de edificios y mostrarlas en Select
	// al seleccionar una nueva sede
	$headquarters.on('change', function(data) {
		$buildings.empty();
		var hq = parseInt($headquarters.val(), 10);
		buildings(hq, baseUrl, function(data) {
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

	// Obtener datos de salas y mostrarlas en Select
	// al seleccionar un nuevo edificio
	$buildings.on('change', function(data) {
		$rooms.empty();
		var building = parseInt($buildings.val(), 10);
		rooms(building, baseUrl, function(data) {
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

	// Habilitar botón de registrar al encontrar una
	// sala válida
	$rooms.on('change', function(data) {
		if ($rooms.val() === null) {
			$regButton.button('disable');
		} else {
			$regButton.button('enable');
		}
	});
});