<?php
$datos = null;
$afiliado = $this->session->userdata('afiliado');
$tyc = $this->session->userdata('tyc');

if(isset($data)){

    $datos = unserialize($data);

    if($datos->rc==0){
        $base_cdn = $this->config->item('base_url_cdn');
        $cant = count($datos->registro->listaTelefonos);
        $disponeClaveSMS= $datos->registro->user->disponeClaveSMS;
        $clave_ope =$this->session->userdata('passwordOperaciones');
        if($clave_ope==''){
            $ruta = '/users/crearPasswordOperaciones';
        }
        else{
            $ruta = '/users/actualizarPasswordOperaciones';
        }
        $userName = $datos->registro->user->userName;
				$email= $datos->registro->user->email;
				if($country == 'Ec-bp') {
					$emailCypher = $datos->registro->user->emailEnc;
				}
        $particular= $datos->isParticular;

        if($datos->registro->user->primerNombre != null){
            $primerNombre= $datos->registro->user->primerNombre;
        }else{
            $primerNombre= null;
        }

        if($datos->registro->user->primerApellido != null){
            $primerApellido= $datos->registro->user->primerApellido;
        }else{
            $primerApellido= null;
        }

        if($datos->registro->user->descripcion_tipo_id_ext_per != null){
            $descripcion_tipo_id_ext_per=$datos->registro->user->descripcion_tipo_id_ext_per;
        }else{
            $descripcion_tipo_id_ext_per= null;
        }

        if($datos->registro->user->id_ext_per != null){
            $id_ext_per=$datos->registro->user->id_ext_per;
        }else{
            $id_ext_per= null;
        }

        if($datos->registro->user->dtfechorcrea_usu != null){
            $dtfechorcrea_usu=$datos->registro->user->dtfechorcrea_usu;
        }else{
            $dtfechorcrea_usu= null;
        }

        if($datos->registro->user->sexo != null){
            $sexo=$datos->registro->user->sexo;
        }else{
            $sexo= null;
        }

        if($datos->registro->user->notEmail!= null){
            $notEmail=$datos->registro->user->notEmail;
        }else{
            $notEmail= 0;
        }

        if($datos->registro->user->notSms!= null){
            $notSms=$datos->registro->user->notSms;
        }else{
            $notSms= 0;
        }

        if($datos->registro->user->notSms!= null){
            $notSms=$datos->registro->user->notSms;
        }else{
            $notSms= 0;
        }

        if($datos->registro->user->segundoNombre!= null){
            $segundoNombre=$datos->registro->user->segundoNombre;
        }else{
            $segundoNombre= null;
        }

        if($datos->registro->user->segundoApellido!= null){
            $segundoApellido=$datos->registro->user->segundoApellido;
        }else{
            $segundoApellido= null;
        }


        if($datos->registro->user->profesion!= null){
            $profesion=$datos->registro->user->profesion;
        }else{
            $profesion= null;
        }

        if($datos->registro->user->fechaNacimiento!= null){
            $fechaNacimiento=$datos->registro->user->fechaNacimiento;
        }else{
            $fechaNacimiento= null;
        }

        $direcciones=json_encode((array)$datos->direccion);

        $numDir= count((array)$datos->direccion);

        $aplicaPerfil=$datos->registro->user->aplicaPerfil;

        if($numDir==0){

            $acDir=' ';
            $acPais=' ';
            $acCiudad=' ';
            $acEstado=' ';
            $acDescTipo=' ';
            $acZonaPostal=' ';
            $acCodPais=' ';
            $acCodEstado=' ';
            $acCodCiudad=' ';
            $acTipo=' ';

        }
        else{
            $acDir= $datos->direccion->acDir;
            $acPais= $datos->direccion->acPais;
            $acCiudad= $datos->direccion->acCiudad;
            $acEstado= $datos->direccion->acEstado;
            $acDescTipo= $datos->direccion->acDescTipo;
            $acZonaPostal= $datos->direccion->acZonaPostal;
            $acCodPais = $datos->direccion->acCodPais;
            $acCodEstado = $datos->direccion->acCodEstado;
            $acCodCiudad = $datos->direccion->acCodCiudad;
            $acTipo = $datos->direccion->acTipo;
        }

        if($aplicaPerfil=='S'){
            $acTipo=$datos->registro->afiliacion->tipo_direccion;
            $acDir=$datos->registro->afiliacion->direccion;
            $acZonaPostal=$datos->registro->afiliacion->cod_postal;
            $acCodEstado=$datos->registro->afiliacion->departamento;
            $acCodCiudad=$datos->registro->afiliacion->provincia;
        }
        else if($aplicaPerfil=='N' && $numDir > 0){
            $acDir= $datos->direccion->acDir;
            $acPais= $datos->direccion->acPais;
            $acCiudad= $datos->direccion->acCiudad;
            $acEstado= $datos->direccion->acEstado;
            $acDescTipo= $datos->direccion->acDescTipo;
            $acZonaPostal= $datos->direccion->acZonaPostal;
            $acCodPais = $datos->direccion->acCodPais;
            $acCodEstado = $datos->direccion->acCodEstado;
            $acCodCiudad = $datos->direccion->acCodCiudad;
            $acTipo = $datos->direccion->acTipo;
        }

        if($aplicaPerfil=='S'){
            $tipo_profesion=$datos->registro->afiliacion->profesion;
            $acDigVerificador = $afiliado != 0 ? $datos->registro->afiliacion->dig_verificador : '';
        }
        else if($aplicaPerfil=='N'){
            $tipo_profesion=$datos->registro->user->tipo_profesion;
            $profesion=$datos->registro->user->profesion;
            $acDigVerificador=$datos->registro->afiliacion->dig_verificador;
        }
        else{
            $tipo_profesion='';
        }

        foreach ($datos->registro->listaTelefonos as $value) {
            if(strtolower($value->tipo) == 'cel'){
                $tipo = $value->tipo;
								$num = preg_replace('/^0+/', '',$value->numero);
								$celCypher = $country === 'Ec-bp' ? $value->numeroEnc : '';
            }

            if(strtolower($value->tipo) == 'hab'){
                $tipo_hab = $value->tipo;
								$num_hab = preg_replace('/^0+/', '',$value->numero);
								$habCypher = $country === 'Ec-bp' ? $value->numeroEnc : '';
            }

            if(strtolower($value->tipo) == 'ofc'){
                $descripcion_otr = $value->descripcion;
                $tipo_otr = $value->tipo;
                $num_otr = $value->numero;
            }

            if(strtolower($value->tipo) == 'fax'){
                $descripcion_otr = $value->descripcion;
                $tipo_otr = $value->tipo;
                $num_otr = $value->numero;
            }

            if(strtolower($value->tipo) == 'otro'){
                $descripcion_otr = $value->descripcion;
                $tipo_otr = $value->tipo;
                $num_otr = $value->numero;
            }
        }

        if(empty($tipo_hab)){
            $tipo_hab = '';
            $num_hab = '';
        }

        if(empty($tipo_otr)){
            $descripcion_otr = '';
            $tipo_otr = '';
            $num_otr = '';
        }
    }else if($datos->rc==-198){
        redirect($this->config->item('base_url') . '/perfil/error');
    }else{
        redirect($this->config->item('base_url') . '/users/error');
    }
}

/*Datos aplica perfil "S"*/

