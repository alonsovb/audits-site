<h3>Historial de auditorías</h3>
<p>A continuación se listan las auditorías activas (<span class="icon"><span class="ui-icon ui-icon-pencil"></span></span>) y las finalizadas (<span class="icon"><span class="ui-icon ui-icon-check"></span></span>).
</p>
<ul>
	{audits}
	<li data-finished="{completed}" class="history-item">
		<span>{date}</span>
		<span class="ui-icon history-item-state" style="margin-top: 0.25em"></span>
		<a href="{view_url}/{id_audit}">{hq_name}, {building_name}, Piso {room_floor}, {room_name}</a>
		<span class="ui-icon ui-icon-trash history-item-delete"></span>
	</li>
	{/audits}
</ul>