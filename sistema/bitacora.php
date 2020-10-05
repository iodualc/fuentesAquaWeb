<?php 
	session_start();
	if($_SESSION['rol'] != 1)
	{
		header("location: ./");
	}
	
	include "../conexion.php";	
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Bitácora Operaciones Usuario</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<h1>Bitácora Operaciones Usuario</h1>
		<!-- <form action="" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
			<input type="submit" value="Buscar" class="btn_search">
        </form> -->
        <div class="table-responsive-lg">
		    <table class="table" style='font-family:Helvetica, sans-serif, monospace; font-size:85%'>
                <tr>
                    <th>ID</th>
                    <th>Momento</th>
                    <th>Usuario DB</th>
                    <th>Accion</th>
                    <th>Nombre Origen</th>
                    <th>Correo Origen</th>
                    <th>Usuario Origen</th>
                    <th>Rol Origen</th>
                    <th>F.Creación  Origen</th>
                    <th>F.Expiración  Origen</th>
                    <!-- <th>Nombre Anterior</th>
                    <th>Correo Anterior</th>
                    <th>Usuario Anterior</th>
                    <th>Rol Anterior</th>
                    <th>F.Creación  Anterior</th>
                    <th>F.Expiración  Anterior</th> -->
                </tr>
		<?php 
			//Paginador
			$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM bitacora_usr ");
			$result_register = mysqli_fetch_array($sql_registe);
			$total_registro = $result_register['total_registro'];

			$por_pagina = 5;

			if(empty($_GET['pagina']))
			{
				$pagina = 1;
			}else{
				$pagina = $_GET['pagina'];
			}

			$desde = ($pagina-1) * $por_pagina;
			$total_paginas = ceil($total_registro / $por_pagina);

			$query = mysqli_query($conection,"SELECT u.bi_id
                                                ,u.bi_fecha
                                                ,u.bi_usr
                                                ,u.bi_accion
                                                ,u.new_nombre
                                                ,u.new_correo
                                                ,u.new_usuario
                                                ,u.new_clave
                                                ,u.new_rol
                                                ,u.new_estatus
                                                ,u.new_fecha_expira
                                                ,u.new_fecha_creacion
                                                ,u.old_nombre
                                                ,u.old_correo
                                                ,u.old_usuario
                                                ,u.old_clave
                                                ,u.old_rol
                                                ,u.old_estatus
                                                ,u.old_fecha_expira
                                                ,u.old_fecha_creacion FROM  bitacora_usr u LIMIT $desde,$por_pagina");

			mysqli_close($conection);

			$result = mysqli_num_rows($query);
			if($result > 0){

				while ($data = mysqli_fetch_array($query)) {
					
			?>
				<tr>
					<td><?php echo $data["bi_id"]; ?></td>
					<td><?php echo $data["bi_fecha"]; ?></td>
					<td><?php echo $data["bi_usr"]; ?></td>
					<td><?php echo $data["bi_accion"]; ?></td>
				</tr>
				<?php
					if ( $data['new_nombre'] != null) {
				?>
				<tr>
					<td colspan="4"><b>Registro Origen:</b></td>	
					<td><?php echo $data['new_nombre'] ?></td>
					<td><?php echo $data['new_correo'] ?></td>
					<td><?php echo $data['new_usuario'] ?></td>
					<td><?php echo $data['new_rol'] ?></td>
					<td><?php echo $data['new_fecha_creacion'] ?></td>
					<td><?php echo $data['new_fecha_expira'] ?></td>
				</tr>
				<?php
					}

					if ( $data['old_nombre'] != null) {
				?>
				<tr>
					<td colspan="4"><b>Registro Actual:</b></td>
					<td><?php echo $data['old_nombre'] ?></td>
					<td><?php echo $data['old_correo'] ?></td>
					<td><?php echo $data['old_usuario'] ?></td>
					<td><?php echo $data['old_rol'] ?></td>
					<td><?php echo $data['old_fecha_creacion'] ?></td>
					<td><?php echo $data['old_fecha_expira'] ?></td>
				</tr>
				<?php
					}
				}
			}
			?>
		</table>
		<div class="paginador">
			<ul>
			<?php 
				if($pagina != 1)
				{
			 ?>
				<li><a href="?pagina=<?php echo 1; ?>">|<</a></li>
				<li><a href="?pagina=<?php echo $pagina-1; ?>"><<</a></li>
			<?php 
				}
				for ($i=1; $i <= $total_paginas; $i++) { 
					# code...
					if($i == $pagina)
					{
						echo '<li class="pageSelected">'.$i.'</li>';
					}else{
						echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
					}
				}

				if($pagina != $total_paginas)
				{
			 ?>
				<li><a href="?pagina=<?php echo $pagina + 1; ?>">>></a></li>
				<li><a href="?pagina=<?php echo $total_paginas; ?> ">>|</a></li>
			<?php } ?>
			</ul>
		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>