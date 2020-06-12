<div id="content" idUsuario="<? echo $this->session->userdata("userName") ?>" confirmacion="<? echo $this->session->userdata("transferir") ?>">
    <div id="content_plata">
        <article>
            <header>
                <h1>Atención al cliente</h1>
            </header>

            <section>
                <div>
                    <fieldset>
                        <div class='group' id='donor'>
                            <?php if($pais == 'Co' || $pais == 'Ve' || $pais == 'Pe' || $pais == 'Ec-bp' || $pais == 'Usd'): ?>
                                <div class='product-presentation'>
                                    <a class='dialog button product-button'><span aria-hidden='true' class='icon-find'></span></a>
                                    <input id='donor-cardnumber' name='donor-cardnumber' type='hidden' value='' />
                                </div>
                                <div class='product-info'>
                                    <p class='field-tip'>Selecciona una cuenta</p>
                                </div>
                            <?php else: ?>
                                <div class='product-info'>
                                    <p class='field-tip'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opción no disponible para tu país</p>
                                </div>
                            <?php endif; ?>
															<div class='product-scheme'>
																	<p class="field-tip" style="color: #eee; margin-left: 10px;">Selecciona la operación que deseas realizar</p>
																	<ul class='product-balance-group disabled-product-balance-group services-content'>
																			<li><span class="icon-lock services-item"></span>Bloqueo <br>de cuenta</li>
																			<li><span class="icon-spinner services-item"></span>Solicitud <br>de reposición</li>
																			<li><span class="icon-key services-item"></span>Cambio <br>de PIN</li>
																			<?php if($pais == 'Co' || $pais == 'Ve' || $pais == 'Pe'): ?>
																			<li><span class="icon-key services-item"></span>Solicitud <br>de PIN</li>
																			<?php endif; ?>
																	</ul>
															</div>
                        </div>
                    </fieldset>

                    <div id="lock-acount" class="services-both" style="display: none">
                        <div id="msg-block" class="msg-prevent">
                            <h2></h2>
                            <h3></h3>
                            <div id="result-block"></div>
                        </div>
                        <div id="prevent-bloq" class="msg-prevent" style="display: none;">
                            <h2>Si realmente deseas <span id="action"></span> tu tarjeta, presiona continuar</h2>
                        </div>
                        <form id="bloqueo-cuenta" accept-charset="utf-8" method="post" class="profile-1">
                            <input type="hidden" id="fecha-exp-bloq" name="fecha-exp-bloq" disabled>
                            <input type="hidden" id="card-bloq" name="card-bloq" disabled>
                            <input type="hidden" id="status" name="status" disabled>
                            <input type="hidden" id="lock-type" name="lock-type" disabled>
                            <input type="hidden" id="prefix-bloq" name="prefix-bloq" disabled>
														<input type="hidden" id="montoComisionTransaccion" name="montoComisionTransaccion" value="0">
                            <fieldset class="col-md-12-profile">
                                <ul id="block-ul" class="row-profile">
                                    <li id="reason-rep" class="col-md-3-profile" style="display: none">
                                        <label for="mot-sol">Motivo de la solicitud</label>
                                        <select id="mot-sol" name="mot-sol" disabled>
                                            <option value="">Selecciona</option>
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
                        <div id="msg-rec" class="msg-prevent-pin" >
                            <h2></h2>
                            <h3></h3>
                            <div id="result-rec"></div>
                        </div>
                        <div id="rec-clave" class="msg-prevent" style="display: none">
                            <p class="msg-pin">Esta solicitud genera un Lote de reposición que es indispensable que tu empresa autorice en Conexión Empresas Online, para poder emitir el nuevo PIN.</p>
                            <p class="msg-pin">Si realmente deseas solicitar la reposición de tu PIN, presiona continuar. El PIN será enviado en un máximo de 5 días hábiles en un sobre de seguridad a la dirección de tu empresa.</p>
                        </div>
                        <form id="recover-key" accept-charset="utf-8" method="post" class="profile-1">
                            <input type="hidden" id="fecha-exp-rec" name="fecha-exp-rec" disabled>
                            <input type="hidden" id="card-rec" name="card-rec" disabled>
                            <input type="hidden" id="prefix-rec" name="prefix-rec" disabled>
                        </form>
                    </div>

                    <div class="form-actions">
										<?php
											if($pais == 'Ec-bp'){
												?>
													<center>
														<div class="atc-form-action-child">
												<?php
											}
										?>
                        <a href="<? echo $this->config->item("base_url"); ?>/dashboard"><button type="reset" class="novo-btn-secondary">Cancelar</button></a>
												<button disabled class="confir" id="continuar" data-action="none" class="novo-btn-primary">Continuar</button>
												<?php
													if($pais == 'Ec-bp'){
														?></div>
															</center>
														<?php
													}
												?>
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
$serviciosActivos = false;
if($datos->rc==0){

    if(count($datos->lista)==0) {
        header("Location: dashboard/error");
    }
    $todos = 0;

    foreach ($datos->lista as $value) {
        $nombre_empresa = $value->nomEmp;
        $cuenta = count(explode(" ", $nombre_empresa));

        //Verifica permisos operaciones de Servicios
				if(count($value->services) <= 0)
				{
					continue;
				}
				else {
					$serviciosActivos = true;
				}

        if($cuenta>1){
            $findspace = ' ';
            $posicion = strpos($nombre_empresa, $findspace);
            $princ = 0;
            $nombre_empresa = substr($nombre_empresa, $princ, $posicion);
        }

        $todos = $todos +1;
    }

		if(!$serviciosActivos){
			header("Location: servicios/error");
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
				$base_cdn = $this->config->item('asset_url');
				$cookie = $this->input->cookie($this->config->item('cookie_prefix').'skin');

        foreach ($datos->lista as $value) {
						//Verifica permisos operaciones de Servicios
		        if(count($value->services) <= 0)
		        {
		          continue;
		        }

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
						$permisos = implode(',',$value->services);
						$moneda=lang("MONEDA");
						$nomPlastico=ucwords(mb_strtolower($value->nom_plastico, 'UTF-8'));
						$nomProducto=ucwords(mb_strtolower($value->nombre_producto, 'UTF-8'));

            echo "<li class='dashboard-item $empresa' card='$value->noTarjeta' pais='$pais' moneda='$moneda' nombre='$nomPlastico' marca='$marca' mascara='$value->noTarjetaConMascara' empresa='$empresa' producto1='$nomProducto' producto='$img' prefix='$value->prefix' bloqueo='$accountBloq' condition='$condition' fe='$fechaExp' permisos='$permisos'>
						<a rel='section'>";
						echo insert_image_cdn($img);
						echo "<div class='dashboard-item-network $marca'></div>
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
		<?php
		if($pais=='Ec-bp'){
			?>
				<center>
			<?php
		}
	echo "<div class='form-actions'>";
	if($pais=='Ec-bp'){
		?>
			<div class="atc-form-action-child-2">
		<?php
	}
	echo "
					 <button  id='cerrar' type='reset' class='novo-btn-primary'>Cancelar</button>";
					 if($pais=='Ec-bp'){
						?>
							</div>
						<?php
					}
					 echo "
				</div>";
				if($pais=='Ec-bp'){
					?>
						</center>
					<?php
				}
    ?>

</div>

<div id="msg_system" style='display:none;'>
    <div id="dialog-confirm" >
        <div id="msg_info">
            <span aria-hidden="true"></span>
            <p></p>
				</div>
        <div id="form-action" class="form-actions">
				<?php 	if($pais=='Ec-bp'): 		?>
					<center>
					<div class="atc-form-action-child-1">
				<?php endif; ?>

						<button id="close-info" class="novo-btn-primary"></button>


				<?php 	if($pais=='Ec-bp'): 		?>
					</div>
					</center>
				<?php 	endif; ?>
				</div>
    </div>
</div>
