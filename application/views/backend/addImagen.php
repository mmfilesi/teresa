	<style>
		.ui-dialog-title {
			font-size: 0.8em;
		}
	</style>

	<?php $action = ( $accion != "edit" ) ? base_url().'admin/insertImagen' : base_url().'admin/updateImagen'; ?>

	<?php if ( $accion == "edit" ) { ?>
		<div class="floatRight" id="js-borrrarImagen" style="margin-top: 20px;">
			<img src="<?= base_url(); ?>css/iconos/ico-borrar.png" widht="20" height="20" alt="borrar imagen" title="borrar imagen" class="cursorPointer" id="js-borrarImagen" />		
		</div>
	<?php } ?>

	<h3 class="azul_0777eb"><?= $titular; ?></h3>

	<form id="formularioImagen" action="<?= $action; ?>" method="post"  enctype="multipart/form-data" class="fuente08">

		<div id="primerEstrato" class="bordeGrisBottom marginBottom-01">

		<!-- datos básicos -->
			<div class="inlineBlock ancho50c verticalTop">

				<p><label for="imagenNombre"><span class="negrita">Nombre</span></label>	<br />
				<input type="text" name="imagenNombre" id="imagenNombre" class="inputText" 
				<?php if ( $accion == "edit" ) { ?>
					value="<?= $todoImagen['nombre']; ?>"
				<?php } ?>
				tabindex="1" /></p>

				<p><label for="imagenFecha"><span class="negrita">Fecha</span></label> <br />	
				<input type="text" name="imagenFecha" id="imagenFecha" class="inputText" 
				<?php if ( $accion == "edit" ) { ?>
					value="<?= $todoImagen['fecha']; ?>"
				<?php } ?>
				tabindex="2" /></p>

				<p><label for="imagenLugar"><span class="negrita">Lugar</span></label> <br />	
				<input type="text" name="imagenLugar" id="imagenLugar" class="inputText" 
				<?php if ( $accion == "edit" ) { ?>
					value="<?= $todoImagen['lugar']; ?>"
				<?php } ?>
				tabindex="3" /></p>

			</div><!-- #datos básicos -->

			<!-- imagen -->
			<div class="inlineBlock ancho50c verticalTop" style="margin-bottom:2em;">

				<p><span class="negrita">Imagen</span></p>
					<?php if ( ( $accion == "edit" ) AND ( $todoImagen['ruta'] != "pendiente" ) AND ( $todoImagen['ruta'] != "" ) ) { ?>
						<div id ="js-contenedorImagenDestacada">								
							<img src="<?= base_url(); ?>/images/images/<?= $todoImagen['ruta']; ?>" width="250" height="150" />
							<input type="hidden" name="imagenRuta"  id="imagenRuta" value="<?= $todoImagen['ruta']; ?>" />	
						</div>
				<?php } else { ?>
						<p><input type="file" name="imagenRuta" id="imagenRuta" class=""></p>
				<?php } ?>

			</div> <!-- #imagen -->

		</div>

		<div id="segundoEstrato" class="bordeGrisBottom marginBottom-01">

		<!-- álbum -->
			<div class="inlineBlock ancho50c verticalTop"  style="margin-bottom:2em;">

					<label for="imagenAlbum"><span class="negrita">Álbum</span></label>	<br />
					<select name="imagenAlbum[]" id="imagenAlbum" class="inputText" multiple tabindex="4">
						<option value="0">ninguno</option>

						<?php if ( $todoAlbums && count($todoAlbums) > 0 ) {
							foreach ( $todoAlbums as $clave ) { ?>
								<option value="<?= $clave['id']; ?>"
									<?php if ( $accion == "edit" && in_array($clave['id'], $todoAlbumsImagen) ) { ?>
										selected
									<?php } ?>
								><?= $clave['nombre']; ?></option>
					 	<?php }
						} ?>
					</select>
				
			</div> <!-- #álbum  -->

			 <!-- tags -->
			<div class="inlineBlock ancho50c verticalTop" style="margin-bottom:2em;">

				<label for="imagenTags"><span class="negrita">Etiquetas</span> </label>	<br />

				<input type="text" name="imagenTags" id="imagenTags" class="inputText" placeholder="separadas por comas" tabindex="5" />
				<span id="js-addTag" class="botonRedondo">+</span>

				<div id="contenedorTags" style="margin-top:5px;">
					<?php if ( $accion == "edit" AND count($todoTagsImagen) > 0 ) { ?>
						<?php $contador = 0; ?>
						<?php foreach ( $todoTagsImagen as $clave ) { ?>
							<span id='js-tag-<?= $contador; ?>' class='listadoTags'>&otimes; <?= $clave['value']; ?></span>
							<?php $contador++; ?>
						<?php } ?>
					<?php } ?>
				</div>
			</div><!-- #tags -->	

		</div>

		<div id="tercerEstrato" class="bordeGrisBottom marginBottom-01">

			<p><span class="negrita">Descripción</span><br />
			<textarea name="imagenDescripcion" id="imagenDescripcion" class="ancho250 azul_0777eb" tabindex="6"><?php if ( $accion == "edit") { echo $todoImagen['descripcion']; } ?></textarea></p>

		</div>

		<?php if ( $accion == "edit" ) { ?>
			<input type="hidden" name="idImagen" id="idImagen" value="<?= $todoImagen['id']; ?>" />
		<?php } ?>
		<?php if ( $accion == "edit" AND count($todoTagsImagen) > 0 ) { ?>
				<?php $contador = 0; ?>
				<?php foreach ( $todoTagsImagen as $clave ) { ?>
					<input type='hidden' id='input-tag-<?= $contador; ?>' name='inputTags[<?= $contador; ?>]' value='<?= $clave['value']; ?>' />
				<?php $contador++; ?>
				<?php } ?>
			<?php } ?>	

		<span id="js-guardar" class="botonAzul floatRight">guardar</span>

	</form>

