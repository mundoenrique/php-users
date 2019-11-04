
<div class="login-content h-100 flex items-center justify-center bg-primary">
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
					<input id="userpwd" name="loginUserpwd" class="form-control" type="password">
					<div class="help-block"></div>
				</div>
				<button id="btn-login" class="btn btn-primary w-100 mt-3 mb-5">
					<span aria-hidden="true" class="icon-lock h3 yellow"></span>
					Ingreso Seguro
				</button>
				<a href="<?= base_url('recuperaracceso');?>" class="block mb-1 h5">Olvidé mi usuario</a>
				<a href="<?= base_url('recuperaracceso');?>" class="block mb-1 h5">Olvidé mi Contraseña</a>
				<p class="mb-0 h5">¿No posees usuario? <a href="<?= base_url('preregistro');?>">Regístrate</a></p>
			</form>
		</div>
	</div>
</div>
