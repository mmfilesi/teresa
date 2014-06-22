	<?php $action = ( $accion != "edit" ) ? base_url().'admin/insertAlbum' : base_url().'admin/updateAlbum'; ?>

	<h3 class="azul_0777eb"><?= $titular; ?></h3>

	<form id="formularioAlbum" action="<?= $action; ?>" method="post"  enctype="multipart/form-data" class="fuente08">

		<div id="primerEstrato" class="bordeGrisBottom marginBottom-01">

		<!-- datos básicos -->
			<div class="inlineBlock ancho50c verticalTop">	
				<p><label for="albumNombre"><span class="negrita">Nombre</span></label>	<br />
				<input type="text" name="albumNombre" id="albumNombre" class="inputText" 
				<?php if ( $accion == "edit" ) { ?>
					value="<?= $todoAlbum['nombre']; ?>"
				<?php } ?>
				/></p>

				<p><label for="albumFecha"><span class="negrita">Fecha</span></label> <br />	
				<input type="text" name="albumFecha" id="albumFecha" class="inputText fuenteDatePickers" 
				<?php if ( $accion == "edit" ) { ?>
					value="<?= $todoAlbum['fecha']; ?>"
				<?php } ?>
				/></p>

				<p><label for="albumLugar"><span class="negrita">Lugar</span></label> <br />	
				<input type="text" name="albumLugar" id="albumLugar" class="inputText" 
				<?php if ( $accion == "edit" ) { ?>
					value="<?= $todoAlbum['lugar']; ?>"
				<?php } ?>
				/></p>

			</div><!-- #datos básicos -->

			<!-- imagen destacada -->
			<div class="inlineBlock ancho50c verticalTop">

				<p><span class="negrita">Imagen destacada</span></p>
					<?php if ( ( $accion == "edit" ) AND ( $todoAlbum['imagen_destacada'] != "pendiente" ) AND ( $todoAlbum['imagen_destacada'] != "" ) ) { ?>
						<div id ="js-contenedorImagenDestacada">
							<p><button id="js-cambiar" class="verde floatRight">cambiar</button>	
							<img src="<?= base_url(); ?>/images/albums/<?= $todoAlbum['id']; ?>/<?= $todoAlbum['imagen_destacada']; ?>" width="250" height="150" />
							<input type="hidden" name="imagenDestacadaSubida" value="<?= $todoAlbum['imagen_destacada']; ?>" /></p>	
						</div>
				<?php } else { ?>
						<p><input type="file" name="imagenDestacada" class=""></p>
				<?php } ?>

			</div> <!-- #imagen destacada -->

		</div>

		<div id="segundoEstrato" class="bordeGrisBottom marginBottom-01">

		<!-- categorías -->
			<div class="inlineBlock ancho50c verticalTop" style="height:175px;">
				<span class="negrita">Categorías</span>
				<div id="contenedorCategorias" class="caja barraAzul">
					<?php if ( $todoCategorias AND count($todoCategorias) > 0 ) { ?>

						<?php foreach ( $todoCategorias as $clave ) { ?>
							<input type="checkbox" name="albumCategorias[<?= $clave['id']; ?>]" value="<?= $clave['id']; ?>" class="azul_0777eb" 

							 <?php if ( $accion == "edit" AND count($todoCategoriasAlbum) > 0 ) {
							 		foreach ( $todoCategoriasAlbum as $clave2 ) { 
							 			if ( $clave['id'] ==  $clave2['id_categoria'] ) { ?>						 			
							 			checked
							 		<?php } ?>
								<?php } ?>
							<?php } ?>

							/> 
							<?= $clave['value']; ?> <br />
					<?php } ?>
				<?php } ?>
				</div>				
			</div>	

			<div class="inlineBlock ancho50c verticalTop">
				<input type="text" name="addCategoria" id="addCategoria" class="inputText" placeholder="Añadir categoría" /> <span id="js-addCategoria" class="botonRedondo">+</span>
			</div> 


		</div>

		<div id="tercerEstrato" class="bordeGrisBottom marginBottom-01">

			<p><span class="negrita">Descripción</span><br />
			<textarea name="albumDescripcion" id="albumDescripcion" class="ancho250 azul_0777eb"><?php if ( $accion == "edit") { echo stripslashes($todoAlbum['descripcion']); } ?></textarea></p>

		</div>

		<?php if ( $accion == "edit" ) { ?>
			<input type="hidden" name="idAlbum" id="idAlbum" value="<?= $todoAlbum['id']; ?>" />
		<?php } ?>

		<div id="js-guardar" class="botonAzul floatRight">guardar</div>

	</form>

