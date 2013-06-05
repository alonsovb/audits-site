{audit}
<h3>{hq_name}, {building_name}, Piso {room_floor}, {room_name}</h3>
{/audit}
<p>La siguiente es la lista de activos para esta auditoría.</p>
<ul>
	{audit_assets}
	<li class="asset-item">
		<h4>Código: {code}</h4>
		<div class="input-present">
			<input type="checkbox" id="present{id_asset}" class="present">
			<label for="present{id_asset}">El activo está presente en la sala</label>
		</div>
		<div class="input-state">
			<input type="checkbox" id="state{id_asset}" class="state">
			<label for="state{id_asset}">En buen estado</label>
		</div>
		<div class="input-rating">
			<label for="rating{id_asset}">Puntuación del activo</label>
			<div class="slider"></div>
			<input type="number" id="rating{id_asset}" class="rating">
		</div>
		<div class="input-comment">
			<label for="comment{id_asset}">Comentarios:</label>
			<input type="text" id="comment{id_asset}" class="comment">
		</div>
	</li>
	{/audit_assets}
</ul>