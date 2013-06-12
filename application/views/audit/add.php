<h3>Nueva auditoría</h3>
<form method="post" action="{add_url}">
	<input type="hidden" value="{base_url}" id="base-url">
	<p>Seleccione la sala en la que realizará una nueva auditoría.</p>
	<label for="headquarter">Seleccione la sede</label>
	<select name="headquarter" id="headquarter" autofocus></select>
	<label for="building">Seleccione el edificio</label>
	<select name="building" id="building"></select>
	<label for="room">Seleccione la habitación o sala</label>
	<select name="room" id="room"></select>
	<input type="submit" value="Registrar" id="auditoria-boton-registrar">
</form>