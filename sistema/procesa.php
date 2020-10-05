<?php
try {

    $conexion = new PDO('mysql:host=localhost;dbname=aquaweb', "dbadminbckp", "admin");
        
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}


switch($_POST['opc'])
{

 case "guardar":
 try{
          $tipo  = "WEB";
          $estado  = "PENDIENTE";
          $fecha = date("Y/m/d", strtotime($_POST['fecha']));
          $sql = $conexion->prepare("INSERT INTO pedidos(numero_pedido, codigo_producto, clientes_rut_cliente, fecha_pedido,tipo_pedido, estado_pedido, cantidad)
          VALUES('".$_POST['numero']."','".$_POST['codigo']."','".$_POST['rut']."','".$fecha."','".$tipo."','".$estado."','".$_POST['cantidad']."')");
          $sql->execute();         
          header("location:mnt_pedidos.php");   
    }
    catch (PDOException $e) {
    print "¡Error al guardar!: " . $e->getMessage() . "<br/>";
    die();
    } 
    break;

case "eliminar":
 try{
          $sql = $conexion->prepare("DELETE FROM pedidos WHERE numero_pedido =".$_POST['clave']);       
          $sql->execute();         
    }
      catch (PDOException $e) {
    print "¡Error al guardar!: " . $e->getMessage() . "<br/>";
    die();
} 
 break;
 case "modificar-form":
 try{
          $sql = $conexion->prepare("SELECT * FROM pedidos WHERE numero_pedido=".$_POST['clave']);       
          $sql->execute();         
          if($fila = $sql->fetch())
          {  
 ?>
       <form action="procesa.php" method="post" id="modificar">
                  <input type="text" value="modificar" name="opc" hidden>
                  <input type="text" value="<?php echo $_POST['clave']?>" name="clave" hidden>
                <div class="form-group">
                  <label for="numero" class="text-left">Número Pedido</label>
                  <input type="text" disabled class="form-control" id="numero" name="numero" value="<?php echo $fila['numero_pedido']?>" placeholder="">                  
                </div>
                <div class="form-group">
                  <label for="rut">RUT Cliente:</label>
                  <input type="text" class="form-control" id="rut" name="rut" value="<?php echo $fila['clientes_rut_cliente']?>" placeholder="digité RUT correcto."
                      data-tpoggle="tooltip" data-placement="bottom"
                      title="Corresponde al RUT registrado del cliente, que solicita el pedido de compra." require>
                </div>
                <div class="form-group">
                  <label for="codigo">Código Producto:</label>
                  <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo $fila['codigo_producto']?>" placeholder="digite código de producto">
                </div>
                <div class="form-group">
                  <label for="fecha">Fecha pedido:</label>
                  <input type="text" class="form-control" id="fecha" name="fecha" value="<?php echo $fila['fecha_pedido']?>" placeholder=""
                    data-tpoggle="tooltip" data-placement="bottom" require
                    title="Corresponde a la fecha en que se realiza al compra, puede ser anterior a la fecha actual.">
                </div>
                <div class="form-group">
                  <label for="cantidad">Cantidad:</label>
                  <input type="text" class="form-control" id="cantidad" name="cantidad" value="<?php echo $fila['cantidad']?>" placeholder="digita cantidad superior a cero."
                      data-tpoggle="tooltip" data-placement="bottom"
                      title="Corresponde a la cantidad total del producto solicitado.">
                </div>               
                <button type="submit" class="btn btn-info">Modificar</button>
              </form>
 <?php
}
  }
      catch (PDOException $e) {
    print "¡Error al guardar!: " . $e->getMessage() . "<br/>";
    die();
}
 break;
case "modificar":
  try{
          $fechaPedido = date("Y/m/d", strtotime($_POST['fecha']));
          $sql = $conexion->prepare("UPDATE pedidos SET codigo_producto='".$_POST['codigo']."', clientes_rut_cliente='".$_POST['rut']."',fecha_pedido='".$fechaPedido."', cantidad='".$_POST['cantidad']."' WHERE numero_pedido=".$_POST['clave']);       
          $sql->execute();         
          header("location:mnt_pedidos.php");   
    }
      catch (PDOException $e) {
    print "¡Error al guardar!: " . $e->getMessage() . "<br/>";
    die();
}
 break;
}
?>