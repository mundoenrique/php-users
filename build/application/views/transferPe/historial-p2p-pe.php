<?php
$cpo_name = $this->security->get_csrf_token_name();
$cpo_cook = $this->security->get_csrf_hash();
?>
<nav id="tabs-menu">
	<ul class="menu">
		<li class="menu-item current-menu-item">
			<!-- <a href="<? echo $this->config->item("base_url"); ?>/transferencia" rel="section"><span aria-hidden="true" class="icon-card"></span> <?php echo lang("MENU_P2P");?></a> -->
			<a href="<? echo $this->config->item("base_url"); ?>/transferencia" rel="section"><span aria-hidden="true" class="icon-card"></span> <?php echo lang("MENU_P2P");?></a>

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
					<li class="menu-item add">
						<a href="<? echo $this->config->item("base_url"); ?>/limit/pe" rel="section">Configurar limites</a>
					</li>
					<li class="menu-item manage">
						<a href="<? echo $this->config->item("base_url"); ?>/transferencia/pe" rel="section">Transferir</a>
					</li>
					<li class="menu-item current-menu-item log">
						<a href="<? echo $this->config->item("base_url"); ?>/transferencia/HistorialPe" rel="section">Historial</a>
					</li>
				</ul>
			</nav>
			<h2>Historial</h2>
			<form accept-charset="utf-8" action="transfers-banks-log.html" method="post">
				<input type="hidden" name="<?php echo $cpo_name ?>" class="ignore" value="<?php echo $cpo_cook ?>">
				<input type="hidden" id="pais" name="pais" value="<?php echo $this->session->userdata("pais"); ?>">
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
						<input type="hidden" name="<?php echo $cpo_name ?>" class="ignore" value="<?php echo $cpo_cook ?>">
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
					<button id="buscar" class="novo-btn-primary"><span aria-hidden="true" class="icon-arrow-right"></span></button>
				</div>
			</nav>
			<div class="group" id="results">
				<h3>Transferencias Realizadas</h3>
				<div id="carga">
				</div>
				<ul id="list-detail" class="feed">
				</ul>
			</div>
	</article>
	</section>

</div>

<div id="dialogo-movil" style='display:none'>
    <div id="dialog-confirm">
        <div class="alert-simple" id="modalType">
            <span aria-hidden="true" class="icon-cancel-sign"></span>
            <p id="msgService"></p>
        </div>
    </div>
    <div class="form-actions">
        <button id="inva5" class="novo-btn-primary">Aceptar</button>
    </div>
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
        $base_cdn = $this->config->item('asset_url');

        foreach ($datos->cuentaOrigen as $value) {
            $cadena = strtolower($value->producto);
            $producto1 = quitar_tildes($cadena);
            $img1=strtolower(str_replace(' ','-',$producto1));
            $img=str_replace("/", "-", $img1);
            $marca=strtolower(str_replace(" ", "-", $value->marca));
            $empresa = strtolower($value->nomEmp);
            $pais=ucwords($this->session->userdata('pais'));
						$moneda=lang("MONEDA");
						$tarjetaHabiente=ucwords(mb_strtolower($value->tarjetaHabiente, 'UTF-8'));
						$nomProducto=ucwords(mb_strtolower($value->producto, 'UTF-8'));

            echo "<li class='dashboard-item $empresa' moneda='$moneda' card='$value->nroTarjeta' nombre='$tarjetaHabiente' marca='$marca' mascara='$value->nroTarjetaMascara' empresa='$empresa' producto1='$nomProducto' producto='$img' prefix='$value->prefix'>
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
            $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
            $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
            $texto = str_replace($no_permitidas, $permitidas ,$cadena);
            return $texto;
        }
        ?>
			</ul>
			<?php
				if($pais=='Ec-bp'){
					?>
						<center>
					<?php
				}
			echo
			"<div class='form-actions'>
           <button  id='cerrar' type='reset' class='novo-btn-primary'>Cancelar</button>
				</div>";
				if($pais=='Ec-bp'){
					?>
						</center>
					<?php
				}
    ?>

	</div>
	<!-- DIV DE CUENTAS ORIGEN -->
