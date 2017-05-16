<div id="content" idUsuario="<? echo $this->session->userdata("userName") ?>" confirmacion="<? echo $this->session->userdata("transferir") ?>">
    <div id="content-clave" style='display:none'>
        <article>
            <header>
                <h1>Pagos</h1>
            </header>
            <section>
                <div id="content-holder">
                    <h2>Autenticación Requerida</h2>
                    <p>Para realizar transacciones con sus cuentas desde <strong>Conexión Personas</strong> es necesario proporcione su clave de operaciones. Esta clave le será solicitada solamente una vez durante su sesión actual.</p>
                    <fieldset class="fieldset-column-center">
                        <label for="transpwd">Clave de Operaciones</label>
                        <input class="field-medium" id="transpwd" name="transpwd" type="password" />
                    </fieldset>
                    <p>En caso de haber olvidado su <strong>Clave de Operaciones</strong></strong>, comuníquese con el <strong>Centro de Contacto</strong>.</p>
                    <div class="form-actions">
                        <a href="<? echo $this->config->item("base_url"); ?>/transfer/index_tcd"><button type="reset">Cancelar</button></a>
                        <button id="continuar_transfer">Continuar</button>
                    </div>
                </div>
            </section>
        </article>
    </div>
    <div id="content_tdc" style='display:none'>
        <article>
            <header>
                <h1>Pagos de Tarjetas de Crédito</h1>
            </header>
            <section>
                <nav id="secondary-menu">
                    <ul class="menu">
                        <li class="menu-item add">
                            <a href="<? echo $this->config->item("base_url"); ?>/affiliation/affiliation_tdc" rel="section">Afiliar</a>
                        </li>
                        <li class="menu-item handler">
                            <a href="<? echo $this->config->item("base_url"); ?>/adm/adm_tdc" rel="section">Administrar Afiliaciones</a>
                        </li>
                        <li class="menu-item current-menu-item manage">
                            <a href="<? echo $this->config->item("base_url"); ?>/transfer/index_tdc" rel="section">Realizar Pago</a>
                        </li>
                        <li class="menu-item log">
                            <a href="<? echo $this->config->item("base_url"); ?>/historial/historial_tdc" rel="section">Historial</a>
                        </li>
                    </ul>
                </nav>
                <div id="content-transfer-P2C">
                    <div id="progress">
                        <ul class="steps">
                            <li class="step-item current-step-item"><span aria-hidden="true" class="icon-card"></span> Realizar Pago</li>
                            <li class="step-item"><span aria-hidden="true" class="icon-view"></span> Confirmación</li>
                            <li class="step-item"><span aria-hidden="true" class="icon-thumbs-up"></span> Finalización</li>
                        </ul>
                    </div>
                    <a class="button alternate-button small-button" href="<? echo $this->config->item("base_url"); ?>/affiliation/affiliation_tdc">Afiliar TDC</a>
                    <h2>Realizar Pago</h2>
                    <p>Espacio reservado para indicaciones sobre completado de datos necesarios para llevar a cabo el pago de tarjetas de crédito por demanda del usuario.</p>
                    <!-- <form accept-charset="utf-8" id="validate"> -->
                    <fieldset>
                        <label for="donor">Cuenta de Origen</label>
                        <div class="group" id="donor">
                            <div class="product-presentation dialog">
                                <a class="button product-button" ><span aria-hidden="true" class="icon-find"></span></a>
                                <input id="donor-cardnumber" name="donor-cardnumber" type="hidden" value="" />
                            </div>
                            <div class="product-info">
                                <p class="field-tip">Seleccione una cuenta propia desde la cual se emitirá el pago.</p>
                            </div>
                            <div class="product-scheme">
                                <ul class="product-balance-group disabled-product-balance-group">
                                    <li>Disponible <span class="product-balance" id="balance-available"> <?php echo lang("MONEDA"); ?> 0,00</span></li>
                                    <li>A debitar <span class="product-balance" id="balance-debit"> <?php echo lang("MONEDA"); ?> 0,00</span></li>
                                </ul>
                            </div>
                        </div>
                        <label for="beneficiary-1x">Tarjetas de Crédito a Pagar<!-- <span class="field-instruction">(máx. 3 simultáneas)</span>--></label>
                        <div id="tdestino">
                            <div class="group obscure-group" id='btn-destino'>
                                <div class="product-presentation">
                                    <a class="dialogDestino button product-button disabled-button" ><span aria-hidden="true" class="icon-find"></span></a>
                                    <input id="beneficiary-1x-cardnumber" name="beneficiary-1x-cardnumber" type="hidden" value="" />
                                </div>
                                <div class="product-info">
                                    <p class="field-tip">Seleccione una de las tarjetas de crédito afiliadas como beneficiaria.</p>
                                </div>
                                <div class="product-scheme">
                                    <fieldset class="form-inline">
                                        <label for="beneficiary-1x-description" title="Descripción de la transferencia">Concepto</label>
                                        <input disabled class="field-large" id="beneficiary-1x-description" name="beneficiary-1x-description" type="text" maxlength="20"/>
                                        <label for="beneficiary-1x-amount" title="Monto a transferir.">Importe</label>
                                        <div class="field-category">
                                            <?php echo lang("MONEDA"); ?>
                                            <input disabled id="beneficiary-1x-coin" name="beneficiary-1x-coin" type="hidden" value="<?php echo lang("MONEDA"); ?>" />
                                        </div>
                                        <input disabled class="field-small" id="beneficiary-1x-amount" name="beneficiary-1x-amount" type="text" />
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <!-- </form> -->
                    <div id="msg"></div>
                    <div class="form-actions">
                        <a href="<? echo $this->config->item("base_url"); ?>/dashboard"><button type="reset">Cancelar</button></a>
                        <button disabled class="confir" id="continuar">Continuar</button>
                    </div>
                </div>
            </section>
        </article>
    </div>