</article>

</div> <!-- #layoutContainer -->

<script>
(function(window, undefined){

	$(document).ready(function() {

		$(".cambiarImagen").click(function() {
			var nImage = parseInt($(this).attr("id").replace("cambiarFicha_",""));
			cadena = "<input type='file' name='imagenFicha"+nImage+"' id='imagenFicha"+nImage+"' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' role='button' aria-disabled='false'>";
			$("#contenedorImagenFicha"+nImage).html(cadena); 
		});

		$("#imagen_cabecera").click(function() {
			cadena = "<input type='file' name='imagenFichaMP' id='imagenFichaMP' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' role='button' aria-disabled='false'>";
			$("#contenedorImagenFichaMP").html(cadena); 
		});


		$(function() {
		    $( "#albumFecha" ).datepicker({
		      defaultDate: "+1w",
		      changeMonth: true,
		      numberOfMonths: 3,
		      onClose: function( selectedDate ) {
		        $( "#fecha" ).datepicker( "option", "minDate", selectedDate );
		      }
		    });
	  	});

	  	// Traducción al español
		$(function($){
			$.datepicker.regional['es'] = {
				closeText: 'Cerrar',
				prevText: '<Ant',
				nextText: 'Sig>',
				currentText: 'Hoy',
				monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
				weekHeader: 'Sm',
				dateFormat: 'dd-mm-yy',
				firstDay: 1,
				isRTL: false,
				showMonthAfterYear: false,
				yearSuffix: ''
			};
			$.datepicker.setDefaults($.datepicker.regional['es']);
		});
		
		// Tiny
		tinyMCE.init({
			mode : "textareas",
			language : 'es',
			browser_spellcheck : true,
			plugins: [
         				"advlist autolink link lists charmap print preview hr anchor pagebreak spellchecker",
        				"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
        				"save table contextmenu directionality paste textcolor"
					],
			toolbar: "forecolor backcolor | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent"
		}); 


		// Interactivismos formulario

		$("#js-addCategoria").click(function(event) {

			event.preventDefault();
	 
			var value = $('#addCategoria').val();

			if ( value != '' ) {
				data = { 'value': value };
				$.post("<?= site_url('admin/insertCategoria'); ?>", data).done(function(data) {				
					$('#contenedorCategorias').prepend(data);
					$('#addCategoria').val('');
				});
			}

		});

		$("#js-cambiar").click(function() {
			var cadena = "<p><input type='file' name='imagenDestacada'></p>";
			$('#js-contenedorImagenDestacada').html(cadena);
		});

		$("#js-guardar").click(function(event) {

			event.preventDefault();
			var check = 0;
			var temporal;
			var cadena = "<div class='roja_dd0909 negrita'>El texto es demasiado largo</div>";
			var imagenCheck = $('#imagenDestacada').val();
			
			var inputsCheck = ['#albumNombre','#albumLugar'];

			for ( var i=0; i< inputsCheck.length; i++ ) {
				temporal = $(inputsCheck[i]).val();
				if ( temporal.length > 250 ) {
					$(inputsCheck[i]).after(cadena);
					check = 1;
				}
			}

			if ( check == 0 ) {
				$("#formularioAlbum").submit();
			}

		});	

	});

})( window );  
</script>