$numAfiliacion=(array)$datos->registro->afiliacion;

	if((isset($numAfiliacion) || count($numAfiliacion)>0) && $aplicaPerfil=='S'){
    $estadocivil=$datos->registro->afiliacion->edocivil;
    $lugar_nacimiento=$datos->registro->afiliacion->lugar_nacimiento;
    $centro_laboral=$datos->registro->afiliacion->centrolab;
    $antiguedad_laboral=$datos->registro->afiliacion->antiguedad_laboral;
    $cargo=$datos->registro->afiliacion->cargo;
    $ingreso_promedio_mensual=$datos->registro->afiliacion->ingreso_promedio_mensual;
    $cargo_publico_last2=$datos->registro->afiliacion->cargo_publico_last2;
    $cargo_publico=$datos->registro->afiliacion->cargo_publico;
    $ruc_cto_laboral=$datos->registro->afiliacion->ruc_cto_laboral;
    $profesion_laboral=$datos->registro->afiliacion->profesion;
    $institucion_publica=$datos->registro->afiliacion->institucion_publica;
    $uif=$datos->registro->afiliacion->uif;
    $labora=$datos->registro->afiliacion->labora;
    $nacionalidad=$datos->registro->afiliacion->nacionalidad;
    $distrito=$datos->registro->afiliacion->distrito;
    $notarjeta=$datos->registro->afiliacion->notarjeta;
    $acProteccion=$datos->registro->afiliacion->acepta_proteccion;
    $acContrato=$datos->registro->afiliacion->acepta_contrato;

}else{
    $estadocivil="";
    $lugar_nacimiento="";
    $centro_laboral="";
    $antiguedad_laboral="";
    $cargo="";
    $ingreso_promedio_mensual="";
    $cargo_publico_last2="";
    $cargo_publico="";
    $tipo_direccion="";
    $cod_postal="";
    $ruc_cto_laboral="";
    $profesion_laboral="";
    $institucion_publica="";
    $uif="";
    $labora="";
    $direccion="";
    $nacionalidad="";
    $provincia="";
    $distrito="";
    $departamento="";
    $notarjeta="";
    $acProteccion="";
    $acContrato="";
}
$tipo_id_ext_per=$datos->registro->user->tipo_id_ext_per;
$pais_residencia=$this->session->userdata('pais');



