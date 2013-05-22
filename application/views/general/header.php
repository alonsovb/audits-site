<header>
	<a href=<?php echo base_url(); ?>><h1>Audits</h1></a>
</header>
<nav class="main-nav">
	<ul>
	<?php
	// Mostrar lo siguiente cuando hay una sesión iniciada
	if ($this->session->userdata('usuario') !== false) { ?>
	<li><a href=<?php echo '"'.base_url('user').'"'; ?>><?php echo $username; ?></a></li>
	<li><a href=<?php echo '"'.base_url('user/logout').'"'; ?>>Cerrar sesión</a></li>
	<?php }
	// Mostrar lo siguiente cuando no hay una sesión
	else { ?>
	<li><a href=<?php echo '"'.base_url('user/login').'"'; ?>>Iniciar sesión</a></li>
	<?php } ?>
	</ul>
</nav>
<div class="wrapper">
	