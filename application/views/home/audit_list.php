<h3>Historial de auditorías</h3>
<p>A continuación se listan las auditorías activas y las finalizadas.</p>
<ul>
	{audits}
	<li data-finished="{completed}" class="history-item">
		<span class="ui-icon"></span>
		<span>{date}</span>
		<a href="{view_url}/{id_audit}">{hq_name}, {building_name}, piso {room_floor}, {room_name}</a>
	</li>
	{/audits}
</ul>