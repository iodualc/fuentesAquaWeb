<?php 
	session_start();
	if($_SESSION['rol'] == 2)
	{
    echo('Rol no tiene permisos para esta funcionalidad.');
		header("location: ./");
	}
	
	include "../conexion.php";

	if(!empty($_POST))
	{
		$alert='';
		if(empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['clave']) || empty($_POST['rol']))
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$nombre = $_POST['nombre'];
			$email  = $_POST['correo'];
			$user   = $_POST['usuario'];
			$clave  = md5($_POST['clave']);
			$rol    = $_POST['rol'];


			$query = mysqli_query($conection,"SELECT * FROM usuarios WHERE usuario = '$user' OR correo = '$email' ");
			$result = mysqli_fetch_array($query);

			if($result > 0){
				$alert='<p class="msg_error">El correo o el usuario ya existe.</p>';
			}else{

				$query_insert = mysqli_query($conection,"INSERT INTO usuario(nombre,correo,usuario,clave,rol)
																	VALUES('$nombre','$email','$user','$clave','$rol')");
				if($query_insert){
					$alert='<p class="msg_save">Usuario creado correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al crear el usuario.</p>';
				}

			}


		}

	}
 ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <!-- Required meta tags -->
	<?php include "includes/scripts.php"; ?>
	<title>Registro pedidos</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
  <!-- <link rel="stylesheet" href="css/bootstrap.min.css">     -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
</head>
  <body>
      <?php include "includes/header.php"; ?>
      <section id="container">
        <div class="">
          <h1>Ingreso de pedidos</h1>
          <!-- <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div> -->
  <!-- Menu 
    <header>          
       <div class="container-fluid menu" >
         <nav class="navbar navbar-expand-lg container">
             <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ml-auto">               
              </ul>              
            </div>
          </nav>
      </div>            
    </header>
 Fin Menu -->

<!-- CRUD -->
<style type="text/css">
.has-feedback .form-control-feedback {
    top: 25px;
    right: 0;
}
.form-horizontal .has-feedback .form-control-feedback {
    top: 0;
    right: -20px;
}
</style>

<div class="container-fluid bg-light ">
<div class="container py-5" >
    <div class="row">
      <div class="col-md-10">
          <div class="card ml-auto sombra">
              <div class="card-body">
                <!-- <h4 class="card-title text-center">Ingresar Pedidos</h4> -->

                <form class="form-horizontal" action="procesa.php" method="post" id="guarda">
                  <input type="text" value="guardar" name="opc" hidden>
                  <div class="form-group">
                    <label for="numero" class="col-sm-3 control-label">Número pedido:</label>
                    <div class="col-sm-3 inputGroupContainer">
                      <div class="input-group">
                        <input type="text" class="form-control" id="numero" name="numero" placeholder="Digité un valor."
                            data-tpoggle="tooltip" data-placement="bottom"
                            title="Corresponde al identificador único de la solicitud de pedido." require>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="rut" class="col-sm-3 control-label">RUT Cliente:</label>
                        <div class="col-sm-3 inputGroupContainer">
                          <div class="input-group">
                            <input type="text" class="form-control" id="rut" name="rut" placeholder="Digité RUT del Cliente."
                              data-tpoggle="tooltip" data-placement="bottom"
                              title="Corresponde al RUT registrado del cliente, que solicita el pedido de compra." require>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="codigo" class="col-sm-3 control-label">Código producto:</label>
                    <div class="col-sm-3 inputGroupContainer">
                      <div class="input-group">
                        <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Digité un valor." require
                              data-tpoggle="tooltip" data-placement="bottom"
                              title="Corresponde al código interno único del producto a solicitar en el pedido.">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecha" class="col-sm-3 control-label">Fecha Pedido:</label>
                    <div class="col-sm-3 inputGroupContainer">
                      <div class="input-group date">
                        <input type="text" class="form-control" id="fecha" name="fecha" placeholder="Digité formato día/mes/año" require
                              data-tpoggle="tooltip" data-placement="bottom"
                              title="Corresponde a la fecha en que se realiza al compra, puede ser anterior a la fecha actual.">
                         <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="cantidad" class="col-sm-3 control-label">Cantidad:</label>
                    <div class="col-sm-3 inputGroupContainer">
                      <div class="input-group">
                        <input type="text" class="form-control" id="cantidad" name="cantidad" placeholder="Digité un valor." require
                              data-tpoggle="tooltip" data-placement="bottom"
                              title="Corresponde a la cantidad total del producto solicitado.">
                      </div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Guardar</button>
                  <button type="button" id="btnAyuda" class="btn btn-info" data-toggle="modal" data-target="#ayuda">Ayuda</button>
              </form>
            </div>
          </div>
      </div>
      <!-- Area donde se listan los datos -->
      <div class="col-md-10">
          <div class="card mr-auto sombra">
              <div class="card-body">
                <h4 class="card-title text-center">Contenido de la Tabla Pedidos.</h4>               
                <ul class="list-group">

                <?php

                try {
                      $conexion = new PDO('mysql:host=localhost;dbname=aquaweb', "dbadminbckp", "admin");
                          
                  } catch (PDOException $e) {
                      print "¡Error!: " . $e->getMessage() . "<br/>";
                      die();
                  }

                  try
                  {
                  $sql = $conexion->prepare("SELECT * FROM pedidos");
                  $sql->execute();
                  while ( $fila = $sql->fetch()) {
                    ?>
                  <li class="list-group-item">

                      Id Pedido = <?php echo $fila['numero_pedido']?>, 
                      Código Producto  = <?php echo $fila['codigo_producto']?>, 
                      Rut Cliente  = <?php echo $fila["clientes_rut_cliente"]?>, 
                      Fecha Pedido  = <?php echo date("d/m/Y hh:mm", strtotime($fila['fecha_pedido']));?>
                      Cantidad = <?php echo $fila['cantidad']?>
                      <!-- Estado Pedido  = <?php echo $fila['estado_pedido']?> -->

                      <span class="fa-stack  float-right eliminar" id="<?php echo $fila['numero_pedido']?>" style="color:red; cursor: pointer;" title="Eliminar registro.">
                      <i class="fa fa-circle fa-stack-2x"></i>
                      <i class="fa fa-trash fa-stack-1x fa-inverse"></i>
                      </span>

                      <span class="fa-stack  float-right modificar" id="<?php echo $fila['numero_pedido']?>" style="color:blue; cursor: pointer ;" title="Actualizar registro.">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                      </span>
                  </li>                    
                    
                    <?php
                  }
                }
                catch(Exception $ex)
                {
                    print "¡Error!: " . $ex->getMessage() . "<br/>";
                      die();
                }
                ?>
                </ul>
              </div>
            </div>
      </div>
    </div> 
   
       
