	<table class="listadoTablas">
		<tr>
			<th></th>
			<th class="textoLeft">Álbum</th>
			<th>Imgs</th>
			<th>Editar</th>
			<th>Borrar</th>
		</tr>

		<?php foreach ( $todoAlbums as $clave ) { ?>
		<tr id="js-fila_<?= $clave['id']; ?>">
			<td class="ancho50 textoCentrado"><img src="<?= base_url(); ?>/images/albums/<?= $clave['id']; ?>/<?= $clave['imagen_destacada']; ?>" width="50" height="25" /></td>
			<td id="js-nombre_<?= $clave['id']; ?>"><?= $clave['nombre']; ?></td>
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

	});
		
})( window );  
</script>