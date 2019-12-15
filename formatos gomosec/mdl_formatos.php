<?php
session_start();
require_once('../Partes/generico.php');

if (isset($_POST['Accion'])){
  if($_POST['Accion'] == 'Listar'){
    Listar();
  }elseif ($_POST['Accion'] == 'Eliminar') {
    Eliminar();
  }elseif ($_POST['Accion'] == 'Guardar') {
    Guardar();
  }elseif ($_POST['Accion'] == 'MostrarDatosEditar') {
    MostrarDatosEditar();
  }elseif ($_POST['Accion'] == 'Editar') {
    Editar();
  }
}



function MostrarDatosEditar()
{
  require('../CONEXION.PHP');

  $Id=$_POST['Id'];
  $botonesMostrar=$_POST['botonesMostrar'];
  $sql="SELECT `idformatos`, `descripcion`, `observacion`,`estado`,`fechaVigencia` FROM `formatos` WHERE `idformatos` = '".$Id."' ";
  $query= $conn->query($sql);
  if($query){
    $SqlInfoRow = $query->fetch_array(MYSQLI_NUM);

    $idformatos=$SqlInfoRow[0];
    $descripcion=$SqlInfoRow[1];
    $observacion=$SqlInfoRow[2];
    $estado=$SqlInfoRow[3];
    $fechaVigencia=$SqlInfoRow[4];


    //cargar los formatos productos

    $sql = "SELECT P.nombre, P.id
    FROM producto P INNER JOIN formatoProducto FP ON P.id = FP.id_producto
    INNER JOIN formatos F ON F.idformatos = FP.id_formato
    WHERE F.idformatos = '" . $idformatos . "'";

    $query = $conn->query($sql);
    if ($query) {
        if ($query->num_rows > 0) {

            $Consecutivo   = 1;
            $T_RowPermisos = '';
            $ArrayModulos  = "";

             while ($row = $query->fetch_assoc()) {
            //
                    $Id = $row["id"];
                    $nombreProducto = $row["nombre"];
                //Armar la tabla de permisos
                  $T_RowPermisos.= "<tr id='".$Id."'>";
                  $T_RowPermisos.= '<td class=\"td_texto_table\" >'.$Id.'</td>';
                  $T_RowPermisos.='<td class=\"td_texto_table\" >'.utf8_encode($nombreProducto).'</td>';
                  $T_RowPermisos.='<td class=\"td_texto_table\" ><span id=\"eliminar'.$Id.'\" class=\"btn_eliminar_row\"  style=\"font-size: 1em; color: Tomato;\"><i class=\"fas fa-minus-circle\"></i></span></td>';
                  $T_RowPermisos.='</tr>';

                if (empty($ArrayModulos)) {
                    $ArrayModulos .= $Id . "º";
                } else {
                    $ArrayModulos .= $Id . "º";
                }
             }
            }
          }
    //

    $Return = '{"array": [{"Titulo": "Exito","Respuesta": "Formatos encontrados.","Tipo": "success"},{"idformatos":"'.$idformatos.'","descripcion": "'.$descripcion.'","observacion": "'.$observacion.'","estado":"'.$estado.'","fecha":"'.$fechaVigencia.'","ArrayModulos":"'.$ArrayModulos.'","HTML":"'.$T_RowPermisos.'","botonesMostrar":"'.$botonesMostrar.'"}]}';
  }

  else {
    $Return = '{"array": [{"Titulo": "Error","Respuesta": "Formato no encontrados.","Tipo": "error"}]}';
  }

  echo $Return;
  $conn->close();
}

