function Principal(){
	Listar();
	$("#btn_guardar").click(Guardar);
	$("#btn_editar").click(Editar);
	$("#btn_cerrar").click(VaciarCampos);
	$("#cerrar_modal").click(VaciarCampos);
}

function Listar(){
	var parametros = {
		"accion" : "Listar"
	}

	$.ajax({
	  method: "POST",
	  url: "mdlindex.php",
	  data: parametros,
	  dataType: "json",
	  success: function(data) {
	  	var HTML = data.error[0]['HTML'];
	  	$('#tbodyproducto').html(HTML);
	  	 $('#tabla').DataTable();
	  },
	  error: function(respuesta,status) {
	  	console.log(respuesta);
	  },
	  complete: function(respuesta,status) {
	  }
	});
}

function CambiarEstado(id,estado){
	var parametros = {
		"accion": "CambiarEstado",
		"id": id,
		"estado": estado
	}

	swal({
	  title: "Confirmar",
	  text: "¿Está seguro de cambiar el estado del producto?",
	  icon: "info",
	  buttons: true,
	  buttons: ["Cancelar", "Aceptar"],
	  dangerMode: true
	})
	.then((willDelete) => {
	  if (willDelete) {
	  		 	$.ajax({
			  method: "POST",
			  url: "mdlindex.php",
			  data: parametros,
			  dataType: "json",
			  success: function(data) {
			  	var titulo = data.arreglo[0]['titulo'];
			  	var tipo = data.arreglo[0]['tipo'];
			  	var respuesta = data.arreglo[0]['respuesta'];
			  	//alert(respuesta);
			  	swal(titulo, respuesta, tipo);
			  	Listar();
			  },
			  error: function(respuesta,status) {
			  	console.log(respuesta);
			  },
			  complete: function(respuesta,status) {
			  }
			});
	  }
	});

	 // var opcion = confirm("¿Está seguro de cambiar el estado del producto?");
	 // if (opcion == true) {
	 //     $.ajax({
		//   method: "POST",
		//   url: "mdlindex.php",
		//   data: parametros,
		//   dataType: "json",
		//   success: function(data) {
		//   	var titulo = data.arreglo[0]['titulo'];
		//   	var tipo = data.arreglo[0]['tipo'];
		//   	var respuesta = data.arreglo[0]['respuesta'];
		//   	alert(respuesta);
		//   	//swal(titulo, respuesta, tipo);
		//   	Listar();
		//   },
		//   error: function(respuesta,status) {
		//   	console.log(respuesta);
		//   },
		//   complete: function(respuesta,status) {
		//   }
		// });
	 // } 
}

function Eliminar(id){
	var parametros = {
		"accion": "Eliminar",
		"id": id
	}

	swal({
	  title: "Confirmar",
	  text: "¿Está seguro de eliminar el producto?",
	  icon: "info",
	  buttons: true,
	  buttons: ["Cancelar", "Aceptar"],
	  dangerMode: true
	})
	.then((willDelete) => {
	  if (willDelete) {
  		 	$.ajax({
			  method: "POST",
			  url: "mdlindex.php",
			  data: parametros,
			  dataType: "json",
			  success: function(data) {
			  	var titulo = data.arreglo[0]['titulo'];
			  	var tipo = data.arreglo[0]['tipo'];
			  	var respuesta = data.arreglo[0]['respuesta'];
			  	// alert(respuesta);
			  	swal(titulo, respuesta, tipo);
			  	Listar();
			  },
			  error: function(respuesta,status) {
			  },
			  complete: function(respuesta,status) {
			  }
			});
	  }
	});

	 // var opcion = confirm("¿Está seguro de eliminar el producto?");
	 // if (opcion == true) {
	 //     $.ajax({
		//   method: "POST",
		//   url: "mdlindex.php",
		//   data: parametros,
		//   dataType: "json",
		//   success: function(data) {
		//   	var titulo = data.arreglo[0]['titulo'];
		//   	var tipo = data.arreglo[0]['tipo'];
		//   	var respuesta = data.arreglo[0]['respuesta'];
		//   	alert(respuesta);
		//   	Listar();
		//   },
		//   error: function(respuesta,status) {
		//   },
		//   complete: function(respuesta,status) {
		//   }
		// });
	 // } 
}

