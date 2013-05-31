var baseurl = 'http://localhost/audits-site/';

function headquarters (callback) {
	$.post(baseurl + 'data/headquarters', function(data) {
		callback(data);
	});
}

function buildings (headquarter, callback) {
	$.post(baseurl + 'data/buildings/' + headquarter, function(data) {
		callback(data);
	});
}

function rooms (building, callback) {
	$.post(baseurl + 'data/rooms/' + building, function(data) {
		callback(data);
	});
}