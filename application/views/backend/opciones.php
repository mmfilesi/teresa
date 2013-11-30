	<!-- Generales -->
	<div id="js-despliegaGenerales" class="botonRedondo floatRight fuente08 js-desplegador">+</div>
	<h4 class="versalitas fuente11" style="margin-bottom:0.2em;">Generales</h4>

	<form id="js-formularioGenerales" action="#" method="post"  enctype="multipart/form-data">
		<div id="estratoGenerales" class="bordeGrisBottom marginBottom-01 displayTable ancho100c" style="display:none;">
			
			<div class="displayRow fuente08 ancho100c">
				<div class="displayCell ancho50c verticalTop">
					<p>	
						<label for="maxWidth"><span class="negrita">Título del sitio</span></label><br />
						<input type="text" name="titular" id="titular" class="inputText" value="<?= $todoOpciones[2]['value']; ?>"/>						
					</p>
				</div>
				<div class="displayCell ancho50c verticalTop">
				</div>
			</div>
			<div class="displayRow fuente08 ancho100c">
				<div class="displayCell ancho50c verticalTop">
				</div>
				<div class="displayCell ancho50c verticalTop">
				</div>
			</div>

			<div class="displayRow ancho100c" style="height:70px;">

				<div class="displayCell ancho50c verticalTop" style="padding-top:20px;">
					<span id="js-recuperarGenerales" class="botonBlanco fuente08 ">valores por defecto</span>
				</div>

				<div class="displayCell ancho50c verticalTop textoRight" style="padding-top:20px;">					
					<span id="js-guardarGenerales" class="botonAzul fuente08">guardar</span>					
				</div>

			</div>

		</div>
	</form>
	<!-- #Generales -->


	<!-- Imágenes -->
	<form id="js-formularioImagenes" action="#" method="post"  enctype="multipart/form-data">

		<div id="js-despliegaImagenes" class="botonRedondo floatRight fuente08 js-desplegador">+</div>
		<h4 class="versalitas fuente11" style="margin-bottom:0.2em;">Imágenes</h4>

		<div id="estratoImagenes" class="bordeGrisBottom marginBottom-01 displayTable ancho100c" style="display:none;">		

			<div class="displayRow fuente08 ancho100c">

				<div class="displayCell ancho50c verticalTop">				
					<p>	
						<label for="maxWidth"><span class="negrita">Ancho máximo imágenes</span></label><br />
						<input type="text" name="maxWidth" id="maxWidth" class="inputText" value="<?= $todoOpciones[2]['value']; ?>"/>						
					</p>
					<p>	
						<label for="maxHeight"><span class="negrita">Alto máximo imágenes</span></label><br />
						<input type="text" name="maxHeight" id="maxHeight" class="inputText" value="<?= $todoOpciones[3]['value']; ?>"/>						
					</p>
				</div>

				<div class="displayCell ancho50c verticalTop">				
					<p> 
						<label for="maxWidthThumb"><span class="negrita">Ancho máximo miniaturas</span></label><br />
						<input type="text" name="maxWidthThumb" id="maxWidthThumb" class="inputText" value="<?= $todoOpciones[0]['value']; ?>"/>
						
					</p>
					<p>
						<label for="maxHeightThumb"><span class="negrita">Alto máximo miniaturas</span></label><br />
						<input type="text" name="maxHeightThumb" id="maxHeightThumb" class="inputText" value="<?= $todoOpciones[1]['value']; ?>"/>			
					</p>
				</div>

			</div>

			<div class="displayRow ancho100c" style="height:70px;">

				<div class="displayCell ancho50c verticalTop" style="padding-top:20px;">
					<span id="js-recuperarImagenes" class="botonBlanco fuente08 ">valores por defecto</span>
				</div>

				<div class="displayCell ancho50c verticalTop textoRight" style="padding-top:20px;">					
					<span id="js-guardarImagenes" class="botonAzul fuente08">guardar</span>					
				</div>

			</div>

		<br class="clear" />		

		</div>

	</form>

</article>

</div> <!-- #layoutContainer -->

<script>
(function(window, undefined){

	$(document).ready(function(event) {

		var loadingText = "<div id='js-avisos' class='fuente075' style='margin-top:10px;'><img src='<?= base_url(); ?>css/iconos/ico-loader.gif' widht='14' height='14' />cargando...</div>";
		var cambiosGuardados = "<img src='<?= base_url(); ?>css/iconos/ico-ok.png' widht='14' height='14' />cambios guardados"

		$('.js-desplegador').click(function() {

			var id = $(this).attr('id');
			id = id.replace("js-despliega", "");
			id = "#estrato"+id;
			var check = $(this).text();

			if ( check == '+' ) {
				$(id).fadeIn('slow');
				$(this).text('x');
			} else {
				$(id).fadeOut('slow');
				$(this).text('+');
			}
		
		});

		$("#js-recuperarImagenes").click(function() {

			$.post("<?= site_url('admin/getDefaultSizeImg'); ?>").done(function(data) {

					sizes = JSON && JSON.parse(data) || $.parseJSON(data);				
					$('#maxWidth').val(sizes[0]);
					$('#maxHeight').val(sizes[1]);
					$('#maxWidthThumb').val(sizes[2]);
					$('#maxHeightThumb').val(sizes[3]);

			});

		});

		$("#js-guardarImagenes").click(function(event) {
			$('#js-avisos').remove();
			$(this).after(loadingText);
			$.post( "<?= site_url('admin/updateDefaultSizeImg'); ?>", $("#js-formularioImagenes").serialize() ).done(function(data) {
				$('#js-avisos').html(cambiosGuardados);
				_.delay(function() {
					$('#js-avisos').fadeOut('slow');
				}, 2000);
			});
		});


	});

})( window );  
</script>