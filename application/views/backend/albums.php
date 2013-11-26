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

</style>

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
<div id="dialog-borrar" class="dialogos" title="Borrar álbum" style="display:none;s">
	Atención, esta acción es irreversible. Se borrará el álbum <span id="js-nombreAlbum" class="negrita"></span>,
	aunque <span class="negrita">no</span> se borrarán sus imágenes asociadas.
</div>



<script>
(function(window, undefined){

	$(document).ready(function() {
		
		$(".js-borrarAlbums").click(function() {

			var id = $(this).attr('id');
			id = id.replace("js-borrar_","");

			var nombre = "#js-nombre_"+id;
			nombre = $(nombre).text();
			$("#js-nombreAlbum").text(nombre);

			$( "#dialog-borrar" ).dialog({
			    resizable: false,
			    height:250,
			    modal: true,
			    buttons: {
			        "Borrar álbum": function() {
			          $( this ).dialog( "close" );
			          var data = {};
			          data = {'id':id};
			          $.post("<?= base_url(); ?>admin/deleteAlbum", data).done(function() {
			          	id = "#js-fila_"+id;
			          	$(id).remove();
			          });
			        },
			        Cancelar: function() {
			          $( this ).dialog( "close" );
			        }
		      	}
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