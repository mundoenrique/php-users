<?php
$pais = $this->session->userdata('pais');

$cpo_name = $this->security->get_csrf_token_name();
$cpo_cook = $this->security->get_csrf_hash();

$skin = $this->input->cookie($this->config->item('cookie_prefix') . 'skin');
switch($skin){
	case 'pichincha': $homeLink = $this->config->item('base_url') . '/pichincha/home'; break;
	case 'latodo': $homeLink = $this->config->item('base_url') . '/latodo/home'; break;
	default: $homeLink = $this->config->item('base_url'); break;
}
?>
<div id="content">
  <article>
    <header>
      <h1>Registro</h1>

    </header>
    <section>
      <div id="progress">
        <ul class="steps">
          <li class="step-item current-step-item"><span aria-hidden="true" class="icon-card"></span> Verificación de
            cuenta</li>
          <li class="step-item"><span aria-hidden="true" class="icon-edit"></span> Afiliación de datos</li>
          <li class="step-item"><span aria-hidden="true" class="icon-thumbs-up"></span> Finalización</li>
        </ul>
      </div>
      <div id="content-holder">
        <h2>Verificación de cuenta</h2>
        <p>Si usted aún no posee usuario para accesar al sistema <strong>Conexión Personas</strong>, a continuación debe
          proporcionar los siguientes datos relacionados con su cuenta:</p>
        <form accept-charset="utf-8" method="post" id="form-validar">
          <fieldset>
            <ul class="field-group">
              <?php if($skin == 'default' || $skin == 'latodo'): ?>
              <li class="field-group-item">
                <label for="country">País</label>
                <select id="iso" name="iso" class="country-list" disabled>
                  <option id="def-country" selected value="" disabled> Cargando... </option>
                </select>
              </li>
              <?php endif; ?>
              <li class="field-group-item">
                <?php if ($skin == 'pichincha'): ?>
                <input type="hidden" id="iso" name="iso" value="Ec-bp" />
                <?php endif; ?>
                <label for="card-number">Número de tarjeta</label>
                <input class="field-medium" maxlength="16" id="card-number" name="card-number" type="text" value="" />
              </li>
              <li class="field-group-item">
                <label for="card-holder-id">Documento de identidad <abbr
                    title="Número de identificación del tarjetahabiente"><span aria-hidden="true"
                      class="icon-question-sign"></span></abbr></label>
                <input class="field-medium" maxlength="16" id="card-holder-id" name="card-holder-id" type="text"
                  value="" />
              </li>
              <li class="field-group-item">
                <label for="card-holder-pin">Clave secreta (PIN) <abbr
                    title="Introduce la clave secreta o PIN de tu tarjeta"><span aria-hidden="true"
                      class="icon-question-sign"></span></abbr></label>
                <input class="field-medium" maxlength="15" id="card-holder-pin" name="card-holder-pin" type="password"
                  value="" />
              </li>
            </ul>
            <label class="label-inline label-disabled" id="condiciones" for="accept-terms"><input id="accept-terms"
                name="accept-terms" type="checkbox" value="yes" disabled /> Acepto las <a href="#"
                rel="section">condiciones de uso</a> de este sistema.</label>
          </fieldset>
        </form>
        <div id="msg"></div>
        <div class="form-actions">

			<?php
			if($skin=='pichincha'){
			?>
        <center>
        <div class="atc-form-action-child-perfil-content_2">
        <?php
			 }
		  ?>
      <a href="<? echo $homeLink; ?>">
		  <button type="reset" class="novo-btn-secondary">Cancelar</button>
		  </a>
      <button id="validar" class="novo-btn-primary">Continuar</button>
      <?php
			  if($skin=='pichincha'){
			?>
			</div>
        </center>
        <?php
		}
		?>
        <div id="loading" class="first-request" style="display:none; float:right; width:30px; margin-top:5px;">
          <span aria-hidden="true" class="icon-refresh icon-spin" style="font-size: 30px"></span>
        </div>
      </div>
</div>
</section>
</article>
</div>

<!-- REGISTRO FASE II -->