</div>

<?php

$datos = null;
if(isset($data)){

if($this->session->userdata("aplicaTransferencia")=='N'){
    header("Location: transfer/error_pago");
}
if(($this->session->userdata("aplicaTransferencia")=='S')&&($this->session->userdata("passwordOperaciones")=='')){
    //header("Location: users/crearPasswordOperaciones");
    $pass = '/users/crearPasswordOperaciones';
    $ruta = $this->config->item("base_url").$pass;
    header("Location: $ruta");
}
$datos = unserialize($data);
if($datos->rc==-150){
    $error = '/transfer/error_pago';
    $ruta = $this->config->item("base_url").$error;
    header("Location: $ruta");
}
if($datos->rc==0){
    $todos = 0;
    foreach ($datos->cuentaOrigen as $value) {
        $nombre_empresa = $value->nomEmp;
        $cuenta = count(explode(" ", $nombre_empresa));

        if($cuenta>1){
            $findspace = ' ';
            $posicion = strpos($nombre_empresa , $findspace);
            $princ = 0;
            $nombre_empresa = substr($nombre_empresa, $princ, $posicion);
        }

        $todos = $todos +1;
    }
}
?>
<div id='content-product' style='display:none' >
    <nav id="filters-stack">
        <ul id="filters" class="stack option-set" data-option-key="filter">
            <li class="stack-item current-stack-item">
                <a href="#all" rel="subsection" data-option-value="*"><span class="badge"><?php echo $todos; ?></span> <?php echo $todos > 1 ? 'Cuentas' : 'Cuenta'; ?></a>
            </li>
        </ul>
    </nav>

    <?php
    }
    ?>

    <ul id='dashboard-donor'>

        <?php
        $datos = null;
        $datos = unserialize($data);
        $base_cdn = $this->config->item('base_url_cdn');

        foreach ($datos->cuentaOrigen as $value) {
            // $img1=strtolower(str_replace(' ','-',$value->producto));
            // $img=str_replace("/", "-", $img1);
            $cadena = strtolower($value->producto);
            $producto1 = quitar_tildes($cadena);
            $img1=strtolower(str_replace(' ','-',$producto1));
            $img=str_replace("/", "-", $img1);
            $marca= strtolower(str_replace(" ", "-", $value->marca));
            $empresa = strtolower($value->nomEmp);
            $pais=ucwords($this->session->userdata('pais'));
            $moneda=lang("MONEDA");

            echo "<li class='dashboard-item $empresa' card='$value->nroTarjeta' producto1='$value->producto' moneda='$moneda' pais='$pais' nombre='$value->tarjetaHabiente' marca='$marca' mascara='$value->nroTarjetaMascara' empresa='$empresa' producto='$img' prefix='$value->prefix'>
			<a rel='section'>
			<img src='".$base_cdn."img/products/".$pais."/$img.png' width='200' height='130' alt='' />
			<div class='dashboard-item-network $marca'></div>
			<div class='dashboard-item-info'>
			<p class='dashboard-item-cardholder'>$value->tarjetaHabiente</p>
			<p class='dashboard-item-balance'>$moneda--</p>
			<p class='dashboard-item-cardnumber'>$value->nroTarjetaMascara</p>
			<p class='dashboard-item-category'>$value->producto</p>
			</div>
			</a>
			</li>";
        }
        function quitar_tildes($cadena) {
            $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
            $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
            $texto = str_replace($no_permitidas, $permitidas ,$cadena);
            return $texto;
        }
        ?>
    </ul>
    <?php echo "<div class='form-actions'>
           <button  id='cerrar' type='reset'>Cancelar</button>
        </div>";
    ?>