/*Fin impresion de datos*/
?>
<div id="content" direccion1="<?php echo lang("DIR1");?>" direccion2="<?php echo lang("DIR2");?>"
  direccion3="<?php echo lang("DIR3");?>" acPais="<?php echo $acPais;?>" particular="<?php echo (int)$particular; ?>"
  primerNombre="<?php echo $primerNombre;?>" primerApellido="<?php echo $primerApellido;?>"
  segundoNombre="<?php echo $segundoNombre;?>" segundoApellido="<?php echo $segundoApellido;?>"
  profesion="<?php echo ucwords($profesion);?>" fechaNacimiento="<?php echo $fechaNacimiento;?>"
  descripcion_tipo_id_ext_per="<?php echo $descripcion_tipo_id_ext_per;?>" id_ext_per="<?php echo $id_ext_per;?>"
  acCiudad="<?php echo $acCiudad;?>" acEstado="<?php echo $acEstado;?>" acDescTipo="<?php echo $acDescTipo;?>"
  acZonaPostal="<?php echo $acZonaPostal;?>" disponeClaveSMS="<?php echo $disponeClaveSMS;?>"
  email="<?php echo $email;?>" num="<?php echo $num;?>" tipo="<?php echo $tipo;?>" num_hab="<?php echo $num_hab;?>"
  tipo_hab="<?php echo $tipo_hab;?>" num_otro="<?php echo $num_otr;?>" tipo_otr="<?php echo $tipo_otr;?>"
  sexo="<?php echo $sexo;?>" userName="<?php echo $userName;?>" dtfechorcrea_usu="<?php echo $dtfechorcrea_usu;?>"
  notEmail="<?php echo $notEmail;?>" notSms="<?php echo $notSms;?>" acCodPais="<?php echo $acCodPais;?>"
  acTipo="<?php echo $acTipo; ?>" acCodEstado="<?php echo $acCodEstado;?>" acCodCiudad="<?php echo $acCodCiudad;?>"
  tipo_profesion="<?php echo $tipo_profesion;?>" aplicaPerfil="<?php echo $aplicaPerfil; ?>"
  afiliado="<?php  echo $afiliado?>" tyc="<?php echo $tyc; ?>" country="<?= $country; ?>">
  <article id="content-formulario-perfil">
    <header></header>
    <div id="widget-account" class="widget">
      <div class="widget-header">
        <p class="text-header">Perfil de Usuario</p>
      </div>
    </div>
    <section>
      <div id="loading-first" class="data-indicator" style="text-align: center;">
        <h3 style="border-bottom: 0px;">Cargando</h3>
        <span aria-hidden="true" class="icon-refresh icon-spin" style="font-size: 50px;"></span>
      </div>
      <div id="content-holder" style="display:none;">

        <h2 class="profile-title-1">Datos personales </h2>
        <form id="form-perfil" accept-charset="utf-8" method="post">
          <fieldset class="col-md-12-profile">
            <ul class="row-profile">
              <li class="col-md-3-profile">
                <label for="personal-id"> Tipo de identificación</label>
                <input type="text" id="tipo_identificacion" name="tipo_identificacion"
                  value="<?php echo $datos->registro->user->descripcion_tipo_id_ext_per; ?>" readonly="readonly">

                <input type="hidden" name="tipo_id_ext_per" id="tipo_id_ext_per"
                  value="<?php echo $tipo_id_ext_per; ?>">
                <input type="hidden" name="aplicaPerfil" id="aplicaPerfil" value="<?php echo $aplicaPerfil; ?>">
                <input type="hidden" name="notarjeta" id="notarjeta" value="<?php echo $notarjeta; ?>">

                <input type="hidden" name="acCodCiudad" id="acCodCiudad" value="<?php echo $acCodCiudad; ?>">
                <input type="hidden" name="acCodEstado" id="acCodEstado" value="<?php echo $acCodEstado; ?>">
                <input type="hidden" name="acCodPais" id="acCodPais" value="<?php echo $acCodPais; ?>">
                <input type="hidden" name="acTipo" id="acTipo" value="<?php echo $acTipo; ?>">
                <input type="hidden" name="acZonaPostal" id="acZonaPostal" value="<?php echo $acZonaPostal; ?>">
                <input type="hidden" name="disponeClaveSMS" id="disponeClaveSMS"
                  value="<?php echo $disponeClaveSMS; ?>">


              </li>
              <li class="col-md-3-profile">
                <label>Número de identificación</label>
                <input type="text" value="<?php echo ucwords($id_ext_per); ?>" id="id_ext_per" name="id_ext_per"
                  readonly="readonly">
              </li>
              <li class="col-md-3-profile dig-verificador">
                <label title="Carácter verificador del DNI">Dígito verificador</label>
                <input title="Obtenga el carácter verificador de su DNI leyéndolo de su documento de identidad"
                  type="text" value="<?php echo $acDigVerificador; ?>" id="dig-ver" name="dig-ver"
                  <?php echo $acDigVerificador !== '' ? 'readonly' : ''; ?> maxlength="1">
              </li>
            </ul>
            <ul class="row-profile">
              <li class="col-md-3-profile">
                <label for="firstname">Primer nombre</label>
                <input class="field-medium" id="primer-nombre" maxlength="40" name="primer_nombre" type="text"
                  value="<?php echo $datos->registro->user->primerNombre; ?>" />
              </li>
              <li class="col-md-3-profile">
                <label for="middle-name"> Segundo nombre</label>
                <input class="field-medium" id="segundo-nombre" maxlength="40" name="segundo_nombre" type="text"
                  value="<?php echo $datos->registro->user->segundoNombre; ?>" />
              </li>
            </ul>
            <ul class="row-profile">
              <li class="col-md-3-profile">
                <label for="last-name1">Primer apellido</label>
                <input class="field-medium" id="primer-apellido" maxlength="40" name="primer_apellido" type="text"
                  value="<?php echo $datos->registro->user->primerApellido; ?>" />
              </li>
              <li class="col-md-3-profile">
                <label for="last-name2">Segundo apellido</label>
                <input class="field-medium" id="segundo-apellido" maxlength="40" name="segundo_apellido" type="text"
                  value="<?php echo $datos->registro->user->segundoApellido; ?>" />
              </li>
            </ul>

            <ul class="row-profile row-fecha-nacimiento">
              <li class="col-md-3-profile remove-perfil-plata-sueldo">
                <label for="lugar-nac">Lugar de nacimiento</label>
                <input class="field-small" id="lugar-nacimiento" maxlength="80" name="lugar_nac" type="text"
                  value="<?php echo $lugar_nacimiento; ?>" />
              </li>
              <li class="col-profile-fecha-nac">
                <label for="fecha-nac">Fecha de nacimiento</label>
                <input id="dia-nacimiento" name="dia-nacimiento" class="nac-input" maxlength="2" type="text" />
                <?php if($country == 'Ec-bp'): ?>
                <input id="mes-nacimiento-bp" name="mes-nacimiento-bp" class="ignore expand-row" type="text">
                <?php else: ?>
                <select id="mes-nacimiento" name="mes-nacimiento">
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
                <?php endif; ?>
                <input id="anio-nacimiento" name="anio-nacimiento" class="nac-input" maxlength="4" type="text" />
                <input id="fecha-nacimiento-valor" type="hidden" value="<?php echo $fechaNacimiento; ?>"
                  name="fecha_nacimiento" />
              </li>
            </ul>

            <ul class="row-profile row-modifica">
              <li class="col-md-3-profile">
                <label for="gender">Sexo</label>
                <label class="label-inline" for="gender-male">
                  <input id="gender_m" <?php if($datos->registro->user->sexo == 'M') echo 'checked="checked"'; ?>
                    name="gender" type="radio" value="M" /> Masculino</label>
                <label class="label-inline" for="gender-female">
                  <input id="gender_f" <?php if($datos->registro->user->sexo == 'F') echo 'checked="checked"'; ?>
                    name="gender" type="radio" value="F" /> Femenino</label>
                </label>
              </li>
              <li class="col-md-3-profile remove-perfil-plata-sueldo">
                <label>Estado civil</label>
                <select class="field-estado-civil" id="edocivil" name="edocivil">
                  <option value="">Seleccione</option>
                  <option value="S">Soltero</option>
                  <option value="C">Casado</option>
                  <option value="V">Viudo</option>
                </select>
                <input type="hidden" id="edo-civil-value" name="edocivil" value="<?php echo $estadocivil; ?>">
              </li>
              <li class="col-md-3-profile remove-perfil-plata-sueldo">
                <label>Nacionalidad</label>
                <input type="text" id="nacionalidad-valor" maxlength="20" value="<?php echo $nacionalidad; ?>"
                  name="nacionalidad">
              </li>
            </ul>
            <ul class="row-profile row-modifica row-profesion">
              <li class="col-md-full-profile">
                <label for="profesion">Profesión</label>
                <?php if($country == 'Ec-bp'): ?>
                <input id="listaProfesion-bp" name="listaProfesion-bp" class="ignore" type="text">
                <?php else: ?>
                <select class="field-select-medium" id="listaProfesion" name="profesion">
                  <input type="hidden" value="<?php echo $tipo_profesion; ?>" name="tipo_profesion"
                    id="tipo_profesion_value">
                </select>
                <?php endif; ?>
              </li>
            </ul>
          </fieldset>
          <hr class="separador-profile">
          <h2 class="profile-title-2">Datos de contacto</h2>
          <fieldset class="col-md-12-profile">
						<?php if($country != 'Ec-bp'): ?>
            <ul class="row-profile">
              <li class="col-md-4-profile">
                <label for="type-dir">Tipo de dirección</label>
                <select class="field-select-medium listaDireccion" name="tipo_direccion" id="tipo_direccion">
                  <option value="">Seleccione</option>
                  <option value="1">Domicilio</option>
                  <option value="2">Laboral</option>
                  <option value="3">Comercial</option>
                </select>
                <input type="hidden" value="<?php echo $acTipo; ?>" name="tipo_direccion" id="tipo_direccion_value">
              </li>
              <li class="col-md-4-profile">
                <label for="code">Código postal</label>
                <input class="field-medium" id="codepostal" name="codepostal" type="text" maxlength="10"
                  value="<?php echo trim($acZonaPostal); ?>">
              </li>
						</ul>
            <ul class="row-profile">
              <li class="col-md-4-profile expand-row">
                <label for="country">País</label>
                <input type="text" id="pais-de-residencia" readonly="readonly" name="pais">
                <input type="hidden" id="pais-residencia-value" value="<?php echo $pais_residencia; ?>"
                  name="paisResidencia">
							</li>
              <li class="col-md-4-profile expand-row">
                <label id="state"></label>
                <select id="departamento" name="departamento_residencia">
                </select>
              </li>
              <li class="col-md-4-profile expand-row">
                <label id="city"></label>
                <select id="provincia" name="provincia_residencia">
                </select>
              </li>
              <li class="col-md-4-profile remove-perfil-plata-sueldo">
                <label>Distrito</label>
                <select id="distrito" name="distrito_residencia">
                </select>
              </li>
              <input type="hidden" id="departamento_data" name="departamento_data" value="<?php echo $acCodEstado; ?>">
              <input type="hidden" id="provincia_data" name="provincia_data" value="<?php echo $acCodCiudad; ?>">
							<input type="hidden" id="distrito_data" name="distrito_data" value="<?php echo $distrito; ?>">
						</ul>
            <ul class="row-profile">
              <li class="col-md-full-profile">
                <label for="direccion">Dirección</label>
                <textarea id="direccion" maxlength="90" name="direccion"><?php echo $acDir; ?></textarea>
              </li>
						</ul>
						<?php endif; ?>
            <ul class="row-profile">
							<?php if($country == 'Ec-bp'): ?>
							<li class="col-md-4-profile expand-row">
                <label for="country">País</label>
                <input type="text" id="pais-de-residencia" readonly="readonly" name="pais">
                <input type="hidden" id="pais-residencia-value" value="<?php echo $pais_residencia; ?>"
                  name="paisResidencia">
							</li>
							<?php endif; ?>
              <li class="col-md-4-profile">
                <label>Teléfono fijo</label>
                <?php if($country === 'Ec-bp'): ?>
                <input type="text" id="telefono_hab-bp" name="telefono_hab-bp" class="ignore"
                  value="<?php echo $num_hab; ?>" readonly>
                <input type="hidden" id="hab_cypher" name="hab_cypher" value="<?= $habCypher; ?>">
                <?php else: ?>
                <input type="text" id="telefono_hab" name="telefono_hab" maxlength="11" value="<?php echo $num_hab; ?>">
                <?php endif; ?>
              </li>
              <li class="col-md-4-profile">
                <label>Teléfono móvil</label>
                <?php if($country === 'Ec-bp'): ?>
                <input type="text" id="telefono-bp" name="telefono-bp" class="ignore" value="<?php echo $num; ?>"
                  readonly>
                <input type="hidden" id="cel_cypher" name="cel_cypher" value="<?= $celCypher; ?>">
                <?php else: ?>
                <input type="text" id="telefono" name="telefono" maxlength="11" value="<?php echo $num; ?>">
                <?php endif; ?>
              </li>
              <?php if($country !== 'Ec-bp'): ?>
              <li class="col-md-4-profile">
                <label>Otro teléfono (Tipo)</label>
                <select id="otro_telefono_tipo" name="otro_telefono_tipo" type="text">
                  <option value="">Seleccione</option>
                  <option value="OFC">Laboral</option>
                  <option value="FAX">Fax</option>
                  <option value="OTRO">Otro</option>
                </select>
                <input type="hidden" value="<?php echo $tipo_otr;?>" id="otro_telefono_tipo_value"
                  name="otro_telefono_tipo_value">
              </li>
              <li class="col-md-4-profile">
                <label>Otro teléfono (Número)</label>
                <input class="field-medium" id="otro_telefono_num" name="otro_telefono_num" maxlength="11" type="text"
                  value=<?php echo $num_otr;?>>
              </li>
              <?php endif; ?>
            </ul>
            <fieldset class="col-md-12-profile">
              <ul class="row-profile">
                <li class="col-md-full-profile">
                  <label>Correo electrónico</label>
                  <?php if($country === 'Ec-bp'): ?>
                  <input type="text" id="email-bp" name="email-bp" class="ignore" value=<?php echo $email; ?> readonly>
                  <input type="hidden" id="email_cypher" name="email_cypher" value=<?= $emailCypher; ?>>
                  <?php else: ?>
                  <span id="msg-correo" style="margin-left:30px; display:none;"></span>
                  <input class="email-profile" id="email" name="email" type="text" maxlength="65"
                    value="<?php echo $datos->registro->user->email; ?>" required>
                  <div id="loading" class="icono-load"
                    style="display:none; float:right; width:30px; margin-top:7px; margin-right:620px; margin-bottom:0px;">
                    <span aria-hidden="true" class="icon-refresh icon-spin" style="font-size: 30px"></span>
                  </div>
                  <input id="verificar-email" name="verificar-email" type="hidden" maxlength="65"
                    value="<?php echo $datos->registro->user->email; ?>">
                  <?php endif; ?>
                </li>
              </ul>
            </fieldset>
            <hr class="separador-profile">
            <div class="remove-perfil-plata-sueldo">
              <h2 class="profile-title-3">Datos laborales</h2>
              <fieldset class="col-md-12-profile">
                <ul class="row-profile">
                  <li class="col-md-3-profile">
                    <label>RUC</label>
                    <input type="text" name="ruc_cto_labora" id="ruc_cto_labora" value="<?php echo $ruc_cto_laboral; ?>"
                      readonly="readonly">
                  </li>
                  <li class="col-md-3-profile">
                    <label>Centro laboral</label>
                    <input type="text" maxlength="100" name="centro_laboral" id="centro_laboral"
                      value="<?php echo $centro_laboral; ?>">
                  </li>
                  <li class="col-md-3-profile">
                    <label>Situación laboral</label>
                    <select name="situacion_laboral" id="situacion_laboral">
                      <option value="">Seleccione</option>
                      <option value="1">Dependiente</option>
                      <option value="0">Independiente</option>
                    </select>
                    <input type="hidden" value="<?php echo $labora; ?>" id="situacion-laboral-value"
                      name="situacion-laboral-value">
                  </li>
                </ul>
                <ul class="row-profile">
                  <li class="col-md-3-profile">
                    <label>Antiguedad laboral</label>
                    <select class="antiguedad-laboral" id="antiguedad_laboral" name="antiguedad_laboral_value">
                    </select>
                    <input id="antiguedad" name="antiguedad" type="hidden" value="<?php echo $antiguedad_laboral;  ?>">
                  </li>
                  <li class="col-md-3-profile">
                    <label>Profesión</label>
                    <select class="field-select-medium profesion-labora" id="listaProfesion" name="profesion">
                      <input type="hidden" value="<?php echo $profesion_laboral; ?>" class="tipo_profesion_value"
                        name="tipo_profesion" id="tipo_profesion_value">
                    </select>
                  </li>
                </ul>
                <ul class="row-profile">
                  <li class="col-md-3-profile">
                    <label>Cargo</label>
                    <input type="text" maxlength="40" name="cargo" id="cargo" value="<?php echo $cargo; ?>">
                  </li>
                  <li class="col-md-3-profile">
                    <label>Ingreso promedio mensual</label>
                    <input type="text" maxlength="12" name="ingreso_promedio" id="ingreso_promedio"
                      value="<?php echo $ingreso_promedio_mensual; ?>">
                  </li>
                </ul>
                <ul class="row-profile">
                  <li class="col-md-full-profile">
                    <label>¿Desempeñó algun cargo público en los últimos 2 años?</label>
                    <label class="label-inline">
                      <input name="cargo_public" class="cargo-publico-radio" type="radio" value="1"
                        id="cargo-publico-si" /> Si
                      <input type="hidden" value="<?php echo $cargo_publico_last2; ?>" id="cargo-publico"
                        name="cargo-publico">
                    </label>
                    <label class="label-inline">
                      <input name="cargo_public" class="cargo-publico-radio" type="radio" value="0"
                        id="cargo-publico-no" /> No
                    </label>
                  </li>
                </ul>
                <ul class="row-profile">
                  <li class="col-md-3-profile">
                    <label>Cargo público</label>
                    <input type="text" class="cargo_publico" maxlength="40" name="cargo_publico" id="cargo_publico"
                      value="<?php echo $cargo_publico; ?>">
                  </li>
                  <li class="col-md-3-profile">
                    <label>Institución</label>
                    <input type="text" class="institucion_publica" maxlength="40" name="institucion_publica"
                      value="<?php echo $institucion_publica; ?>" id="institucion_publica">
                  </li>
                </ul>
                <ul class="row-profile">
                  <li class="col-md-full-profile">
                    <label>¿Es sujeto obligado a informar UIF-Peru, conforme al artículo 3° de la Ley N° 29038?</label>
                    <label class="label-inline">
                      <input id="sujeto-obligado-si" class="sujeto-obligado" name="sujeto_obligado" type="radio"
                        value="1" /> Si
                      <input type="hidden" id="uif" name="uif" value="<?php echo $uif=='' ? 0 : $uif; ?>">
                    </label>
                    <label class="label-inline">
                      <input id="sujeto-obligado-no" class="sujeto-obligado" name="sujeto_obligado" type="radio"
                        value="0" /> No
                    </label>
                  </li>
                </ul>
              </fieldset>
              <hr class="separador-profile" />
            </div>
            <h2 class="profile-title-3">Datos de Usuario</h2>
            <fieldset class="col-md-12-profile">
              <ul class="row-profile">
                <li class="col-md-3-profile">
                  <label for="new-login">Login</label>
                  <input type="text" name="userName" value="<?php echo ucwords($datos->registro->user->userName); ?>"
                    readonly="readonly">
                </li>
                <li class="col-md-3-profile">
                  <label for="birth-date">Fecha de creación</label>
                  <input type="text" value="<?php echo ucwords($datos->registro->user->dtfechorcrea_usu); ?>"
                    name="dtfechorcrea_usu" id="dtfechorcrea_usu" readonly="readonly">
                </li>
                <li class="col-md-3-profile">
                  <label for="transpwd" class="pass-2"> Notificaciones</label>
                  <label class="label-inline" for="notificacions-email"><input id="notificacions-email"
                      name="notificacions-email" type="checkbox" value=<?php echo $notEmail; ?>> Correo
                    electrónico</label>
                  <label class="label-inline" for="notificacions-sms"><input id="notificacions-sms" name="sms"
                      type="checkbox" value=<?php echo $notSms; ?>> SMS</label>
                </li>
              </ul>
              <ul class="row-profile">
                <li class="col-md-3-profile">
                  <label class="pass-2"> Contraseña </label>
                  <label for="password" class="link-config">
                    <a href="<?php echo $this->config->item("base_url"); ?>/users/cambiarPassword?t=n">Ir a la
                      configuración </a>
                  </label>
                </li>
                <?php
                                if($this->session->userdata("aplicaTransferencia")=='S'){
                                    echo"<li class='col-md-3-profile'>";
                                    echo "<label for='key' class='pass-2'> Clave de Operaciones </label>
												<label for='key' class='link-config'><a href='".$this->config->item('base_url').$ruta."'>Ir a la  configuración</a></label>
												</li>";
                                    echo"<li class='col-md-3-profile'>";
                                    echo "<label for='key' class='pass-2'> Clave SMS</label>
												 <label for='key' class='link-config'><a href='".$this->config->item('base_url')."/users/crearPasswordSms?num = $num&disponeClaveSMS = $disponeClaveSMS&acCodPais = $acCodPais&id_ext_per = $id_ext_per'>Ir a la  configuración</a></label></li>";
                                }

                                ?>
              </ul>
              <div>
                <hr class="separador-profile" />
                <ul class="row-profile">
                  <li class="col-md-12-profile">
                    <label class="label-inline" for="tyc"><input id="tyc" name="tyc" type="checkbox"
                        value=<?php echo $tyc; ?> <?php echo $tyc == 1 ? 'checked' : '' ?>> Aceptar Términos y
                      condiciones</label>
                    <span id="contract">
                      &nbsp;&nbsp;&nbsp;
                      <label class="label-inline" for="proteccion"><input id="proteccion" name="proteccion"
                          type="checkbox" value=<?php echo $acProteccion; ?>> Aceptar protección de datos
                        personales</label>
                      &nbsp;&nbsp;&nbsp;
                      <label class="label-inline" for="contrato"><input id="contrato" name="contrato" type="checkbox"
                          value=<?php echo $acContrato; ?>> Acepto el contrato de cuenta dinero electrónico plata
                        beneficios</label>
                    </span>
                  </li>
                </ul>
              </div>
            </fieldset>
            <div id="msg" style="clear:both;"></div>
            <?php if($country != 'Ec-bp'): ?>
            <div class="form-actions">
              <?php 	if($country == 'Ec-bp'): 		?>
              <center>

                <div class="atc-form-action-child-perfil-content">
                  <?php 	endif; ?>
                  <a href="<? echo $this->config->item("base_url"); ?>/dashboard"><button id="perfil-cancelar"
                      type="reset" class="novo-btn-secondary">Cancelar</button></a>
                  <button id="actualizar" class="novo-btn-primary">Continuar</button>
                  <?php 	if($country == 'Ec-bp'): 		?>

                </div>
              </center>
              <?php 	endif; ?>
              <div id="load_reg" class="icono-load" style="display:none; float:right; width:30px; margin-top:5px;">
                <span aria-hidden="true" class="icon-refresh icon-spin" style="font-size: 30px"></span>
              </div>
            </div>
            <?php endif; ?>
        </form>
      </div>
    </section>
  </article>
  <!---Actualizacion exitosa del perfil--->
  <div id="exito" style='display:none'>
    <article>
      <header>
        <h1>Perfil Actualizado Exitosamente</h1>
      </header>
      <section>
        <div id="content-clave">
          <p>Sus datos han sido cargados exitosamente.</p>
          <div class="empty-state-actions">
            <a class="button novo-btn-primary" href="<? echo $this->config->item("base_url"); ?>/dashboard"
              rel="section">Aceptar</a>
          </div>
        </div>
      </section>
    </article>
  </div>