</div>
</div>
<!-- Fin CRUD -->

<!-- Modal -->
<div class="modal fade" id="modificar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modificar pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body datos">       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>      
      </div>
    </div>
  </div>
</div>
<!-- fin Modal -->

<!-- Modal ventana de ayuda -->
<div class="modal fade" id="ayuda" tabindex="-1" role="dialog" aria-labelledby="helpModalLabel" aria-hidden="true"
     data-keyboard="false" data-backdrop="static" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="helpModalLabel">Ayuda pantalla Pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body datos">
        <img src="img/btn_hlp_pedido.png" alt="Ayuda Pedido." class="img-responsive center-block">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>      
      </div>
    </div>
  </div>
</div>
<!-- fin Modal -->


<footer class="footer">
    <div class="container text-center text-white">
      <!-- <span class="text-muted empresa"></span> -->
      <?php include "includes/footer.php"; ?>
    </div>
</footer>
        </div>
  </section>
    <!-- <script src="js/jquery-3.2.1.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
    <!-- <script src="//unpkg.com/@popperjs/core@2"></script> -->
    <script src="js/popper.min.js"></script>
    <!-- <script src="js/bootstrap.min.js"></script> -->
    <!-- <script src="js/scrollreveal.min.js"></script> -->
    <script src="js/helper.js"></script>
    
    <!-- Include bootbox.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.js"></script>

    <script>

       $(".eliminar").click(function(){
        var clave = $(this).attr("id");
        $.ajax({
          url : "procesa.php",
          data : "opc=eliminar&clave="+clave,
          type : "post",
          success: function()
          {
            location.reload();
          }
        })
      });
       
       $(".modificar").click(function(){
        var clave = $(this).attr("id");
         $.ajax({
          url : "procesa.php",
          data : "opc=modificar-form&clave="+clave,
          type : "post",
          success: function($datos)
          {
            alert('2');
            $(".datos").html($datos);
          }
        })
        $('#modificar').modal('show');
      });

      $(".btnAyuda").click(function(){
        var clave = $(this).attr("id");
         $.ajax({
          url : "",
          data : "opc=modificar-form&clave="+clave,
          type : "post",
          success: function($datos)
          {
            alert("111111111");
            $(".datos").html($datos);
          }
        })
        $('#ayuda').modal('show');
      });
    </script>
  </body>
</html>

<script type="text/javascript">
  $(document).ready( function() {

      $('#guarda').bootstrapValidator({
          feedbackIcons: {
              valid: 'glyphicon glyphicon-ok',
              invalid: 'glyphicon glyphicon-remove',
              validating: 'glyphicon glyphicon-refresh'
          },
          fields: {
            numero: {
              validators: {
                  notEmpty: {
                      message: 'Campo nombre es requerido.'
                  },
                  stringLength: {
                    max: 6,
                    message: 'El campo debe tener máximo 6 caracteres.'
                  },
                  numeric: {
                    message: 'Código producto requiere números.'
                  }
              }
            },
            rut: {
                validators: {
                    notEmpty: {
                        message: 'Campo código es requerido'
                    },
                    stringLength: {
                        max: 10,
                        message: 'El campo RUT debe tener máximo 10 caracteres.'
                    },
                    alphanumeric: {
                        message: 'RUT no pude contener simbolos.'
                    }
                }
            },
            codigo: {
                validators: {
                    notEmpty: {
                        message: 'Campo código es requerido'
                    },
                    numeric: {
                        message: 'Código producto requiere números.'
                  }
                }
            },
            fecha: {
                validators: {
                    notEmpty: {
                        message: 'Campo código es requerido'
                    },
                    date: {
                      format: 'DD/MM/YYYY',
                      message: 'No es una fecha valida.'
                    }
                }
            },
            cantidad: {
                validators: {
                    notEmpty: {
                        message: 'Campo no puede estar en blanco es requerido'
                    }
                },
                numeric: {
                    message: 'Cantidad debe contener números.'
                  }
            }
          }
      });
  });
</script>