function Guardar(){
	var parametros = {
		"accion": "Guardar",
		"nombre": $("#nombre").val(),
		"bodega": $("#bodega").val(),
		"cantidad": $("#cantidad").val(),
		"estado": $("#estado").val(),
		"descripcion": $("#descripcion").val()
	}

	if (!parametros.nombre || !parametros.bodega || !parametros.cantidad || !parametros.estado || !parametros.descripcion ) {
		swal("Atención", "Existen campos vacios, por favor verifique", "info");
		// alert("Existen campos vacios, por favor verifique");
	} else{
		$.ajax({
		 method: "POST",
		 url: "mdlindex.php",
		 data: parametros,
		 dataType: "json",
		 success: function(data) {
		  var titulo = data.arreglo[0]['titulo'];
		  var tipo = data.arreglo[0]['tipo'];
		  var respuesta = data.arreglo[0]['respuesta'];
		  // alert(respuesta);
		  swal(titulo, respuesta, tipo);
		  $("#cerrar_modal").click();
		  VaciarCampos();
		  Listar();
		 },
		 error: function(respuesta,status) {
		 	console.log(respuesta);
		 },
		 complete: function(respuesta,status) {
		 }
		});
	}
}

function VaciarCampos(){
	$("#nombre").val("");
	$("#bodega").val("");
	$("#cantidad").val("");
	$("#estado").val("");
	$("#descripcion").val("");
  	$('#titulo_crear').show();
  	$('#titulo_editar').hide();
  	$('#btn_guardar').show();
  	$('#btn_editar').hide();
}

function Mostrar(id){
	var parametros={
		"accion": "Mostrar",
		"id": id
	};

	$.ajax({
	  method: "POST",
	  url: "mdlindex.php",
	  data: parametros,
	  dataType: "json",
	  success: function(data) {
	  	var nombre = data.error[0]['nombre'];
	  	var bodega = data.error[0]['bodega'];
	  	var cantidad = data.error[0]['cantidad'];
	  	var estado = data.error[0]['estado'];
	  	var descripcion = data.error[0]['observacion'];

	  	$('#idprod').val(id);
	  	$('#nombre').val(nombre);
	  	$('#bodega').val(bodega);
	  	$('#cantidad').val(cantidad);
	  	$('#estado').val(estado);
	  	$('#descripcion').val(descripcion);
	  	$('#btn_guardar').hide();
	  	$('#btn_editar').show();
	  	$('#titulo_crear').hide();
	  	$('#titulo_editar').show();
	  },
	  error: function(respuesta,status) {
	  	console.log(respuesta);
	  },
	  complete: function(respuesta,status) {
	  }
	});
}

function Editar(){
 	var parametros = {
		"accion": "Editar",
		"id": $("#idprod").val(),
		"nombre": $("#nombre").val(),
		"bodega": $("#bodega").val(),
		"cantidad": $("#cantidad").val(),
		"estado": $("#estado").val(),
		"descripcion": $("#descripcion").val()
	}

	if (!parametros.nombre || !parametros.bodega || !parametros.cantidad || !parametros.estado || !parametros.descripcion ) {
		// alert("Existen campos vacios, por favor verifique");
		swal("Atención", "Existen campos vacios, por favor verifique", "info");
	} else{
		swal({
		  title: "Confirmar",
		  text: "¿Está seguro de editar el producto?",
		  icon: "info",
		  buttons: true,
		  buttons: ["Cancelar", "Aceptar"],
		  dangerMode: true
		})
		.then((willDelete) => {
		  if (willDelete) {
	  		 	$.ajax({
				  method: "POST",
				  url: "mdlindex.php",
				  data: parametros,
				  dataType: "json",
				  success: function(data) {
				  	var titulo = data.arreglo[0]['titulo'];
				  	var tipo = data.arreglo[0]['tipo'];
				  	var respuesta = data.arreglo[0]['respuesta'];
				  	// alert(respuesta);
				  	swal(titulo, respuesta, tipo);
				  	$("#cerrar_modal").click();
		  			VaciarCampos();
		  			Listar();
				  },
				  error: function(respuesta,status) {
				  },
				  complete: function(respuesta,status) {
				  }
				});
		  }
		});
		// $.ajax({
		//  method: "POST",
		//  url: "mdlindex.php",
		//  data: parametros,
		//  dataType: "json",
		//  success: function(data) {
		//   var titulo = data.arreglo[0]['titulo'];
		//   var tipo = data.arreglo[0]['tipo'];
		//   var respuesta = data.arreglo[0]['respuesta'];
		//   alert(respuesta);
		//   $("#cerrar_modal").click();
		//   VaciarCampos();
		//   Listar();
		//  },
		//  error: function(respuesta,status) {
		//  	console.log(respuesta);
		//  },
		//  complete: function(respuesta,status) {
		//  }
		// });
	}	
}