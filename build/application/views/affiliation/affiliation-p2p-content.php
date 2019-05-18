<?php
$cpo_name = $this->security->get_csrf_token_name();
$cpo_cook = $this->security->get_csrf_hash();
?>
<nav id="tabs-menu">
    <ul class="menu">
        <li class="menu-item current-menu-item">
            <a href="<? echo $this->config->item("base_url"); ?>/transferencia" rel="section"><span aria-hidden="true" class="icon-card"></span> <?php echo lang("MENU_P2P");?></a>
        </li>
        <li class="menu-item">
            <a href="<? echo $this->config->item("base_url"); ?>/transfer/index_bank" rel="section"><span aria-hidden="true" class="icon-bank"></span> Cuentas Bancarias</a>
        </li>
    </ul>
</nav>

<div id="content">
    <article>
        <header>
            <!-- <h1>Afiliación <?php echo lang("MENU_P2P");?></h1> -->
            <h1>Afiliación <?php echo lang("MENU_P2P");?></h1>

        </header>
        <section>
            <nav id="secondary-menu">
                <ul class="menu">
                    <li class="menu-item current-menu-item add">
                        <a href="<? echo $this->config->item("base_url"); ?>/affiliation" rel="section">Afiliar</a>
                    </li>
                    <li class="menu-item handler">
                        <a href="<? echo $this->config->item("base_url"); ?>/adm" rel="section">Administrar Afiliaciones</a>
                    </li>
                    <li class="menu-item manage">
                        <a href="<? echo $this->config->item("base_url"); ?>/transferencia" rel="section">Transferir</a>
                    </li>
                    <li class="menu-item manage">
                        <a href="<? echo $this->config->item("base_url"); ?>/historial" rel="section">Historial</a>
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
                <p>Ingrese los datos requeridos a continuación para afiliar una cuenta a la cual desee transferir fondos en determinado momento.</p>
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
                                <label for="card-number">N° de Cuenta Destino</label>
                                <input class="field-medium nrocta" disabled id="card-number" maxlength="16" name="card-number" type="text" />
                            </li>
                            <li class="field-group-item">
                                <label for="card-holder-email">Correo Electrónico</label>
                                <input class="field-large" disabled id="card-holder-email" maxlength="60" name="card-holder-email" type="text" />
                            </li>
                        </ul>
                    </fieldset>
                </form>
                <div id="msg"></div>
                <div class="form-actions">
                    <button id="afiliar" disabled>Afiliar</button>
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

            echo "<li class='dashboard-item $empresa' card='$value->nroTarjeta' nombre='$tarjetaHabiente' marca='$marca' mascara='$value->nroTarjetaMascara' empresa='$empresa' producto1='$nomProducto' producto='$img' prefix='$value->prefix'>
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
           <button  id='cerrar' type='reset'>Cancelar</button>
        </div>";
    ?>

</div>    <!-- DIV DE CUENTAS ORIGEN -->


<!-- ---------------------------------------------------------------------  PROCESAR AFILIACION -----------------------------------------------------------------------  -->


<div id="content-confirmacion" style='display:none'>
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
        <a href="<? echo $this->config->item("base_url"); ?>/affiliation"><button type="reset">Cancelar</button></a>
        <button class="continuar">Continuar</button>
    </div>
</div>
<!-- FINALIZA VISTA DE CONFIRMACION -->


<!-- ---------------------------------------------------------------------  FINALIZAR AFILIACION EXITOSA -----------------------------------------------------------------------  -->


