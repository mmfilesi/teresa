<script src="<?=base_url()?>js/vendor/datatable/jquery.dataTables.min.js"></script> 
<link rel="stylesheet" href="<?= base_url(); ?>css/datatable.css">

	<h3 class="azul_0777eb"><?= $titular; ?></h3>

	<table class="listadoTablas tablasDataTable" id="tablaAlbumes">

		<thead>
			<tr>
				<th></th>
				<th class="textoLeft cursorPointer">Álbum</th>
				<th>Imgs</th>
				<th>Editar</th>
				<th>Borrar</th>
			</tr>
		</thead>
		
		<tbody>
		<?php foreach ( $todoAlbums as $clave ) { ?>
		<tr id="js-fila_<?= $clave['id']; ?>">
			<?php 
				if ( $clave['imagen_destacada'] != "pendiente" ) {
					$imagenDestacada = $clave['imagen_destacada'];
					$imagenDestacada = explode(".", $imagenDestacada);
					$miniatura = base_url()."/../images/albums/".$clave['id']."/".$imagenDestacada[0]."_thumb.".$imagenDestacada[1];
				} else {
					$miniatura = base_url()."/../images/noThumbail.png";
				}
			?>
			<td class="ancho50 textoCentrado"><img src="<?= $miniatura; ?>" width="50" height="25" /></td>
			<td id="js-nombre_<?= $clave['id']; ?>" class="fuente085"><?= $clave['nombre']; ?></td>
			<td class="ancho50 textoCentrado">
				<a href="<?= base_url(); ?>admin/albumImagenes/<?= $clave['id']; ?>">
					<img src="<?= base_url(); ?>css/iconos/ico-guardar.png" widht="20" height="20" id="js-imagenes_<?= $clave['id']; ?>" />
				</a>
			</td>
			<td class="ancho50 textoCentrado">
				<a href="<?= base_url(); ?>admin/addAlbum/<?= $clave['id']; ?>">
					<img src="<?= base_url(); ?>css/iconos/ico-editar.png" widht="20" height="20" id="js-editar_<?= $clave['id']; ?>" />
				</a>
			</td>
			<td class="ancho50 textoCentrado">
				<img src="<?= base_url(); ?>css/iconos/ico-borrar.png" widht="20" height="20" id="js-borrar_<?= $clave['id']; ?>" class="js-borrarAlbums cursorPointer" />
			</td>

		</tr>
		<?php } ?>
	</tbody>

	</table>

<!-- Dialogs -->
<div id="dialog-borrar" class="dialogos" title="Borrar álbum" style="display:none;">
	<div class="bordeGrisBottom marginBottom-01" style="padding-bottom:1em;">
		Atención, esta acción es irreversible. Se borrará el álbum <span id="js-nombreAlbum" class="negrita"></span>,
		aunque <span class="negrita">no</span> se borrarán sus imágenes asociadas.
	</div>
	<div class="textoRight">
		<span id="js-cancelarDialog" class="botonRojo" style="margin-right:10px;">cancelar</span>
		<span id="js-borrarDialog" class="botonAzul" id="">borrar</span>
		<span id="js-idBorrar" style="display:none;"></span>
	</div>
</div>

<script>
(function(window, undefined){

	$(document).ready(function() {
		
		$(".js-borrarAlbums").click(function() {

			var id = $(this).attr('id');
			id = id.replace("js-borrar_","");
			$( "#js-idBorrar" ).text(id);

			var nombre = "#js-nombre_"+id;
			nombre = $(nombre).text();
			$( "#js-nombreAlbum" ).text(nombre);

			$( "#dialog-borrar" ).dialog({
			    resizable: false,
			    height:200,
			    modal: true
		    });

		});

	    $('#js-cancelarDialog').click(function() {
		    $( "#dialog-borrar" ).dialog( "close" );
	    });

		$('#js-borrarDialog').click(function() {
		    $( "#dialog-borrar" ).dialog( "close" );
		    var id = $( "#js-idBorrar" ).text();
		    var data = {};
	        data = {'id':id};
	        $.post("<?= base_url(); ?>admin/deleteAlbum", data).done(function() {
	        	id = "#js-fila_"+id;
	          	$(id).remove();
	         });
		});

		$('#tablaAlbumes').dataTable( {
			"aaSorting": [[ 1, "desc" ]],
			"oLanguage": {
						    "sProcessing":     "Procesando...",
						    "sLengthMenu":     "Mostrar _MENU_ álbumes",
						    "sZeroRecords":    "No se encontraron álbumes",
						    "sEmptyTable":     "Ningún dato disponible en esta tabla",
						    "sInfo":           "Álbumes: _START_ al _END_ de un total de _TOTAL_ álbumes",
						    "sInfoEmpty":      "Mostrando álbumes del 0 al 0 de un total de 0 álbumes",
						    "sInfoFiltered":   "(filtrado de un total de _MAX_ álbumes)",
						    "sInfoPostFix":    "",
						    "sSearch": 			"<img src='<?=base_url()?>css/iconos/ico-lupa.png'/>",
						    "sUrl":            "",
						    "sInfoThousands":  ",",
						    "sLoadingRecords": "Cargando...",
						    "oPaginate": {
						        "sFirst":    "Primero",
						        "sLast":     "Último",
						        "sNext":     "Siguiente",
						        "sPrevious": "Anterior"
						    },
						    "oAria": {
						        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
						        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
						    }
						}

		});


	});
		
})( window );  
</script>