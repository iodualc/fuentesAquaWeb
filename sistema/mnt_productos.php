<?php 
  session_start();
 
  unset($_SESSION['consulta']);

 ?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Mantenedor Productos</title>
  
	<link rel="stylesheet" type="text/css" href="librerias/bootstrap/bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker.min.css">

  <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/alertify.css">
	<link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/themes/default.css">
  <link rel="stylesheet" type="text/css" href="librerias/select2/css/select2.css">
  
  <script src="librerias/jquery-3.2.1.min.js"></script>
	<script src="librerias/bootstrap/js/bootstrap.js"></script>
  <script src="librerias/bootstrap/bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.min.js"></script>
  <script src="https://cdn.rawgit.com/PascaleBeier/bootstrap-validate/v2.2.0/dist/bootstrap-validate.js" ></script>

	<script src="librerias/alertifyjs/alertify.js"></script>
  <script src="librerias/select2/js/select2.js"></script>
  <script src="js/funciones.js"></script> 
</head>
<body>

	<div class="container">
    <div id="buscador"></div>
		<div id="tabla"></div>
	</div>

	<!-- Modal para registros nuevos -->
<div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agrega nuevo producto</h4>
      </div>
      <div class="modal-body">
        <form class="needs-validation" novalidate>
            <div class="form-group">
              <div class='inputWrapper invalidClass' id='formHolder1'>
                <label>Código Producto</label>
                <input type="text" name="" id="codigo" class="form-control input-sm" require>
              </div>
            </div>
            <div class='inputWrapper invalidClass' id='formHolder2'>
              <label>Descripción Producto</label>
              <input type="text" name="" id="descripcion" class="form-control input-sm" required>
            </div>
            <div class='inputWrapper invalidClass' id='formHolder3'>
              <label>Fecha Producto</label>
              <input type="text" name="" id="fecha" class="form-control">
            </div>
            <div class='inputWrapper invalidClass' id='formHolder4'>
              <label>Stock Producto</label>
              <input type="text" name="" id="stock" class="form-control input-sm" required>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" data-dismiss="modal" id="guardarnuevo">
          Agregar
          </button>
        </div>
    </div>
  </div>
</div>

<!-- Modal para edicion de datos -->
<div class="modal fade" id="modalEdicion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Actualizar datos</h4>
      </div>
      <div class="modal-body">
      		<input type="text" hidden="" id="idProductoUpd" name="">
        	<label>Codigo</label>
        	<input type="text" name="" id="codigoUpd" class="form-control input-sm">
        	<label>Descripcion</label>
        	<input type="text" name="" id="descripcionUpd" class="form-control input-sm">
        	<label>Fecha Producto</label>
        	<input type="text" name="" id="fechaUpd" class="form-control input-sm">
        	<label>Stock Producto</label>
        	<input type="text" name="" id="stockUpd" class="form-control input-sm">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" id="actualizadatos" data-dismiss="modal">Actualizar</button>
        
      </div>
    </div>
  </div>
</div>

<div>
  <a class="btn btn-primary" href="http://localhost/aquavtas/taller-mnu.php#" role="button">Volver</a>
</div>
</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		$('#tabla').load('componentes/tabla.php');
    $('#buscador').load('componentes/buscador.php');
	});
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#guardarnuevo').click(
          function() {
            codigo=$('#codigo').val();
            descripcion=$('#descripcion').val();
            fecha=$('#fecha').val();
            stock=$('#stock').val();

            agregardatos(codigo, descripcion, fecha, stock);
        });

        $('#actualizadatos').click(function(){
          actualizaDatos();
        });

    });
</script>

<script type="text/javascript">
	$(document).ready(function(){
    $('#fecha').datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        daysOfWeekHighlighted: "0,6"
    });
  });

  $(document).ready(function(){
    $('#fechaUpd').datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        daysOfWeekHighlighted: "0,6"
    });
  });
</script>

<script>
function submitContactForm(){
    var codigo = $('#codigo').val();
    var descripcion = $('#descripcion').val();
    var fecha = $('#fecha').val();
    var stock = $('#stock').val();
    if(codigo.trim() == '' ){
        $('#codigo').focus();
        alert('Please enter your codigo.');
        return false;
    }else if(descripcion.trim() == '' ){
        alert('Please enter your descripcion.');
        $('#descripcion').focus();
        return false;
    }else if(fecha.trim() == '' ){
        alert('Please enter your fecha.');
        $('#fecha').focus();
        return false;
    }else if(stock.trim() == '' ){
        alert('Please enter your stock.');
        $('#stock').focus();
        return false;
    }else{
        $.ajax({
            type:'POST',
            url:'',
            data:'contactFrmSubmit=1&codigo='+codigo+'&demail='+descripcion+'&message='+fecha,
            beforeSend: function () {
                $('.submitBtn').attr("disabled","disabled");
                $('.modal-body').css('opacity', '.5');
            },
            success:function(msg){
                if(msg == 'ok'){
                    $('#codigo').val('');
                    $('#descripcion').val('');
                    $('#stock').val('');
                    $('.statusMsg').html('<span style="color:green;">Thanks for contacting us, well get back to you soon.</p>');
                }else{
                    $('.statusMsg').html('<span style="color:red;">Some problem occurred, please try again.</span>');
                }
                $('.submitBtn').removeAttr("disabled");
                $('.modal-body').css('opacity', '');
            }
        });
    }
}
</script>

<script>
$(document).ready(function() {
  bootstrapValidate('#codigo', 'required:Ingrese al menos 4 caracteres.', function(isValid) {
    if (isValid) {
      $("#formHolder1").addClass('validClass');
      $("#formHolder1").removeClass('invalidClass');
    } else {
      $("#formHolder1").addClass('invalidClass');
      $("#formHolder1").removeClass('validClass');
    }
  });
  bootstrapValidate('#descripcion', 'required:No puede estar en blanco, la descripción.', function(isValid) {
    if (isValid) {
      $("#formHolder2").addClass('validClass');
      $("#formHolder2").removeClass('invalidClass');
    } else {
      $("#formHolder2").addClass('invalidClass');
      $("#formHolder2").removeClass('validClass');
    }
  });
  bootstrapValidate('#fecha', 'min:1:No puede estar la fecha en blanco..', function(isValid) {
    if (isValid) {
      $("#formHolder3").addClass('validClass');
      $("#formHolder3").removeClass('invalidClass');
    } else {
      $("#formHolder3").addClass('invalidClass');
      $("#formHolder3").removeClass('validClass');
    }
  });
  bootstrapValidate('#stock', 'numeric:No puede tener el stock en cero.', function(isValid) {
    if (isValid) {
      $("#formHolder4").addClass('validClass');
      $("#formHolder4").removeClass('invalidClass');
    } else {
      $("#formHolder4").addClass('invalidClass');
      $("#formHolder4").removeClass('validClass');
    }
  });

}); 
</script>