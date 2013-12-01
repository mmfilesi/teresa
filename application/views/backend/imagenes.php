<script src="<?=base_url()?>js/vendor/datatable/jquery.dataTables.min.js"></script> 

<style>

/* ==========================================================================
   Datatable
   ========================================================================== */

	.dataTables_wrapper {
	    background-color: #f1f1f1;
	    border-top: 1px solid #e9eaea;
	    border-left: 1px solid #e9eaea;
	    border-bottom: 1px solid #d8d6d6;
	    border-right: 1px solid #d8d6d6;
	    border-radius: 5px;
	    overflow: hidden;
	    width:100%;
	    padding: 0.2em;
	}

	.dataTables_length {
	    float:left;
	    font-size: 0.8em;
	    padding: 6px;
	}

	.dataTables_filter {            
	    font-size: 0.8em;
	    float:right;
	    padding: 6px;
	}

	.dataTables_info {
	    float:left;
	    font-size: 0.8em;
	    padding: 10px;
	}

	.dataTables_paginate {
	    font-size: 0.8em;
	    float:right;
	    padding: 10px;
	}


	.tablasDataTable {
	    margin-top: 0.2em;
	}

	.listadoTablas {
	   width:100%;
	}

	.listadoTablas th {
	    padding:0.4em;
	    border-bottom: 1px solid #999;
	    border-top: 1px solid #999;         
	    background-color: #e2e2e2;
	    font-size: 0.85em;
	    color:#333;
	}

	.listadoTablas td {
	    padding:0.4em;
	    border-bottom: 1px solid #ededed;
	    font-size: 0.8em;           
	}

	.listadoTablas tr:nth-child(even) {
	    background: #f8f8f8;
	}

	.listadoTablas tr:nth-child(odd) {
	    background: #fff;
	}

	.listadoTablas tr:hover {
	    background: #ffcc33;
	}

	/* Two button pagination - previous / next */
	.paginate_disabled_previous,
	.paginate_enabled_previous,
	.paginate_disabled_next,
	.paginate_enabled_next {
	    height: 19px;
	    float: left;
	    cursor: pointer;
	    *cursor: hand;
	    color: #111 !important;
	}
	.paginate_disabled_previous:hover,
	.paginate_enabled_previous:hover,
	.paginate_disabled_next:hover,
	.paginate_enabled_next:hover {
	    text-decoration: none !important;
	}
	.paginate_disabled_previous:active,
	.paginate_enabled_previous:active,
	.paginate_disabled_next:active,
	.paginate_enabled_next:active {
	    outline: none;
	}

	.paginate_disabled_previous,
	.paginate_disabled_next {
	    color: #666 !important;
	}
	.paginate_disabled_previous,
	.paginate_enabled_previous {
	    padding-left: 23px;
	}
	.paginate_disabled_next,
	.paginate_enabled_next {
	    padding-right: 23px;
	    margin-left: 10px;
	}

	.paginate_enabled_previous { background: url('<?=base_url()?>/css/images/back_enabled.png') no-repeat top left; }
	.paginate_enabled_previous:hover { background: url('<?=base_url()?>/css/images/back_enabled_hover.png') no-repeat top left; }
	.paginate_disabled_previous { background: url('<?=base_url()?>/css/images/back_disabled.png') no-repeat top left; }

	.paginate_enabled_next { background: url('<?=base_url()?>/css/images/forward_enabled.png') no-repeat top right; }
	.paginate_enabled_next:hover { background: url('<?=base_url()?>/css/images/forward_enabled_hover.png') no-repeat top right; }
	.paginate_disabled_next { background: url('<?=base_url()?>/css/images/forward_disabled.png') no-repeat top right; }


	.sorting_asc {
	    background: url('<?=base_url()?>/css/images/sort_asc.png') no-repeat center right;
	}

	.sorting_desc {
	    background: url('<?=base_url()?>/css/images/sort_desc.png') no-repeat center right;
	}

	.sorting {
	    background: url('<?=base_url()?>/css/images/sort_both.png') no-repeat center right;
	}

	.sorting_asc_disabled {
	    background: url('<?=base_url()?>/css/images/sort_asc_disabled.png') no-repeat center right;
	}

	.sorting_desc_disabled {
	    background: url('<?=base_url()?>/css/images/sort_desc_disabled.png') no-repeat center right;
	}


	.ui-dialog-title {
		font-size: 0.8em;
	}

</style>

	<table class="listadoTablas tablasDataTable" id="tablaImagenes">
		<thead>
			<tr>
				<th></th>
				<th class="textoLeft cursorPointer">Álbum</th>
				<th>Editar</th>
				<th>Borrar</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ( $todoImagenes as $clave ) { ?>
		<tr id="js-fila_<?= $clave['id']; ?>">

			<?php $miniatura = base_url()."/../images/images/".$clave['ruta']; ?>
			<td class="ancho50 textoCentrado"><img src="<?= $miniatura; ?>" width="50" height="25" /></td>
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