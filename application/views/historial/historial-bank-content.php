<nav id="tabs-menu">
    <ul class="menu">
        <li class="menu-item">
            <a href="<? echo $this->config->item("base_url"); ?>/transferencia" rel="section"><span aria-hidden="true" class="icon-card"></span> Plata a Plata</a>
        </li>
        <li class="menu-item current-menu-item">
            <a href="<? echo $this->config->item("base_url"); ?>/transfer/index_bank" rel="section"><span aria-hidden="true" class="icon-bank"></span> Cuentas Bancarias</a>
        </li>
    </ul>
</nav>

<div id="content">
    <article>
        <header>
            <h1>Historial</h1>
        </header>
        <section>
            <nav id="secondary-menu">
                <ul class="menu">
                    <li class="menu-item manage">
                        <a href="<? echo $this->config->item("base_url"); ?>/affiliation/affiliation_bank" rel="section">Afiliar</a>
                    </li>
                    <li class="menu-item handler">
                        <a href="<? echo $this->config->item("base_url"); ?>/adm/adm_bank" rel="section">Administrar Afiliaciones</a>
                    </li>
                    <li class="menu-item manage">
                        <a href="<? echo $this->config->item("base_url"); ?>/transfer/index_bank" rel="section">Transferir</a>
                    </li>
                    <li class="menu-item current-menu-item add">
                        <a href="<? echo $this->config->item("base_url"); ?>/historial/historial_bank" rel="section">Historial</a>
                    </li>
                </ul>
            </nav>
            <h2>Historial</h2>
            <form accept-charset="utf-8" action="transfers-banks-log.html" method="post">
                <label for="donor">Cuenta de Origen</label>
                <div class="group" id="donor">
                    <div class="group" id="donor">
                        <div class="product-presentation">
                            <a class='dialog button product-button'><span aria-hidden='true' class='icon-find'></span></a>
                            <!-- Boton para seleccionar cuentas destino -->
                        </div>
                    </div>
                </div>
            </form>
            <nav id="filters-stack">
                <div class="stack-form">
                    <form accept-charset="utf-8" class="stack-form" method="post">
                        <fieldset>
                            <label for="filter-month">Mostrar:</label>
                            <select id="filter-month" name="filter-month">
                                <option value="01">Enero</option>
                                <option value="02">Febrero</option>
                                <option value="03">Marzo</option>
                                <option value="04">Abril</option>
                                <option value="05">Mayo</option>
                                <option value="06">Junio</option>
                                <option value="07">Julio</option>
                                <option value="08">Agosto</option>
                                <option value="09">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                            <select id="filter-year" name="filter-year">
                                <?php
                                // Fix to generate options from current year up to previous four @mpalazzo
                                $anno_act = date('Y');
                                for ($i = $anno_act; $i > $anno_act - 5; $i--): ?>
                                    <option value="<?php echo $i; ?>"<?php if ($i == $anno_act) echo ' selected'; ?>><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </fieldset>
                    </form>
                    <button id="buscar"><span aria-hidden="true" class="icon-arrow-right"></span></button>
                </div>
            </nav>
            <div class="group" id="results">
                <h3>Transferencias Realizadas</h3>
                <div id= "carga">
                </div>
                <ul id= "list-detail" class="feed">

                </ul>
            </div>
    </article>
    </section>
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
    else{
        header("Location: users/error_gral");
    }
    ?>
    <ul id='dashboard-donor'>

        <?php
        $datos = null;
        $datos = unserialize($data);
        $base_cdn = $this->config->item('base_url_cdn');

        foreach ($datos->cuentaOrigen as $value) {
            //$img=strtolower(str_replace(' ','-',$value->producto));
            //$img=str_replace("/", "-", $img1);
            $cadena = strtolower($value->producto);
            $producto1 = quitar_tildes($cadena);
            $img1=strtolower(str_replace(' ','-',$producto1));
            $img=str_replace("/", "-", $img1);
            $marca= strtolower(str_replace(" ", "-", $value->marca));
            $empresa = strtolower($value->nomEmp);
            $pais=ucwords($this->session->userdata('pais'));
            $moneda=lang("MONEDA");

            echo "<li class='dashboard-item $empresa' moneda='$moneda' card='$value->nroTarjeta' nombre='$value->tarjetaHabiente' marca='$marca' producto1='$value->producto' mascara='$value->nroTarjetaMascara' empresa='$empresa' producto='$img' prefix='$value->prefix'>
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
