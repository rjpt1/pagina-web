
<?php
session_start();
if (!isset($_SESSION["USUARIO"])) {
    $Usuario = $_SESSION["USUARIO"];
    if (empty($Usuario)) {

        header('Location: http://www.gomosec.com/ecosistema/MDL/Inicio/login.php');
    }
}

require('../CONEXION.PHP');
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Formatos
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
  <!-- CSS Files -->
  <link href="../../assets/css/material-dashboard.css?v=2.1.0" rel="stylesheet" />
  <link href="../../assets/css/EstiloTablaModal.css" rel="stylesheet" />
  <link href="../../assets/demo/demo.css" rel="stylesheet" />
  <link rel="stylesheet" href="../../LIB/dist/sweetalert.css" />
  <link href="https://fonts.googleapis.com/css?family=Titillium+Web&display=swap" rel="stylesheet">
  <style type="text/css">
    body{
      font-family: 'Titillium Web', sans-serif;
    }
  </style>
</head>

<body class="">

      <div class="wrapper ">
    <!-- Barra de navegación left -->

      <?php
$ID_LI = basename($_SERVER['PHP_SELF']);
include('../Partes/frm_barnav_lef.php');
?>

    <!-- FIN Barra de navegación left -->
    <div class="main-panel" style="height:100%;">
      <!-- Navbar -->
        <!-- Barra de navegación Top -->

        <?php
$TituloInterfaz = "Formatos";
include('../Partes/frm_barnav_top.php');
?>

       <!-- FIN Barra de navegación Top -->
      <!-- End Navbar -->
      <div class="content">
 	  	<div class="container-fluid">
 	     <div class="row">
          <div class="col-md-12">

          <button type="button" class="btn btn-info btn" data-toggle="modal" data-target="#myModal" id="btn_nuevo">Nuevo</button>
            <div class="card">
 	  		       <div class="card-header card-header-primary">
            	    <h4 class="card-title "><strong>Listado de Formatos</strong></h4>
                	<p class="card-category"> Aqui se encuentra la información de todos los formatos</p>
              <div style="width:3%; position: absolute; text-align: right; Top:30%; right:1%;">
                <span id="refresh_cliente" style="cursor: pointer; font-size: 2em; color: Withe;"><i class="fas fa-sync-alt"></i></span>
              </div>
              </div>

 	  		           <div class="card-body">
                      <div id ="div_listado_formatos" class="table-responsive">
                      </div>
                  </div>
                </div>
              </div>
            </div>
 		       </div>
         </div>
       </div>
    </div>

    <!-- modal -->
    <div id="myModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Formato</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
          <div class="modal-body">

              <div class="row">
              <div class="col">
                  <div class="form-group">
                    <label class="bmd-label-floating">Descripción</label>
                    <textarea class="form-control" id="txt_descripcion" value="txt_descripcion" rows="4" cols="20"></textarea>

                  </div>
                </div>
              <div class="col">
                <div class="form-group">
                  <label class="bmd-label-floating">Observación</label>
                  <textarea class="form-control" id="txt_observacion"  value="txt_observacion" rows="4" cols="20"></textarea>

                </div>
              </div>

              </div>
              <div class="row">
              <div class="col">
                <div class="col-md-6" id="div_estado">
                  <div class="form-group">
                    <label class="bmd-label-floating">Estado</label>
                    <select class="form-control" id="txt_estado" style="text-align-last: center !important; font-weight:bold;padding:0px;margin:0px;">
                      <option value="ACTIVO">ACTIVO</option>
                      <option value="INACTIVO">INACTIVO</option>
                    </select>
                  </div>
                </div>
                </div>
              <div class="col">
                <div class="form-group">
                  <label class="bmd-label-floating" >Fecha vigencia</label>
                  <input class="form-control" id="txt_fechaVigencia" type="date" value="txt_fechaVigencia">

                </div>
              </div>

              </div>
              <br>
              <div class="row">
              <div class="col-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Subir formato</label>
                    <input class="form-control"  id="txt_pdf_formato" type="file" name="uploadedFile" />

                  </div>
                </div>


              </div>
              <br>
              <div class="row">
                <div class="col-6">
                  <label class="bmd-label-floating">Productos</label>
                  <select class="form-control" id="txt_producto">
                    <option value="-1">Seleccione...</option>
                    <?php
                    $sqlProducto = "SELECT `id`, `nombre` FROM `producto`";

                    $queryProducto = $conn->query($sqlProducto);
                    if ($queryProducto) {
                      if ($queryProducto->num_rows > 0) {
                        while($rowProducto = $queryProducto->fetch_assoc()) {
                          $ReturnProducto .= '<option value="'.$rowProducto["id"].'">'.utf8_encode($rowProducto["nombre"]).'</option>';
                        }
                      }else{
                      $ReturnProducto = '';
                      }
                      $queryProducto->close();
                    } else {
                    $ReturnProducto = '';
                    }
                    echo $ReturnProducto;
                    ?>
                  </select>
                </div>
                <div class="col-6">
                  <button type="button" class="btn btn-success btn-md" id="btn_cargar" style="position:absolute !important ;bottom:1px !important; ">Cargar</button>

                </div>

              </div>
              <br>
              <div class="row">
              <div class="col-12">
                  <div class="form-group">
                    <table class="table">
                      <thead class="thead_encabezado_table">
                        <tr class="tr_th_encabezado_table">
                          <th  class="th_encabezado_table radius_A" width="15%">Código</th>
                          <th class="th_encabezado_table radius_A" width="70%">Producto </th>
                          <th class="th_encabezado_table radius_A" width="15%">Acción</th>
                        </tr>

                      </thead>
                      <tbody id="TbodydetallesFormatos" class="TbodydetallesFormatos">

                      </tbody>
                    </table>

                  </div>
                </div>


              </div>
                <br>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning btn" id="btn_modificar" style="padding: 1.4% !important; top:1.5%; vertical-align: baseline !important; background-color:#FA9E2E;" ><i class="far fa-edit" style="font-size: 1.6em;"></i> Modificar</button>
        <button type="button" id="btn_guardar" class="btn btn-primary">Guardar</button>
        <button type="button" id="btn_editar" class="btn btn-primary">Editar</button>
        <button type="button" class="btn btn-secondary" id="closeModal" data-dismiss="modal" style="background-color: #999999; color:white">Cerrar</button>
      </div>
    </div>
  </div>
</div>
    <!-- end modal -->


      <!-- Barra footer -->

        <?php
        include('../Partes/frm_footer_principal.php');
        ?>

      <!-- FIN Barra footer -->








  <!--   Core JS Files   -->
  <script src="../../assets/js/core/jquery.min.js" type="text/javascript"></script>
  <script src="../../assets/js/core/popper.min.js" type="text/javascript"></script>
  <script src="../../assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
  <script src="../../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chartist JS -->
  <script src="../../assets/js/plugins/chartist.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../../assets/js/material-dashboard.min.js?v=2.1.0" type="text/javascript"></script>
  <script src="../../assets/js/jquery-3.3.1.min.js"></script>
  <!-- <script src="LIB/dist/sweetalert.min.js"></script> -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="fns_formatos.js" type="text/javascript"></script>
  <script src="../Partes/js_barnav.js" type="text/javascript"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
  <script type="text/javascript">
    var GSW_MOSTRAR = 0;
    var GID = 0;
    var BANDERA=0;
    var RowDetFormato=[];
    var Nombre = '<?php
                  echo $ID_LI;
                  ?>';
    $(document).ready(Principal);
  </script>

</body>
</html>