</div>

<div class="overlay-modal" style="display:none;">

  <!-- MODAL ERROR 1 -->
  <div id="dialogo-fallo-actualizacion" style="display:none;">
    <div id="dialog" class="dialog-small">
      <div class="alert-simple alert-error" id="message">
        <span aria-hidden="true" class="icon-cancel-sign"></span>
        <p>El perfil no pudo ser actualizado, intente mas tarde.</p>
      </div>
      <div class="form-actions">
        <!--<button id="invalido1">Aceptar</button>-->
        <a href="<? echo $this->config->item("base_url"); ?>/dashboard"> <button type="submit"
            class="novo-btn-primary">Aceptar</button> </a>
      </div>
    </div>
  </div>

  <!-- MODAL ERROR 2 -->
  <div id="dialogo-actualizacion-incompleta" style="display:none;">
    <div class="dialog-small" id="dialog">
      <div class="alert-simple  alert-warning" id="message">
        <span aria-hidden="true" class="icon-cancel-sign"></span>
        <p>Los datos de la afiliación no fueron actualizados en su totalidad, por favor intente más tarde.</p>
      </div>
      <div class="form-actions">
        <!-- <button id="invalido2">Aceptar</button> -->
        <a href="<? echo $this->config->item("base_url"); ?>/dashboard"> <button type="submit"
            class="novo-btn-primary">Aceptar</button> </a>
      </div>
    </div>
  </div>
