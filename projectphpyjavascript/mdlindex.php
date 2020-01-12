<?php
if (isset($_POST['accion'])) {
	if ($_POST['accion'] == 'Listar') {
		Listar();
	} else 	if ($_POST['accion'] == 'CambiarEstado') {
		CambiarEstado();
	} else 	if ($_POST['accion'] == 'Eliminar') {
		Eliminar();
	} else 	if ($_POST['accion'] == 'Guardar') {
		Guardar();
	} else 	if ($_POST['accion'] == 'Mostrar') {
		Mostrar();
	} else 	if ($_POST['accion'] == 'Editar') {
		Editar();
	}
}

//if(true){Listar();}
function Listar(){
	// $servername = "localhost";
	// $username = "root";
	// $password = "";
	// $dbname = "prueba";
	// $Respuesta = "";
	// $Tabla ="";

	// // Create connection
	// $conn = new mysqli($servername, $username, $password, $dbname);
	// // Check connection
	// if ($conn->connect_error) {
	//     die("Connection failed: " . $conn->connect_error);
	// }
	require('conexion.php');

	$sql = "SELECT id, nombre, bodega, cantidad, estado, observacion FROM productos";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {

	    	if (strtolower($row["estado"])=='inactivo') {
	    		$color = "#faa4b1";
	    	} else {
	    		$color = "#befaa4";
	    	}

	    	$Tabla.="<tr>";
	    	$Tabla.="<td>".$row["id"]."</td>";
	    	$Tabla.="<td>".$row["nombre"]."</td>";
	    	$Tabla.="<td>".$row["bodega"]."</td>";
	    	$Tabla.="<td>".$row["cantidad"]."</td>";
	    	$Tabla.="<td><label style=background-color:".$color.">".$row["estado"]."</label></td>";
	    	$Tabla.="<td>".$row["observacion"]."</td>";
	    	$Tabla.='<td><button type=\'button\' class=\'btn btn-primary\' onclick=\'CambiarEstado('.$row["id"].',\"'.$row["estado"].'\")\' >Cambiar estado</button> <button type=\'button\' class=\'btn btn-danger\' title=\'ELIMINAR\' onclick=\'Eliminar('.$row["id"].')\' ><i class=\"fa fa-trash-o\"></i></button> <button type=\'button\' class=\'btn btn-warning\' title=\'EDITAR\' onclick=\'Mostrar('.$row["id"].')\' data-toggle=\'modal\' data-target=\'#staticBackdrop\'><i class=\"fa fa-pencil\"></i></button> </td>';
	    	$Tabla.="</tr>";
	    	$Respuesta = '{"error":[{"titulo":"Éxito","respuesta":"se ha obtenido la lista de productos","tipo":"success","HTML":"'.$Tabla.'"}]}';
	        // echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
	    }
	} else {
		$Respuesta = '{"error":[{"titulo":"error","respuesta":" NO se ha obtenido la lista de productos","tipo":"error"}]}';
	}
    echo $Respuesta;
    //exit();
	$conn->close();
}

function CambiarEstado(){
	require('conexion.php');

	$estado = $_POST['estado'];
	$id = $_POST['id'];

	if (strtolower($estado) == "activo") {
		$estado = "Inactivo";
	} else{
		$estado = "Activo";
	}

	$sql = "UPDATE productos SET estado='".$estado."'WHERE id=".$id."";

	if ($conn->query($sql) === TRUE) {
	    $Respuesta = '{"arreglo":[{"titulo":"Éxito","respuesta":" Se ha cambiado el estado del producto.","tipo":"success"}]}';
	} else {
	    $Respuesta = '{"arreglo":[{"titulo":"Error","respuesta":" No se ha cambiado el estado del producto.","tipo":"error","estado":"'.$estado.'","sql":"'.$sql.'"}]}';
	}

    echo $Respuesta;
    //exit();
	$conn->close();
}

function Eliminar(){
	require('conexion.php');

	$id = $_POST['id'];

	$sql = "DELETE FROM productos WHERE id=".$id."";

	if ($conn->query($sql) === TRUE) {
	    $Respuesta = '{"arreglo":[{"titulo":"Éxito","respuesta":" Se ha eliminado el producto.","tipo":"success"}]}';
	} else {
	    $Respuesta = '{"arreglo":[{"titulo":"Error","respuesta":" No se ha eliminado el producto.","tipo":"error","sql":"'.$sql.'"}]}';
	}

    echo $Respuesta;
    //exit();
	$conn->close();
}

function Guardar(){
	require('conexion.php');

	$nombre = $_POST['nombre'];
	$bodega = $_POST['bodega'];
	$cantidad = $_POST['cantidad'];
	$estado = $_POST['estado'];
	$descripcion = $_POST['descripcion'];

	$sql = "INSERT INTO productos (nombre, bodega, cantidad, estado, observacion) VALUES ('".$nombre."', '".$bodega."', '".$cantidad."', '".$estado."', '".$descripcion."')";

	if ($conn->query($sql) === TRUE) {
	    $Respuesta = '{"arreglo":[{"titulo":"Éxito","respuesta":" Se ha creado el producto.","tipo":"success"}]}';
	} else {
	    $Respuesta = '{"arreglo":[{"titulo":"Error","respuesta":" No se ha creado el producto.","tipo":"error","sql":"'.$sql.'"}]}';
	}

    echo $Respuesta;
    //exit();
	$conn->close();
}

function Mostrar(){
	require('conexion.php');
	$id = $_POST['id'];

	$sql = "SELECT id, nombre, bodega, cantidad, estado, observacion FROM productos WHERE id = '".$id."'" ;
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	    	$nombre = $row["nombre"];
	    	$bodega = $row["bodega"];
	    	$cantidad = $row["cantidad"];
	    	$estado = $row["estado"];
	    	$observacion = $row["observacion"];
	    	$Respuesta = '{"error":[{"titulo":"Éxito","respuesta":"se ha obtenido la lista de productos","tipo":"success","nombre":"'.$nombre.'","bodega":"'.$bodega.'","cantidad":"'.$cantidad.'","estado":"'.$estado.'","observacion":"'.$observacion.'"}]}';
	        // echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
	    }
	} else {
		$Respuesta = '{"error":[{"titulo":"error","respuesta":" NO se ha obtenido la lista de productos","tipo":"error"}]}';
	}
    echo $Respuesta;
    //exit();
	$conn->close();
}

function Editar(){
	require('conexion.php');

	$id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$bodega = $_POST['bodega'];
	$cantidad = $_POST['cantidad'];
	$estado = $_POST['estado'];
	$descripcion = $_POST['descripcion'];

	$sql = "UPDATE productos SET nombre='".$nombre."', bodega='".$bodega."', cantidad='".$cantidad."', estado='".$estado."', observacion='".$descripcion."' WHERE id=".$id."";

	if ($conn->query($sql) === TRUE) {
	    $Respuesta = '{"arreglo":[{"titulo":"Éxito","respuesta":" Se ha actualizado el producto.","tipo":"success"}]}';
	} else {
	    $Respuesta = '{"arreglo":[{"titulo":"Error","respuesta":" No se ha actualizado el producto.","tipo":"error","sql":"'.$sql.'"}]}';
	}

    echo $Respuesta;
    //exit();
	$conn->close();
}