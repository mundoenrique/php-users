<?php
  $skin = $this->input->cookie($this->config->item('cookie_prefix') . 'skin');
	if ($skin == 'latodo') {
		$recoverUserLink = $this->config->item('base_url') . '/users/obtenerLogin_pe';
		$recoverPwdLink = $this->config->item('base_url') . '/users/recoveryPassword_pe';
	} else if($skin == 'pichincha'){
		$recoverUserLink = $this->config->item('base_url') . '/users/obtenerLogin_pi';
		$recoverPwdLink = $this->config->item('base_url') . '/users/recoveryPassword_pi';
	}else {
		$recoverUserLink = $this->config->item('base_url') . '/users/obtenerLogin';
		$recoverPwdLink = $this->config->item('base_url') . '/users/recoveryPassword';
	}
  $signupLink = $this->config->item('base_url') . '/registro';

  echo $insertRecaptcha;
?>
<?php if($skin != 'pichincha'): ?>
<div id="slideshow">
  <ul class="slides">
    <li class="slide current-slide" data-slide="">
			<div class="img-back">
				<p class="slide-title"><?= lang('WELCOME_TITLE'); ?></p>
			</div>
      <p><?= lang('WELCOME_MSG'); ?></p>
    </li>
  </ul>
</div>
<?php endif; ?>
<!-- MODAL -->

<div id="dialog-overlay" style='display:none'>
  <header>
    <h2>Contraseña temporal caducada</h2>
  </header>
  <div class="dialog-small" id="dialog">
    <div class="alert-simple alert-warning" id="message">
      <span aria-hidden="true" class="icon-warning-sign"></span>
      <p>Su contraseña temporal <strong>ha cadudado</strong>. Dirijase al módulo "Olvidé mi Contraseña", para restaurarla. Recuerde cambiar su contraseña en un plazo <strong>menor</strong> de 24 horas. </p>
    </div>
    <div class="form-actions">
      <button id="caducado">Aceptar</button>
    </div>
  </div>
</div>
<!-- PASSWORD VENCIDOO -->

<div id="dialog-overlay1" style='display:none'>
  <header>
    <h2>Contraseña caducada</h2>
  </header>
  <div class="dialog-small" id="dialog">
    <div class="alert-simple alert-warning" id="message">
      <span aria-hidden="true" class="icon-warning-sign"></span>
      <p>Su contraseña <strong>ha cadudado</strong>. </p>
    </div>
    <div class="form-actions">
      <button id="caducado1">Aceptar</button>
    </div>
  </div>
</div>

<!-- MODAL LOGIN O CLAVE INVALIDO -->

<div id="dialog-login" style='display:none'>
  <header>
    <h2>Usuario o Contraseña Inválido</h2>
  </header>
  <div class="dialog-small" id="dialog">
    <div class="alert-simple alert-warning" id="message">
      <span aria-hidden="true" class="icon-warning-sign"></span>
      <p>Usuario o Contraseña <strong>inválido</strong>. Por favor <strong>verifique</strong> sus datos, e intente nuevamente. </p>
    </div>
    <div class="form-actions">
      <button id="invalido">Aceptar</button>
    </div>
  </div>
</div>


<!-- MODAL SESION ACTIVA -->

<div id="sesion-activa" style='display:none'>
  <header>
    <h2>Información</h2>
  </header>
  <div class="dialog-small" id="dialog">
    <div class="alert-simple alert-warning" id="message">
      <span aria-hidden="true" class="icon-warning-sign"></span>
      <p>
      Tienes una sesión activa en otra ubicación. Ten en cuenta que para salir de la aplicación debes seleccionar <strong>Cerrar sesión</strong>.<br>
      Pulsa <strong>Aceptar</strong> para cerrarla y continuar.
      </p>
    </div>
    <div class="form-actions">
      <button id="activa">Aceptar</button>
    </div>
  </div>
</div>

<!-- MODAL ERROR -->

<div id="dialog-error" style='display:none'>
  <header>
    <h2>Conexión Personas</h2>
  </header>
  <div class="dialog-small" id="dialog">
    <div class="alert-simple alert-warning" id="message">
      <span aria-hidden="true" class="icon-warning-sign"></span>
      <p>No fue posible procesar tu solicitud, por favor <strong>vuelve a intentar</strong></p>
    </div>
    <div class="form-actions">
      <button id="error">Aceptar</button>
    </div>
  </div>
</div>

<div id="dialog-voygo-error" style='display:none'>
  <header>
    <h2>Error de acceso</h2>
  </header>
  <div class="dialog-small" id="dialog">
    <div class="alert-simple alert-warning" id="message">
      <span aria-hidden="true" class="icon-warning-sign"></span>
      <p>Usted no posee un usuario del portal <strong>Voygo Usuarios</strong>.</p>
    </div>
    <div class="form-actions">
      <button id="error-voygo">Aceptar</button>
    </div>
  </div>
</div>


<!-- MODAL ERROR -->

<div id="dialog-bloq" style='display:none'>
  <header>
    <h2>Usuario Bloqueado</h2>
  </header>
  <div class="dialog-small" id="dialog">
    <div class="alert-simple alert-warning" id="message">
      <span aria-hidden="true" class="icon-warning-sign"></span>
      <p>¿Olvidate tu <a href="<?php echo $recoverUserLink; ?>" rel="section">usuario</a> o <a href="<?php echo $recoverPwdLink; ?>" rel="section">contraseña</a>?</p>
    </div>
    <div class="form-actions">
      <button id="aceptar">Aceptar</button>
    </div>
  </div>
</div>

<div id="dialog-login-ve" style='display:none'>
  <header>
    <h2>Conexión Personas Online</h2>
  </header>
  <div class="dialog-small" id="dialog">
    <div class="alert-simple alert-info" id="message">
      <span aria-hidden="true" class="icon-info-sign"></span>
      <p>
          Estimado usuario.<br> Esta página ha sido cambiada, para ingresar a <strong>Conexión Personas Online</strong> presiona el botón "<strong>Continuar</strong>" o puedes acceder desde <a style="color: #FFF; text-decoration: underline;">https://online.tebca.com/personas</a>
      </p>
    </div>
    <div class="form-actions">
      <a href="https://online.tebca.com/personas/"><button>Continuar</button></a>
    </div>
  </div>
</div>
