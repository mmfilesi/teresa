<div class="layoutContainer">

<?= $sidebar; ?>

<article id="developArea" class="bordesRedondeados10 bordeGris ">

<h3 class="azul_0777eb"><?= $titular; ?></h3>

	<?php $action = ( $accion != "edit" ) ? base_url().'admin/insertAlbum' : base_url().'admin/updateAlbum'; ?>

	<form action="<?= $action; ?>" method="post"  enctype="multipart/form-data" class="fuente08">

		<div id="primerEstrato" class="bordeGrisBottom marginBottom-01">

		<!-- datos básicos -->
			<div class="inlineBlock ancho50c verticalTop">	
				<p><label for="albumNombre"><span class="negrita">Nombre</span></label>	<br />
				<input type="text" name="albumNombre" id="albumNombre" class="ancho250 azul_0777eb" 
				<?php if ( $accion == "edit" ) { ?>
					value="<?= $todoAlbum['nombre']; ?>"
				<?php } ?>
				/></p>

				<p><label for="albumFecha"><span class="negrita">Fecha</span></label> <br />	
				<input type="text" name="albumFecha" id="albumFecha" class="ancho250 azul_0777eb" 
				<?php if ( $accion == "edit" ) { ?>
					value="<?= $todoAlbum['fecha']; ?>"
				<?php } ?>
				/></p>

				<p><label for="albumLugar"><span class="negrita">Lugar</span></label> <br />	
				<input type="text" name="albumLugar" id="albumLugar" class="ancho250 azul_0777eb" 
				<?php if ( $accion == "edit" ) { ?>
					value="<?= $todoAlbum['lugar']; ?>"
				<?php } ?>
				/></p>

				<p><input type="checkbox" name="albumGoogle" id="albumGoogle" value="1" class="azul_0777eb" 
				<?php if ( $accion == "edit" AND $todoAlbum['google_maps'] == 1 ) { ?>
					checked
				<?php } ?>
				/><label for="albumGoogle"> Mostrar en google Maps</label></p>

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
						<p><input type="file" name="imagenDestacada"></p>
				<?php } ?>

			</div> <!-- #imagen destacada -->

		</div>

		<div id="segundoEstrato" class="bordeGrisBottom marginBottom-01">

		<!-- categorías -->
			<div class="inlineBlock ancho50c verticalTop">

				<span class="negrita">Categorías</span> 

				<div id="contenedorCategorias" class="alto100s ancho250">
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

				<p><br />
				<input type="text" name="addCategoria" id="addCategoria" class="ancho250 azul_0777eb" /> <button id="js-addCategoria" class="botonMas">+</button>
				</p>

			</div> <!-- #categorías -->

			 <!-- tags -->
			<div class="inlineBlock ancho50c verticalTop">

				<label for="albumTags"><span class="negrita">Etiquetas</span> </label>	<br />

				<input type="text" name="albumTags" id="albumTags" class="ancho250 azul_0777eb" placeholder="separadas por comas"/>
				<button id="js-addTag" class="botonMas">+</button>

				<div id="contenedorTags">
					<?php if ( $accion == "edit" AND count($todoTagsAlbum) > 0 ) { ?>
						<?php $contador = 0; ?>
						<?php foreach ( $todoTagsAlbum as $clave ) { ?>
							<span id='js-tag-<?= $contador; ?>' class='listadoTags'>&otimes; <?= $clave['value']; ?></span>
							<?php $contador++; ?>
						<?php } ?>
					<?php } ?>
				</div>
			</div><!-- #tags -->	

		</div>

		<div id="tercerEstrato" class="bordeGrisBottom marginBottom-01">

			<p><span class="negrita">Descripción</span><br />
			<textarea name="albumDescripcion" id="albumDescripcion" class="ancho250 azul_0777eb"><?php if ( $accion == "edit") { echo $todoAlbum['descripcion']; } ?></textarea></p>

		</div>

		<?php if ( $accion == "edit" ) { ?>
			<input type="hidden" name="idAlbum" id="idAlbum" value="<?= $todoAlbum['id']; ?>" />
		<?php } ?>
		<?php if ( $accion == "edit" AND count($todoTagsAlbum) > 0 ) { ?>
				<?php $contador = 0; ?>
				<?php foreach ( $todoTagsAlbum as $clave ) { ?>
					<input type='hidden' id='input-tag-<?= $contador; ?>' name='inputTags[<?= $contador; ?>]' value='<?= $clave['value']; ?>' />
				<?php $contador++; ?>
				<?php } ?>
			<?php } ?>	

		<button id="js-guardar" class="azul floatRight">guardar</button>

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

		//

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

	});

	// Interactivismos formulario

	$("#js-addCategoria").click(function(event) {

		event.preventDefault();

		var value = $('#addCategoria').val();

		if ( value != "" ) {
			data = { 'value': value };
			$.post("<?= site_url('admin/insertCategoria'); ?>", data).done(function(data) {
				$("#contenedorCategorias").html(data);
			});
		}

	});

	$("#js-cambiar").click(function() {
		var cadena = "<p><input type='file' name='imagenDestacada'></p>";
		$('#js-contenedorImagenDestacada').html(cadena);
	});

	$("#js-addTag").click(function(event) {

		event.preventDefault();

		var cadena = "";
		var cadena2 = "";
		var arrayTags = $("#albumTags").val();
		var tagsYaListados = $(".listadoTags").length;
		var contador;

		arrayTags = arrayTags.split(",");

		for ( var i=0; i < arrayTags.length; i++ ) {
			contador = i+tagsYaListados;
			cadena += "<span id='js-tag-"+contador+"' class='listadoTags'>&otimes; "+arrayTags[i]+"</span>";
			cadena2 = "<input type='hidden' id='input-tag-"+contador+"' name='inputTags["+contador+"]' value='"+arrayTags[i]+"' />";
			$("#js-guardar").before(cadena2);
		}

		$("#contenedorTags").prepend(cadena);
		$("#albumTags").val("");

	});

	$("#contenedorTags").on("click",".listadoTags", function() {
		var id = $(this).attr('id');
		id = id.replace("js-tag-", "");
		id = "#input-tag-"+id;
		$(id).remove();
		$(this).remove();
	});



})( window );  
</script>