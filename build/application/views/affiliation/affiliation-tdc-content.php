<?php
$cpo_name = $this->security->get_csrf_token_name();
$cpo_cook = $this->security->get_csrf_hash();
?>
<div id="content">
    <article>
        <header>
            <h1>Registro de Tarjeta de Crédito</h1>
        </header>
        <section>
            <nav id="secondary-menu">
                <ul class="menu">
                    <li class="menu-item current-menu-item add">
                        <a href="<? echo $this->config->item("base_url"); ?>/affiliation/affiliation_tdc" rel="section">Afiliar</a>
                    </li>
                    <li class="menu-item handler">
                        <a href="<? echo $this->config->item("base_url"); ?>/adm/adm_tdc" rel="section">Administrar Afiliaciones</a>
                    </li>
                    <li class="menu-item manage">
                        <a href="<? echo $this->config->item("base_url"); ?>/transfer/index_tdc" rel="section">Realizar Pago</a>
                    </li>
                    <li class="menu-item manage">
                        <a href="<? echo $this->config->item("base_url"); ?>/historial/historial_tdc" rel="section">Historial</a>
                    </li>
                </ul>
            </nav>

            <div id="content-holder">
                <div id="progress">
                    <ul class="steps">
                        <li class="step-item current-step-item"><span aria-hidden="true" class="icon-edit"></span> Registro de Cuenta</li>
                        <li class="step-item"><span aria-hidden="true" class="icon-view"></span> Confirmación</li>
                        <li class="step-item"><span aria-hidden="true" class="icon-thumbs-up"></span> Finalización</li>
                    </ul>
                </div>
                <h2>Registro de Cuenta</h2>
                <p>Ingrese los datos requeridos a continuación para afiliar una tarjeta de crédito a la cual desee transferir fondos desde sus cuentas en determinado momento.</p>
                <form accept-charset="utf-8" id="validate_afiliacion">
									<input type="hidden" name="<?php echo $cpo_name ?>" class="ignore" value="<?php echo $cpo_cook ?>">
                    <fieldset>
                        <label for="donor">Cuenta de Origen</label>
                        <div class="group" id="donor">
                            <div class="product-presentation">
                                <a class='dialog button product-button'><span aria-hidden='true' class='icon-find'></span></a>
                                <!-- Boton para seleccionar cuentas destino -->
                            </div>
                        </div>
                        <ul class="field-group">
                            <li class="field-group-item">
                                <label for="dayExp"><?php echo lang('DATE_EXPIRATION'); ?></label>
                                <select id="month-exp" name="month-exp" disabled>
                                    <option value="">Mes</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                                <select id="year-exp" name="year-exp" disabled>
                                    <option value="">Año</option>
                                    <?php
                                        $actual = date('Y');
                                        $anio = strtotime ( '-5 year' , strtotime ($actual ) ) ;
                                        $anioFinal = strtotime ( '+15 year' , strtotime ($actual ) ) ;
                                        $anio = date('Y', $anio);
                                        $anioFinal = date('Y', $anioFinal);
                                        for($i = $anio; $i<=$anioFinal; $i++):
                                    ?>
                                    <option value="<?php echo substr($i, -2); ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                                </select>
                            </li>
                            <li class="field-group-item">
                                <label for="bank-name">Banco</label>
                                <select id="bank-name" name="bank-name">
                                    <option selected value="">Seleccionar</option>
                                </select>
                            </li>
                        </ul>
                        <ul class="field-group">
                            <li class="field-group-item">
                                <label for="card-number">N° de Tarjeta de Crédito</label>
                                <input class="field-medium nrocta" id="card-number" maxlength="16" disabled name="card-number" type="text" />
                            </li>
                            <li class="field-group-item">
                                <label for="bank-account-holder">Beneficiario</label>
                                <input class="field-large" id="bank-account-holder" maxlength="35" disabled name="bank-account-holder" type="text" />
                            </li>
                        </ul>
                        <ul class="field-group">
                            <li class="field-group-item">
                                <label for="doc-name">Documento de Identidad</label>
                                <select id="doc-name" name="doc-name">
                                    <option selected value="">Seleccionar</option>
                                    <option value="V">V</option>
                                    <option value="E">E</option>
                                    <option value="J">J</option>
                                    <option value="G">G</option>
                                </select>
                                <input class="field-medium" id="bank-account-holder-id" maxlength="14" minlength="5" disabled  name="bank-account-holder-id" type="text" />
                            </li>
                            <li class="field-group-item">
                                <label for="bank-account-holder-email">Correo Electrónico</label>
                                <input class="field-large" id="bank-account-holder-email" maxlength="60" disabled  name="bank-account-holder-email" type="text" />
                            </li>
                        </ul>
                    </fieldset>
                </form>
                <div id="msg"></div>
                <div class="form-actions">
                    <button id="afiliar" class="novo-btn-primary" disabled >Afiliar</button>
                </div>
            </div>
        </section>
    </article>