</article>

</div> <!-- #layoutContainer -->

<!-- Dialogs -->

	<?php if ( $accion == "edit" ) { ?>
		
		<div id="dialog-borrar" class="dialogos" title="Borrar imagen" style="display:none;">
			<form action="<?= base_url(); ?>admin/deleteImagen" id="dialogBorrarFormulario" method="post">
			<div class="bordeGrisBottom marginBottom-01" style="padding-bottom:1em;">Atención, esta acción es irreversible. ¿Quieres borrar esta imagen?</div>			
			<div class="textoRight">
				<span id="js-cancelarDialog" class="botonRojo" style="margin-right:10px;">cancelar</span>
				<span id="js-borrarDialog" class="botonAzul">borrar</span>
			</div>
			<input type="hidden" name="idImagen" value="<?= $todoImagen['id']; ?>">
			</form>
		</div>

	<?php } ?>	



<script>
(function(window, undefined){

	$(document).ready(function() {

		var utilidadesFormulario = function() {

			this.init = function() {
				utilidadesFormulario.datePicker();
				utilidadesFormulario.tinyMCE();
				utilidadesFormulario.tags();
			},

			/* Datepicker */
			this.datePicker = function() {

				$(function() {
				    $( "#imagenFecha" ).datepicker({
				      defaultDate: "+1w",
				      changeMonth: true,
				      numberOfMonths: 3,
				      onClose: function( selectedDate ) {
				        $( "#fecha" ).datepicker( "option", "minDate", selectedDate );
				      }
				    });
			  	});

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

			}, /* #Datepicker */

			/* Editor */
			this.tinyMCE = function() {
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
			}, /* #Editor */

			this.tags = function() {

				$("#js-addTag").click(function(event) {

					event.preventDefault();

					var cadena = "";
					var cadena2 = "";
					var arrayTags = $("#imagenTags").val();
					var tagsYaListados = $(".listadoTags").length;
					var contador;

					if ( arrayTags != "" ) {

					arrayTags = arrayTags.split(",");

					for ( var i=0; i < arrayTags.length; i++ ) {
							contador = i+tagsYaListados;
							cadena += "<span id='js-tag-"+contador+"' class='listadoTags'>&otimes; "+arrayTags[i]+"</span>";
							cadena2 = "<input type='hidden' id='input-tag-"+contador+"' name='inputTags["+contador+"]' value='"+arrayTags[i]+"' />";
							$("#js-guardar").before(cadena2);
						}

						$("#contenedorTags").prepend(cadena);
						$("#imagenTags").val("");

					}

				});

				$("#contenedorTags").on("click",".listadoTags", function() {
					var id = $(this).attr('id');
					id = id.replace("js-tag-", "");
					id = "#input-tag-"+id;
					$(id).remove();
					$(this).remove();
				});
			} /* #Tags */

		} /* #utilidadesFormulario */

		var envioFormulario = function() {

			this.init = function() {
				envioFormulario.controlDatos();
				<?php if ( $accion == "edit" ) { ?>
					envioFormulario.borrarImagen();
				<?php } ?>
			},

			this.controlDatos = function() {

				$("#js-guardar").click(function(event) {
					event.preventDefault();
					var check = 0;
					var temporal;
					var cadena = "<div class='roja_dd0909 negrita'>El texto es demasiado largo</div>";
					var imagenCheck = $('#imagenRuta').val();
					
					var inputsCheck = ['#imagenNombre','#imagenLugar'];

					for ( var i=0; i< inputsCheck.length; i++ ) {
						temporal = $(inputsCheck[i]).val();
						if ( temporal.length > 250 ) {
							$(inputsCheck[i]).after(cadena);
							check = 1;
						}
					}

					cadena = "<div class='roja_dd0909 negrita' id='js-sinImagen'>Falta subir la imagen</div>";

					if ( imagenCheck == "" || imagenCheck === undefined ) {
						$('#imagenRuta').after(cadena);
						check = 1;
						$('#imagenRuta').click(function() {
							$('#js-sinImagen').remove();
						});
					}

					if ( check == 0 ) {
						$("#formularioImagen").submit();
					}

				});

			}, /* #controlDatos */

			this.borrarImagen = function() {			

				$("#js-borrarImagen").click(function() {
					$( "#dialog-borrar" ).dialog({
					    resizable: false,
					    height:160,
					    modal: true
				    });

				    $('#js-cancelarDialog').click(function() {
				    	$( "#dialog-borrar" ).dialog( "close" );
				    });

				    $('#js-borrarDialog').click(function() {
				    	$( "#dialogBorrarFormulario" ).submit();
				    });  			

				});			

			}  /* #borrarImagen */

		} /* #envioFormulario */

		var utilidadesFormulario = new utilidadesFormulario();
		utilidadesFormulario.init();
		var envioFormulario = new envioFormulario();
		envioFormulario.init();


	});

})( window );  
</script>