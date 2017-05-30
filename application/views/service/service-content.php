<div id="content" idUsuario="<? echo $this->session->userdata("userName") ?>" confirmacion="<? echo $this->session->userdata("transferir") ?>">
    <div id="content_plata">
        <article>
            <header>
                <h1>Servicios</h1>
            </header>

            <section>
                <div>
                    <fieldset>
                        <div class='group' id='donor'>
                            <?php if($pais == 'Co' || $pais == 'Ve'): ?>
                                <div class='product-presentation'>
                                    <a class='dialog button product-button'><span aria-hidden='true' class='icon-find'></span></a>
                                    <input id='donor-cardnumber' name='donor-cardnumber' type='hidden' value='' />
                                </div>
                                <div class='product-info'>
                                    <p class='field-tip'>Seleccione una cuenta</p>
                                </div>
                            <?php else: ?>
                                <div class='product-info'>
                                    <p class='field-tip'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opción no disponible para su país</p>
                                </div>
                            <?php endif; ?>
                            <?php if($pais == 'Co'): ?>
                                <div class='product-scheme'>
                                    <p class="field-tip" style="color: #eee; margin-left: 10px;">Indique la operación que desea realizar</p>
                                    <ul class='product-balance-group disabled-product-balance-group services-content'>
                                        <li><span class="icon-lock services-item"></span>Bloquear <br>cuenta</li>
                                        <li><span class="icon-key services-item"></span>Cambio <br>de PIN</li>
                                        <li><span class="icon-spinner services-item"></span>Solicitud <br>de reposición</li>
                                    </ul>
                                </div>
                            <?php elseif($pais == 'Ve'): ?>
                                <div class='product-scheme'>
                                    <p class="field-tip" style="color: #eee; margin-left: 10px;">Haga clic aquí si requiere reponer su PIN para acceso a operaciones en comercios y cajeros automáticos</p>
                                    <ul class='product-balance-group disabled-product-balance-group services-content'>
                                        <li><span class="icon-key services-item"></span>Reposición <br>de PIN</li>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </fieldset>

                    <div id="lock-acount" class="services-both" style="display: none">
                        <div id="msg-block" class="msg-prevent">
                            <h2></h2>
                            <h3></h3>
                            <div id="result-block"></div>
                        </div>
                        <div id="prevent-bloq" class="msg-prevent" style="display: none;">
                            <h2>Si realmente desea <span id="action"></span> su tarjeta presione continuar</h2>
                        </div>
                        <form id="bloqueo-cuenta" accept-charset="utf-8" method="post" class="profile-1">
                            <input type="hidden" id="fecha-exp-bloq" name="fecha-exp-bloq" disabled>
                            <input type="hidden" id="card-bloq" name="card-bloq" disabled>
                            <input type="hidden" id="status" name="status" disabled>
                            <input type="hidden" id="lock-type" name="lock-type" disabled>
                            <input type="hidden" id="prefix-bloq" name="prefix-bloq" disabled>
                            <fieldset class="col-md-12-profile">
                                <ul id="block-ul" class="row-profile">
                                    <li id="reason-rep" class="col-md-3-profile" style="display: none">
                                        <label for="mot-sol">Motivo de la solicitud</label>
                                        <select id="mot-sol" name="mot-sol" disabled>
                                            <option value="">Seleccione</option>
                                            <option value="41">Tarjeta perdida</option>
                                            <option value="43">Tarjeta robada</option>
                                            <option value="TD">Tarjeta deteriorada</option>
                                            <option value="TR">Reemplazar tarjeta</option>
                                        </select>
                                        <input type="hidden" id="mot-sol-now" name="mot-sol-now">
                                    </li>
                                </ul>
                            </fieldset>
                        </form>

                        <div id="msg1" style="clear:both;"></div>
                    </div>

                    <div id="change-key" class="services-both" style="display: none">

                        <div id="msg-change" class="msg-prevent">
                            <h2></h2>
                            <h3></h3>
                            <div id="result-change"></div>
                        </div>

                        <form id="cambio-pin" accept-charset="utf-8" method="post" class="profile-1">
                            <input id="fecha-exp-cambio" type="hidden"  name="fecha-exp-cambio">
                            <input id="card-cambio" type="hidden"  name="card-cambio">
                            <input type="hidden" id="prefix-cambio" name="prefix-cambio" disabled>
                            <fieldset class="col-md-12-profile">
                                <ul id="change-ul" class="row-profile">
                                    <li class="col-md-3-profile">
                                        <label for="pin-current">PIN actual</label>
                                        <input class="field-medium" id="pin-current" name="pin-current" maxlength="4" type="password">
                                        <input type="hidden" id="pin-current-now" name="pin-current-now">
                                    </li>
                                </ul>
                                <ul class="row-profile">
                                    <li class="col-md-3-profile">
                                        <label for="new-pin">Nuevo PIN</label>
                                        <input class="field-medium" id="new-pin" name="new-pin" maxlength="4" type="password">
                                        <input type="hidden" id="new-pin-now" name="new-pin-now">
                                    </li>
                                    <li class="col-md-3-profile">
                                        <label for="confirm-pin">Confirmar PIN</label>
                                        <input class="field-medium" id="confirm-pin" maxlength="4" name="confirm-pin" type="password">
                                    </li>
                                </ul>
                            </fieldset>
                        </form>

                        <div id="msg2" style="clear:both;"></div>
                    </div>

                    <div id="rec-key" class="services-both" style="display: none">
                        <div id="msg-rec" class="msg-prevent">
                            <h2></h2>
                            <h3></h3>
                            <div id="result-rec"></div>
                        </div>
                        <div id="rec-clave" class="msg-prevent" style="display: none">
                            <p class="msg-prin">Al confirmar esta solicitud, su PIN será enviado en sobre de seguridad a la dirección de su empresa, en un máximo de 5 días hábiles.</p>
                            <p class="msg-sec">Si realmente desea solicitar la reposición de su PIN presione continuar.</p>
                        </div>
                        <form id="recover-key" accept-charset="utf-8" method="post" class="profile-1">
                            <input type="hidden" id="fecha-exp-rec" name="fecha-exp-rec" disabled>
                            <input type="hidden" id="card-rec" name="card-rec" disabled>
                            <input type="hidden" id="prefix-rec" name="prefix-rec" disabled>
                        </form>
                    </div>

                    <div class="form-actions">
                        <a href="<? echo $this->config->item("base_url"); ?>/dashboard"><button type="reset">Cancelar</button></a>
                        <button disabled class="confir" id="continuar" data-action="none">Continuar</button>
                    </div>
                </div>
            </section>
        </article>
    </div>
