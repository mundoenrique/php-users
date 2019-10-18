<div class="postregistro-content h-100 bg-white">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="primary h0">Registro</h1>
		</header>
		<section>
			<div class="border-top pt-3">
				<h2 class="tertiary h3">Afiliación de Datos</h2>
				<p>Para obtener su usuario de <strong>Conexión Personas</strong>, es necesario ingrese los datos requeridos a continuación:</p>
				<div class="border-top pt-4">
					<form method="post" id="form-validar">
						<h3 class="tertiary h4">Datos personales</h3>
						<div class="row">
							<div class="form-group col-6 col-lg-3">
								<label for="IdType">Tipo de identificación</label>
								<input id="IdType" class="form-control" name="IdType" type="text" value="" readonly="readonly">
							</div>
							<div class="form-group col-6 col-lg-3">
								<label for="IdNumber">Número de identificación</label>
								<input id="IdNumber" class="form-control" maxlength="16" name="IdNumber" type="text" value="" readonly="readonly"/>
							</div>
							<div class="form-group col-6 col-lg-3">
								<label for="firstName">Primer nombre</label>
								<input id="firstName" maxlength="35" name="firstName" type="text" placeholder="Primer nombre" value="" class="form-control"/>
							</div>
							<div class="form-group col-6 col-lg-3">
								<label for="lastName">Segundo nombre</label>
                <input id="lastName" class="form-control" maxlength="35" name="lastName" type="text"/>
							</div>
							<div class="form-group col-6 col-lg-3">
								<label for="lastName">Apellido paterno</label>
                <input id="lastName" maxlength="35" name="lastName" type="text" placeholder="Apellido paterno" value="" class="form-control"/>
							</div>
							<div class="form-group col-6 col-lg-3">
								<label for="lastName">Apellido materno</label>
                <input id="lastName" maxlength="35" name="segundo_apellido" type="text" class="form-control"/>
							</div>
							<div class="form-group col-6 col-lg-3">
								<label>Fecha de Nacimiento</label>
								<div class="form-row align-items-center">
									<div class="col-3">
										<input maxlength="2" id="day" class="form-control" name="day" type="text" placeholder="Dia" autocomplete="off">
									</div>
										<div class="col">
											<select class="bg-secondary custom-select" placeholder="Seleccionar" name="month" id="month">
												<option value="01">Enero</option>
												<option value="02">Febrero</option>
												<option value="03">Marzo</option>
												<option value="04">Abril</option>
												<option value="05">Mayo</option>
												<option value="06">Junio</option>
												<option value="07">Julio</option>
												<option value="08">Agosto</option>
												<option value="09">Septiembre</option>
												<option value="10">Octubre</option>
												<option value="11">Noviembre</option>
												<option value="12">Diciembre</option>
											</select>
										</div>
										<div class="col-4">
											<input maxlength="4" id="year" name="year" type="text" placeholder="Año" autocomplete="off" class="form-control">
										</div>
										<input type="hidden" id="fecha-de-nacimiento" name="fecha_nacimiento">
								</div>
							</div>
						</div>
						<div class="form-group form-check mt-4 mb-3">
							<input id="accept-terms" class="form-check-input" type="checkbox" name="accept-terms" value="" required disabled>
							<label class="form-check-label" for="accept-terms">
								Acepto las <a class="" href="#" rel="section">condiciones de uso</a> de este sistema
							</label>
						</div>
						<div class="flex items-center justify-end pt-3 border-top">
							<a class="btn underline" href="<?= base_url('inicio');?>">Cancelar</a>
							<button id="validar" class="btn btn-primary" type="submit">Continuar</button>
						</div>
					</form>
				</div>
			</div>
		</section>
	</div>
</div>