</div>

<?php

$datos = null;
if(isset($data)){

$datos = unserialize($data);

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
?>

<div id='content-product' style='display:none'>
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
            $cadena = strtolower($value->producto);
            $producto1 = quitar_tildes($cadena);
            $img1=strtolower(str_replace(' ','-',$producto1));
            $img=str_replace("/", "-", $img1);
            $marca= strtolower(str_replace(" ", "-", $value->marca));
            $empresa = strtolower($value->nomEmp);
						$pais=ucwords($this->session->userdata('pais'));
						$tarjetaHabiente=ucwords(mb_strtolower($value->tarjetaHabiente, 'UTF-8'));
						$nomProducto=ucwords(mb_strtolower($value->producto, 'UTF-8'));

            echo "<li class='dashboard-item $empresa' card='$value->nroTarjeta' nombre='$tarjetaHabiente' producto1='$nomProducto' marca='$marca' mascara='$value->nroTarjetaMascara' empresa='$empresa' producto='$img' prefix='$value->prefix'>
         <a rel='section'>
         <img src='".$base_cdn."img/products/".$pais."/$img.png' width='200' height='130' alt='' />
         <div class='dashboard-item-network $marca'></div>
         <div class='dashboard-item-info'>
         <p class='dashboard-item-cardholder'>$tarjetaHabiente</p>
         <p class='dashboard-item-cardnumber'>$value->nroTarjetaMascara</p>
         <p class='dashboard-item-category'>$nomProducto</p>
         </div>
         </a>
         </li>";
        }

        function quitar_tildes($cadena) {
            $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","��Š","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
            $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
            $texto = str_replace($no_permitidas, $permitidas ,$cadena);
            return $texto;
        }
        ?>
    </ul>
    <?php echo "<div class='form-actions'>
           <button  id='cerrar' type='reset' class='novo-btn-primary'>Cancelar</button>
        </div>";
    ?>

</div>    <!-- DIV DE CUENTAS ORIGEN -->


<!-- ---------------------------------------------------------------------  PROCESAR AFILIACION -----------------------------------------------------------------------  -->


<div id="content-confirmacion" style='display:none'>
    <article>
        <header>
            <h1>Registro de Tarjeta de Crédito</h1>
        </header>
        <section>
            <nav id="secondary-menu">
                <ul class="menu">
                    <li class="menu-item current-menu-item add">
                        <a href="<? echo $this->config->item("base_url"); ?>/affiliation" rel="section">Afiliar</a>
                    </li>
                    <li class="menu-item handler">
                        <a href="<? echo $this->config->item("base_url"); ?>/adm/adm_tdc" rel="section">Administrar Afiliaciones</a>
                    </li>
                    <li class="menu-item manage">
                        <a href="<? echo $this->config->item("base_url"); ?>/transferencia" rel="section">Realizar Pago</a>
                    </li>
                    <li class="menu-item manage">
                        <a href="<? echo $this->config->item("base_url"); ?>/historial/historial_tdc" rel="section">Historial</a>
                    </li>
                </ul>
            </nav>
            <div id="progress">
                <ul class="steps">
                    <li class="step-item completed-step-item"><span aria-hidden="true" class="icon-edit"></span> Registro de Cuenta</li>
                    <li class="step-item current-step-item"><span aria-hidden="true" class="icon-view"></span> Confirmación</li>
                    <li class="step-item"><span aria-hidden="true" class="icon-thumbs-up"></span> Finalización</li>
                </ul>
            </div>
            <h2>Confirmación</h2>
            <p>Por favor, verifique los datos de la afiliación que va a efectuar.</p>
            <form accept-charset="utf-8" method="post" id="confir">
							<input type="hidden" name="<?php echo $cpo_name ?>" class="ignore" value="<?php echo $cpo_cook ?>">
                <table class="receipt" cellpadding="0" cellspacing="0" width="100%">
                    <tbody id="cargarConfirmacion">

                    </tbody>
                </table>
            </form>
            <div class="form-actions">
                <a href="<? echo $this->config->item("base_url"); ?>/affiliation/affiliation_tdc"><button type="reset" class="novo-btn-secondary">Cancelar</button> </a>
                <button class="continuar" class="novo-btn-primary">Continuar</button>
            </div>
        </section>
    </article>
