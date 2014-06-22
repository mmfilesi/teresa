<style>
	.ui-state-highlight { 
	    display:inline-block;
	    margin: 10px;
	    height: 110px;
	    width: 200px; 
	}
</style>
		
		<h3 class="azul_0777eb"><?= $titular; ?></h3>

		<?php $contador = 1; ?>	
		<div id="js-sortable" class="layoutMiniaturaContenedor">
		<?php foreach ( $todoAlbums as $clave ) { ?>				
			<?php 
				if ( $clave['imagen_destacada'] != "pendiente" ) {
					$imagenDestacada = $clave['imagen_destacada'];
					$imagenDestacada = explode(".", $imagenDestacada);
					$miniatura = base_url()."/images/albums/".$clave['id']."/".$imagenDestacada[0]."_thumb.".$imagenDestacada[1];
				} else {
					$miniatura = base_url()."/images/noThumbail.png";
				}
			?>

			<div class="layoutMiniatura" id="js-capsula_<?= $clave['id']; ?>">
				<img src="<?= $miniatura; ?>" width="190" height="95" />
				<div class="layoutMiniaturaTitular"><span class="js-numerosMiniatura negrita"><?= $contador; ?></span>. <?= $clave['nombre']; ?></div>
			</div>

		<?php $contador++; ?>	

		<?php } ?>

		</div>

<script>
(function(window, undefined){

	$(document).ready(function() {
		
		$(function() {
		    $( "#js-sortable" ).sortable({
				placeholder:"ui-state-highlight",
				update : function () { 
					var ordenAlbums = $(this).sortable("toArray").toString(); 					
					$.post('<?= base_url(); ?>admin/ordenarAlbumsUpdate', {'ordenAlbums':ordenAlbums} , function(data) {
						var contador = 1;
						$(".js-numerosMiniatura").each(function() {
							$(this).text(contador);
							contador++;
						})				
					});

				} //#Update
			}); //#sortable


		    $( "#js-sortable" ).disableSelection();
		});

	});
		
})( window );  
</script>