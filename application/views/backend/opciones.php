<style>

/*.ui-widget-content {
	border-top: 1px solid #e9eaea;
    border-left: 1px solid #e9eaea;
    border-bottom: 1px solid #d8d6d6;
    border-right: 1px solid #d8d6d6;
}

.ui-widget-header {
	background: #ededed; */
}

</style>

	<button id="js-addTag" class="botonMas floatRight fuente08">+</button>
		<h4 class="versalitas fuente11" style="margin-bottom:0.2em;">Generales</h4>
		<div id="estratoGrafico" class="bordeGrisBottom marginBottom-01 displayTable ancho100c">
		</div>

	<button id="js-addTag" class="botonMas floatRight fuente08">+</button>
		<h4 class="versalitas fuente11" style="margin-bottom:0.2em;">Colores</h4>
		<div id="estratoGrafico" class="bordeGrisBottom marginBottom-01 displayTable ancho100c">
		</div>

<!-- Generales -->

	<form id="js-formularioImagenes" action="#" method="post"  enctype="multipart/form-data">

		<button id="js-addTag" class="botonMas floatRight fuente08">x</button>
		<h4 class="versalitas fuente11" style="margin-bottom:0.2em;">Imágenes</h4>
		<div id="estratoGrafico" class="bordeGrisBottom marginBottom-01 displayTable ancho100c">

			<div class="displayRow fuente08">

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

			<div class="displayRow fuente08">
				<div class="displayCell ancho50c verticalTop" style="padding-top:20px;">
					<button id="js-guardarImagenes" class="botonBlanco">valores por defecto</button>
				</div>
				<div class="displayCell ancho50c verticalTop textoRight" style="padding-top:20px;">
					<button id="js-guardarImagenes" class="botonAzul">guardar</button>					
				</div>
			</div>

		<br class="clear" />	
		</div>

	</form>

<!-- #Generales -->


<!-- Imágenes -->

	<form id="js-formularioImagenes" action="#" method="post"  enctype="multipart/form-data">

		<button id="js-addTag" class="botonMas floatRight fuente08">x</button>
		<h4 class="versalitas fuente11" style="margin-bottom:0.2em;">Imágenes</h4>
		<div id="estratoGrafico" class="bordeGrisBottom marginBottom-01 displayTable ancho100c">

			<div class="displayRow fuente08">

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

			<div class="displayRow fuente08">
				<div class="displayCell ancho50c verticalTop" style="padding-top:20px;">
					<button id="js-guardarImagenes" class="botonBlanco">valores por defecto</button>
				</div>
				<div class="displayCell ancho50c verticalTop textoRight" style="padding-top:20px;">
					<button id="js-guardarImagenes" class="botonAzul">guardar</button>					
				</div>
			</div>

		<br class="clear" />	
		</div>

	</form>

<!-- #Imágenes -->

</article>

</div> <!-- #layoutContainer -->

<script>
(function(window, undefined){

	$(document).ready(function() {



	});



})( window );  
</script>