</div>

<!-- MODAL CORREO NO DISPONIBLE -->
<div id="dialogo_disponible" style='display:none'>
  <div id="dialog-confirm">
    <div class="alert-simple alert-error" id="message">
      <span aria-hidden="true" class="icon-cancel-sign"></span>
      <p>El correo indicado <strong>NO está disponible</strong> o está siendo usado por otra persona. Por favor
        verifique e intente nuevamente.</p>
    </div>
    <div class="form-actions">
      <button id="disp" class="novo-btn-primary">Aceptar</button>
    </div>
  </div>
</div>

<!-- MODAL DATOS DE AFILIACIÓN NO COMPLETADOS -->
<div id="completar-afiliacion" style='display:none'>
  <div>
    <div class="alert-simple ">
      <span aria-hidden="true" class="icon-cancel-sign"></span>
      <p id="msgAfil"></p>
    </div>
    <div class="form-actions">
      <button id="acept" class="novo-btn-primary">Aceptar</button>
    </div>
  </div>
</div>
<!--Modal protección de datos-->
<div id="datos_personales" style='display:none'>
  <div class="cond-serv">
    <p>
      Se informa que los datos personales proporcionados por el CLIENTE a TEBCA quedan incorporados al banco de datos de
      clientes de TEBCA. Dicha información será utilizada para efectos de la gestión de los servicios objeto del
      presente Contrato (incluyendo procesamiento de datos, remisión de correspondencia, entre otros), la misma que
      podrá ser realizada a través de terceros.
    </p>
    <p>
      TEBCA protege el banco de datos y sus tratamientos con todas las medidas de índole técnica y organizativa
      necesarias para resguardar su seguridad y evitar alteración, pérdida, tratamiento o acceso no autorizado.
    </p>
    <p>
      Mediante la aceptación a estos términos, usted autoriza a TEBCA a utilizar, en tanto esta autorización no sea
      revocada, sus datos personales, incluyendo datos sensibles, que hubieran sido proporcionados directamente a TEBCA,
      aquellos que pudieran encontrarse en fuentes accesibles para el público o los que hayan sido obtenidos de
      terceros; para tratamientos que supongan desarrollo de acciones comerciales, incluyendo la remisión (vía medio
      físico, electrónico o telefónico) de publicidad, información u ofertas/promociones (personalizadas o generales) de
      servicios de TEBCA y/o de otras empresas del Grupo Intercorp y sus socios estratégicos, entre las que se
      encuentran aquellas difundidas en el portal de la Superintendencia del Mercado de Valores (<a
        href="http://www.smv.gob.pe" target="_blank">www.smv.gob.pe</a>) así como en el portal <a
        href="http://www.intercorp.com.pe/es" target="_blank">www.intercorp.com.pe/es.</a> El CLIENTE autoriza a TEBCA
      la cesión, transferencia o comunicación de sus datos personales, a dichas empresas y entre ellas.
    </p>
    <p>
      El otorgamiento de la presente autorización es libre y voluntaria por lo que no condiciona el otorgamiento y/o
      gestión de los servicios ofrecidos por TEBCA.
    </p>
    <p>
      Usted puede revocar la autorización para el tratamiento de sus datos personales en cualquier momento, así como
      ejercer los derechos de acceso, rectificación, cancelación y oposición para el tratamiento de sus datos
      personales. Para ejercer este derecho, o cualquier otro previsto en las normas de protección de datos personales,
      usted deberá presentar su solicitud en la oficina de TEBCA o a través del Centro de Contacto.
    </p>
  </div>
  <div class="form-actions">
    <button id="close-datos" class="novo-btn-primary">Aceptar</button>
  </div>
