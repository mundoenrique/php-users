
<div class="login-content flex items-center justify-center bg-primary">
	<div class="flex flex-column items-center">
		<img class="logo-banco mb-2" src="<?= $this->asset->insertFile('img-banco_bogota.svg','img',$countryUri); ?>" alt="Logo Banco de Bogotá">
		<span class="mb-2 secondary center h3">Personas</span>
		<div class="widget rounded">
			<form id="form-login" class="" action="">
				<div class="form-group">
					<label for="username">Usuario</label>
					<input id="username" name="loginUsername" class="form-control" type="text">
					<div class="help-block"></div>
				</div>
				<div class="form-group">
					<label for="userpwd">Contraseña</label>
					<div class="input-group">
						<input id="userpwd" name="loginUserpwd" class="form-control" type="password">
						<div class="input-group-append">
							<span id="pwd-addon" class="input-group-text" title="Clic aquí para mostrar/ocultar contraseña"><i class="icon-view mr-0"></i></span>
						</div>
					</div>
					<div class="help-block"></div>
				</div>
				<button id="btn-login" class="btn btn-loading-lg btn-primary w-100 mt-3 mb-5">
					<span aria-hidden="true" class="icon-lock mr-1 h3 yellow"></span>
					Ingreso Seguro
				</button>
				<a class="block mb-1 h5 primary" href="<?= base_url('recuperaracceso');?>">Recuperar acceso</a>
				<p class="mb-0 h5">¿No posees usuario? <a class="primary" href="<?= base_url('preregistro');?>">Regístrate</a></p>
			</form>
		</div>
	</div>
</div>
