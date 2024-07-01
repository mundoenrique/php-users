<?php
$cpo_name = $this->security->get_csrf_token_name();
$cpo_cook = $this->security->get_csrf_hash();
$skin = get_cookie('skin', TRUE);
switch ($skin) {
  case 'pichincha':
    $homeLink = BASE_URL . '/pichincha/home';
    break;
  case 'latodo':
    $homeLink = BASE_URL . '/latodo/home';
    break;
  default:
    $homeLink = BASE_URL;
    break;
}
?>
<div id="content">
  <article>
    <header>
      <h1>Recuperar Usuario</h1>
    </header>
    <section>
      <div id="progress">
        <ul class="steps two-steps">
          <li class="step-item current-step-item"><span aria-hidden="true" class="icon-edit"></span> Verificación de datos</li>
          <li class="step-item"><span aria-hidden="true" class="icon-thumbs-up"></span> Finalización</li>
        </ul>
      </div>
      <div id="content-holder">
        <h2>Verificación de datos</h2>
        <p>Si ha olvidado su usuario de acceso a <strong>Conexión Personas</strong>, por favor ingrese los siguientes datos para validar su identidad:</p>
        <form accept-charset="utf-8" id="form-validar" method="post">
          <input type="hidden" name="<?php echo $cpo_name ?>" class="ignore" value="<?php echo $cpo_cook ?>">
          <fieldset class="fieldset-column-center">
            <label for="email">Correo Electrónico</label>
            <input class="field-large" maxlength="64" id="email" name="email" placeholder="usuario@ejemplo.com" type="text" />
            <label for="card-holder-id">Documento de Identidad</label>
            <input class="field-medium" maxlength="15" id="card-holder-id" name="card-holder-id" type="text" />
          </fieldset>
        </form>
        <div id="msg"></div>
        <div class="form-actions">
          <?php
          if ($skin == 'pichincha') {
          ?>
            <center>
              <div class="atc-form-action-child-perfil-content_2">
              <?php
            }
              ?>
              <a href="<?php echo $homeLink; ?>"><button type="reset" class="novo-btn-secondary">Cancelar</button></a>
              <button id="continuar" class="novo-btn-primary">Continuar</button>
              <?php
              if ($skin == 'pichincha') {
              ?>
              </div>
            </center>
          <?php
              }
          ?>
          <div id="loading" class="icono-load" style="display:none; float:right; width:30px; margin-top:5px; margin-right: 15px;">
            <span aria-hidden="true" class="icon-refresh icon-spin" style="font-size: 30px"></span>
          </div>
        </div>

      </div>
    </section>
  </article>
</div>

<!-- CONFIRMACION  -->

<div id="confirmacion" style='display:none'>
  <article>
    <header>
      <h1>Recuperar Usuario</h1>
    </header>
    <section>
      <div id="progress">
        <ul class="steps two-steps">
          <li class="step-item completed-step-item"><span aria-hidden="true" class="icon-edit"></span> Verificación de Datos</li>
          <li class="step-item current-step-item"><span aria-hidden="true" class="icon-thumbs-up"></span> Finalización</li>
        </ul>
      </div>
      <div id="content-holder">
        <h2>Finalización</h2>
        <form accept-charset="utf-8" method="post">
          <input type="hidden" name="<?php echo $cpo_name ?>" class="ignore" value="<?php echo $cpo_cook ?>">
          <div class="alert-success" id="message">
            <span aria-hidden="true" class="icon-ok-sign"></span> Recuperación de usuario exitosa
            <p>Se ha envíado un mensaje a su correo electrónico con sus datos de acceso al sistema <strong>Conexión Personas</strong>.</p>
          </div>
        </form>
        <div class="form-actions">
          <a href="<?php echo $homeLink; ?>"><button class="novo-btn-primary">Continuar</button></a>
        </div>
      </div>
    </section>
  </article>
</div>

<!-- MODAL CORREO O CEDULA INVALIDO -->

<div id="dialog-login-error" style='display:none'>
  <header>
    <h2>Campos inválidos</h2>
  </header>
  <div class="dialog-small" id="dialog">
    <div class="alert-simple alert-error" id="message">
      <span aria-hidden="true" class="icon-cancel-sign"></span>
      <p>Correo o Documento de identidad <strong>inválido</strong>. Por favor <strong>verifique</strong> sus datos, e intente nuevamente. </p>
    </div>
    <div class="form-actions">
      <?php
      if ($skin == 'pichincha') {
      ?> <center>
          <div class="atc-form-action-child-validar"> <?php } ?>

          <button id="invalido" class="novo-btn-primary">Aceptar</button> <?php
                                                                          if ($skin == 'pichincha') {
                                                                          ?>
          </div>
        </center> <?php } ?>
    </div>
  </div>
</div>