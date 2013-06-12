/**
 * Obtiene mediante AJAX las sedes
 * @param  {string}   baseurl  Url base para obtener la información
 * @param  {Function} callback Función que se llamará al obtener la información
 */
function headquarters (baseurl, callback) {
	$.post(baseurl + 'data/headquarters', function(data) {
		callback(data);
	});
}

/**
 * Obtiene mediante AJAX los edificios de una sede
 * @param  {int}      headquarter Índice de la sede
 * @param  {string}   baseurl     Url base para obtener la información
 * @param  {Function} callback    Función que se llamará al obtener la información
 */
function buildings (headquarter, baseurl, callback) {
	$.post(baseurl + 'data/buildings/' + headquarter, function(data) {
		callback(data);
	});
}

/**
 * Obtiene mediante AJAX los salones de un edificio
 * @param  {int}      building    Índice del edificio
 * @param  {string}   baseurl     Url base para obtener la información
 * @param  {Function} callback    Función que se llamará al obtener la información
 */
function rooms (building, baseurl, callback) {
	$.post(baseurl + 'data/rooms/' + building, function(data) {
		callback(data);
	});
}