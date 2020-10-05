		<nav>
			<ul>
				<li><a href="index.php">Inicio</a></li>
			<?php 
				if($_SESSION['rol'] == 1){
			 ?>
				<li class="principal">

					<a href="#">Seguridad</a>
					<ul>
						<li><a href="registro_usuario.php">Nuevo Usuario</a></li>
						<li><a href="lista_usuarios.php">Lista de Usuarios</a></li>
						<li><a href="bitacora.php">Bitacora usuarios</a></li>
						<li><a href="bitacora_sistema.php">Bitacora sistema</a></li>
					</ul>
				</li>
				<li class="principal">
					<a href="#">Mantenedores</a>
					<ul>
						<li><a href="#">Clientes</a></li>
						<li><a href="mnt_productos.php">Productos</a></li>
					</ul>
				</li>
				<?php } ?>
				<li class="principal">
					<a href="mnt_pedidos.php">Pedidos</a>
					<!-- <ul>
						<li><a href="mtn_pedidos.php">Nuevo Pedido</a></li>
						<li><a href="#">Lista de Pedidos</a></li>
					</ul> -->
				</li>
				<li class="principal">
					<a href="#">Ordenes</a>
					<ul>
						<li><a href="#">Nuevo Orden</a></li>
						<li><a href="#">Lista de Ordenes</a></li>
					</ul>
				</li>
				<?php 
				if($_SESSION['rol'] == 2){
				 ?>
				<li class="principal">
					<a href="#">Reportes</a>
					<ul>
						<li><a href="#">Reporte Resumen de Pedidos</a></li>
						<li><a href="#">Reporte Total Ventas Mes</a></li>
					</ul>
				</li>
				<?php } ?>
			</ul>
		</nav>