function Editar()
{
  require('../CONEXION.PHP');
  $descripcion=$_POST["descripcion"];
  $observacion=$_POST["observacion"];
  $estado=$_POST["estado"];
  $fecha=$_POST["fecha"];
  $idformato=$_POST["idformato"];
  $ArrayModuloFormatos = $_POST['ArrayModuloFormatos'];
  $JsonArrayModuloFormatos = json_decode($ArrayModuloFormatos);
  $filename = $_FILES['formato']['name'];
  $filetype = $_FILES['formato']['type'];
  $filesize = $_FILES['formato']['size'];
  $directorio = '../../assets/img/formatos/';
  if (move_uploaded_file($_FILES['formato']['tmp_name'], $directorio.$filename)) {
    $sql="UPDATE `formatos` SET `descripcion`='".$descripcion."',`observacion`='".$observacion."',`estado`='".$estado."',`fechaVigencia`='".$fecha."',`archivo`='".$filename."' WHERE `idformatos`= '".$idformato."' ";
    $query = $conn->query($sql);
    if ($query) {
      $sqldelete="DELETE FROM `formatoProducto` WHERE `id_formato` ='".$idformato."' ";
      //error_log($sqldelete);
      $conn->query($sqldelete);
      foreach ($JsonArrayModuloFormatos as $key) {
        /* array numérico */
           $Cod = $key->Cod;
            $sql="INSERT INTO `formatoProducto` (`id_producto`, `id_formato`) VALUES ('".$Cod."','".$idformato."')";
            $conn->query($sql);
      }

    }
    $Return = "Exito"."º"." Se edito de forma correcta el formato"."º"."success";
  }else {
    $Return = "Error"."º"."Error al cargar el formato"."º"."error";
  }
    echo $Return;
    $conn->close();
}


function Guardar()
{
  require('../CONEXION.PHP');
  $descripcion=$_POST["descripcion"];
  $observacion=$_POST["observacion"];
  $estado=$_POST["estado"];
  $fecha=$_POST["fecha"];
  $ArrayModuloFormatos = $_POST['ArrayModuloFormatos'];
  $JsonArrayModuloFormatos = json_decode($ArrayModuloFormatos);
  $filename = $_FILES['formato']['name'];
  $filetype = $_FILES['formato']['type'];
  $filesize = $_FILES['formato']['size'];
  $directorio = '../../assets/img/formatos/';
  if (move_uploaded_file($_FILES['formato']['tmp_name'], $directorio.$filename)) {
    $sql="INSERT INTO `formatos`( `descripcion`, `observacion`, `estado`, `fechaVigencia`, `archivo`) VALUES ('".utf8_encode($descripcion)."','".$observacion."','".$estado."','".$fecha."','".$filename."')";
    $query = $conn->query($sql);
    // detales formatos
    $sqlMax = "SELECT MAX(`idformatos`) FROM formatos";
    $queryMax = $conn->query($sqlMax);
    //var_dump($queryMax);
    if ($queryMax) {
    	if ($queryMax->num_rows > 0) {
        $SqlRow = $queryMax->fetch_array(MYSQLI_NUM);
        $Id=$SqlRow[0];

        foreach ($JsonArrayModuloFormatos as $key) {
              /* array numérico */
              $Cod = $key->Cod;
              $sql="INSERT INTO `formatoProducto` (`id_producto`, `id_formato`) VALUES ('".$Cod."','".$Id."')";
              $conn->query($sql);
        }
      }
    }

    $Return = "Exito"."º"." se cargo el formato de forma correcta"."º"."success";

  }else {
    $Return = "Error"."º"."Error al cargar el formato"."º"."error";
  }
    echo $Return;
    $conn->close();
}

function Eliminar()
{
  require('../CONEXION.PHP');

  $Codigo = $_POST['Id'];
  $sqlDelete = "DELETE FROM `formatos` WHERE `idformatos` = '".$Codigo."' ";

  $query= $conn->query($sqlDelete);
  if ($query) {
          $Return = '{"array": [{"Titulo": "Éxito","Respuesta": "Se ha eliminado el registro correctamente.","Tipo": "success"}]}';

  } else {
    $Return = '{"array": [{"Titulo": "Error","Respuesta": "Imposible realizar la consulta.","Tipo": "error"}]}';
  }

  echo $Return;
  $conn->close();

}