</div>

<div id='content-destino' style='display:none'>
    <ul id="dashboard-beneficiary">	</ul>
    <div class='form-actions'>
        <button  id='close' type='reset'>Cancelar</button>
    </div>
</div>

<div style='display:none' id="removerDestino">
    <div class='group obscure-group' id='btn-destino'>
        <div class='product-presentation'>
            <a class='dialogDestino button product-button disabled-button' ><span aria-hidden='true' class='icon-find'></span></a>
            <input id='beneficiary-1x-cardnumber' name='beneficiary-1x-cardnumber' type='hidden' value='' />
        </div>
        <div class='product-info'>
            <p class='field-tip'>Seleccione una de sus cuentas afiliadas como beneficiaria de esta transferencia.</p>
        </div>
        <div class='product-scheme'>
            <fieldset class='form-inline'>
                <label for='beneficiary-1x-description'>Concepto</label>
                <input disabled class='field-large' id='beneficiary-1x-description' name='beneficiary-1x-description' type='text' />
                <label for='beneficiary-1x-amount'>Importe</label>
                <div class='field-category'>
                    <?php echo lang("MONEDA"); ?>
                    <input disabled id='beneficiary-1x-coin' name='beneficiary-1x-coin' type='hidden' value='<?php echo lang("MONEDA"); ?>' />
                </div>
                <input disabled class='field-small' id='beneficiary-1x-amount' name='beneficiary-1x-amount' type='text' />
            </fieldset></div>
    </div>
</div>

<div id="confirm-transfer" style="display:none">
    <div id="progress">
        <ul class="steps">
            <li class="step-item completed-step-item"><span aria-hidden="true" class="icon-card"></span> Realizar Pago</li>
            <li class="step-item current-step-item"><span aria-hidden="true" class="icon-view"></span> Confirmación</li>
            <li class="step-item"><span aria-hidden="true" class="icon-thumbs-up"></span> Finalización</li>
        </ul>
    </div>
    <div id="content-holder">
        <div id="titulo">
            <h2>Confirmación</h2>
            <p>Por favor, verifique los datos de las siguientes operaciones de pago que solicita:</p>
        </div>
        <table class="receipt" cellpadding="0" cellspacing="0" width="100%">
            <tbody id="tbody">

            </tbody>
        </table>
        <div class="form-actions" id="confimacion_t">
            <a href="<? echo $this->config->item("base_url"); ?>/transfer/index_tdc"><button type='reset'>Cancelar</button></a>
            <button id="continue_trans">Continuar</button>
        </div>
    </div>
</div>

<div id="dialog-confirm" style="display:none">
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>Hemos enviado una notificación a su correo electrónico con el código aleatorio que se solicita a continuación para confirmar la operación en curso.</p>
    </div>
    <div class="field-prepend">
        <span aria-hidden="true" class="icon-key"></span>
        <input class="field-medium" id="transpwd_confirmacion" name="transpwd" placeholder="Código Aleatorio" type="password" />
    </div>
</div>
</div>