</div> <!-- FINALIZA VISTA DE CONFIRMACION -->


<!-- ---------------------------------------------------------------------  FINALIZAR AFILIACION EXITOSA -----------------------------------------------------------------------  -->


<div id="content-finalizar" style='display:none'>
    <article>
        <header>
            <h1>Registro de Tarjeta de Crédito</h1>
        </header>
        <section>
            <nav id="secondary-menu">
                <ul class="menu">
                    <li class="menu-item current-menu-item add">
                        <a href="<? echo $this->config->item("base_url"); ?>/affiliation" rel="section">Afiliar</a>
                    </li>
                    <li class="menu-item handler">
                        <a href="<? echo $this->config->item("base_url"); ?>/adm/adm_tdc" rel="section">Administrar Afiliaciones</a>
                    </li>
                    <li class="menu-item manage">
                        <a href="<? echo $this->config->item("base_url"); ?>/transferencia" rel="section">Realizar Pago</a>
                    </li>
                    <li class="menu-item manage">
                        <a href="<? echo $this->config->item("base_url"); ?>/historial/historial_tdc" rel="section">Historial</a>
                    </li>
                </ul>
            </nav>
            <div id="progress">
                <ul class="steps">
                    <li class="step-item completed-step-item"><span aria-hidden="true" class="icon-edit"></span> Registro de Cuenta</li>
                    <li class="step-item completed-step-item"><span aria-hidden="true" class="icon-view"></span> Confirmación</li>
                    <li class="step-item current-step-item"><span aria-hidden="true" class="icon-thumbs-up"></span> Finalización</li>
                </ul>
            </div>
            <h2>Finalización</h2>
            <div class="alert-success" id="message">
                <span aria-hidden="true" class="icon-ok-sign"></span> Afiliación realizada satisfactoriamente
                <p>Se ha enviado el comprobante de esta operación a su correo electrónico.</p>
            </div>
            <p>Los datos registrados durante la operación fueron los siguientes:</p>
            <form accept-charset="utf-8" method="GET"  id="formFinAfiliacion">
                <table class="receipt" cellpadding="0" cellspacing="0" width="100%">
                    <tbody id="cargarFinalizacion">

                    </tbody>
                </table>
            </form>
            <div class="form-actions">
                <a href="<? echo $this->config->item("base_url"); ?>/dashboard/"><button class="novo-btn-secondary">No</button></a>
                <a href="<? echo $this->config->item("base_url"); ?>/affiliation/affiliation_tdc"><button class="novo-btn-primary">Si</button> </a>
                <p>¿Desea afiliar otra tarjeta de crédito para pagos?</p>
            </div>
        </section>
    </article>
</div>


<!-- ---------------------------------------------------------------------  FINALIZAR AFILIACION EXITOSA -----------------------------------------------------------------------  -->


<div id="content-finalizar2" style='display:none'>
    <article>
        <header>
            <h1>Registro de Tarjeta de Crédito</h1>
        </header>
        <section>
            <nav id="secondary-menu">
                <ul class="menu">
                    <li class="menu-item current-menu-item add">
                        <a href="<? echo $this->config->item("base_url"); ?>/affiliation" rel="section">Afiliar</a>
                    </li>
                    <li class="menu-item handler">
                        <a href="<? echo $this->config->item("base_url"); ?>/adm/adm_tdc" rel="section">Administrar Afiliaciones</a>
                    </li>
                    <li class="menu-item manage">
                        <a href="<? echo $this->config->item("base_url"); ?>/transferencia" rel="section">Realizar Pago</a>
                    </li>
                    <li class="menu-item manage">
                        <a href="<? echo $this->config->item("base_url"); ?>/historial/historial_tdc" rel="section">Historial</a>
                    </li>
                </ul>
            </nav>
            <div id="progress">
                <ul class="steps">
                    <li class="step-item completed-step-item"><span aria-hidden="true" class="icon-edit"></span> Registro de Cuenta</li>
                    <li class="step-item completed-step-item"><span aria-hidden="true" class="icon-view"></span> Confirmación</li>
                    <li class="step-item current-step-item"><span aria-hidden="true" class="icon-thumbs-up"></span> Finalización</li>
                </ul>
            </div>
            <h2>Finalización</h2>
            <div class="alert-warning" id="message">
                <span aria-hidden="true" class="icon-ok-sign"></span> Afiliación realizada satisfactoriamente
                <p>Su afiliación fue procesada con éxito, sin embargo en estos momentos, no se pudo enviar comprobante de esta operación a su correo electrónico.</p>
            </div>
            <p>Los datos registrados durante la operación fueron los siguientes:</p>
            <form accept-charset="utf-8" method="post"  id="formFinAfiliacion">
							<input type="hidden" name="<?php echo $cpo_name ?>" class="ignore" value="<?php echo $cpo_cook ?>">
                <table class="receipt" cellpadding="0" cellspacing="0" width="100%">
                    <tbody id="cargarFinalizacion3">

                    </tbody>
                </table>
            </form>
            <div class="form-actions">
                <a href="<? echo $this->config->item("base_url"); ?>/dashboard/"><button class="novo-btn-secondary">No</button></a>
                <a href="<? echo $this->config->item("base_url"); ?>/affiliation/affiliation_tdc"><button class="novo-btn-primary">Si</button> </a>
                <p>¿Desea afiliar otra tarjeta de crédito para pagos?</p>
            </div>
        </section>
    </article>