function Listar (){
  require('../CONEXION.PHP');
  $Cargo=$_SESSION['USUARIO_CARGO'];
  $sql="SELECT idformatos, descripcion, observacion, estado, fechaVigencia, archivo  FROM  formatos";
  $query = $conn->query($sql);
  if ($query) {
    if ($query->num_rows > 0) {
      $Consecutivo = 1;
      $T_Row = '';
      while($row = $query->fetch_assoc()) {

        if ($row["estado"] == "ACTIVO") {
          $StyleEstado = "background-color:#C9FFC9;color: #29AD29;";
        }else {
          if ($row["estado"] == "INACTIVO") {
            $StyleEstado = "background-color:#FFC9C9;color: #AD2929;";
          }else {
            $StyleEstado = "background-color:#fff;color: #000;";
          }
        }
        $id=$row["idformatos"];

        $T_Row.= '<tr value =\"'.$id.'\" id = \"'.$id.'\"  class = \"RowFormatos\" style=\"cursor:pointer;\" >';
        $T_Row.= '<td data-toggle=\"modal\" data-target=\"#myModal\">'.$Consecutivo.'</td>';
        $T_Row.= '<td  data-toggle=\"modal\" data-target=\"#myModal\">'.$row["idformatos"].'</td>';
        $T_Row.= '<td data-toggle=\"modal\" data-target=\"#myModal\">'.utf8_decode($row["descripcion"]).'</td>';
        $T_Row.= '<td data-toggle=\"modal\" data-target=\"#myModal\">'.utf8_decode($row["observacion"]).'</td>';
        $T_Row.= '<td data-toggle=\"modal\" data-target=\"#myModal\"><a href=\"../../assets/img/formatos/'.$row["archivo"].'\" target=\"_blank\">'.$row["archivo"].'</a></td>';

        $T_Row.= '<td style=\"text-align-last: center !important;font-weight:bold;'.$StyleEstado.'\">'.$row["estado"].'</td>';
        $T_Row.= '<td data-toggle=\"modal\" data-target=\"#myModal\">'.$row["fechaVigencia"].'</td>';
        $T_Row.= '<td width=\"5%\" style=\"text-align:right;\" >';
        $T_Row.= '<span  data-toggle=\"modal\" data-target=\"#myModal\" id=\"btn_modificar_row_formatos'.$row["idformatos"].'\" value = \"'.$row["idformatos"].'\" class=\"btn_modificar_row_formatos\"  style=\"font-size: 1.5em; color: #FA9E2E; margin-right:3%;\"><i class=\"far fa-edit\"></i></span>';
        $T_Row.= '<span id=\"btn_eliminar_row_formatos'.$row["idformatos"].'\" value = \"'.$row["idformatos"].'\" class=\"btn_eliminar_row_formatos\"  style=\"font-size: 1.5em; color: Tomato;\"><i class=\"fas fa-minus-circle\"></i></span>';
        $T_Row.= '</td></tr>';

        $Consecutivo++;
      }

         $Table = '<table id=\"TableFormato\" class=\"Table display\" style=\"width:100%\"><thead class=\"text-primary\"><tr><th>Cons</th><th>Código</th><th>Descripción</th><th>Observación</th><th>Formato</th><th>Estado</th><th>Fecha Vigencia</th><th></th></tr></thead><tbody>';
         $Table .= $T_Row;
         $Table .= '</tbody><tfoot><tr><th width=\"2%\">Cons</th><th>Código</th><th>Descripción</th><th>Observación</th><th>Formato</th><th>Estado</th><th>Fecha Vigencia</th><th width=\"2%\"></th></tr></tfoot></table>';

         $Return = '{"array": [{"Titulo": "Éxito","Respuesta": "El listado de dormatos ha sido cargado exitosamente.","Tipo": "success"},{"Listado": [{"Id": "TableFormato","HTML":"'.$Table.'", "ClassTr":"RowFormatos"}]}]}';

    }else{
      $Return = '{"array": [{"Titulo": "Error","Respuesta": "Formatos no encontrados.","Tipo": "error"}]}';
    }
    $query->close();
  } else {
    $Return = '{"array": [{"Titulo": "Error","Respuesta": "Imposible realizar la consulta.","Tipo": "error"}]}';
  }
  echo $Return;
  $conn->close();
}
