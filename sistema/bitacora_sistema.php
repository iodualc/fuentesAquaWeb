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
	<title>Bitácora Operaciones Sistema</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<h1>Bitácora Operaciones Sistema</h1>
        <div class="table-responsive-lg">
		    <table class="table" style='font-family:Helvetica, sans-serif, monospace; font-size:85%'>
                <tr>
                    <th>ID</th>
                    <th>Fecha Registro</th>
                    <th>Usuario </th>
                    <th>Accion Usuario</th>
                    <th>Tabla</th>
                </tr>
		<?php 
			//Paginador
			$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM bitacora_sys ");
			$result_register = mysqli_fetch_array($sql_registe);
			$total_registro = $result_register['total_registro'];

			$por_pagina = 10;

			if(empty($_GET['pagina']))
			{
				$pagina = 1;
			}else{
				$pagina = $_GET['pagina'];
			}

			$desde = ($pagina-1) * $por_pagina;
			$total_paginas = ceil($total_registro / $por_pagina);

			$query = mysqli_query($conection,"SELECT bi_id, bi_fecha, bi_usr, bi_accion, bi_tabla
			FROM  bitacora_sys  LIMIT $desde,$por_pagina");

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
					<td><?php echo $data["bi_tabla"]; ?></td>
				</tr>
				<?php
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