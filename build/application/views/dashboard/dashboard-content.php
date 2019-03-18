<?php $country = $this->session->userdata('pais'); ?>
<div id="content">
    <article>
        <header>
            <h1>Vista Consolidada</h1><?php

            $datos = null;
            if(isset($data)){
            $datos = unserialize($data);

            if($datos->rc==0){
                $todos = 0;
                foreach ($datos->lista as $value) {
                    $todos = $todos +1;
                }
                if(count($datos->lista)==0){
                    header("Location: dashboard/error");
                }
            }

            else
						{
                header("Location: users/error_gral");
            }



            ?>
        </header>
        <section>
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
										//estado de la tarjeta activa o inactiva(NE)
										$activeCard = $value->bloque;


										//Verifica si la tarjeta se encuentra inactiva - CuentaGeneralPeru
										$inactiveImage = "";
										$inactiveInfo = "";
										$saldo = "";
										//verifica mensaje de saldo inicial
										if($country !== 'Ve'){
											$saldo = $moneda." ---";
										}


          					echo "<li class='dashboard-item $empresa' activeurl = '$activeCard' card='$value->noTarjeta' marca='$marca' empresa='$empresa' producto='$img' numt_mascara='$value->noTarjetaConMascara' moneda='$moneda' doc='$id'>
					<a href='#' rel='section'>
						<img src='".$base_cdn."img/products/".$pais."/$img.png' width='200' height='130' alt='' class='$inactiveImage' id='cardImage' />
						<div class='dashboard-item-network $marca $inactiveImage' >$value->marca</div>
						<div class='dashboard-item-info $inactiveInfo'>
							<p class='dashboard-item-cardholder'>$nomPlastico</p>
							<p class='dashboard-item-balance'>$saldo</p>
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