</div>

<!--Modal aceptación de contrato-->
<div id="contrato_cuenta" style='display:none'>
  <div class="cond-serv">
    <p>
      Servitebca Perú, Servicio de Transferencia Electrónica de Beneficios y Pagos S.A. (en adelante, “SERVITEBCA”) y el
      Cliente celebran un contrato por el cual se regulan los términos y condiciones aplicables a la cuenta general de
      dinero electrónico “Plata Beneficios”.
    </p>
    <p>
      <strong>PRIMERA. DEFINICIONES:</strong><br>
      Cliente: persona natural titular de la cuenta general de dinero electrónico “Plata Beneficios”.<br>
      Cuenta: cuenta general de dinero electrónico, cuya titularidad es del CLIENTE<br>
      Dinero Electrónico: valor monetario almacenado en soportes electrónicos (tales como tarjetas electrónicas prepago)
      diseñados para atender usos generales.<br>
      Emisión: la conversión de dinero electrónico por el mismo valor que se recibe, a través de su almacenamiento en un
      soporte electrónico; incluye la emisión propiamente dicho, la reconversión a efectivo (retiros), transferencias,
      pagos y cualquier otro movimiento o transacción vinculado al valor monetario almacenado en el soporte
      electrónico.<br>
      Empresa: empresa que ha suscrito un contrato de servicios con SERVITEBCA para que le provea los servicios de
      emisión, gestión y procesamiento de tarjetas electrónica recargables. La Empresa solicita la emisión y realiza la
      recarga (conversión) de las Tarjetas de manera exclusiva.<br>
      Tarjeta: tarjeta electrónica denominada “Plata Beneficios” que será entregada por SERVITEBCA al CLIENTE para que
      éste pueda realizar operaciones y acceder a servicios que SERVITEBCA le ofrezca, con cargo al saldo en la Cuenta,
      para lo cual utilizará la Clave Secreta que le será proporcionada conjuntamente con la Tarjeta.
    </p>
    <p>
      <strong>SEGUNDA. OBJETO:</strong>
      Mediante el presente contrato las partes acuerdan que SERVITEBCA brindará el servicio de dinero electrónico al
      CLIENTE, a través de una Cuenta cuyo soporte electrónico será la Tarjeta. La Tarjeta podrá ser utilizada a nivel
      nacional e internacional.
    </p>
    <p>
      <strong>TERCERA. CONDICIÓN PARA LA PRESTACIÓN DEL SERVICIO:</strong>
      Para que EL CLIENTE pueda obtener la Tarjeta, la Empresa debe haber firmado un contrato de servicios con
      SERVITEBCA y haber ordenado su emisión a favor del CLIENTE. Para ser titular de la Tarjeta, el CLIENTE debe ser
      mayor de edad y haber completado los datos de identificación requeridos por SERVITEBCA.
    </p>
    <p>
      <strong>CUARTA. CARACTERÍSTICAS Y CONDICIONES DE LAS OPERACIONES, LÍMITES Y RESTRICCIONES:</strong><br>
      4.1 Operaciones<br>
      a) Recargas (o conversión): La Tarjeta sólo admite recargas de la Empresa.<br>
      b) Retiros de efectivo (o reconversión): EL CLIENTE podrá realizar retiros de efectivo a través de todos los
      cajeros automáticos a nivel nacional y en el exterior. Los retiros podrán hacerse en cualquier moneda, en cuyo
      caso estarán sujetos al tipo de cambio .<br>
      c) Consumos: EL CLIENTE podrá realizar consumos para el pago de bienes y/o servicios en los establecimientos
      afiliados a las marcas Visa o MasterCard, según corresponda a la Tarjeta, para lo cual el comercio deslizará la
      Tarjeta por el terminal POS e introducirá el monto del consumo. El CLIENTE deberá ingresar en el terminal POS la
      Clave Secreta para confirmar la operación. El valor del consumo será debitado de la Cuenta. El voucher indicará el
      monto del consumo así como el saldo disponible en la Cuenta. Asimismo, el CLIENTE podrá realizar consumos en
      páginas web, locales e internacionales, utilizando la Clave Secreta. En cualquier caso, los consumos podrán
      efectuarse en cualquier moneda, en cuyo caso estarán sujetos al tipo de cambio.<br>
      d) Consultas de saldos y movimientos: El CLIENTE podrá efectuar consultas de saldos y movimientos por (i)
      Aplicación de Acceso Móvil de Servitebca (App’s), (ii) Centro de Contacto de SERVITEBCA, llamando al (511)
      619-8931 (en adelante el “Centro de Contacto”), (iii) página web (www.miplata.com.pe), y en (v) Cajeros
      GlobalNet.<br>
      El CLIENTE podrá encontrar el detalle de las instrucciones para efectuar operaciones con la Tarjeta en la página
      web (www.miplata.com.pe).<br>
      4.2. Límites y Restricciones<br>
      Las operaciones que realice el CLIENTE con la Tarjeta estarán sujetas a los límites transaccionales cuyo detalle
      es entregado al CLIENTE conjuntamente con la Tarjeta y que constan en la página web (www.miplata.com.pe).
    </p>
    <p>
      <strong>QUINTA. CONDICIONES DE USO DE LA TARJETA:</strong>
      SERVITEBCA entregará al CLIENTE una Tarjeta, magnetizada y numerada, que vendrá en un sobre cerrado y sellado el
      cual también contendrá las condiciones de uso de la Tarjeta. Con la Tarjeta, el CLIENTE podrá realizar
      transacciones, en Soles y Dólares de los Estados Unidos de América, en el Perú y en el extranjero. La Tarjeta es
      prepago por lo que el uso de la misma estará condicionado a que la Cuenta tenga saldo disponible. El CLIENTE asume
      plena responsabilidad por el resguardo y mal uso de la Tarjeta, así como por la pérdida o hurto de la misma,
      debiendo informar inmediatamente a SERVITEBCA por los medios definidos en el presente Contrato.
    </p>
    <p>
      <strong>SEXTA. CLAVE SECRETA:</strong>
      Junto con la Tarjeta, SERVITEBCA entregará a EL CLIENTE una clave secreta (en adelante, la “Clave”). Dicha Clave
      será la única que podrá ser utilizada por EL CLIENTE para realizar consumos en establecimientos afiliados a la red
      de Visa o MasterCard, según corresponda a la Tarjeta, así como para efectuar disposiciones de efectivo en cajeros
      automáticos. El CLIENTE asume responsabilidad por mantener en reserva y no divulgar las claves, ya que todas las
      transacciones realizadas mediante el uso de éstas serán consideradas como válidamente efectuadas por EL CLIENTE.
    </p>
    <p>
      <strong>SÉTIMA. BLOQUEO DE TARJETAS:</strong><br>
      A. POR HURTO, ROBO, EXTRAVIO DE TARJETA O PERDIDA DE CLAVE SECRETA<br>
      7.1. EL CLIENTE deberá notificar a SERVITEBCA el hurto, robo o extravío de la Tarjeta, o en caso de que un tercero
      no autorizado tome conocimiento de cualquiera de las Claves, inmediatamente después de que ocurra cualquiera de
      estos hechos, llamando al Centro de Contacto para que éste bloquee la Cuenta. EL CLIENTE será responsable por las
      transacciones realizadas con la Tarjeta en tanto SERVITEBCA no haya recibido la respectiva solicitud de
      bloqueo.<br>
      7.2. En caso exista saldo remanente en la Cuenta bloqueada:<br>
      (i) EL CLIENTE deberá solicitar la reposición de la Tarjeta, previo pago de la comisión respectiva, según el
      Tarifario vigente, el cual también se encuentra en www.miplata.com.pe. El saldo se trasladará a la nueva
      Tarjeta.<br> (ii) En caso El CLIENTE no desee la reposición de la Tarjeta, podrá solicitar el reembolso del saldo
      disponible en la Tarjeta bloqueada, para lo cual deberá comunicarse con el Centro de Contacto para que le informe
      los mecanismos para la devolución. Dichos mecanismos para devolución del saldo remanente incluyen, según determine
      SERVITEBCA, la entrega de dinero en efectivo o cheque.<br>
      B. POR OTROS MOTIVOS<br>
      7.3. El CLIENTE podrá solicitar el bloqueo temporal de la Cuenta a través del Centro de Contacto. Para activar la
      Cuenta nuevamente, deberá pasar la validación positiva, en cuyo caso se activará la Cuenta el día hábil siguiente.
      SERVITEBCA informará a la Empresa sobre el bloqueo temporal de la Cuenta a fin de que no la considere para futuras
      recargas (conversiones).<br>
      7.4. El CLIENTE podrá solicitar el bloqueo definitivo de la Cuenta, para lo cual deberá comunicarse con el Centro
      de Contacto. De contar con saldo disponible y no solicitar la reposición de la Tarjeta, EL CLIENTE deberá
      solicitar al Centro de Contacto la devolución. SERVITEBCA informará los mecanismos para la devolución (entrega en
      efectivo o cheque), la cual se llevará a cabo en la oficina de SERVITEBCA. SERVITEBCA informará a la Empresa sobre
      el bloqueo definitivo de la Cuenta a fin de que no la considere para futuras recargas (conversiones).<br>
      C. POR PARTE DE SERVITEBCA<br>
      7.5. SERVITEBCA podrá bloquear temporalmente la Cuenta por mandato de autoridad competente o cuando tenga indicios
      de operaciones fraudulentas, inusuales, irregulares, ilícitas o sospechosas, incumpliendo la política de lavado de
      activos de SERVITEBCA de acuerdo con la ley de la materia o cuando el CLIENTE hubiera suministrado información
      inexacta, incompleta o falsa. En estos supuestos, SERVITEBCA le informará al CLIENTE de la medida adoptada
      mediante correo electrónico, comunicación telefónica o escrita dirigida a su domicilio.
    </p>
    <p>
      <strong>OCTAVA. EXCLUSIÓN DE RESPONSABILIDAD: </strong>
      EL CLIENTE no será responsable de pérdidas en casos de clonación de la Tarjeta, suplantación del usuario en las
      oficinas de SERVITEBCA o funcionamiento defectuoso de los canales o sistemas puestos a disposición de EL CLIENTE
      para efectuar sus operaciones .
    </p>
    <p>
      <strong>NOVENA. PLAZO: </strong>
      El presente Contrato es de plazo indeterminado.
    </p>
    <p>
      <strong>DÉCIMA. RESOLUCIÓN: </strong>
      SERVITEBCA podrá resolver el presente Contrato en cualquiera de los siguientes supuestos:<br>
      a) Si la Cuenta se mantuviera inactiva (sin movimientos) por un plazo igual o mayor a seis (6) meses;<br>
      b) Caso fortuito o fuerza mayor;<br>
      c) Cuando se trate de la aplicación de normas prudenciales emitidas por la Superintendencia de Banca, Seguros y
      Administradoras de Fondos de Pensiones, tales como aquéllas vinculadas a la prevención de lavado de activos y
      financiamiento del terrorismo;<br>
      d) Por suministro de información falsa, incompleta o insuficiente por parte de EL CLIENTE;<br>
      e) Si mantener el Contrato vigente incumple las políticas de SERVITEBCA o de alguna disposición legal.<br>
      En los supuestos descritos en los literales c) y d), la comunicación respecto a la resolución del Contrato o
      bloqueo de la Cuenta se realizará dentro de los siete (07) días calendarios posteriores de adoptada la medida. En
      los demás supuestos, SERVITEBCA informará al CLIENTE de la decisión de resolver el Contrato con tres (3) días
      hábiles de anticipación.<br>
      Una vez resuelto definitivamente el Contrato, EL CLIENTE únicamente podrá obtener el reembolso de los fondos
      disponibles en la Tarjeta previa comunicación con el Centro de Contacto para que le informe los mecanismos para la
      devolución.
    </p>
    <p>
      <strong>UNDÉCIMA. TARIFAS DE SERVICIOS: </strong>
      Los servicios objeto de este Contrato estarán sujetos a las comisiones y gastos que se indican en el Tarifario que
      será entregado al CLIENTE conjuntamente con el presente Contrato y que forma parte del mismo. EL CLIENTE autoriza
      expresamente a SERVITEBCA a compensar con los saldos disponibles en la Cuenta, cualquier costo, total o parcial,
      que se encuentre pactado en el presente Contrato. EL CLIENTE acepta que SERVITEBCA podrá rechazar las operaciones
      realizadas cuando la Cuenta no tenga saldo disponible para cubrir el pago de las comisiones y/o gastos, de acuerdo
      al presente Contrato. Si el saldo fuera insuficiente para cobrarse del mismo las comisiones/gastos en un plazo
      igual o mayor a seis (6) meses, EL CLIENTE autoriza expresamente a SERVITEBCA a resolver el Contrato y cancelar la
      Tarjeta.
    </p>
    <p>
      <strong>DUODÉCIMA. OBLIGACIONES DE SERVITEBCA: </strong>
      SERVITEBCA tendrá las siguientes obligaciones: 12.1. Proveer la Tarjeta a EL CLIENTE, según la presentación física
      y condiciones técnicas que SERVITEBCA considere necesarias para la prestación del servicio. 12.2. Permitir el uso
      de la Tarjeta para los fines establecidos en este Contrato, hasta el saldo disponible en la Cuenta. 12.3. Poner a
      disposición de EL CLIENTE un sistema de consulta de movimientos, consulta de saldos y de información sobre la
      Cuenta.
    </p>
    <p>
      <strong>DÉCIMO TERCERA. OBLIGACIONES DE EL CLIENTE: </strong>
      EL CLIENTE tendrá las siguientes obligaciones: 13.1. Pagar las comisiones y/o gastos establecidos en el Tarifario
      vigente. 13.2. Notificar a SERVITEBCA oportunamente sobre el hurto, robo o extravío de la Tarjeta o en caso un
      tercero tome conocimiento de la Clave, a fin que SERVITEBCA proceda al bloqueo de la Tarjeta. 13.3. Actualizar
      constantemente sus datos por los medios implementados por SERVITEBCA.
    </p>
    <p>
      <strong>DÉCIMO CUARTA. COMUNICACIONES: </strong>
      SERVITEBCA se reserva el derecho de modificar las condiciones contractuales, incluyendo comisiones y gastos, en
      cuyo caso informará previamente al CLIENTE dentro de los plazos y por los medios establecidos en el presente
      Contrato. Las comunicaciones que informen sobre modificaciones a las comisiones y/o gastos, resolución del
      Contrato, limitación o exoneración de responsabilidad por parte de SERVITEBCA así como la incorporación de
      servicios no relacionados directamente al servicio objeto del Contrato, serán enviadas al CLIENTE a través de
      cualquiera de los siguientes medios: (i) correos electrónicos, (ii) llamadas telefónicas o (iii) comunicaciones al
      domicilio. Dichas comunicaciones se enviarán con cuarenta y cinco (45) días de anticipación a su entrada en
      vigencia. Modificaciones contractuales distintas a las antes indicadas, serán informadas, con cuarenta y cinco
      (45) días de anticipación a su entrada en vigencia, a través de cualquiera de los siguientes medios: (i) la página
      web (www.miplata.com.pe), (ii) mensajes de texto (SMS) o (iii) correos electrónicos y en general, cualquier otro
      medio electrónico que SERVITEBCA disponga. En caso EL CLIENTE no estuviera de acuerdo con las modificaciones,
      podrá resolver el Contrato dentro de los plazos antes indicados. SERVITEBCA enviará las comunicaciones directas
      según los datos consignados por EL CLIENTE, por lo que el CLIENTE se obliga a notificar a SERVITEBCA por escrito,
      vía telefónica y/o vía web, cualquier cambio de los datos proporcionados. EL CLIENTE podrá consultar sobre los
      servicios y procedimientos de SERVITEBCA a través de los siguientes canales de atención: (i) página web
      (www.miplata.com.pe); (ii) Centro de Contacto, las 24 horas del días, los 365 días del año y cualquier otro que
      SERVITEBCA ponga a su disposición. Asimismo, EL CLIENTE podrá dirigir cualquier reclamo al Centro de Contacto, la
      página web (www.miplata.com.pe) y el correo electrónico servicios@tebca.com.pe.
    </p>
    <p>
      <strong>DÉCIMO QUINTA. AUTORIZACIÓN: </strong>
      EL CLIENTE expresamente faculta a SERVITEBCA para realizar las gestiones oportunas para constatar la veracidad de
      los datos aportados por éste. Asimismo, SERVITEBCA podrá requerir al CLIENTE información adicional o la
      rectificación o confirmación de los datos brindados por el CLIENTE, reservándose el derecho de no prestarle ningún
      servicio, en caso éste no haya suministrado o haya suministrado documentación y/o información falsa, incorrecta o
      contradictoria. A estos efectos, si el CLIENTE no brinda o rectifica la información solicitada dentro del plazo de
      siete (7) días calendario, SERVITEBCA procederá a bloquear la Cuenta y devolverá el saldo disponible en ésta, a
      través de la entrega de dinero en efectivo o cheque, según determine SERVITEBCA, en sus oficinas. Del mismo modo,
      EL CLIENTE autoriza a SERVITEBCA, sin que ello implique obligación o responsabilidad por parte de SERVITEBCA, para
      que investigue, con las más amplias facultades, todo lo relativo a los presuntos usos indebidos de la Tarjeta y se
      compromete a prestarle toda la colaboración que ésta requiera.
    </p>
    <p>
      <strong>DÉCIMO SEXTA. PROTECCIÓN DE DATOS PERSONALES: </strong>
      Se informa que los datos personales proporcionados por el CLIENTE a SERVITEBCA quedan incorporados al banco de
      datos de clientes de SERVITEBCA. Dicha información será utilizada para efectos de la gestión de los servicios
      objeto del presente Contrato (incluyendo procesamiento de datos, remisión de correspondencia, entre otros), la
      misma que podrá ser realizada a través de terceros. Asimismo, el CLIENTE autoriza a SERVITEBCA a utilizar, en
      tanto esta autorización no sea revocada, sus datos personales, incluyendo datos sensibles, que hubieran sido
      proporcionados directamente a SERVITEBCA, aquellos que pudieran encontrarse en fuentes accesibles para el público
      o los que hayan sido obtenidos de terceros; para tratamientos que supongan desarrollo de acciones comerciales,
      incluyendo la remisión (vía medio físico, electrónico o telefónico) de publicidad, información u
      ofertas/promociones (personalizadas o generales) de servicios de SERVITEBCA y/o de otras empresas del Grupo
      Intercorp y sus socios estratégicos, entre las que se encuentran aquellas difundidas en el portal de la
      Superintendencia del Mercado de Valores (www.smv.gob.pe) así como en el portal www.intercorp.com.pe/es. EL CLIENTE
      declara conocer que SERVITEBCA podrá usar, brindar y/o transferir sus datos personales para dar cumplimiento a las
      obligaciones y/o requerimientos que se generen en virtud de las normas vigentes en el ordenamiento jurídico
      peruano, incluyendo pero sin limitarse a las vinculadas al sistema de prevención de lavado de activos y
      financiamiento del terrorismo y normas prudenciales. SERVITEBCA podrá dar tratamiento y eventualmente transferir
      los datos personales del CLIENTE a autoridades y terceros autorizados por ley. Para tales efectos, el CLIENTE
      autoriza a SERVITEBCA la cesión, transferencia o comunicación de sus datos personales, a dichas empresas y entre
      ellas. Se informa al titular de los datos personales, que puede revocar la autorización para el tratamiento de sus
      datos personales en cualquier momento, de conformidad con lo previsto en la Ley de Protección de Datos Personales
      (Ley No. 29733) y su Reglamento (Decreto Supremo No. 003-2013-JUS. Para ejercer este derecho, o cualquier otro
      previsto en dichas normas, el titular de datos personales podrá presentar su solicitud en la oficina de SERVITEBCA
      o a través del Centro de Contacto.
    </p>
    <p>
      <strong>DÉCIMO SÉTIMA. DOMICILIO, SOLUCIÓN DE CONTROVERSIAS, LEGISLACIÓN APLICABLE Y DECLARACIÓN DE CONFORMIDAD:
      </strong>
      17.1. Para todo efecto derivado del presente Contrato, el CLIENTE declara como domicilio el consignado en la
      cartilla de información. Asimismo, para la solución de controversias derivadas del Contrato, las partes se someten
      a la competencia y jurisdicción de los jueces del lugar donde se celebra el Contrato. 17.2. El presente Contrato
      se regula bajo las normas aplicables de la República del Perú. 17.3. EL CLIENTE declara que: (i) suscribe este
      Contrato aceptando sus términos, (ii) las dudas sobre los términos y conceptos han sido absueltos y (iii) ha
      recibido la información/documentación necesaria respecto a las Tarjetas.
    </p>
    <p>
      <strong>DÉCIMO OCTAVA. TEXTO DEL CONTRATO: </strong>
      18.1. El Texto del presente documento también consta en la página web www.miplata.com.pe. 18.2. EL CLIENTE declara
      haber recibido un ejemplar del presente Contrato, así como una guía de uso de la Tarjeta. Para mayor información
      sobre las condiciones de uso, EL CLIENTE podrá ingresar a www.miplata.com.pe o comunicarse con el Centro de
      Contacto.
    </p>
  </div>
  <div class="form-actions">
    <button id="close-contrato" class="novo-btn-primary">Aceptar</button>
  </div>
</div>
