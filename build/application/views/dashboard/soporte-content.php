<div id="content">
	<article>
		<header>
			<h1>Servicios</h1>

			<?php

			$datos = null;
			if(isset($data)){
				$datos = unserialize($data);

				if($datos->rc==0){

					$tebca = 0;
					$servitebca = 0;
					$todos = 0;

					foreach ($datos->lista as $value) {
						if(strtolower($value->nomEmp) == "servitebca"){
							$servitebca = $servitebca +1;
						}else{
							$tebca = $tebca +1;
						}

						$todos = $todos +1;
					}
					if(count($datos->lista)==0){
						header("Location: dashboard/error");
					}
				}

				else{
					header("Location: users/error_gral");
				}

			?>

			</header>
			<section>
				<nav id="filters-stack">
					<ul id="filters" class="stack option-set" data-option-key="filter">
						<li class="stack-item current-stack-item">
							<a href="#all" rel="subsection" data-option-value="*">Todas <span class="badge"><?php echo $todos; ?></span></a>
						</li>
						<li class="stack-item">
							<a href="#tebca" rel="subsection"  data-option-value=".tebca">Tebca <span class="badge"><?php echo $tebca; ?></span></a>
						</li>
						<li class="stack-item">
							<a href="#servitebca" rel="subsection" data-option-value=".servitebca">Servitebca <span class="badge"><?php echo $servitebca; ?></span></a>
						</li>
					</ul>
			</nav>

			<?php
		}
		?>
		<ul id="dashboard">

			<?php
			$base_cdn = $this->config->item('base_url_cdn');
			if($datos->lista == 0){
				echo "Error cargando cuantas.";
			}
			foreach ($datos->lista as $value) {
				$cadena = strtolower($value->nombre_producto);
				$producto1 = quitar_tildes($cadena);
				$img1=strtolower(str_replace(' ','-',$producto1));
				$img=str_replace("/", "-", $img1);
				$marca= strtolower(str_replace(" ", "-", $value->marca));
				$empresa = strtolower($value->nomEmp);
				$pais=ucwords($this->session->userdata('pais'));
				$nomPlastico=ucwords(mb_strtolower($value->nom_plastico, 'UTF-8'));
				$nomProducto=ucwords(mb_strtolower($value->nombre_producto, 'UTF-8'));
				$moneda=lang("MONEDA");
				$id=lang("ID");

				/*echo "<li class='dashboard-item $empresa' card='$value->noTarjeta' marca='$marca' empresa='$empresa' producto='$img' numt_mascara='$value->noTarjetaConMascara' moneda='$moneda' doc='$id'>
					<a href='#' rel='section'>
						<img src='".$base_cdn."img/products/".$pais."/$img.png' width='200' height='130' alt='' />
						<div class='dashboard-item-network $marca'>$value->marca</div>
						<div class='dashboard-item-info'>
							<p class='dashboard-item-cardholder'>$nomPlastico</p>
							<p class='dashboard-item-balance'>$moneda---</p>
							<p class='dashboard-item-cardnumber'>$value->noTarjetaConMascara</p>
							<p class='dashboard-item-category'>$nomProducto</p>
						</div>
					</a>
				</li>";*/
				echo "<li class='dashboard-item $empresa' card='$value->noTarjeta' marca='$marca' empresa='$empresa' producto='$img' numt_mascara='$value->noTarjetaConMascara' moneda='$moneda' doc='$id'>
					<a href='#' rel='section'>
						<img src='".$base_cdn."img/products/".$pais."/$img.png' width='200' height='130' alt='' />
						<div class='dashboard-item-network $marca'>$value->marca</div>
						<div class='dashboard-item-info'>
							<p class='dashboard-item-cardholder'>$nomPlastico</p>

							<p class='dashboard-item-cardnumber'>$value->noTarjetaConMascara</p>
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
	</section>

	<form id='tarjeta' method='post' action="detalles">
		<input id="numt" type="hidden" name="numt" value="" />
		<input id="marca" type="hidden" name="marca" value="" />
		<input id="empresa" type="hidden" name="empresa" value="" />
		<input id="producto" type="hidden" name="producto" value="" />
		<input id="numt_mascara" type="hidden" name="numt_mascara" value="" />
	</form>
</article>
</div>

<?php if ($this->session->userdata('pais') === 'Ve'): ?>
<!-- MODAL MENSAJE TEMPORAL -->
<div id="dialog-temporal" style='display:none'>
	<header>
		<h2>Aviso importante</h2>
	</header>
	<div class="dialog-content">
		<p>Estimados Clientes:</p>
		<p>Cualquier inquietud sobre su tarjeta tales como saldos, vigencia etc, por favor comunicarse a nuestra línea de atención: (57) (1) 41933333 Extensiones -202 -203 o al Correo Electrónico: <a href="mailto:operaciones@servitebca.com.co" >operaciones@servitebca.com.co</a></p>
		<p>Cordial Saludo.</p>
		<p>Bogotá 23 de mayo de 2016.</p>
		<div class="form-actions">
			<button id="close-button">Cerrar</button>
		</div>
	</div>
</div>
<?php endif; ?>