<div id="content-registro" style='display:none'>
  <!-- style='display:none' -->
  <?php $pais = $this->session->userdata("pais"); ?>
  <article>
    <header>
      <h1>Registro</h1>
    </header>
    <section>
      <div id="progress">
        <ul class="steps">
          <li class="step-item completed-step-item"><span aria-hidden="true" class="icon-card"></span> Verificación de
            cuenta</li>
          <li class="step-item current-step-item"><span aria-hidden="true" class="icon-edit"></span> Afiliación de datos
          </li>
          <li class="step-item"><span aria-hidden="true" class="icon-thumbs-up"></span> Finalización</li>
        </ul>
      </div>
      <div id="content-holder" pais="<?= $pais;?>">
        <h2>Afiliación de Datos</h2>
        <p>Para obtener su usuario de <strong>Conexión Personas</strong>, es necesario ingrese los datos requeridos a
          continuación:</p>
        <form accept-charset="utf-8" method="post" id="form-usuario">
          <hr class="separador-segments">

          <fieldset class="fields">
            <legend class="title-segments">
              <h3>Datos personales</h3>
            </legend>
            <ul class="inline-list four-segments">
              <li>
                <label>Tipo de identificación</label>
                <input id="listaIdentificadores" value="" name="tipo_identificacion" type="text" readonly="readonly"
                  class="field-disabled" />
              </li>
              <li>
                <label>Número de identificación</label>
                <input id="holder-id" value="" name="numero_identificacion" type="text" readonly="readonly"
                  class="field-disabled" />
              </li>
              <li class="dig-verificador">
                <label title="Carácter verificador del DNI">Dígito verificador</label>
                <input title="Obtenga el carácter verificador de su DNI leyéndolo de su documento de identidad"
                  id="dig-ver" name="dig-ver" type="text" class="field-disabled" maxlength="1" />
              </li>
            </ul>
            <ul class="inline-list four-segments">
              <li>
                <label for="first-name">Primer nombre</label>
                <input id="first-name" maxlength="35" name="primer_nombre" type="text" placeholder="Primer nombre"
                  value="" class="field-disabled" />
              </li>
              <li>
                <label for="last-name">Segundo nombre</label>
                <input id="first-ext-name" maxlength="35" name="segundo_nombre" type="text" />
              </li>
            </ul>
            <ul class="inline-list four-segments">
              <li>
                <label for="last-name">Apellido paterno</label>
                <input id="last-name" maxlength="35" name="primer_apellido" type="text" placeholder="Apellido paterno"
                  value="" class="field-disabled" />
              </li>
              <li>
                <label for="last-name">Apellido materno</label>
                <input id="last-ext-name" maxlength="35" name="segundo_apellido" type="text" />
              </li>
            </ul>
            <div>
              <ul class="inline-list four-segments field-plata nacimiento-mitad" id="nacimiento">
                <li class="field-group-item lugar-nacimiento">
                  <label for="lugar-nacimiento">Lugar de Nacimiento</label>
                  <input maxlength="15" id="lugar-nacimiento" name="lugar_nacimiento" type="text" />
                </li>
								<label for="filter-range-from">Fecha de Nacimiento</label>
									<div class="field-prepend">
									<span aria-hidden="true" class="icon-calendar"></span>
									<input  id="fecha-de-nacimiento-new" name="fecha-de-nacimiento-new" class="field-small" maxlength="10"
										placeholder="DD/MM/AAAA" autocomplete="off">
									</div>
              </ul>
            </div>
            <ul class="field-group four-segments radio-sexo">
              <li class="select-group-item">
                <label>Sexo</label>
                <label class="label-inline" for="gender-male"><input checked id="gender-male" name="genero" type="radio"
                    value="M" /> Masculino</label>
                <label class="label-inline label-sex-fem" for="gender-female"><input id="gender-female" name="genero"
                    type="radio" value="F" /> Femenino</label>
              </li>
              <li class="select-group-item remove-plata-sueldo">
                <label for="edocivil">Estado Civil</label>
                <select id="edocivil" name="edo_civil" class="estado-civil-select">
                  <option value="">Seleccione</option>
                  <option value="S">Soltero</option>
                  <option value="C">Casado</option>
                  <option value="V">Viudo</option>
                </select>
              </li>
              <li class="select-group-item remove-plata-sueldo">
                <label for="nacionalidad">Nacionalidad</label>
                <input maxlength="15" id="nacionalidad" name="nacionalidad" type="text" />
              </li>
            </ul>
          </fieldset>
          <hr class="separador-segments separador-1">
          <fieldset class="fields">
            <legend class="title-segments">
              <h3>Datos de contacto</h3>
            </legend>
            <ul class="inline-list two-segments remove-plata-sueldo">
              <li>
                <label>Tipo de dirección</label>
                <select name="tipo_direccion" id="tipoDireccion">
                  <option value="">Seleccione</option>
                  <option value="1">Domicilio</option>
                  <option value="2">Laboral</option>
                  <option value="3">Comercial</option>
                </select>
              </li>
              <li>
                <label>Código postal</label>
                <input type="text" name="codigo_postal" id="codigoPostal" maxlength="8">
              </li>
            </ul>
            <ul class="four-segments inline-list four-select remove-plata-sueldo">
              <li class="li-contact-select">
                <label>País de residencia</label>
                <input id="paisResidencia" name="pais_Residencia" type="text" readonly="readonly"
                  class="field-disabled" />
                <input id="paisResidenciaHidden" name="pais_Residencia_Hidden" type="hidden" class="field-disabled" />
              </li>
              <li class="li-contact-select">
                <label>Departamento</label>
                <select name="departamento" id="departamento">
                  <option value="">Seleccione</option>
                </select>
              </li>
              <li class="li-contact-select">
                <label>Provincia</label>
                <select name="provincia" id="provincia">
                  <option value="">-</option>
                </select>
              </li>
              <li class="li-contact-select">
                <label>Distrito</label>
                <select name="distrito" id="distrito">
                  <option value="">-</option>
                </select>
              </li>
            </ul>
            <ul class="inline-list one-segments field-plata remove-plata-sueldo" id="direccion">
              <li>
                <label for="address">Dirección</label>
                <input id="text-address" name="direccion" maxlength="50" type="text" />
              </li>
            </ul>
            <ul class="inline-list two-segments">
              <li>
                <label for="email">Correo Electrónico</label>
                <?php if($skin == 'pichincha'): ?>
                <input type="text" id="email-bp" name="email-bp" readonly>
                <input type="hidden" id="email_cypher" name="email_cypher">
                <?php else: ?>
                <input id="email" name="correo" maxlength="50" placeholder="usuario@ejemplo.com" type="text">
                <?php endif; ?>
              </li>
              <?php if($skin != 'pichincha'): ?>
              <li>
                <label for="confirm-email">Confirmar Correo Electrónico</label>
                <input id="confirm-email" name="confirm-correo" maxlength="50" placeholder="usuario@ejemplo.com"
                  type="text" />
              </li>
              <?php endif; ?>
            </ul>
            <ul class="inline-list two-segments area-telefonos">
              <li>
                <div id="phone-2x">
                  <div class="field-category field-category-wide field-phone-group">
                    <label class="phone-field">Teléfono fijo</label>
                  </div>
                  <?php if($skin == 'pichincha'): ?>
                  <input type="text" id="telf-hab" name="telf-hab" readonly>
                  <input type="hidden" id="hab_cypher" name="hab_cypher">
                  <?php else: ?>
                  <input id="telefonoFijo" maxlength="11" name="telefono_fijo" type="text" />
                  <?php endif; ?>
                </div>
              </li>
              <li>
                <div id="phone-1x">
                  <div class="field-category field-category-wide field-phone-group">
                    <label class="phone-field">Teléfono móvil</label>
                  </div>
                  <?php if($skin == 'pichincha'): ?>
                  <input type="text" id="telf-cel" name="telf-cel" readonly>
                  <input type="hidden" id="cel_cypher" name="cel_cypher">
                  <?php else: ?>
                  <input id="telefonoMovil" maxlength="11" name="telefono_movil" type="text" />
                  <?php endif; ?>
                </div>
              </li>
            </ul>
            <?php if($skin != 'pichincha'): ?>
            <ul class="inline-list two-segments">
              <li>
                <label class="phone-field phone-field-2">Otro Teléfono (Tipo)</label>
                <select class="otro-telefono-type" name="otro_tipo_telefono" id="otroTelefonoSelect" style="width:80%;">
                  <option value="">Seleccione</option>
                  <option value="OFC">Laboral</option>
                  <option value="FAX">Fax</option>
                  <option value="OTRO">Otro</option>
                </select>
              </li>
              <li>
                <label class="phone-field phone-field-2">Otro Teléfono (Número)</label>
                <input id="otroTelefonoNum" maxlength="11" name="otro_telefono_num" type="text" />
              </li>
            </ul>
            <?php endif; ?>
          </fieldset>
          <hr class="separador-segments separador-2">
          <fieldset class="fields field-plata segments-laborales">
            <legend class="title-segments">
              <h3>Datos laborales</h3>
            </legend>
            <ul class="inline-list four-segments">
              <li>
                <label for="centro-laboral">RUC</label>
                <input maxlength="15" value="" type="text" name="ruc_laboral" id="ruc" readonly="readonly" />
              </li>
              <li>
                <label for="centro-laboral">Centro laboral</label>
                <input maxlength="100" id="centro-laboral" name="centro_laboral" type="text" />
              </li>
              <li>
                <label for="situacion-laboral">Situación laboral</label>
                <select id="text-situacion" name="situacion_laboral">
                  <option value="">Seleccione</option>
                  <option value="1">Dependiente</option>
                  <option value="0">Independiente</option>
                </select>
              </li>
            </ul>
            <ul class="inline-list four-segments">
              <li class="antiguedad-laboral-select col-md-6">
                <label for="antiguedad-laboral">Antigüedad laboral</label>
                <select class="antiguedad-laboral" name="anos_antiguedad" id="antiguedadLaboral">
                </select>
              </li>
              <li class="ocupacion-laboral-input col-md-6">
                <label for="ocupacion-laboral">Ocupación, oficio o profesión </label>
                <select name="ocupacion_laboral" id="ocupacion-laboral">
                  <option value="">Seleccione</option>
                </select>
              </li>
            </ul>
            <ul class="inline-list two-segments">
              <li>
                <label for="cargo-laboral">Cargo</label>
                <input maxlength="15" id="cargo-laboral" name="cargo_laboral" type="text" />
              </li>
              <li>
                <label for="ingreso">Ingreso promedio mensual</label>
                <input maxlength="15" id="ingreso" name="ingreso" type="text" maxlength="8" />
              </li>
            </ul>
            <label>¿Desempeñó cargo público en últimos 2 años?</label>
            <ul class="inline-list four-segments">
              <li class="field-group-item">
                <label class="label-inline" for="cargo-publico-si"><input id="cargo-publico-si" name="desem_publico"
                    type="radio" value="1" /> Si</label>
                <label class="label-inline" for="cargo-publico-no"><input id="cargo-publico-no" name="desem_publico"
                    type="radio" value="0" /> No</label>
              </li>
            </ul>
            <ul class="inline-list two-segments">
              <li>
                <label for="cargo-publico">Cargo público</label>
                <input maxlength="15" id="cargo-publico" name="cargo_publico" type="text" />
              </li>
              <li>
                <label for="institucion">Institución</label>
                <input maxlength="15" id="institucion" name="institucion" type="text" />
              </li>
            </ul>
            <label for="uif">¿Es sujeto obligado a informar UIF-Perú, conforme al artículo 3° de la Ley N°
              29038?</label>

            <ul class="inline-list four-segments">
              <li class="field-group-item">
                <label class="label-inline" for="uif-si"><input id="uif-si" name="uif" type="radio" value="1" />
                  Si</label>
                <label class="label-inline" for="uif-no"><input id="uif-no" name="uif" type="radio" value="0" />
                  No</label>
              </li>
            </ul>
          </fieldset>
          <hr class="separador-segments separador-3">
          <fieldset class="fields">
            <legend class="title-segments">
              <h3>Datos de usuario</h3>
            </legend>
            <div class="user-requerimientos">
              <div class="user-pass">
                <label for="username">Usuario</label>
                <input maxlength="15" id="username" name="username" type="text" />
                <div id="loading" class="icono-load"
                  style="display:none; float:right; width:30px; margin-top:0px; margin-right:155px; margin-bottom:0px;">
                  <span aria-hidden="true" class="icon-refresh icon-spin" style="font-size: 30px"></span>
                </div>
                <label for="userpwd">Contraseña</label>
                <input id="userpwd" maxlength="15" name="userpwd" type="password" />
                <label for="confirm-userpwd">Confirmar Contraseña</label>
                <input id="confirm-userpwd" maxlength="15" name="confirm_userpwd" type="password" />
              </div>

              <div class="field-meter" id="password-strength-meter">
                <h4>Requerimientos de contraseña:</h4>
                <ul class="pwd-rules">
                  <li id="length" class="pwd-rules-item rule-invalid">• De 8 a 15 <strong>Caracteres</strong></li>
                  <li id="letter" class="pwd-rules-item rule-invalid">• Al menos una <strong>letra minúscula</strong>
                  </li>
                  <li id="capital" class="pwd-rules-item rule-invalid">• Al menos una <strong>letra mayúscula</strong>
                  </li>
                  <li id="number" class="pwd-rules-item rule-invalid">• De 1 a 3 <strong>números</strong></li>
                  <li id="especial" class="pwd-rules-item rule-invalid">• Al menos un <strong>caracter
                      especial</strong><br />(ej: ! @ ? + - . , #)</li>
                  <li id="consecutivo" class="pwd-rules-item rule-invalid">• No debe tener más de 2
                    <strong>caracteres</strong> iguales consecutivos</li>
                </ul>
              </div>
            </div>
          </fieldset>
          <div id="contract">
            <hr class="separador-segments separador-3">
            <fieldset>
              <ul class="row-profile">
                <li class="col-md-12-profile">
                  <label class="label-inline" for="proteccion"><input id="proteccion" name="proteccion" type="checkbox">
                    Aceptar protección de datos personales</label>
                  &nbsp;&nbsp;&nbsp;
                  <label class="label-inline" for="contrato"><input id="contrato" name="contrato" type="checkbox">
                    Acepto el contrato de cuenta dinero electrónico <div id='modalContrato' style="display:inline;">
                      plata beneficios</div></label>
                </li>
              </ul>
            </fieldset>
          </div>
        </form>
        <div class="form-actions">
          <div id="msg2"></div>

          <?php
						if($skin == 'pichincha'){
							?>
          <center>
            <div class="atc-form-action-child-perfil-content_2">
              <?php
						}
					?>
              <a href="<? echo $homeLink; ?>"> <button type="reset" class="novo-btn-secondary">Cancelar</button> </a>
              <button id="registrar" class="novo-btn-primary"> Continuar</button>
              <?php
						if($skin == 'pichincha'){
							?>
            </div>
            <center>
              <?php
						}
					?>
              <div id="load_reg" class="icono-load" style="display:none; float:right; width:30px; margin-top:5px;">
                <span aria-hidden="true" class="icon-refresh icon-spin" style="font-size: 30px"></span>
              </div>
        </div>
      </div>
    </section>
  </article>
</div>

<!-- REGISTRO EXITOSO -->
<div id="exito" style='display:none'>
  <article>
    <header>
      <h1>Registro</h1>
    </header>
    <section>
      <div id="progress">
        <ul class="steps">
          <li class="step-item completed-step-item"><span aria-hidden="true" class="icon-card"></span> Verificación de
            Cuenta</li>
          <li class="step-item completed-step-item"><span aria-hidden="true" class="icon-edit"></span> Afiliación de
            Datos</li>
          <li class="step-item current-step-item"><span aria-hidden="true" class="icon-thumbs-up"></span> Finalización
          </li>
        </ul>
      </div>
      <div id="content-holder">
        <h2>Finalización</h2>
        <form accept-charset="utf-8" action="index.html" method="post">
          <input type="hidden" name="<?php echo $cpo_name ?>" class="ignore" value="<?php echo $cpo_cook ?>">
          <div class="alert-success" id="message">

          </div>
        </form>
        <div class="form-actions">
          <a href="<? echo $this->config->item("base_url"); ?>/dashboard"> <button type="submit"
              class="novo-btn-primary">Continuar</button>
          </a>
        </div>
      </div>
    </section>
  </article>
</div>

<!-- REGISTRO exitoso 2  -->
<div id="exito2" style='display:none'>
  <article>
    <header>
      <h1>Registro</h1>
    </header>
    <section>
      <div id="progress">
        <ul class="steps">
          <li class="step-item completed-step-item"><span aria-hidden="true" class="icon-card"></span> Verificación de
            Cuenta</li>
          <li class="step-item completed-step-item"><span aria-hidden="true" class="icon-edit"></span> Afiliación de
            Datos</li>
          <li class="step-item current-step-item"><span aria-hidden="true" class="icon-thumbs-up"></span> Finalización
          </li>
        </ul>
      </div>
      <div id="content-holder">
        <h2>Finalización</h2>
        <form accept-charset="utf-8" action="index.html" method="post">
          <input type="hidden" name="<?php echo $cpo_name ?>" class="ignore" value="<?php echo $cpo_cook ?>">
          <div class="alert-warning" id="message2">

          </div>
        </form>
        <div class="form-actions">
          <a href="<? echo $this->config->item("base_url"); ?>/dashboard"> <button type="submit"
              class="novo-btn-primary">Continuar</button>
          </a>
        </div>
      </div>
    </section>
  </article>
</div>

<div id="dialogo_oculto" style='display:none'>
  <div id="dialog-confirm">
    <div class="alert-simple alert-error" id="message">
      <span aria-hidden="true" class="icon-cancel-sign"></span>
      <p>La clave <strong>no cumple</strong> con las recomendaciones. <strong>Por favor varificala y vuelve a
          intentarlo.</strong>
      </p>
    </div>
    <div class="form-actions">
      <button id="close-nopass" class="novo-btn-primary">Aceptar</button>
    </div>
  </div>
</div>

<!--- Modal Validación VERIFICACIÓN CUENTA - CUENTA GENERAL PERU -->
<div id="dialogo-check-count" style='display:none'>
  <form accept-charset="utf-8" method="post">
    <input type="hidden" name="<?php echo $cpo_name ?>" class="ignore" value="<?php echo $cpo_cook ?>">
    <div id="dialog-confirm">
      <div class="alert-simple" id="messageContent">
        <span aria-hidden="true" class="icon-cancel-sign"></span>
        <p id="msnContent"></p>
      </div>
      <div class="form-actions">
        <button id="ok-check" class="novo-btn-primary">Aceptar</button>
      </div>
    </div>
  </form>
</div>

<!-- MODAL USUARIO NO DISPONIBLE -->
<div id="dialogo_disponible" style='display:none'>
  <div id="dialog-confirm">
    <div class="alert-simple alert-error" id="message">

      <?php if ($skin != 'pichincha'): ?>
      <span aria-hidden="true" class="icon-cancel-sign"></span>
      <?php endif ?>
      <p>El usuario indicado <strong>NO está disponible</strong> o está siendo usado por otra persona. Por favor
        verifique e intente nuevamente.</p>
    </div>
    <div class="form-actions">
      <button id="disp" class="novo-btn-primary">Aceptar</button>
    </div>
  </div>
</div>

<!-- ERROR 1 -->
<div id="dialog-clave-inv" style='display:none'>
  <header>
    <h2>Campos obligatorios</h2>
  </header>
  <div class="dialog-small" id="dialog">
    <div class="alert-simple alert-error" id="message">
      <span aria-hidden="true" class="icon-cancel-sign"></span>
      <p> Por favor <strong>verifique</strong> los datos de contraseña, e intente nuevamente. </p>
    </div>
    <div class="form-actions">
      <button id="invalido" class="novo-btn-primary">Aceptar</button>
    </div>
  </div>
</div>

<!-- ERROR 2 -->
<div id="dialog-clave-inv2" style='display:none'>
  <header>
    <h2>Contraseñas no coinciden</h2>
  </header>
  <div class="dialog-small" id="dialog">
    <div class="alert-simple alert-error" id="message">
      <span aria-hidden="true" class="icon-cancel-sign"></span>
      <p>Sus contraseñas <strong>no coinciden</strong>. Por favor <strong>verifique</strong> sus datos, e intente
        nuevamente. </p>
    </div>
    <div class="form-actions">
      <button id="invalido2" class="novo-btn-primary">Aceptar</button>
    </div>
  </div>
</div>


<!-- ERROR al cargar regiones -->
<div id="dialog-cargar-regiones" style='display:none'>
  <header>
    <h2>ERROR</h2>
  </header>
  <div class="dialog-small" id="dialog">
    <div class="alert-simple alert-error" id="message">
      <span aria-hidden="true" class="icon-cancel-sign"></span>
      <p>No se pueden cargar los Departamentos</p>
    </div>
    <div class="form-actions">
      <button id="invalido3" class="novo-btn-primary">Aceptar</button>
    </div>
  </div>
</div>

<!-- ERROR telefono movil exixtente -->
<div id="dialogo-movil" style='display:none'>
  <div id="dialog-confirm">
    <div class="alert-simple" id="modalType">
      <span aria-hidden="true" class="icon-cancel-sign"></span>
      <p id="msgService"></p>
    </div>
  </div>
  <div class="form-actions">
    <?php 	if($skin=='pichincha'): 		?>
    <center>
      <div class="atc-form-action-child-validar">
        <?php endif; ?>
        <button id="inva5" class="novo-btn-primary">Aceptar</button>
        <?php 	if($skin=='pichincha'): 		?>

      </div>
      <center>
        <?php endif; ?>
  </div>
</div>
<!--Modal protección de datos-->
<div id="datos_personales" style='display:none'>
  <div class="cond-serv">
    <p>
      Se informa que los datos personales proporcionados por el CLIENTE a TEBCA quedan incorporados al banco de datos de
      clientes de TEBCA. Dicha información será utilizada para efectos de la gestión de los servicios objeto del
      presente Contrato (incluyendo procesamiento de datos, remisión de correspondencia, entre otros), la misma que
      podrá ser realizada a través de terceros.
    </p>
    <p>
      TEBCA protege el banco de datos y sus tratamientos con todas las medidas de índole técnica y organizativa
      necesarias para resguardar su seguridad y evitar alteración, pérdida, tratamiento o acceso no autorizado.
    </p>
    <p>
      Mediante la aceptación a estos términos, usted autoriza a TEBCA a utilizar, en tanto esta autorización no sea
      revocada, sus datos personales, incluyendo datos sensibles, que hubieran sido proporcionados directamente a TEBCA,
      aquellos que pudieran encontrarse en fuentes accesibles para el público o los que hayan sido obtenidos de
      terceros; para tratamientos que supongan desarrollo de acciones comerciales, incluyendo la remisión (vía medio
      físico, electrónico o telefónico) de publicidad, información u ofertas/promociones (personalizadas o generales) de
      servicios de TEBCA y/o de otras empresas del Grupo Intercorp y sus socios estratégicos, entre las que se
      encuentran aquellas difundidas en el portal de la Superintendencia del Mercado de Valores (<a
        href="http://www.smv.gob.pe" target="_blank">www.smv.gob.pe</a>) así como en el portal <a
        href="http://www.intercorp.com.pe/es" target="_blank">www.intercorp.com.pe/es.</a> El CLIENTE autoriza a TEBCA
      la cesión, transferencia o comunicación de sus datos personales, a dichas empresas y entre ellas.
    </p>
    <p>
      El otorgamiento de la presente autorización es libre y voluntaria por lo que no condiciona el otorgamiento y/o
      gestión de los servicios ofrecidos por TEBCA.
    </p>
    <p>
      Usted puede revocar la autorización para el tratamiento de sus datos personales en cualquier momento, así como
      ejercer los derechos de acceso, rectificación, cancelación y oposición para el tratamiento de sus datos
      personales. Para ejercer este derecho, o cualquier otro previsto en las normas de protección de datos personales,
      usted deberá presentar su solicitud en la oficina de TEBCA o a través del Centro de Contacto.
    </p>
  </div>
  <div class="form-actions">
    <button id="close-datos" class="novo-btn-primary">Aceptar</button>
  </div>
</div>
<!--Modal aceptación de contrato-->
<div id="contrato_cuenta" style='display:none'>
  <div class="cond-serv">
    <p>
      Servitebca Perú, Servicio de Transferencia Electrónica de Beneficios y Pagos S.A. (en adelante, “SERVITEBCA”) y el
      Cliente celebran un contrato por el cual se regulan los términos y condiciones aplicables a la cuenta general de
      dinero electrónico “Plata Beneficios”.
    </p>
    <p>
      <strong>PRIMERA. DEFINICIONES:</strong><br>
      Cliente: persona natural titular de la cuenta general de dinero electrónico “Plata Beneficios”.<br>
      Cuenta: cuenta general de dinero electrónico, cuya titularidad es del CLIENTE<br>
      Dinero Electrónico: valor monetario almacenado en soportes electrónicos (tales como tarjetas electrónicas prepago)
      diseñados para atender usos generales.<br>
      Emisión: la conversión de dinero electrónico por el mismo valor que se recibe, a través de su almacenamiento en un
      soporte electrónico; incluye la emisión propiamente dicho, la reconversión a efectivo (retiros), transferencias,
      pagos y cualquier otro movimiento o transacción vinculado al valor monetario almacenado en el soporte
      electrónico.<br>
      Empresa: empresa que ha suscrito un contrato de servicios con SERVITEBCA para que le provea los servicios de
      emisión, gestión y procesamiento de tarjetas electrónica recargables. La Empresa solicita la emisión y realiza la
      recarga (conversión) de las Tarjetas de manera exclusiva.<br>
      Tarjeta: tarjeta electrónica denominada “Plata Beneficios” que será entregada por SERVITEBCA al CLIENTE para que
      éste pueda realizar operaciones y acceder a servicios que SERVITEBCA le ofrezca, con cargo al saldo en la Cuenta,
      para lo cual utilizará la Clave Secreta que le será proporcionada conjuntamente con la Tarjeta.
    </p>
    <p>
      <strong>SEGUNDA. OBJETO:</strong>
      Mediante el presente contrato las partes acuerdan que SERVITEBCA brindará el servicio de dinero electrónico al
      CLIENTE, a través de una Cuenta cuyo soporte electrónico será la Tarjeta. La Tarjeta podrá ser utilizada a nivel
      nacional e internacional.
    </p>
    <p>
      <strong>TERCERA. CONDICIÓN PARA LA PRESTACIÓN DEL SERVICIO:</strong>
      Para que EL CLIENTE pueda obtener la Tarjeta, la Empresa debe haber firmado un contrato de servicios con
      SERVITEBCA y haber ordenado su emisión a favor del CLIENTE. Para ser titular de la Tarjeta, el CLIENTE debe ser
      mayor de edad y haber completado los datos de identificación requeridos por SERVITEBCA.
    </p>
    <p>
      <strong>CUARTA. CARACTERÍSTICAS Y CONDICIONES DE LAS OPERACIONES, LÍMITES Y RESTRICCIONES:</strong><br>
      4.1 Operaciones<br>
      a) Recargas (o conversión): La Tarjeta sólo admite recargas de la Empresa.<br>
      b) Retiros de efectivo (o reconversión): EL CLIENTE podrá realizar retiros de efectivo a través de todos los
      cajeros automáticos a nivel nacional y en el exterior. Los retiros podrán hacerse en cualquier moneda, en cuyo
      caso estarán sujetos al tipo de cambio .<br>
      c) Consumos: EL CLIENTE podrá realizar consumos para el pago de bienes y/o servicios en los establecimientos
      afiliados a las marcas Visa o MasterCard, según corresponda a la Tarjeta, para lo cual el comercio deslizará la
      Tarjeta por el terminal POS e introducirá el monto del consumo. El CLIENTE deberá ingresar en el terminal POS la
      Clave Secreta para confirmar la operación. El valor del consumo será debitado de la Cuenta. El voucher indicará el
      monto del consumo así como el saldo disponible en la Cuenta. Asimismo, el CLIENTE podrá realizar consumos en
      páginas web, locales e internacionales, utilizando la Clave Secreta. En cualquier caso, los consumos podrán
      efectuarse en cualquier moneda, en cuyo caso estarán sujetos al tipo de cambio.<br>
      d) Consultas de saldos y movimientos: El CLIENTE podrá efectuar consultas de saldos y movimientos por (i)
      Aplicación de Acceso Móvil de Servitebca (App’s), (ii) Centro de Contacto de SERVITEBCA, llamando al (511)
      619-8931 (en adelante el “Centro de Contacto”), (iii) página web (www.miplata.com.pe), y en (v) Cajeros
      GlobalNet.<br>
      El CLIENTE podrá encontrar el detalle de las instrucciones para efectuar operaciones con la Tarjeta en la página
      web (www.miplata.com.pe).<br>
      4.2. Límites y Restricciones<br>
      Las operaciones que realice el CLIENTE con la Tarjeta estarán sujetas a los límites transaccionales cuyo detalle
      es entregado al CLIENTE conjuntamente con la Tarjeta y que constan en la página web (www.miplata.com.pe).
    </p>
    <p>
      <strong>QUINTA. CONDICIONES DE USO DE LA TARJETA:</strong>
      SERVITEBCA entregará al CLIENTE una Tarjeta, magnetizada y numerada, que vendrá en un sobre cerrado y sellado el
      cual también contendrá las condiciones de uso de la Tarjeta. Con la Tarjeta, el CLIENTE podrá realizar
      transacciones, en Soles y Dólares de los Estados Unidos de América, en el Perú y en el extranjero. La Tarjeta es
      prepago por lo que el uso de la misma estará condicionado a que la Cuenta tenga saldo disponible. El CLIENTE asume
      plena responsabilidad por el resguardo y mal uso de la Tarjeta, así como por la pérdida o hurto de la misma,
      debiendo informar inmediatamente a SERVITEBCA por los medios definidos en el presente Contrato.
    </p>
    <p>
      <strong>SEXTA. CLAVE SECRETA:</strong>
      Junto con la Tarjeta, SERVITEBCA entregará a EL CLIENTE una clave secreta (en adelante, la “Clave”). Dicha Clave
      será la única que podrá ser utilizada por EL CLIENTE para realizar consumos en establecimientos afiliados a la red
      de Visa o MasterCard, según corresponda a la Tarjeta, así como para efectuar disposiciones de efectivo en cajeros
      automáticos. El CLIENTE asume responsabilidad por mantener en reserva y no divulgar las claves, ya que todas las
      transacciones realizadas mediante el uso de éstas serán consideradas como válidamente efectuadas por EL CLIENTE.
    </p>
    <p>
      <strong>SÉTIMA. BLOQUEO DE TARJETAS:</strong><br>
      A. POR HURTO, ROBO, EXTRAVIO DE TARJETA O PERDIDA DE CLAVE SECRETA<br>
      7.1. EL CLIENTE deberá notificar a SERVITEBCA el hurto, robo o extravío de la Tarjeta, o en caso de que un tercero
      no autorizado tome conocimiento de cualquiera de las Claves, inmediatamente después de que ocurra cualquiera de
      estos hechos, llamando al Centro de Contacto para que éste bloquee la Cuenta. EL CLIENTE será responsable por las
      transacciones realizadas con la Tarjeta en tanto SERVITEBCA no haya recibido la respectiva solicitud de
      bloqueo.<br>
      7.2. En caso exista saldo remanente en la Cuenta bloqueada:<br>
      (i) EL CLIENTE deberá solicitar la reposición de la Tarjeta, previo pago de la comisión respectiva, según el
      Tarifario vigente, el cual también se encuentra en www.miplata.com.pe. El saldo se trasladará a la nueva
      Tarjeta.<br> (ii) En caso El CLIENTE no desee la reposición de la Tarjeta, podrá solicitar el reembolso del saldo
      disponible en la Tarjeta bloqueada, para lo cual deberá comunicarse con el Centro de Contacto para que le informe
      los mecanismos para la devolución. Dichos mecanismos para devolución del saldo remanente incluyen, según determine
      SERVITEBCA, la entrega de dinero en efectivo o cheque.<br>
      B. POR OTROS MOTIVOS<br>
      7.3. El CLIENTE podrá solicitar el bloqueo temporal de la Cuenta a través del Centro de Contacto. Para activar la
      Cuenta nuevamente, deberá pasar la validación positiva, en cuyo caso se activará la Cuenta el día hábil siguiente.
      SERVITEBCA informará a la Empresa sobre el bloqueo temporal de la Cuenta a fin de que no la considere para futuras
      recargas (conversiones).<br>
      7.4. El CLIENTE podrá solicitar el bloqueo definitivo de la Cuenta, para lo cual deberá comunicarse con el Centro
      de Contacto. De contar con saldo disponible y no solicitar la reposición de la Tarjeta, EL CLIENTE deberá
      solicitar al Centro de Contacto la devolución. SERVITEBCA informará los mecanismos para la devolución (entrega en
      efectivo o cheque), la cual se llevará a cabo en la oficina de SERVITEBCA. SERVITEBCA informará a la Empresa sobre
      el bloqueo definitivo de la Cuenta a fin de que no la considere para futuras recargas (conversiones).<br>
      C. POR PARTE DE SERVITEBCA<br>
      7.5. SERVITEBCA podrá bloquear temporalmente la Cuenta por mandato de autoridad competente o cuando tenga indicios
      de operaciones fraudulentas, inusuales, irregulares, ilícitas o sospechosas, incumpliendo la política de lavado de
      activos de SERVITEBCA de acuerdo con la ley de la materia o cuando el CLIENTE hubiera suministrado información
      inexacta, incompleta o falsa. En estos supuestos, SERVITEBCA le informará al CLIENTE de la medida adoptada
      mediante correo electrónico, comunicación telefónica o escrita dirigida a su domicilio.
    </p>
    <p>
      <strong>OCTAVA. EXCLUSIÓN DE RESPONSABILIDAD: </strong>
      EL CLIENTE no será responsable de pérdidas en casos de clonación de la Tarjeta, suplantación del usuario en las
      oficinas de SERVITEBCA o funcionamiento defectuoso de los canales o sistemas puestos a disposición de EL CLIENTE
      para efectuar sus operaciones .
    </p>
    <p>
      <strong>NOVENA. PLAZO: </strong>
      El presente Contrato es de plazo indeterminado.
    </p>
    <p>
      <strong>DÉCIMA. RESOLUCIÓN: </strong>
      SERVITEBCA podrá resolver el presente Contrato en cualquiera de los siguientes supuestos:<br>
      a) Si la Cuenta se mantuviera inactiva (sin movimientos) por un plazo igual o mayor a seis (6) meses;<br>
      b) Caso fortuito o fuerza mayor;<br>
      c) Cuando se trate de la aplicación de normas prudenciales emitidas por la Superintendencia de Banca, Seguros y
      Administradoras de Fondos de Pensiones, tales como aquéllas vinculadas a la prevención de lavado de activos y
      financiamiento del terrorismo;<br>
      d) Por suministro de información falsa, incompleta o insuficiente por parte de EL CLIENTE;<br>
      e) Si mantener el Contrato vigente incumple las políticas de SERVITEBCA o de alguna disposición legal.<br>
      En los supuestos descritos en los literales c) y d), la comunicación respecto a la resolución del Contrato o
      bloqueo de la Cuenta se realizará dentro de los siete (07) días calendarios posteriores de adoptada la medida. En
      los demás supuestos, SERVITEBCA informará al CLIENTE de la decisión de resolver el Contrato con tres (3) días
      hábiles de anticipación.<br>
      Una vez resuelto definitivamente el Contrato, EL CLIENTE únicamente podrá obtener el reembolso de los fondos
      disponibles en la Tarjeta previa comunicación con el Centro de Contacto para que le informe los mecanismos para la
      devolución.
    </p>
    <p>
      <strong>UNDÉCIMA. TARIFAS DE SERVICIOS: </strong>
      Los servicios objeto de este Contrato estarán sujetos a las comisiones y gastos que se indican en el Tarifario que
      será entregado al CLIENTE conjuntamente con el presente Contrato y que forma parte del mismo. EL CLIENTE autoriza
      expresamente a SERVITEBCA a compensar con los saldos disponibles en la Cuenta, cualquier costo, total o parcial,
      que se encuentre pactado en el presente Contrato. EL CLIENTE acepta que SERVITEBCA podrá rechazar las operaciones
      realizadas cuando la Cuenta no tenga saldo disponible para cubrir el pago de las comisiones y/o gastos, de acuerdo
      al presente Contrato. Si el saldo fuera insuficiente para cobrarse del mismo las comisiones/gastos en un plazo
      igual o mayor a seis (6) meses, EL CLIENTE autoriza expresamente a SERVITEBCA a resolver el Contrato y cancelar la
      Tarjeta.
    </p>
    <p>
      <strong>DUODÉCIMA. OBLIGACIONES DE SERVITEBCA: </strong>
      SERVITEBCA tendrá las siguientes obligaciones: 12.1. Proveer la Tarjeta a EL CLIENTE, según la presentación física
      y condiciones técnicas que SERVITEBCA considere necesarias para la prestación del servicio. 12.2. Permitir el uso
      de la Tarjeta para los fines establecidos en este Contrato, hasta el saldo disponible en la Cuenta. 12.3. Poner a
      disposición de EL CLIENTE un sistema de consulta de movimientos, consulta de saldos y de información sobre la
      Cuenta.
    </p>
    <p>
      <strong>DÉCIMO TERCERA. OBLIGACIONES DE EL CLIENTE: </strong>
      EL CLIENTE tendrá las siguientes obligaciones: 13.1. Pagar las comisiones y/o gastos establecidos en el Tarifario
      vigente. 13.2. Notificar a SERVITEBCA oportunamente sobre el hurto, robo o extravío de la Tarjeta o en caso un
      tercero tome conocimiento de la Clave, a fin que SERVITEBCA proceda al bloqueo de la Tarjeta. 13.3. Actualizar
      constantemente sus datos por los medios implementados por SERVITEBCA.
    </p>
    <p>
      <strong>DÉCIMO CUARTA. COMUNICACIONES: </strong>
      SERVITEBCA se reserva el derecho de modificar las condiciones contractuales, incluyendo comisiones y gastos, en
      cuyo caso informará previamente al CLIENTE dentro de los plazos y por los medios establecidos en el presente
      Contrato. Las comunicaciones que informen sobre modificaciones a las comisiones y/o gastos, resolución del
      Contrato, limitación o exoneración de responsabilidad por parte de SERVITEBCA así como la incorporación de
      servicios no relacionados directamente al servicio objeto del Contrato, serán enviadas al CLIENTE a través de
      cualquiera de los siguientes medios: (i) correos electrónicos, (ii) llamadas telefónicas o (iii) comunicaciones al
      domicilio. Dichas comunicaciones se enviarán con cuarenta y cinco (45) días de anticipación a su entrada en
      vigencia. Modificaciones contractuales distintas a las antes indicadas, serán informadas, con cuarenta y cinco
      (45) días de anticipación a su entrada en vigencia, a través de cualquiera de los siguientes medios: (i) la página
      web (www.miplata.com.pe), (ii) mensajes de texto (SMS) o (iii) correos electrónicos y en general, cualquier otro
      medio electrónico que SERVITEBCA disponga. En caso EL CLIENTE no estuviera de acuerdo con las modificaciones,
      podrá resolver el Contrato dentro de los plazos antes indicados. SERVITEBCA enviará las comunicaciones directas
      según los datos consignados por EL CLIENTE, por lo que el CLIENTE se obliga a notificar a SERVITEBCA por escrito,
      vía telefónica y/o vía web, cualquier cambio de los datos proporcionados. EL CLIENTE podrá consultar sobre los
      servicios y procedimientos de SERVITEBCA a través de los siguientes canales de atención: (i) página web
      (www.miplata.com.pe); (ii) Centro de Contacto, las 24 horas del días, los 365 días del año y cualquier otro que
      SERVITEBCA ponga a su disposición. Asimismo, EL CLIENTE podrá dirigir cualquier reclamo al Centro de Contacto, la
      página web (www.miplata.com.pe) y el correo electrónico servicios@tebca.com.pe.
    </p>
    <p>
      <strong>DÉCIMO QUINTA. AUTORIZACIÓN: </strong>
      EL CLIENTE expresamente faculta a SERVITEBCA para realizar las gestiones oportunas para constatar la veracidad de
      los datos aportados por éste. Asimismo, SERVITEBCA podrá requerir al CLIENTE información adicional o la
      rectificación o confirmación de los datos brindados por el CLIENTE, reservándose el derecho de no prestarle ningún
      servicio, en caso éste no haya suministrado o haya suministrado documentación y/o información falsa, incorrecta o
      contradictoria. A estos efectos, si el CLIENTE no brinda o rectifica la información solicitada dentro del plazo de
      siete (7) días calendario, SERVITEBCA procederá a bloquear la Cuenta y devolverá el saldo disponible en ésta, a
      través de la entrega de dinero en efectivo o cheque, según determine SERVITEBCA, en sus oficinas. Del mismo modo,
      EL CLIENTE autoriza a SERVITEBCA, sin que ello implique obligación o responsabilidad por parte de SERVITEBCA, para
      que investigue, con las más amplias facultades, todo lo relativo a los presuntos usos indebidos de la Tarjeta y se
      compromete a prestarle toda la colaboración que ésta requiera.
    </p>
    <p>
      <strong>DÉCIMO SEXTA. PROTECCIÓN DE DATOS PERSONALES: </strong>
      Se informa que los datos personales proporcionados por el CLIENTE a SERVITEBCA quedan incorporados al banco de
      datos de clientes de SERVITEBCA. Dicha información será utilizada para efectos de la gestión de los servicios
      objeto del presente Contrato (incluyendo procesamiento de datos, remisión de correspondencia, entre otros), la
      misma que podrá ser realizada a través de terceros. Asimismo, el CLIENTE autoriza a SERVITEBCA a utilizar, en
      tanto esta autorización no sea revocada, sus datos personales, incluyendo datos sensibles, que hubieran sido
      proporcionados directamente a SERVITEBCA, aquellos que pudieran encontrarse en fuentes accesibles para el público
      o los que hayan sido obtenidos de terceros; para tratamientos que supongan desarrollo de acciones comerciales,
      incluyendo la remisión (vía medio físico, electrónico o telefónico) de publicidad, información u
      ofertas/promociones (personalizadas o generales) de servicios de SERVITEBCA y/o de otras empresas del Grupo
      Intercorp y sus socios estratégicos, entre las que se encuentran aquellas difundidas en el portal de la
      Superintendencia del Mercado de Valores (www.smv.gob.pe) así como en el portal www.intercorp.com.pe/es. EL CLIENTE
      declara conocer que SERVITEBCA podrá usar, brindar y/o transferir sus datos personales para dar cumplimiento a las
      obligaciones y/o requerimientos que se generen en virtud de las normas vigentes en el ordenamiento jurídico
      peruano, incluyendo pero sin limitarse a las vinculadas al sistema de prevención de lavado de activos y
      financiamiento del terrorismo y normas prudenciales. SERVITEBCA podrá dar tratamiento y eventualmente transferir
      los datos personales del CLIENTE a autoridades y terceros autorizados por ley. Para tales efectos, el CLIENTE
      autoriza a SERVITEBCA la cesión, transferencia o comunicación de sus datos personales, a dichas empresas y entre
      ellas. Se informa al titular de los datos personales, que puede revocar la autorización para el tratamiento de sus
      datos personales en cualquier momento, de conformidad con lo previsto en la Ley de Protección de Datos Personales
      (Ley No. 29733) y su Reglamento (Decreto Supremo No. 003-2013-JUS. Para ejercer este derecho, o cualquier otro
      previsto en dichas normas, el titular de datos personales podrá presentar su solicitud en la oficina de SERVITEBCA
      o a través del Centro de Contacto.
    </p>
    <p>
      <strong>DÉCIMO SÉTIMA. DOMICILIO, SOLUCIÓN DE CONTROVERSIAS, LEGISLACIÓN APLICABLE Y DECLARACIÓN DE CONFORMIDAD:
      </strong>
      17.1. Para todo efecto derivado del presente Contrato, el CLIENTE declara como domicilio el consignado en la
      cartilla de información. Asimismo, para la solución de controversias derivadas del Contrato, las partes se someten
      a la competencia y jurisdicción de los jueces del lugar donde se celebra el Contrato. 17.2. El presente Contrato
      se regula bajo las normas aplicables de la República del Perú. 17.3. EL CLIENTE declara que: (i) suscribe este
      Contrato aceptando sus términos, (ii) las dudas sobre los términos y conceptos han sido absueltos y (iii) ha
      recibido la información/documentación necesaria respecto a las Tarjetas.
    </p>
    <p>
      <strong>DÉCIMO OCTAVA. TEXTO DEL CONTRATO: </strong>
      18.1. El Texto del presente documento también consta en la página web www.miplata.com.pe. 18.2. EL CLIENTE declara
      haber recibido un ejemplar del presente Contrato, así como una guía de uso de la Tarjeta. Para mayor información
      sobre las condiciones de uso, EL CLIENTE podrá ingresar a www.miplata.com.pe o comunicarse con el Centro de
      Contacto.
    </p>
  </div>
  <div class="form-actions">
    <button id="close-contrato" class="novo-btn-primary">Aceptar</button>
  </div>
</div>

<div id="contrato_cuenta_general" style='display:none'>
  <div class="cond-serv">

    <p>
      <strong>PRIMERA. DEFINICIONES:</strong><br>
      Cliente: persona natural titular de la cuenta general de dinero electrónico abierta en SERVITEBCA.
      Cuenta: cuenta general de dinero electrónico, cuya titularidad es del CLIENTE
      Dinero Electrónico: valor monetario almacenado en soportes electrónicos (tales como tarjetas electrónicas prepago)
      diseñados para atender usos generales.
      PRIMERA. DEFINICIONES:
      Emisión: incluye la emisión propiamente dicha; que es la conversión de dinero electrónico a dinero físico por el
      mismo valor que se recibe, a través de su
      almacenamiento en un soporte electrónico; la reconversión a efectivo (retiros); transferencias; pagos y cualquier
      otro movimiento o transacción vinculado al valor
      monetario almacenado en el soporte electrónico que SERVITEBCA se encuentre autorizado a realizar.
      Empresa: empresa que ha suscrito un contrato de servicios con SERVITEBCA para que le provea los servicios de
      emisión, gestión y procesamiento de tarjetas
      electrónica recargables. La Empresa solicita la emisión de las Tarjetas y podrá también realizar recargas
      (conversión) a las mismas.
      Tarjeta: tarjeta prepaga de dinero electrónico recargable que será entregada por SERVITEBCA al CLIENTE para que
      éste pueda realizar operaciones y acceder a
      servicios que SERVITEBCA le ofrezca, con cargo al saldo en la Cuenta, para lo cual utilizará la Clave Secreta que
      le será proporcionada conjuntamente con la Tarjeta.
    </p>
    <p>
      <strong>SEGUNDA. OBJETO:</strong>
      Mediante el presente contrato las partes acuerdan que SERVITEBCA brindará el servicio de dinero electrónico al
      CLIENTE, a través de una
      Cuenta cuyo soporte electrónico será la Tarjeta. La Tarjeta podrá ser utilizada a nivel nacional e internacional.
    </p>
    <p>
      <strong>TERCERA. CONDICIÓN PARA LA PRESTACIÓN DEL SERVICIO:</strong>
      Para que EL CLIENTE pueda obtener la Tarjeta, la Empresa debe mantener una relación comercial vigente con
      SERVITEBCA. Para ser titular de la Tarjeta, el CLIENTE debe ser mayor de edad y haber completado los datos de
      identificación requeridos por SERVITEBCA.
    </p>
    <p>
      <strong>CUARTA. CARACTERÍSTICAS Y CONDICIONES DE LAS OPERACIONES, LÍMITES Y RESTRICCIONES:</strong><br>
      4.1 Operaciones
      <br>a) Recargas (o conversión): La Tarjeta admite recargas de la Empresa y del CLIENTE. EL CLIENTE podrá efectuar
      recargas a través de cajeros corresponsales a nivel
      nacional, sin perjuicio de otros canales que SERVITEBCA podrá poner a su disposición.
      <br>b) Retiros de efectivo (o reconversión): EL CLIENTE podrá realizar retiros de efectivo a través de todos los
      cajeros automáticos a nivel nacional y en el exterior. Los
      retiros podrán hacerse en cualquier moneda, en cuyo caso estarán sujetos al tipo de cambio. La comisión por
      retiros se encuentra indicada en el tarifario y será
      cargada del saldo disponible en la Cuenta.
      <br>c) Consumos: EL CLIENTE podrá realizar consumos para el pago de bienes y/o servicios en los establecimientos
      afiliados a las marcas Visa o MasterCard, según
      corresponda a la Tarjeta. El valor del consumo será debitado de la Cuenta y se indicará en el voucher. Asimismo,
      el CLIENTE podrá realizar consumos en páginas
      web, locales e internacionales. En cualquier caso, los consumos podrán efectuarse en cualquier moneda, en cuyo
      caso estarán sujetos al tipo de cambio .
      <br>d) Consultas de saldos y movimientos: El CLIENTE podrá efectuar consultas de saldos y movimientos libre de
      costo por (i) Aplicación de Acceso Móvil de Servitebca
      (App’s), (ii) Centro de Contacto de SERVITEBCA, llamando al (511) 619-8931 (en adelante el “Centro de Contacto” y
      (iii) página web (www.miplata.com.pe). Las
      consultas de saldo en Cajeros GlobalNet tendrá el costo indicado en el tarifario y será cargado del saldo
      disponible en la Cuenta.
      El CLIENTE podrá encontrar el detalle de las instrucciones para efectuar operaciones con la Tarjeta en la página
      web (www.miplata.com.pe).
      <br>4.2. Límites y Restricciones
      <br>Las operaciones que realice el CLIENTE con la Tarjeta estarán sujetas a los límites transaccionales cuyo
      detalle es entregado al CLIENTE conjuntamente con la Tarjeta
      y que constan en la página web (www.miplata.com.pe), los cuales en ningún caso superarán el límite de 1 UIT
      establecido en la norma aplicable.
    </p>
    <p>
      <strong>QUINTA. CONDICIONES DE USO DE LA TARJETA:</strong>
      La Tarjeta será magnetizada y numerada y vendrá en un sobre cerrado y sellado el cual también contendrá
      lascondiciones de uso de la Tarjeta. Con la Tarjeta, el CLIENTE podrá realizar transacciones, en Soles y Dólares
      de los Estados Unidos de América, en el Perú y en el
      extranjero. La Tarjeta es prepago por lo que el uso de la misma estará condicionado a que la Cuenta tenga saldo
      disponible. Salvo por los supuestos de exclusión
      de responsabilidad establecidos en la cláusula octava del presente Contrato, El CLIENTE asume plena
      responsabilidad por el resguardo y mal uso de la Tarjeta, así
      como por la pérdida o hurto de la misma, debiendo informar inmediatamente a SERVITEBCA según lo dispuesto en el
      presente Contrato.
    </p>
    <p>
      <strong>SEXTA. CLAVE SECRETA:</strong>
      Junto con la Tarjeta, SERVITEBCA entregará a EL CLIENTE una clave secreta (en adelante, la “Clave”). Dicha Clave
      será la única que podrá ser
      utilizada por EL CLIENTE para realizar consumos en establecimientos afiliados a la red de Visa o MasterCard, según
      corresponda a la Tarjeta, así como para efectuar
      disposiciones de efectivo en cajeros automáticos. El CLIENTE asume responsabilidad por mantener en reserva y no
      divulgar las claves, ya que todas las transacciones
      realizadas mediante el uso de éstas serán consideradas como válidamente efectuadas por EL CLIENTE.
    </p>
    <p>
      <strong>SÉTIMA. BLOQUEO DE TARJETAS:</strong><br>
      A. POR HURTO, ROBO, EXTRAVIO DE TARJETA O PERDIDA DE CLAVE SECRETA
      <br>7.1. EL CLIENTE deberá bloquear la Cuenta en caso de hurto, robo o extravío de la Tarjeta o Clave, o en caso
      de que un tercero no autorizado tome conocimiento de
      cualquiera de las Claves, inmediatamente después de que ocurra cualquiera de estos hechos. EL CLIENTE podrá
      bloquear la Cuenta llamando al Centro de Contacto
      o a través de otros canales que SERVITEBCA pondrá a su disposición y que le serán oportunamente informados. Dichos
      canales se encontrarán a disposición del
      CLIENTE los 365 días del año y las 24 horas del día. Salvo por los supuestos de exclusión de responsabilidad
      establecidos en la cláusula octava del presente Contrato,
      EL CLIENTE será responsable por las transacciones realizadas con la Tarjeta en tanto SERVITEBCA no haya recibido
      la respectiva solicitud de bloqueo.
      <br>7.2. En caso exista saldo remanente en la Cuenta bloqueada:
      (i) EL CLIENTE deberá solicitar la reposición de la Tarjeta, previo pago de la comisión respectiva, según el
      Tarifario vigente, el cual también se encuentra en
      www.miplata.com.pe. El saldo se trasladará a la nueva Tarjeta.
      (ii) En caso El CLIENTE no desee la reposición de la Tarjeta, podrá solicitar el reembolso del saldo disponible en
      la Tarjeta bloqueada, para lo cual deberá comunicarse
      con el Centro de Contacto para que le informe los mecanismos para la devolución. Dichos mecanismos para devolución
      del saldo remanente incluyen, según
      determine SERVITEBCA, la entrega de dinero en efectivo o cheque.
      <br>B. POR OTROS MOTIVOS
      <br>7.3. El CLIENTE podrá bloquear temporalmente la Cuenta directamente a través del App o a través del Centro de
      Contacto. Para activar la Cuenta nuevamente, podrá
      hacerlo a través del App o del Centro de Contacto, en cuyo caso se le solicitará sus datos para validar su
      identidad.
      <br>7.4. El CLIENTE podrá bloquear definitivamente la Cuenta, directamente a través del App o a través del Centro
      de Contacto. De contar con saldo disponible y no
      solicitar la reposición de la Tarjeta, EL CLIENTE deberá solicitar al Centro de Contacto la devolución. SERVITEBCA
      informará los mecanismos para la devolución (entrega
      en efectivo o cheque), la cual se llevará a cabo en la oficina de SERVITEBCA.
      <br>C. POR PARTE DE SERVITEBCA
      <br>7.5. SERVITEBCA podrá bloquear la Cuenta de forma temporal o definitiva, por mandato de autoridad competente o
      cuando tenga indicios de operaciones
      fraudulentas, inusuales, irregulares, ilícitas o sospechosas, incumpliendo la política de lavado de activos de
      SERVITEBCA, de acuerdo con lo dispuesto en las normas
      prudenciales o cuando el CLIENTE hubiera suministrado información inexacta, incompleta o falsa. En estos
      supuestos, SERVITEBCA le informará al CLIENTE de la
      medida adoptada mediante correo electrónico, comunicación telefónica o escrita dirigida a su domicilio.
    </p>
    <p>
      <strong>OCTAVA. EXCLUSIÓN DE RESPONSABILIDAD: EL CLIENTE </strong>
      no será responsable de pérdidas en casos de clonación de la Tarjeta; cuando las operaciones se hayan
      realizado luego de haber solicitado a SERVITEBCA el bloqueo de la Cuenta por los medios establecidos para ello en
      el numeral 7.1 de la cláusula sétima del presente
      Contrato; suplantación del CLIENTE en las oficinas de SERVITEBCA o funcionamiento defectuoso de los canales o
      sistemas puestos a disposición de EL CLIENTE para
      efectuar sus operaciones.
    </p>
    <p>
      <strong>NOVENA. PLAZO: </strong>
      El presente Contrato es de plazo indeterminado.
    </p>
    <p>
      <strong>DÉCIMA. RESOLUCIÓN: </strong>
      SERVITEBCA podrá resolver el presente Contrato en cualquiera de los siguientes supuestos:
      <br>a) Si la Cuenta se mantuviera inactiva (sin saldo ni movimientos) por un plazo igual o mayor a seis (6) meses;
      <br>b) Caso fortuito o fuerza mayor;
      <br>c) Cuando se trate de la aplicación de normas prudenciales emitidas por la Superintendencia de Banca, Seguros
      y Administradoras de Fondos de Pensiones, tales
      como aquéllas vinculadas a la prevención de lavado de activos y financiamiento del terrorismo;
      <br>d) Por suministro de información falsa, incompleta o insuficiente por parte de EL CLIENTE;
      <br>e) Si mantener el Contrato vigente incumple las políticas de SERVITEBCA o de alguna disposición legal;
      <br>f) Si el saldo en la Cuenta fuera insuficiente para cobrarse del mismo las comisiones/gastos en un plazo igual
      o mayor a seis (6) meses.
      En los supuestos descritos en los literales c) y d), la comunicación respecto a la resolución del Contrato o
      bloqueo de la Cuenta se realizará dentro de los siete (07)
      días calendarios posteriores de adoptada la medida. En los demás supuestos, SERVITEBCA informará al CLIENTE de la
      decisión de resolver el Contrato con tres (3)
      días hábiles de anticipación.
      <br>Una vez resuelto definitivamente el Contrato, EL CLIENTE únicamente podrá obtener el reembolso de los fondos
      disponibles en la Tarjeta previa comunicación con
      el Centro de Contacto para que le informe los mecanismos para la devolución.
    </p>
    <p>
      <strong>UNDÉCIMA. TARIFAS DE SERVICIOS: </strong>
      Los servicios objeto de este Contrato estarán sujetos a las comisiones y gastos que se indican en el Tarifario que
      será entregado
      al CLIENTE conjuntamente con el presente Contrato y que forma parte del mismo. EL CLIENTE autoriza expresamente a
      SERVITEBCA a cargar del saldo disponible en
      la Cuenta, cualquier costo, total o parcial, que se encuentre pactado en el presente Contrato. EL CLIENTE acepta
      que SERVITEBCA podrá rechazar las operaciones
      realizadas cuando la Cuenta no tenga saldo disponible para cubrir el pago de las comisiones y/o gastos, de acuerdo
      al presente Contrato.
    </p>
    <p>
      <strong>DUODÉCIMA. OBLIGACIONES DE SERVITEBCA: </strong>
      SERVITEBCA tendrá las siguientes obligaciones: 12.1. Proveer la Tarjeta a EL CLIENTE, según la presentación física
      y
      condiciones técnicas necesarias para la prestación del servicio. 12.2. Permitir el uso de la Tarjeta para los
      fines establecidos en este Contrato, hasta el saldo
      disponible en la Cuenta. 12.3. Poner a disposición de EL CLIENTE canales de consulta de movimientos, consulta de
      saldos y de información sobre la Cuenta, cuyos
      costos asociados se encontrarán en el tarifario.
    </p>
    <p>
      <strong>DÉCIMO TERCERA. OBLIGACIONES DE EL CLIENTE: </strong>
      EL CLIENTE tendrá las siguientes obligaciones: 13.1. Pagar las comisiones y/o gastos establecidos en el Tarifario
      vigente. 13.2. Notificar a SERVITEBCA oportunamente sobre el hurto, robo o extravío de la Tarjeta o en caso un
      tercero tome conocimiento de la Clave, según lo
      dispuesto en el numeral 7.1 de la cláusula sétima del presente Contrato, a fin que SERVITEBCA proceda al bloqueo
      de la Tarjeta. 13.3. Actualizar constantemente sus
      datos por los medios implementados por SERVITEBCA
    </p>
    <p>
      <strong>DÉCIMO CUARTA. COMUNICACIONES: </strong>
      SERVITEBCA se reserva el derecho de modificar las condiciones contractuales, incluyendo comisiones y gastos, en
      cuyo caso
      informará previamente al CLIENTE dentro de los plazos y por los medios establecidos en el presente Contrato. Las
      comunicaciones que informen sobre
      modificaciones a las comisiones y/o gastos, resolución del Contrato, limitación o exoneración de responsabilidad
      por parte de SERVITEBCA así como la incorporación
      de servicios no relacionados directamente al servicio objeto del Contrato, serán enviadas al CLIENTE a través de
      cualquiera de los siguientes medios de
      comunicación directos: (i) correos electrónicos, (ii) llamadas telefónicas o (iii) comunicaciones al domicilio.
      Dichas comunicaciones se enviarán con cuarenta y cinco
      (45) días de anticipación a su entrada en vigencia. Modificaciones contractuales distintas a las antes indicadas,
      serán informadas, con cuarenta y cinco (45) días de
      anticipación a su entrada en vigencia, a través de cualquiera de los siguientes medios: (i) la página web
      (www.miplata.com.pe) o (ii) correos electrónicos. En caso
      EL CLIENTE no estuviera de acuerdo con las modificaciones, podrá resolver el Contrato dentro de los plazos antes
      indicados. Para comunicar modificaciones
      beneficiosas al CLIENTE, SERVITEBCA utilizará (i) la página web (www.miplata.com.pe) o (ii) correos electrónicos.
      SERVITEBCA enviará las comunicaciones directas
      según los datos consignados por EL CLIENTE, por lo que el CLIENTE se obliga a notificar a SERVITEBCA por escrito,
      vía telefónica y/o vía web, cualquier cambio de los
      datos proporcionados.
      <br>EL CLIENTE podrá consultar sobre los servicios y procedimientos de SERVITEBCA a través de los siguientes
      canales de atención: (i) página web
      (www.miplata.com.pe); (ii) Centro de Contacto, las 24 horas del días, los 365 días del año y cualquier otro que
      SERVITEBCA ponga a su disposición.
      Asimismo, EL CLIENTE podrá dirigir cualquier reclamo al Centro de Contacto, la página web (www.miplata.com.pe) y
      el correo electrónico servicios@tebca.com.pe.
      Los reclamos serán atendidos en un plazo no mayor a treinta (30) días calendario, pudiendo extender dicho plazo
      por otro igual cuando la naturaleza del reclamo
      lo justifique, situación que será informada al CLIENTE antes de la culminación del plazo inicial.
    </p>
    <p>
      <strong>DÉCIMO QUINTA. AUTORIZACIÓN: </strong>
      EL CLIENTE expresamente faculta a SERVITEBCA para realizar las gestiones oportunas para constatar la veracidad de
      los datos
      aportados por éste. Asimismo, SERVITEBCA podrá requerir al CLIENTE información adicional o la rectificación o
      confirmación de los datos brindados por el CLIENTE,
      reservándose el derecho de no prestarle ningún servicio, en caso éste no haya suministrado o haya suministrado
      documentación y/o información falsa, incorrecta
      o contradictoria. A estos efectos, si el CLIENTE no brinda o rectifica la información solicitada dentro del plazo
      de siete (7) días calendario, SERVITEBCA procederá a
      bloquear la Cuenta y devolverá el saldo disponible en ésta, a través de la entrega de dinero en efectivo o cheque,
      según determine SERVITEBCA, en sus oficinas. Del
      mismo modo, EL CLIENTE autoriza a SERVITEBCA, sin que ello implique obligación o responsabilidad por parte de
      SERVITEBCA, para que investigue, con las más
      amplias facultades, todo lo relativo a los presuntos usos indebidos de la Tarjeta y se compromete a prestarle toda
      la colaboración que ésta requiera.
    </p>
    <p>
      <strong>DÉCIMO SEXTA. DOMICILIO, SOLUCIÓN DE CONTROVERSIAS, LEGISLACIÓN APLICABLE Y DECLARACIÓN DE
        CONFORMIDAD</strong>
      16.1. Para todo efecto derivado del presente Contrato, el CLIENTE declara como domicilio el consignado en el
      formulario de datos. Asimismo, para la solución de controversias derivadas del Contrato, las partes
      se someten a la competencia y jurisdicción de los jueces del lugar donde se celebra el Contrato. 16.2. El presente
      Contrato se regula bajo las normas aplicables de
      la República del Perú. 16.3. EL CLIENTE declara que: (i) suscribe este Contrato aceptando sus términos, (ii) las
      dudas sobre los términos y conceptos han sido absueltos
      y (iii) ha recibido la información/documentación necesaria respecto a la Cuenta y las Tarjetas.
    </p>
    <p>
      <strong>DÉCIMO SÉTIMA. TEXTO DEL CONTRATO:: </strong>
      17.1. El Texto del presente documento también consta en la página web www.miplata.com.pe. 17.2. EL CLIENTE declara
      haber
      recibido un ejemplar del presente Contrato, así como un resumen de condiciones. Para mayor información sobre las
      condiciones de uso, EL CLIENTE podrá ingresar
      a www.miplata.com.pe o comunicarse con el Centro de Contacto.
    </p>

  </div>
  <div class="form-actions">
    <button id="close-contrato-general" class="novo-btn-primary">Aceptar</button>
  </div>
</div>