</div>


<!-- ---------------------------------------------------------------------  FINALIZAR AFILIACION NO EXITOSA -----------------------------------------------------------------------  -->


<div id="content-finalizar3" style='display:none'>
    <article>
        <header>
            <h1>Registro de Tarjeta de Crédito</h1>
        </header>
        <section>
            <nav id="secondary-menu">
                <ul class="menu">
                    <li class="menu-item current-menu-item add">
                        <a href="<? echo $this->config->item("base_url"); ?>/affiliation" rel="section">Afiliar</a>
                    </li>
                    <li class="menu-item handler">
                        <a href="<? echo $this->config->item("base_url"); ?>/adm/adm_tdc" rel="section">Administrar Afiliaciones</a>
                    </li>
                    <li class="menu-item manage">
                        <a href="<? echo $this->config->item("base_url"); ?>/transferencia" rel="section">Realizar Pago</a>
                    </li>
                    <li class="menu-item manage">
                        <a href="<? echo $this->config->item("base_url"); ?>/historial/historial_tdc" rel="section">Historial</a>
                    </li>
                </ul>
            </nav>
            <div id="progress">
                <ul class="steps">
                    <li class="step-item completed-step-item"><span aria-hidden="true" class="icon-edit"></span> Registro de Cuenta</li>
                    <li class="step-item completed-step-item"><span aria-hidden="true" class="icon-view"></span> Confirmación</li>
                    <li class="step-item current-step-item"><span aria-hidden="true" class="icon-thumbs-up"></span> Finalización</li>
                </ul>
            </div>
            <h2>Finalización</h2>
            <div class="alert-error" id="message">
	            <span aria-hidden="true" class="icon-cancel-sign"></span>
	            Afiliación NO realizada <span id="nonAfiliation"></span>
            </div>
            <p>Los datos registrados durante la operación fueron los siguientes:</p>
            <form accept-charset="utf-8" method="post"  id="formFinAfiliacion">
							<input type="hidden" name="<?php echo $cpo_name ?>" class="ignore" value="<?php echo $cpo_cook ?>">
                <table class="receipt" cellpadding="0" cellspacing="0" width="100%">
                    <tbody id="cargarFinalizacion2">

                    </tbody>
                </table>
            </form>
            <div class="form-actions">
                <a href="<? echo $this->config->item("base_url"); ?>/dashboard/"> <button class="novo-btn-secondary">No</button> </a>
                <a href="<? echo $this->config->item("base_url"); ?>/affiliation/affiliation_tdc"> <button class="novo-btn-primary">Si</button> </a>
                <p>¿Desea afiliar otra tarjeta de crédito para pagos?</p>
            </div>
        </section>
    </article>
</div>

<div class="dialog-small" id="dialog-error-afil" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>La tarjeta que desea afiliar <strong>no permite transferencias.</strong>. Por favor <strong>verifique</strong> sus datos, e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="invalido2" class="novo-btn-primary">Aceptar</button>
    </div>
</div>

<!-- Tarjeta ya existente -->
<div class="dialog-small" id="dialog-error-afil2" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>La tarjeta que desea afiliar <strong>ya se encuentra registrada.</strong> Por favor verifique sus datos, e intente nuevamente.</p>
    </div>
    <div class="form-actions">
        <button id="invalido3" class="novo-btn-primary">Aceptar</button>
    </div>
</div>

<!-- VALIDACION DE CODIGO DE BANCO -->

<div class="dialog-small" id="dialog-banco" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>El número de tarjeta que introdujo es incorrecto. Por favor, verifique e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="banco_inv" class="novo-btn-primary">Aceptar</button>
    </div>
</div>