<div id="content-finalizar" style='display:none'>
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
    <form accept-charset="utf-8" method="post"  id="formFinAfiliacion">
			<input type="hidden" name="<?php echo $cpo_name ?>" class="ignore" value="<?php echo $cpo_cook ?>">
        <table class="receipt" cellpadding="0" cellspacing="0" width="100%">
            <tbody id="cargarFinalizacion">

            </tbody>
        </table>
        <div class="form-actions">
            <a href="<? echo $this->config->item("base_url"); ?>/dashboard/"><button>No</button></a>
            <!-- <a href="google.com"><button>No</button></a> -->
            <a href="<? echo $this->config->item("base_url"); ?>/affiliation/affiliation"><button>Si</button> </a>
            <!-- <p>¿Desea afiliar otra cuenta para transferencia <?php echo lang("MENU_P2P");?>?</p> -->
            <p>¿Desea afiliar otra cuenta para transferencia <?php echo lang("MENU_P2P");?>?</p>

        </div>
    </form>
</div>


<!-- ---------------------------------------------------------------------  FINALIZAR AFILIACION EXITOSA -----------------------------------------------------------------------  -->


<div id="content-finalizar2" style='display:none'>
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
        <div class="form-actions">
            <a href="<? echo $this->config->item("base_url"); ?>/dashboard/"><button>No</button></a>
            <!-- <a href="google.com"><button>No</button></a> -->
            <a href="<? echo $this->config->item("base_url"); ?>/affiliation/affiliation"><button>Si</button> </a>
            <!-- <p>¿Desea afiliar otra cuenta para transferencia <?php echo lang("MENU_P2P");?>?</p> -->
            <p>¿Desea afiliar otra cuenta para transferencia <?php echo lang("MENU_P2P");?>?</p>

        </div>
    </form>
</div>


<!-- ---------------------------------------------------------------------  FINALIZAR AFILIACION NO EXITOSA -----------------------------------------------------------------------  -->


<div id="content-finalizar3" style='display:none'>
    <div id="progress">
        <ul class="steps">
            <li class="step-item completed-step-item"><span aria-hidden="true" class="icon-edit"></span> Registro de Cuenta</li>
            <li class="step-item completed-step-item"><span aria-hidden="true" class="icon-view"></span> Confirmación</li>
            <li class="step-item current-step-item"><span aria-hidden="true" class="icon-thumbs-up"></span> Finalización</li>
        </ul>
    </div>
    <h2>Finalización</h2>
    <div class="alert-error" id="message">
        <span aria-hidden="true" class="icon-cancel-sign"></span> Afiliación NO realizada
    </div>
    <p>Los datos registrados durante la operación fueron los siguientes:</p>
    <form accept-charset="utf-8" method="post"  id="formFinAfiliacion">
			<input type="hidden" name="<?php echo $cpo_name ?>" class="ignore" value="<?php echo $cpo_cook ?>">
        <table class="receipt" cellpadding="0" cellspacing="0" width="100%">
            <tbody id="cargarFinalizacion2">

            </tbody>
        </table>
        <div class="form-actions">
            <a href="<? echo $this->config->item("base_url"); ?>/affiliation/affiliation"> <button>Regresar</button> </a>
        </div>
    </form>
</div>


<!--   <header>
      <h2>Error Afiliación</h2>
  </header> -->
<div class="dialog-small" id="dialog-error-afil" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>La tarjeta que desea afiliar <strong>no permite transferencias.</strong>. Por favor <strong>verifique</strong> sus datos, e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="invalido2">Aceptar</button>
    </div>
</div>

<!-- Tarjeta no encontrada -->
<div class="dialog-small" id="dialog-error-afil1" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>La tarjeta que desea afiliar <strong>no ha sido encontrada.</strong>. Por favor <strong>verifique</strong> sus datos, e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="invalido3">Aceptar</button>
    </div>
</div>

<!-- Tarjeta no encontrada -->
<div class="dialog-small" id="dialog-error-afil2" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>Ha ocurrido un error en el sistema. Por favor <strong>intente</strong>mas tarde. </p>
    </div>
    <div class="form-actions">
        <button id="invalido4">Aceptar</button>
    </div>
</div>

<!-- Tarjeta ya existente -->
<div class="dialog-small" id="dialog-error-afil3" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p id="msgNon"></p>
    </div>
    <div class="form-actions">
        <button id="invalido5">Aceptar</button>
    </div>
</div>
