<div id="preRegistry" class="registro-content h-content bg-white">
	<div class="max-width-4 mx-auto p-responsive py-4">
		<header class="">
			<h1 class="primary h0">Registro</h1>
		</header>
		<section>
			<hr class="separador-one">
			<div class="pt-3">
				<h2 class="tertiary h3">Verificación de cuenta</h2>
				<p>Si aún no posees usuario para acceder al sistema <strong><?= lang('GEN_SYSTEM_NAME'); ?></strong>, a continuación debes proporcionar los siguientes datos relacionados con tu cuenta:</p>
				<hr class="separador-one">
				<div class="max-width-1 fit-lg mx-auto pt-3">
					<form id="formVerifyAccount" method="post">
						<div class="row">
							<div class="form-group col-lg-4">
								<label for="telephoneNumber">Nro. de teléfono</label>
								<input id="telephoneNumber" class="form-control" type="text" name="telephoneNumber">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-lg-4">
								<label for="typeDocument">Tipo de documento (tarjetahabiente)</label>
								<?php
									if ($statusListTypeDocument == 'disabled'){
								?>
									<select id="typeDocumentUser" class="custom-select form-control" name="typeDocumentUser" <?=$statusListTypeDocument;?>>
											<option selected="" value="0"><?= $typeDocument->descripcion;?></option>
										</select>
										<div class="help-block"></div>
								<?php }else{?>
									<select id="typeDocumentUser" class="custom-select form-control" name="typeDocumentUser">
										<option selected="" value="0">Seleccione</option>
										<?php foreach ($typeDocument as $row) {?>
										<option value="<?= $row->id;?>"><?= $row->descripcion;?></option>
										<?php }?>
									</select>
									<div class="help-block"></div>
								<?php }?>
							</div>
							<div class="form-group col-lg-4">
								<label for="idNumber">Nro. de documento (tarjetahabiente)</label>
								<input id="idNumber" class="form-control" type="text" name="idNumber">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-lg-4">
								<label for="typeDocument">Tipo de documento (empresa)</label>
								<?php
									if ($statusListTypeDocument == 'disabled'){
								?>
									<select id="typeDocumentBussines" class="custom-select form-control" name="typeDocumentBussines" <?=$statusListTypeDocument;?>>
											<option selected="" value="0"><?= $typeDocument->descripcion;?></option>
										</select>
										<div class="help-block"></div>
								<?php }else{?>
									<select id="typeDocumentBussines" class="custom-select form-control" name="typeDocumentBussines">
										<option selected="" value="0">Seleccione</option>
										<?php foreach ($typeDocument as $row) {?>
										<option value="<?= $row->id;?>"><?= $row->descripcion;?></option>
										<?php }?>
									</select>
									<div class="help-block"></div>
								<?php }?>
							</div>
							<div class="form-group col-lg-4">
								<label for="nitBussines">Nro. de documento (empresa)</label>
								<input id="nitBussines" class="form-control" type="text" name="nitBussines">
								<div class="help-block"></div>
							</div>
						</div>
						<div class="form-group custom-control custom-switch my-3">
							<input id="acceptTerms" class="custom-control-input" type="checkbox" name="acceptTerms">
							<label class="custom-control-label" for="acceptTerms">
								Acepto las <a id="termsConditions" class="primary" href="#" rel="section">condiciones de uso</a> de este sistema.
							</label>
							<div class="help-block"></div>
						</div>
						<div id="verification" class="none">
							<hr class="separador-one mb-3">
							<p>Hemos envíado un código de verificación a tu teléfono móvil, por favor indicalo a continuación:</p>
							<div class="row form-group col-lg-4">
								<label for="codeOTP">Código de validación</label>
								<input id="codeOTP" class="form-control" type="text" name="codeOTP" disabled>
								<div class="help-block"></div>
							</div>
							<p id="verificationMsg" class="mb-3 h5"></p>
						</div>
						<hr class="separador-one">
						<div class="flex items-center justify-end pt-3">
							<a class="btn btn-small btn-link" href="<?= base_url('inicio');?>">Cancelar</a>
							<button id="btnValidar" class="btn btn-small btn-loading btn-primary" type="submit" <?=$statusListTypeDocument;?>>Continuar</button>
							<button id="btnVerifyOTP" class="btn btn-small btn-loading btn-primary none" type="submit">Continuar</button>
						</div>
					</form>
				</div>
			</div>
		</section>
	</div>

	<div id="dialogConditions" class="none">
		<div class="dialog-content p-3">
			<header class="">
				<h2 class="h2 primary">Condiciones generales, términos de uso y confidencialidad</h2>
			</header>
			<p class="p-0">
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam bibendum, purus sit amet venenatis laoreet, mi elit tempor turpis, et sagittis erat felis ac dui. Quisque leo enim, gravida consectetur odio quis, iaculis pharetra erat. Cras volutpat lacinia volutpat. In quis mauris enim. Suspendisse pharetra in libero nec vestibulum. Vestibulum tincidunt orci eget nisi lobortis, ut fringilla felis pellentesque. Aenean eget eros risus. Pellentesque ac nisi vehicula, lacinia ligula at, lacinia libero. Proin aliquet ligula ac ipsum laoreet convallis.
			</p>
			<p class="p-0">
			Nulla quam elit, placerat at dui quis, efficitur consectetur turpis. Donec vitae porta justo, a convallis libero. Curabitur luctus sagittis maximus. Suspendisse nec diam sed lacus mattis egestas id accumsan ante. Maecenas pharetra rhoncus nisl. Vestibulum laoreet nibh finibus ornare tristique. Aenean sit amet odio rhoncus, scelerisque eros et, feugiat risus. Donec vestibulum condimentum augue, quis gravida velit tempor ac. Morbi eu tellus ligula. Cras ultricies, risus in laoreet laoreet, est urna tempor metus, quis luctus nulla neque quis ex. Quisque ac lacus ac tortor sagittis bibendum. Ut lobortis convallis urna, vel aliquet arcu aliquet feugiat. Duis dapibus dapibus dolor, ac blandit mi eleifend et.
			</p>
			<p class="p-0">
			Donec lectus mauris, facilisis non ultricies ac, tempor ut purus. Vestibulum placerat vel ex eget tincidunt. Aliquam lobortis interdum ligula, nec facilisis nisi tincidunt consectetur. Curabitur diam odio, blandit in lorem eget, porttitor semper erat. Pellentesque sed lectus risus. Curabitur hendrerit arcu tortor, id blandit ante bibendum in. Sed ex lacus, elementum a euismod eu, sodales nec purus. Suspendisse tincidunt placerat lectus, at ultricies arcu maximus eu. Fusce hendrerit orci ipsum, vestibulum suscipit eros porta vitae. Mauris mollis tincidunt felis et venenatis. Nam sollicitudin lorem at turpis ultrices, id viverra tortor laoreet. In hac habitasse platea dictumst. Vestibulum vitae velit porta est sodales efficitur. Phasellus sollicitudin ac velit eget egestas. Phasellus vitae nisl eros.
			</p>
			<p class="p-0">
			Nulla ac hendrerit massa. Nullam eu tempus arcu. Pellentesque metus purus, luctus quis porttitor non, ornare sit amet dui. In hac habitasse platea dictumst. Sed ornare hendrerit molestie. Pellentesque suscipit sed nisi sed porttitor. Nullam laoreet magna sed diam eleifend posuere. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nunc tellus velit, ultrices id cursus vel, imperdiet ut nunc.
			</p>
			<p class="p-0">
			Sed facilisis viverra elit non posuere. Maecenas eu pulvinar tortor. Morbi ornare massa ipsum, id fermentum urna consequat id. Aliquam interdum tincidunt arcu sed vestibulum. Mauris et nibh vel eros rutrum blandit ut sed nibh. Pellentesque ut tincidunt tellus. Nulla efficitur ligula nunc. In placerat orci ex, quis condimentum mauris tincidunt et. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed ultricies lectus et nulla auctor, sed volutpat justo gravida. Sed a arcu nec quam pulvinar dapibus porta ac nibh. Morbi condimentum eget lorem nec eleifend. Curabitur at lectus odio.
			</p>
			<p class="p-0">
			In vulputate ante non feugiat maximus. Duis sodales dolor pulvinar neque vulputate, eu pellentesque elit pretium. Maecenas auctor sem vitae velit pellentesque pharetra. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce pellentesque mauris quis gravida interdum. In gravida, lectus in placerat suscipit, mauris libero pulvinar ipsum, in condimentum enim lorem quis felis. Duis pellentesque condimentum arcu non dictum. Donec a condimentum leo. Praesent lacinia pharetra erat, a eleifend enim eleifend at. Nulla risus augue, sodales porta justo in, interdum lobortis turpis.
			</p>
			<p class="p-0">
			Nullam tristique, felis at consectetur sodales, arcu odio varius urna, eu ullamcorper nulla lectus nec elit. Aliquam erat volutpat. Aenean auctor et nibh quis sagittis. Nullam fermentum sem id eros finibus tempor. Curabitur semper cursus libero ac suscipit. Sed et ligula orci. Donec at velit finibus, suscipit ante a, sodales odio. Nulla rutrum vitae leo vitae commodo. Aenean ac lorem massa.
			</p>
		</div>
		<hr class="separador-one m-0">
		<div id="footerSistemInfo" class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
			<div class="ui-dialog-buttonset novo-dialog-buttonset">
				<button id="aceptar" class="btn btn-small btn-loading btn-primary" type="button">Aceptar</button>
			</div>
		</div>
	</div>

</div>


<?php
	$data = json_encode([
		'setTimerOTP' => $setTimerOTP,
		'typeDocument' => $typeDocument
	]);
?>
<script>
	var dataPreRegistry = <?= $data;?>;
</script>

