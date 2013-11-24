	<form id="js-formularioImagenes" action="#" method="post"  enctype="multipart/form-data" class="fuente08">

		<h4>+ Imágenes</h4>
		<div id="estratoGrafico" class="bordeGrisBottom marginBottom-01 displayTable">

			<div class="displayRow">

				<div class="displayCell ancho50c verticalTop">				
					<p>
						<input type="text" name="maxWidth" id="maxWidth" class="ancho250 azul_0777eb" value="<?= $todoOpciones[2]['value']; ?>"/>
						<label for="maxWidth"><span class="negrita">Ancho máximo imágenes</span></label>
					</p>
					<p>
						<input type="text" name="maxHeight" id="maxHeight" class="ancho250 azul_0777eb" value="<?= $todoOpciones[3]['value']; ?>"/>
						<label for="maxHeight"><span class="negrita">Alto máximo imágenes</span></label>
					</p>
				</div>

				<div class="displayCell ancho50c verticalTop">				
					<p>
						<input type="text" name="maxWidthThumb" id="maxWidthThumb" class="ancho250 azul_0777eb" value="<?= $todoOpciones[0]['value']; ?>"/>
						<label for="maxWidthThumb"><span class="negrita">Ancho máximo miniaturas</span></label>
					</p>
					<p>
						<input type="text" name="maxHeightThumb" id="maxHeightThumb" class="ancho250 azul_0777eb" value="<?= $todoOpciones[1]['value']; ?>"/>
						<label for="maxHeightThumb"><span class="negrita">Alto máximo miniaturas</span></label>
					</p>
				</div>

			</div>

			<div class="displayRow">
				<div class="displayCell ancho50c verticalTop">
					valores por defecto
				</div>
				<div class="displayCell ancho50c verticalTop textoRight">
					<button id="js-guardarImagenes" class="azul">guardar</button>					
				</div>
			</div>

		<br class="clear" />	
		</div>

	</form>

</article>

</div> <!-- #layoutContainer -->

<script>
(function(window, undefined){

	$(document).ready(function() {

		$("#js-guardarImagenes").click(function(event) {
			event.preventDefault();
		});

	});



})( window );  
</script>