<div id="transferFinal" style='display:none'>
    <article>
        <header>
            <h1>Pagos de Tarjetas de Crédito</h1>
        </header>
        <section>
            <nav id="secondary-menu">
                <ul class="menu">
                    <li class="menu-item add">
                        <a href="<? echo $this->config->item("base_url"); ?>/affiliation/affiliation_tdc" rel="section">Afiliar</a>
                    </li>
                    <li class="menu-item handler">
                        <a href="<? echo $this->config->item("base_url"); ?>/adm/adm_tdc" rel="section">Administrar Afiliaciones</a>
                    </li>
                    <li class="menu-item current-menu-item manage">
                        <a href="<? echo $this->config->item("base_url"); ?>/transfer/index_tdc" rel="section">Realizar Pago</a>
                    </li>
                    <li class="menu-item log">
                        <a href="<? echo $this->config->item("base_url"); ?>/historial/historial_tdc" rel="section">Historial</a>
                    </li>
                </ul>
            </nav>
            <div id="progress">
                <ul class="steps">
                    <li class="step-item completed-step-item"><span aria-hidden="true" class="icon-card"></span> Realizar Pago</li>
                    <li class="step-item completed-step-item"><span aria-hidden="true" class="icon-view"></span> Confirmación</li>
                    <li class="step-item current-step-item"><span aria-hidden="true" class="icon-thumbs-up"></span> Finalización</li>
                </ul>
            </div>
            <div id="content-holder">
                <h2>Finalización</h2>
                <div class="alert-success" id="message">
                    <span aria-hidden="true" class="icon-ok-sign"></span> Transferencia realizada satisfactoriamente
                    <p>Se ha enviado el comprobante de operaciones a su correo electrónico. Solamente se muestran las transacciones que resultaron exitosas...</p>
                </div>
                <form accept-charset="utf-8" method="post">
                    <table class="receipt" cellpadding="0" cellspacing="0" width="100%">
                        <tbody id="bodyConfirm">

                        </tbody>
                    </table>
                </form>
                <div class="form-actions">
                    <a href="<? echo $this->config->item("base_url"); ?>/dashboard"><button>No</button></a>
                    <a href="<? echo $this->config->item("base_url"); ?>/transfer/index_tdc"> <button>Si</button> </a>
                    <p>¿Desea realizar otro pago de tarjetas de crédito?</p>
                </div>
            </div>

</div>
</section>
</article>
</div>

<!-- CUENTAS DESTINO NO AFILIADAS -->
<div id="content-no-afil" style='display:none'>
    <div id="content">
        <article>
            <header>
                <h1>Pagos de Tarjetas de Crédito</h1>
            </header>
            <section>
                <nav id="secondary-menu">
                    <ul class="menu">
                        <li class="menu-item add">
                            <a href="<? echo $this->config->item("base_url"); ?>/affiliation/affiliation_tdc" rel="section">Afiliar</a>
                        </li>
                        <li class="menu-item handler">
                            <a href="<? echo $this->config->item("base_url"); ?>/adm/adm_tdc" rel="section">Administrar Afiliaciones</a>
                        </li>
                        <li class="menu-item current-menu-item manage">
                            <a href="<? echo $this->config->item("base_url"); ?>/transfer/index_tdc" rel="section">Realizar Pago</a>
                        </li>
                        <li class="menu-item log">
                            <a href="<? echo $this->config->item("base_url"); ?>/historial/historial_tdc" rel="section">Historial</a>
                        </li>
                    </ul>
                </nav>
                <div id="progress">
                    <ul class="steps">
                        <li class="step-item failed-step-item"><span aria-hidden="true" class="icon-exchange"></span> Transferir</li>
                        <li class="step-item"><span aria-hidden="true" class="icon-view"></span> Confirmación</li>
                        <li class="step-item"><span aria-hidden="true" class="icon-thumbs-up"></span> Finalización</li>
                    </ul>
                </div>
                <div id="empty-state">
                    <h2>Sin cuentas afiliadas</h2>
                    <p>Para la cuenta origen seleccionada, usted no posee cuentas Bancarias asociadas para llevar a cabo esta operación.</p>
                    <div class="empty-state-actions">
                        <a class="button" href="<? echo $this->config->item("base_url"); ?>/affiliation/affiliation_tdc"  rel="section">Afiliar Cuenta</a>
                    </div>
                    <span aria-hidden="true" class="icon-card"></span>
                </div>
            </section>
        </article>
    </div>
</div>
<!-- ERROR FORMATO campos -->
<div class="dialog-small" id="campos_vacios" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>El campo concepto no debe estar vacío. Por favor, verifique e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="error_campos">Aceptar</button>
    </div>
</div>
<!-- ERROR FORMATO campos -->
<div class="dialog-small" id="campos_vacios_monto" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>El campo monto no debe estar vacío. Por favor, verifique e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="error_campos_monto">Aceptar</button>
    </div>
</div>
<!-- ERROR FORMATO MONTO -->
<div class="dialog-small" id="dialog-error-monto" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>El monto debe contener dos decimales separados por punto. Por favor, verifique e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="monto_invalido">Aceptar</button>
    </div>
</div>

<!-- ERROR FORMATO MONTO -->
<div class="dialog-small" id="dialog-error-monto-vc" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>El monto debe contener dos decimales separados por coma. Por favor, verifique e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="monto_invalido_vc">Aceptar</button>
    </div>
