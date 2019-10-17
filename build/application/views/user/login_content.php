<div class="login-content flex flex-column items-center bg-primary">
	<img class="logo-banco mb-2" src="<?= $this->asset->insertFile('img-banco_bogota.svg','img',$countryUri); ?>" alt="">
	<span class="mb-2 secondary center h3">Personas</span>
	<div class="login bg-widget rounded">
		<form id="form-login">
			<div class="form-group">
				<label for="username">Usuario</label>
				<input id="username" name="username" class="form-control" type="text" placeholder="Usuario" required>
			</div>
			<div class="form-group">
				<label for="userpwd">Contraseña</label>
				<input id="userpwd" name="userpwd" class="form-control" type="password" placeholder="Contraseña" required>
			</div>
			<button id="btn-login" class="btn btn-primary btn-icon icon-lock mx-auto my-3 flex">Ingreso Seguro</button>
		</form>
		<a href="recuperar-clave" class="block mb-1 h5">Olvidé mi usuario</a>
		<a href="recuperar-clave" class="block mb-1 h5">Olvidé mi Contraseña</a>
		<p class="mb-0 h5">¿No posees usuario? <a href="<?= base_url('registro');?>">Regístrate</a></p>
	</div>
</div>