</div>
<!-- content -->

<?php

$datos = null;
if(isset($data)) {

$datos = unserialize($data);

if($datos->rc==0){

    if(count($datos->lista)==0) {
        header("Location: dashboard/error");
    }
    $todos = 0;

    foreach ($datos->lista as $value) {
        $nombre_empresa = $value->nomEmp;
        $cuenta = count(explode(" ", $nombre_empresa));

        if($cuenta>1){
            $findspace = ' ';
            $posicion = strpos($nombre_empresa, $findspace);
            $princ = 0;
            $nombre_empresa = substr($nombre_empresa, $princ, $posicion);
        }

        $todos = $todos +1;
    }
} else {
    header("Location: users/error_gral");
}

?>

<div id='content-product' style='display:none'>
    <nav id="filters-stack">
        <ul id="filters" class="stack option-set" data-option-key="filter">
            <li class="stack-item current-stack-item">
                <a href="#all" rel="subsection" data-option-value="*"><span class="badge"><?php echo $todos; ?></span> <?php echo $todos > 1 ? 'Cuentas' : 'Cuenta'; ?></a><a href="#all" rel="subsection" data-option-value="*">Todas <span class="badge"><?php echo $todos; ?></span></a>
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

        foreach ($datos->lista as $value) {
            $cadena = strtolower($value->nombre_producto);
            $producto1 = quitar_tildes($cadena);
            $img1=strtolower(str_replace(' ','-',$producto1));
            $img=str_replace("/", "-", $img1);
            $marca= strtolower(str_replace(" ", "-", $value->marca));
            $empresa = strtolower($value->nomEmp);
            $accountBloq = ($value->bloque == '') ? 'N' : $value->bloque;
            $condition = $value->condicion;
            $fechaExp = $value->fechaExp;
            $pais=ucwords($this->session->userdata('pais'));
            $moneda=lang("MONEDA");

            echo "<li class='dashboard-item $empresa' card='$value->noTarjeta' pais='$pais' moneda='$moneda' nombre='$value->nom_plastico' marca='$marca' mascara='$value->noTarjetaConMascara' empresa='$empresa' producto1='$value->nombre_producto' producto='$img' prefix='$value->prefix' bloqueo='$accountBloq' condition='$condition' fe='$fechaExp'>
         <a rel='section'>
         <img src='".$base_cdn."img/products/".$pais."/$img.png' width='200' height='130' alt='' />
         <div class='dashboard-item-network $marca'></div>
         <div class='dashboard-item-info'>
         <p class='dashboard-item-cardholder'>$value->nom_plastico</p>

         <p class='dashboard-item-cardnumber'>$value->noTarjetaConMascara</p>
         <p class='dashboard-item-category'>$value->nombre_producto</p>
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

<div id="msg_system" style='display:none'>
    <div id="dialog-confirm">
        <div id="msg_info">
            <span aria-hidden="true"></span>
            <p></p>
        </div>
        <div id="form-action" class="form-actions">
            <button id="close-info"></button>
        </div>
    </div>
</div>
