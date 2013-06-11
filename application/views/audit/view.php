{audit}
<h3>{hq_name}, {building_name}, Piso {room_floor}, {room_name}</h3>
<p>Aquí se muestra información acerca de la auditoría seleccionada (código {id_audit})</p>
<input type="hidden" value="{ajax_url}" id="ajax-url">
<input type="hidden" value="{history_url}" id="history-url">
<input type="hidden" value="{delete_url}" id="delete-url">
<input type="hidden" value="{id_audit}" id="id-audit">
<input type="hidden" value="{disabled}" id="audit-complete">
<label for="audit-comment">Comentarios generales de la auditoría:</label>
<textarea id="audit-comment" name="comment" {disabled}>{comment}</textarea>
{/audit}
<p>La siguiente es la lista de activos para esta auditoría.</p>
<ul class="asset-list">
	{audit_assets}
	<li id="asset{id_asset}" class="asset-item" data-asset="{id_asset}">
		<h4>Código de activo: {code}</h4>
		<div class="input-present">
			<input type="checkbox" id="present{id_asset}" class="present" {present} {disabled}>
			<label for="present{id_asset}">El activo está presente en la sala</label>
		</div>
		<div class="input-state">
			<input type="checkbox" id="state{id_asset}" class="state" {state} {disabled}>
			<label for="state{id_asset}">En buen estado</label>
		</div>
		<div class="input-rating">
			<label for="rating{id_asset}">Puntuación del activo</label>
			<div class="slider"></div>
			<input type="number" id="rating{id_asset}" class="rating" value="{rating}" min="1" max="10" {disabled}>
		</div>
		<div class="input-comment">
			<label for="comment{id_asset}">Comentarios:</label>
			<textarea id="comment{id_asset}" class="comment" {disabled}>{comment}</textarea>
		</div>
	</li>
	{/audit_assets}
</ul>
<a class="action-button" href="#" type="button" id="guardar" data-completar="0">Guardar</a>
<a class="action-button" href="#" type="button" id="completar" data-completar="1">Completar</a>
<a class="action-button" href="{history_url}" id="eliminar">Eliminar</a>