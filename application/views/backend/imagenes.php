<script src="<?=base_url()?>js/vendor/datatable/jquery.dataTables.min.js"></script> 
<link rel="stylesheet" href="<?= base_url(); ?>css/datatable.css">

	<h3 class="azul_0777eb"><?= $titular; ?></h3>

	<table class="listadoTablas tablasDataTable" id="tablaImagenes">
		<thead>
			<tr>
				<th></th>
				<th class="textoLeft cursorPointer">Publicada</th>
				<th class="textoLeft cursorPointer">Nombre</th>
				<th>Editar</th>
				<th>Borrar</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ( $todoImagenes as $clave ) { ?>
		<tr id="js-fila_<?= $clave['id']; ?>">

			<?php $miniatura = base_url()."/../images/images/".$clave['ruta']; ?>
			<td class="ancho50 textoCentrado"><img src="<?= $miniatura; ?>" width="50" height="25" /></td>

			<td class="fuente085" style="width:160px;"><?= $clave['indexacion']; ?></td>

			<td id="js-nombre_<?= $clave['id']; ?>" class="fuente085"><?= $clave['nombre']; ?></td>

			<td class="ancho50 textoCentrado">
				<a href="<?= base_url(); ?>admin/addImagen/<?= $clave['id']; ?>">
					<img src="<?= base_url(); ?>css/iconos/ico-editar.png" widht="20" height="20" id="js-editar_<?= $clave['id']; ?>" />
				</a>
			</td>
			<td class="ancho50 textoCentrado">
				<img src="<?= base_url(); ?>css/iconos/ico-borrar.png" widht="20" height="20" id="js-borrar_<?= $clave['id']; ?>" class="js-borrarImagenes cursorPointer" />
			</td>

		</tr>
		<?php } ?>
	</tbody>

	</table>



<!-- Dialogs -->

<div id="dialog-borrar" class="dialogos" title="Borrar imagen" style="display:none;">
	<form action="<?= base_url(); ?>admin/deleteImagen" id="dialogBorrarFormulario" method="post">
	<div class="bordeGrisBottom marginBottom-01" style="padding-bottom:1em;">Atención, esta acción es irreversible. ¿Quieres borrar esta imagen?</div>			
	<div class="textoRight">
		<span id="js-cancelarDialog" class="botonRojo" style="margin-right:10px;">cancelar</span>
		<span id="js-borrarDialog" class="botonAzul">borrar</span>
	</div>
	<input type="hidden" name="idImagen" id="idImagen" value="">
	</form>
</div>



<script>
(function(window, undefined){

	$(document).ready(function() {
		
		$(".js-borrarImagenes").click(function() {

			var id = $(this).attr('id');
			id = id.replace("js-borrar_","");
			$("#idImagen").val(id);

			$( "#dialog-borrar" ).dialog({
			    resizable: false,
			    height:160,
			    modal: true
		    });

		    $('#js-cancelarDialog').click(function() {
		    	$( "#dialog-borrar" ).dialog( "close" );
		    	$( this ).unbind( "click" );
		    });

		    $('#js-borrarDialog').click(function() {
		    	$( "#dialogBorrarFormulario" ).submit();
		    });

		});

		$('#tablaImagenes').dataTable( {
			"aaSorting": [[ 1, "desc" ]],
			"oLanguage": {
						    "sProcessing":     "Procesando...",
						    "sLengthMenu":     "Mostrar _MENU_ imágenes",
						    "sZeroRecords":    "No se encontraron imágenes",
						    "sEmptyTable":     "Ningún dato disponible en esta tabla",
						    "sInfo":           "Imágenes: _START_ al _END_ de un total de _TOTAL_ imágenes",
						    "sInfoEmpty":      "Mostrando imágenes del 0 al 0 de un total de 0 imágenes",
						    "sInfoFiltered":   "(filtrado de un total de _MAX_ imágenes)",
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