</div>
<!-- ERROR FORMATO MONTO -->
<div class="dialog-small" id="dialog-max-monto1" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>El monto excede su saldo disponible. Por favor, verifique e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="monto_inv">Aceptar</button>
    </div>
</div>

<!-- ERROR MONTO eXCEDE1 -->
<div class="dialog-small" id="dialog-max-monto" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>El monto supera al monto límite de operaciones. Por favor, verifique e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="monto_invalido1">Aceptar</button>
    </div>
</div>

<!-- ERROR MONTO eXCEDE2 -->
<div class="dialog-small" id="dialog-min-monto" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>El monto a debitar es menor al monto mínimo de operaciones. Por favor, verifique e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="monto_invalido2">Aceptar</button>
    </div>
</div>

<!-- ERROR MONTO eXCEDE3 -->
<div class="dialog-small" id="dialog-min-monto2" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>El monto a debitar es mayor al monto maximo mensual permitido. Por favor, verifique e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="monto_invalido3">Aceptar</button>
    </div>
</div>


<!-- ERROR MONTO eXCEDE4 -->
<div class="dialog-small" id="dialog-min-monto3" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>El monto a debitar es mayor al monto maximo diario permitido. Por favor, verifique e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="monto_invalido4">Aceptar</button>
    </div>
</div>

<!-- ERROR MONTO eXCEDE5 -->
<div class="dialog-small" id="dialog-error-monto1" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>El monto a total a debitar supera el monto máximo de operaciones . Por favor, verifique e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="error_monto1">Aceptar</button>
    </div>
</div>

<!-- ERROR MONTO eXCEDE6-->
<div class="dialog-small" id="dialog-error-monto2" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>El monto total a debitar es menor al monto mínimo de operaciones. Por favor, verifique e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="error_monto2">Aceptar</button>
    </div>
</div>

<!-- ERROR MONTO eXCEDE7-->
<div class="dialog-small" id="dialog-error-monto7" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>El monto total a debitar es mayor al monto maximo diario permitido. Por favor, verifique e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="error_monto7">Aceptar</button>
    </div>
</div>

<!-- ERROR MONTO eXCEDE7-->
<div class="dialog-small" id="dialog-error-monto8" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>El monto total a debitar es mayor al monto maximo mensual permitido. Por favor, verifique e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="error_monto8">Aceptar</button>
    </div>
</div>

<!-- ERROR MONTO -->
<div class="dialog-small" id="dialog-error-monto9" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>El monto total excede su saldo disponible. Por favor, verifique e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="error_monto9">Aceptar</button>
    </div>
</div>

<!-- ERROR CANTIDAD OPERACIONES1 -->
<div class="dialog-small" id="dialog-cant-ope1" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>La cantidad de operaciones no esta permitida. Usted excede el límite diario permitido. Por favor, verifique e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="cant_ope1">Aceptar</button>
    </div>
</div>

<!-- ERROR CANTIDAD OPERACIONES2 -->
<div class="dialog-small" id="dialog-cant-ope2" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>La cantidad de operaciones no esta permitida. Usted excede el límite mensual permitido.  Por favor, verifique e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="cant_ope2">Aceptar</button>
    </div>
</div>

<!-- ERROR CLAVE DE CONFIRMACION -->
<div class="dialog-small" id="dialog-error-correo" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>Su <strong>clave de confirmación</strong> es incorrecta. Por favor, verifique e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="invalido">Aceptar</button>
    </div>
</div>



<!-- errores limites semanales -->

<!-- ERROR MONTO eXCEDE4 SEMANAL-->
<div class="dialog-small" id="dialog-min-monto-sm" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>El monto a debitar es mayor al monto maximo semanal permitido. Por favor, verifique e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="monto_invalido_sm">Aceptar</button>
    </div>
</div>

<!-- ERROR MONTO eXCEDE7 SEMANAL-->
<div class="dialog-small" id="dialog-error-monto-sm" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>El monto total a debitar es mayor al monto maximo semanal permitido. Por favor, verifique e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="error_monto_sm">Aceptar</button>
    </div>
</div>

<!-- ERROR CANTIDAD OPERACIONES SEMANALES -->
<div class="dialog-small" id="dialog-cant-ope-sm" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>La cantidad de operaciones no esta permitida. Usted excede el límite semanal permitido. Por favor, verifique e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="cant_ope_sm">Aceptar</button>
    </div>
</div>
