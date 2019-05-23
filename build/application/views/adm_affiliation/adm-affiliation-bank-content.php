<nav id="tabs-menu">
    <ul class="menu">
        <li class="menu-item">
            <a href="<? echo $this->config->item("base_url"); ?>/transferencia" rel="section"><span aria-hidden="true" class="icon-card"></span> <?php echo lang("MENU_P2P");?></a>
        </li>
        <li class="menu-item current-menu-item">
            <a href="<? echo $this->config->item("base_url"); ?>/transfer/index_bank" rel="section"><span aria-hidden="true" class="icon-bank"></span> Cuentas Bancarias</a>
        </li>
    </ul>
</nav>

<div id="content">
    <article>
        <header>
            <h1>Transferencias a Cuentas Bancarias</h1>
        </header>
        <section>
            <nav id="secondary-menu">
                <ul class="menu">
                    <li class="menu-item add">
                        <a href="<? echo $this->config->item("base_url"); ?>/affiliation/affiliation_bank" rel="section">Afiliar</a>
                    </li>
                    <li class="menu-item current-menu-item handler">
                        <a href="<? echo $this->config->item("base_url"); ?>/adm/adm_bank" rel="section">Administrar Afiliaciones</a>
                    </li>
                    <li class="menu-item manage">
                        <a href="<? echo $this->config->item("base_url"); ?>/transfer/index_bank" rel="section">Transferir</a>
                    </li>
                    <li class="menu-item log">
                        <a href="<? echo $this->config->item("base_url"); ?>/historial/historial_bank"  rel="section">Historial</a>
                    </li>
                </ul>
            </nav>
            <form accept-charset="utf-8" action="transfers-p2p-handler-p2.html" method="post">
                <fieldset>
                    <div class="group" id="donor">
                        <div class='product-presentation'>
                            <a class='dialog button product-button'><span aria-hidden='true' class='icon-find'></span></a>
                            <input id='donor-cardnumber' name='donor-cardnumber' type='hidden' value='' />
                        </div>
                        <div class="product-info">
                            <p class="field-tip">Seleccione una cuenta propia para modificar sus afiliaciones.</p>
                        </div>
                    </div>
                </fieldset>
            </form>
            <h2>Administrar Afiliaciones</h2>
            <div id="empty-state">
                <h2>Sin afiliaciones a mostrar</h2>
                <p>Debe seleccionar una cuenta propia para visualizar las afiliaciones asociadas.</p>
                <span aria-hidden="true" class="icon-card"></span>
            </div>
            <div id="content-holder">
                <ul id="dashboard">
                </ul>
            </div>
        </section>
    </article>
</div>


<div id='content-product' style='display:none'>

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
            $moneda=lang("MONEDA");

            echo "<li class='dashboard-item $empresa' card='$value->nroTarjeta' moneda='$moneda' nombre='$value->tarjetaHabiente' producto1='$value->producto' marca='$marca' mascara='$value->nroTarjetaMascara' empresa='$empresa' producto='$img' prefix='$value->prefix'>
         <a rel='section'>
         <img src='".$base_cdn."img/products/".$pais."/$img.png' width='200' height='130' alt='' />
         <div class='dashboard-item-network $marca'></div>
         <div class='dashboard-item-info'>
         <p class='dashboard-item-cardholder'>$value->tarjetaHabiente</p>
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

</div>    <!-- DIV DE CUENTAS ORIGEN -->

<div id="content-elim" style='display:none'>
    <div id="content-holder">
        <h2>Eliminación de Afiliación</h2>
        <p>Por favor, verifique los datos de la afiliación que Ud. está a punto de remover. Introduzca su clave de operaciones si está de acuerdo con este cambio:</p>
        <form accept-charset="utf-8" action="transfers-banks-remove2.html" method="post">
            <table class="receipt" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                <tr>
                    <td class="data-label"><label>Cuenta de Origen</label></td>
                    <td class="data-reference">Miguel Palazzo<br /><span class="highlight">1045 15** **** 1976</span><br /><span class="lighten">Plata Clásica / Visa Electron / Viáticos</span></td>
                </tr>
                <tr>
                    <td class="data-label"><label>Cuenta Destino Afiliada</label></td>
                    <td class="data-reference">Rafael Aguilar <span class="lighten">(raguilar@novopayment.com)</span><br />C.I. V-11.222.333<br /><span class="highlight">556677 ********** 8899</span><br /><span class="lighten">Banesco</span></td>
                </tr>
                <tr>
                    <td class="data-label"><label for="transpwd">Clave de Operaciones</label></td>
                    <td>
                        <div class="field-prepend">
                            <span aria-hidden="true" class="icon-key"></span>
                            <input class="field-medium" id="transpwd" name="transpwd" type="password" />
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="form-actions">
                <button type="reset">Cancelar</button>
                <button type="submit">Continuar</button>
            </div>
        </form>
    </div>
    </section>
    </article>
</div>
</div>
<!-- VALIDACION DE CODIGO DE BANCO -->

<div class="dialog-small" id="dialog-banco" style='display:none'>
    <div class="alert-simple alert-warning" id="message">
        <span aria-hidden="true" class="icon-warning-sign"></span>
        <p>El número de cuenta que introdujo no coincide con el banco. Por favor, verifique e intente nuevamente. </p>
    </div>
    <div class="form-actions">
        <button id="banco_inv">Aceptar</button>
    </div>
</div>