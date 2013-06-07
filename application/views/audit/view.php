{audit}
<h3>{hq_name}, {building_name}, Piso {room_floor}, {room_name}</h3>
<p>Aquí se muestra información acerca de la auditoría seleccionada (código {id_audit})</p>
<label for="audit-comment">Comentarios generales de la auditoría:</label>
<textarea id="audit-comment">{comment}</textarea>
{/audit}
<p>La siguiente es la lista de activos para esta auditoría.</p>
<ul class="asset-list">
	{audit_assets}
	<?php 
		$asset = json_encode(
			array(
				"audit"=>"{audit}",
				"asset"=>"{id_asset}",
				"state"=>"{state}",
				"rating"=>"{rating}",
				"comment"=>"{comment}"
				));
		$asset = htmlspecialchars($asset, ENT_QUOTES);
	?>
	<li id="asset{id_asset}" class="asset-item" data-asset="<?php echo $asset; ?>">
		<h4>Código de activo: {code}</h4>
		<div class="input-present">
			<input type="checkbox" id="present{id_asset}" class="present" {present}>
			<label for="present{id_asset}">El activo está presente en la sala</label>
		</div>
		<div class="input-state">
			<input type="checkbox" id="state{id_asset}" class="state" {state}>
			<label for="state{id_asset}">En buen estado</label>
		</div>
		<div class="input-rating">
			<label for="rating{id_asset}">Puntuación del activo</label>
			<div class="slider"></div>
			<input type="number" id="rating{id_asset}" class="rating" value="{rating}" min="1" max="10">
		</div>
		<div class="input-comment">
			<label for="comment{id_asset}">Comentarios:</label>
			<textarea id="comment{id_asset}" class="comment">{comment}</textarea>
		</div>
	</li>
	{/audit_assets}
</ul>
<a class="action-button" href="#" type="button" id="guardar">Guardar</a>
<a class="action-button" href="{history_url}" id="eliminar">Eliminar</a>