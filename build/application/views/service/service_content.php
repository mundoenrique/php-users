<div id="service" class="service-content h-100 bg-content">
    <div class="py-4 px-5">
      <header class="">
        <h1 class="primary h0">Atención al cliente</h1>
      </header>
      <section>
        <div class='product-scheme pt-3'>
          <div class="form-group">
            <label for="otherPhone">Selecciona una cuenta</label>
            <select class="custom-select form-control" placeholder="Seleccione" name="phoneType" id="phoneType">
              <option value="OFC">604842******8712</option>
              <option value="FAX">604841******4423</option>
            </select>
          </div>
          <p class="field-tip mt-3">Selecciona la operación que deseas realizar</p>
          <ul class='services-content list-inline flex justify-between'>
            <li id="lock" class="list-inline-item services-item center"><i class="icon-lock block"></i>Bloqueo <br>de cuenta</li>
            <li id="replace" class="list-inline-item services-item center"><i class="icon-spinner block"></i>Solicitud <br>de reposición</li>
            <li id="key" class="list-inline-item services-item center"><i class="icon-key block"></i>Cambio <br>de PIN</li>
            <li id="recover" class="list-inline-item services-item center"><i class="icon-key block"></i>Solicitud <br>de PIN</li>
          </ul>
        </div>
      </section>

      <div id="lockAcount" class="services-both none">
        <div id="msg-block" class="msg-prevent">
          <h2>Solicitud de reposición</h2>
          <h3></h3>
          <div id="result-block"></div>
        </div>
        <div id="prevent-bloq" class="msg-prevent" style="display: none;">
          <h2>Si realmente deseas <span id="action">Bloquear </span> tu tarjeta, presiona continuar</h2>
        </div>
        <form id="bloqueo-cuenta" accept-charset="utf-8" method="post" class="profile-1">
          <input type="hidden" id="fecha-exp-bloq" name="fecha-exp-bloq">
          <input type="hidden" id="card-bloq" name="card-bloq">
          <input type="hidden" id="status" name="status">
          <input type="hidden" id="lock-type" name="lock-type">
          <input type="hidden" id="prefix-bloq" name="prefix-bloq">
          <input type="hidden" id="montoComisionTransaccion" name="montoComisionTransaccion" value="0">
          <fieldset class="col-md-12-profile">
            <ul id="block-ul" class="row-profile">
							<li id="reason-rep" class="col-md-3-profile" style="">
								<div class="form-group">
									<label for="mot-sol">Motivo de la solicitud</label>
									<select id="mot-sol" name="mot-sol">
										<option value="">Selecciona</option>
										<option value="41">Tarjeta perdida</option>
										<option value="43">Tarjeta robada</option>
										<option value="TD">Tarjeta deteriorada</option>
										<option value="TR">Reemplazar tarjeta</option>
									</select>
								</div>
                <input type="hidden" id="mot-sol-now" name="mot-sol-now">
              </li>
            </ul>
          </fieldset>
          <div class="flex items-center justify-end pt-3 border-top">
            <a class="btn underline" href="cpo_login.php">Cancelar</a>
            <button id="btnContinuar" name="btnContinuar" class="btn btn-primary" type="submit">Continuar</button>
          </div>
        </form>

        <div id="msg1" style="clear:both;"></div>
      </div>

      <div id="changeKey" class="services-both none">

        <div id="msg-change" class="msg-prevent">
          <h2>Cambio de PIN</h2>
          <h3></h3>
          <div id="result-change"></div>
        </div>

        <form id="cambio-pin" accept-charset="utf-8" method="post" class="profile-1">
          <input id="fecha-exp-cambio" type="hidden" name="fecha-exp-cambio">
          <input id="card-cambio" type="hidden" name="card-cambio">
          <input type="hidden" id="prefix-cambio" name="prefix-cambio">
          <fieldset class="col-md-12-profile">
            <ul id="change-ul" class="row-profile">
              <li class="col-md-3-profile">
                <label for="pin-current">PIN actual</label>
                <input class="field-medium" id="pin-current" name="pin-current" maxlength="4" type="password" autocomplete="off">
                <input type="hidden" id="pin-current-now" name="pin-current-now">
              </li>
            </ul>
            <ul class="row-profile">
              <li class="col-md-3-profile">
                <label for="new-pin">Nuevo PIN</label>
                <input class="field-medium" id="new-pin" name="new-pin" maxlength="4" type="password" autocomplete="off">
                <input type="hidden" id="new-pin-now" name="new-pin-now">
              </li>
              <li class="col-md-3-profile">
                <label for="confirm-pin">Confirmar PIN</label>
                <input class="field-medium" id="confirm-pin" maxlength="4" name="confirm-pin" type="password" autocomplete="off">
              </li>
            </ul>
          </fieldset>
          <div class="flex items-center justify-end pt-3 border-top">
            <a class="btn underline" href="cpo_login.php">Cancelar</a>
            <button id="btnContinuar" name="btnContinuar" class="btn btn-primary" type="submit">Continuar</button>
          </div>
        </form>

        <div id="msg2" style="clear:both;"></div>
      </div>

      <div id="recKey" class="services-both none">
        <div id="msg-rec" class="msg-prevent-pin">
          <h2>Solicitud de reposición de PIN</h2>
          <h3></h3>
          <div id="result-rec"></div>
        </div>
        <div id="rec-clave" class="msg-prevent" style="">
          <p class="msg-pin">Esta solicitud genera un Lote de reposición que es indispensable que tu empresa autorice en Conexión Empresas Online, para poder emitir el nuevo PIN.</p>
          <p class="msg-pin">Si realmente deseas solicitar la reposición de tu PIN, presiona continuar. El PIN será enviado en un máximo de 5 días hábiles en un sobre de seguridad a la dirección de tu empresa.</p>
        </div>
        <form id="recover-key" accept-charset="utf-8" method="post" class="profile-1">
          <input type="hidden" id="fecha-exp-rec" name="fecha-exp-rec">
          <input type="hidden" id="card-rec" name="card-rec">
          <input type="hidden" id="prefix-rec" name="prefix-rec">
        </form>
        <div class="flex items-center justify-end pt-3 border-top">
            <a class="btn underline" href="cpo_login.php">Cancelar</a>
            <button id="btnContinuar" name="btnContinuar" class="btn btn-primary" type="submit">Continuar</button>
          </div>
      </div>

    </div>
  </div>
