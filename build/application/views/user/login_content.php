
<div class="login-content flex items-center justify-center bg-primary">
	<div class="flex flex-column items-center z1">
		<img class="logo-banco mb-2" src="<?= $this->asset->insertFile('img-banco_bogota.svg','img',$countryUri); ?>" alt="Logo Banco de Bogotá">
		<span class="mb-2 secondary center h3">Personas</span>
		<div class="widget rounded">
			<form id="form-login" class="" action="">
				<div class="form-group">
					<label for="username">Usuario</label>
					<input id="username" class="form-control" type="text" name="loginUsername">
				</div>
				<div class="form-group">
					<label for="userpwd">Contraseña</label>
					<div class="input-group">
						<input id="userpwd" class="form-control" type="password" name="loginUserpwd">
						<div class="input-group-append">
							<span id="pwdAddon" class="input-group-text" title="Clic aquí para mostrar/ocultar contraseña"><i class="icon-view mr-0"></i></span>
						</div>
					</div>
				</div>
				<div id="formMsg" class="general-form-msg"></div>
				<button id="btn-login" class="btn btn-loading-lg btn-primary w-100 mt-3 mb-5">
					<span class="icon-lock mr-1 h3 yellow" aria-hidden="true"></span>
					Ingreso seguro
				</button>
				<a class="block mb-1 h5 primary" href="<?= base_url('recuperaracceso');?>">Recuperar acceso</a>
				<p class="mb-0 h5">¿No posees usuario? <a class="primary" href="<?= base_url('preregistro');?>">Regístrate</a></p>
			</form>
		</div>
	</div>

	<!-- Widgets centro de contacto -->
	<div id="widgetSupport" class="widget widget-support rounded-top">
		<div class="widget-header">
			<h2 class="mb-2 h3 regular center">¿Necesitas ayuda?</h2>
		</div>
		<div class="widget-section">
			<p class="mb-1">Líneas de atención a nivel nacional</p>

			<table class="w-100">
				<thead>
					<tr>
						<th class="px-0">CIUDAD</th>
						<th class="px-0 text-right">CONTACTO</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Bogotá</td>
						<td class="text-right">382 00 00</td>
					</tr>
					<tr>
						<td>Barranquilla</td>
						<td class="text-right"> 350 43 00</td>
					</tr>
					<tr>
						<td>Bucaramanga</td>
						<td class="text-right">652 55 00</td>
					</tr>
					<tr>
						<td>Cali</td>
						<td class="text-right">898 00 77</td>
					</tr>
					<tr>
						<td>Medellín</td>
						<td class="text-right">576 43 30 </td>
					</tr>
					<tr>
						<td>Nivel Nacional </td>
						<td class="text-right">018000 518 877 </td>
					</tr>
				</tbody>
			</table>

		</div>
	</div>
</div>
