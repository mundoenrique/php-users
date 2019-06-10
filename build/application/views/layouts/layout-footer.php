<?php
	$closeLink = $this->config->item('base_url') . '/users/closeSess';

?>

<footer id="foot">
    <div id="foot-wrapper">
        <div class="foot-wrapper-top">
            <nav id="foot-menu">
                <ul class="menu">
                    <?php if ($this->session->userdata('idUsuario') !== false): ?>
                        <li class="menu-item terms">
                            <label class="label-inline condiciones-g" id="condiciones-g" for="accept-terms"><a href="#" rel="section">Condiciones de Uso</a></label>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <a id="app-engine" href="http://www.novopayment.com/" rel="me" target="_blank">NovoPayment, Inc.</a>
        </div>
        <div class="foot-wrapper-bottom">
            <ul id="certificates">
                <li class="certificate-item norton-secured">Norton Secured</li>
                <li class="certificate-item pci">PCI Security Standards Council</li>
            </ul>
            <p id="app-copyright">© <?php echo date('Y'); ?> NovoPayment Inc. All rights reserved.</p>
        </div>
    </div>
</footer>
<script type="text/javascript"> var base_url = "<?php echo $this->config->item("base_url"); ?>";</script>
<?php if($FooterCustomInsertJSActive){?>

    <?php
    foreach ($FooterCustomInsertJS as $script) {
        echo insert_js_cdn($script);
        echo "\n";
    }
    if ($this->session->userdata('nombreCompleto')) { // Die Session JS call
        echo insert_js_cdn('diesession.js'); }
    ?>

<?php };?>
<?php if($FooterCustomJSActive){?>
    <script>
        {FooterCustomJS}
    </script>
<?php };?>
</body>
</html>

<!-- MODAL VALIDACION RECPATCHA-->

<div id="dialog-validate" style='display:none'>
  <header>
    <h2>Validación de acceso</h2>
  </header>
  <div class="dialog-small" id="dialog">
    <div class="alert-simple alert-warning" id="message">
      <span aria-hidden="true" class="icon-warning-sign"></span>
      <p>El sistema ha detectado una actividad no autorizada, por favor intenta nuevamente </p>
    </div>
    <div class="form-actions">
      <button id="error-validate">Aceptar</button>
    </div>
  </div>
</div>

<div id="diesession_modal" style='display:none;'>
    <article>
        <section>
            <div id="content-holder">
                <h2>Desconexión automática</h2>
                <div style="background: #03A9F4" class="alert-success" id="message">
                    <p style="line-height: 30px">No se ha detectado actividad en la p&aacute;gina.</p><p>Sesi&oacute;n pr&oacute;xima a expirar.</p>
                </div>
                <div class="form-actions">
                    <a href="<? echo $closeLink; ?>" id="aceptar_diesession"><button>Continuar</button></a>
                </div>
            </div>
        </section>
    </article>
</div>

<!-- TERMINOS Y CONDICIONES -->
<div id="dialog-tc" style='display:none'>

    <h2>Condiciones de Uso</h2>

    <div class="dialog-content">
        <?php if (ucwords($this->session->userdata('pais')) == 'Co'): ?>
            <p><strong>NovoPayment Colombia S.A.S.</strong>, sociedad legalmente constituida y registrada ante la Cámara de Comercio de Bogotá (en adelante  “La Empresa”); a continuación establece las Condiciones Generales y Términos de Uso y Confidencialidad que rigen la plataforma electrónica desarrollada por La Empresa y que ha sido habilitada para que los clientes de las instituciones financieras emisoras (en adelante los “Usuarios”), puedan hacer uso de las distintas funcionalidades que ofrece.</p>
                <p>En consecuencia, los Usuarios que deseen acceder a la referida plataforma, se obligan a leer las presentes Condiciones Generales y Términos de Uso y Confidencialidad cuidadosamente antes de continuar su recorrido, con lo cual se entenderá que están de acuerdo con las mismas y declaran que aceptan cumplir a cabalidad las instrucciones y obligaciones aquí contenidas. </p>
                <p>La plataforma de La Empresa le proporciona a los Usuarios, las herramientas necesarias para cumplir y hacer uso de las distintas soluciones de gestión de efectivo ofrecidas por las entidades emisoras, de manera rápida y con total seguridad. Sin embargo, La Empresa no garantiza, de forma alguna, el servicio ininterrumpido o libre de error de la misma.</p>
                <p>La página web de La Empresa ofrece el enlace con otras páginas web por lo que el acceso a dichas páginas será por cuenta y riesgo de los Usuarios. De igual forma, los Usuarios podrán encontrar anuncios referentes a las promociones de los productos y servicios de La Empresa los cuales se regirán por los contratos que regulan dichos productos y servicios así como, por los términos y condiciones que rijan las respectivas promociones.</p>
                <p>La Empresa declara que toda la información referente a los Usuarios, será tratada conforme a las disposiciones constitucionales, legales y administrativas que garantizan los derechos a la privacidad de las comunicaciones y del acceso a la información personal, según lo dispuesto en la Ley Estatutaria 1581 de 2012, y su respectivo Decreto Reglamentario 1377 de 2013, así como también lo dispuesto en la Constitución Política de Colombia de 1991.</p>
                <p>Por tal motivo, La Empresa se compromete a nunca emitir ni divulgar datos personales sin el expreso consentimiento de los Usuarios a no ser que sea para verificar datos o cumplir con requisitos legales. No obstante, La Empresa, previa autorización por parte de los Usuarios, podrá transferir estos datos en caso de venta de la empresa, siempre respetando y garantizado la privacidad, el honor y la reputación de las personas.</p>
                <p>En tal sentido, los Usuarios entienden que la información contenida, fijada y puesta a disposición del público en la página web de La Empresa son considerados mensajes de datos, según los términos y condiciones que aquí se exponen. Sobre los mensajes de datos se garantizan los derechos a la privacidad de las comunicaciones y del acceso a la información personal.</p>
                <p>La Empresa declara que los mensajes de datos vienen resguardados por dispositivos de seguridad que permiten verificar que no han sido alterados, que han permanecido íntegros durante su generación, comunicación y transmisión, recepción y archivo, y para confirmar la identidad del emisor, con ello se puede evidenciar su origen. Asimismo, estos mensajes de datos son grabados y pueden ser recuperados para ulterior consulta.</p>
                <p>A su vez, queda expresamente entendido que entre La Empresa y los Usuarios de las bases de datos digitales, originales o no, que han sido creadas con ocasión de brindar servicios y productos con información personal, privada y confidencial de los Usuarios le pertenecen a La Empresa quien, con expresa autorización por parte de los usuarios, es la única titular de los derechos económicos sobre la misma. No obstante, La Empresa protegerá y respetará los derechos personalísimos que del uso o almacenamiento de dicha información se genere en cabeza de los Usuarios, conforme a lo dispuesto en la ley Estatutaria 1581 de 2012, y su respectivo Decreto Reglamentario 1377 de 2013.</p>
                <p>En tal sentido, La Empresa hará su mejor esfuerzo para el mejor uso de sus plataformas tecnológicas, garantizando el honor y la intimidad personal y familiar de los Usuarios, y así lo entienden estos últimos. No obstante, La Empresa se reserva el derecho de suspender el servicio temporalmente en cualquier momento, sin previa notificación a los Usuarios, siempre y cuando sea por razones de mantenimiento de la plataforma u otras razones de carácter técnico que se consideren necesarias y convenientes. En estos casos, no existirá ningún tipo de responsabilidad y por ende no generará ningún tipo de indemnización por parte de La Empresa a los Usuarios.</p>
                <p>Los Usuarios, de conformidad con las políticas de seguridad y privacidad de la plataforma tecnológica, al momento de su registro en la misma, tendrán la posibilidad de elegir si desean recibir o no mensajes electrónicos comerciales por parte de La Empresa.</p>
                <p>Los Usuarios, de conformidad con las políticas de seguridad y privacidad de la plataforma tecnológica, al momento de su registro en la misma, tendrán la posibilidad de elegir si desean recibir o no mensajes electrónicos comerciales por parte de La Empresa.</p>
                <p>En caso de cualquier violación a por parte de los Usuarios de las condiciones de seguridad y privacidad, de los sistemas que utilizan tecnología de la información, de la privacidad de las personas y comunicaciones y de la propiedad intelectual que estén vinculados a la plataforma tecnológica, se estará en incumplimiento de lo establecido por las distintas normas que regulan la materia.</p>
                <p>En caso de cualquier violación a por parte de los Usuarios de las condiciones de seguridad y privacidad, de los sistemas que utilizan tecnología de la información, de la privacidad de las personas y comunicaciones y de la propiedad intelectual que estén vinculados a la plataforma tecnológica, se estará en incumplimiento de lo establecido por las distintas normas que regulan la materia.</p>
                <p>Al seleccionar la opción “Acepto las Condiciones de Uso de este sistema”, El Usuario también está aceptando el Reglamento de Uso de las tarjetas prepago publicado en <a href="https://pichincha.miplata.com.co/reglamento" target="_blank">https://www.pichincha.miplata.com.co/reglamento/</a> y <a href="https://pichincha.mibonus.com.co/reglamento" target="_blank">https://www.pichincha.mibonus.com.co/reglamento/.</a></p>

        <?php elseif (ucwords($this->session->userdata('pais')) == 'Pe' || ucwords($this->session->userdata('pais')) == 'Usd'): ?>
            <p><strong>Tebca Perú, Transferencia Electrónica de Beneficios S.A.C.</strong> y <strong>Servitebca Perú, Servicio de Transferencia Electrónica de Beneficios y Pagos S.A.,</strong> ambas sociedades domiciliadas en la ciudad de Lima e inscritas en la partida electrónica 12071991 y 12072298, en fechas 18 de octubre de 2007 y 19 de octubre de 2007 respectivamente, quienes en lo adelante, conjunta o indistintamente, se denominarán “La Empresa”; a continuación describen los términos y condiciones que rigen el uso y la confidencialidad de la plataforma electrónica de La Empresa; en lo adelante “La Plataforma”:</p>
            <p>Sus Usuarios se obligan a leer las presentes Condiciones Generales y Términos de Uso y Confidencialidad cuidadosamente antes de continuar su recorrido en este sitio  web y, de hacerlo, se entenderá que están de acuerdo con las mismas y declaran que aceptan cumplir a cabalidad con las instrucciones y obligaciones aquí contenidas .</p>

            <p>La Empresa, no se hace responsable por las medidas de seguridad que deben ser tomadas por los Usuarios, cuando obtengan sus claves y contraseñas personales, ni por el uso inadecuado del resguardo de las mismas; en ese sentido, se libera de toda responsabilidad con relación al mal uso de claves, contraseñas, firmas electrónicas, certificados e incluso del mismo hardware en donde se almacena la información que es privilegiada. Esta liberación de responsabilidad, se extiende a cualquier daño causado por los Usuarios derivado del mal uso de la información contenida en La Plataforma. Igualmente, La Empresa no se hace responsable por el incumplimiento o retardo en la prestación de sus servicios, siempre y cuando, sea consecuencia de un caso fortuito y/o fuerza mayor y durante el tiempo que éstos persistan.</p>

            <p>La Plataforma de La Empresa le proporciona a sus Usuarios las herramientas necesarias para cumplir y hacer uso de los distintos programas que ofrece de manera eficaz, rápida y con total seguridad. Sin embargo, La Empresa no garantiza de forma alguna el servicio ininterrumpido o libre de error a través de este sitio web.</p>

            <p>Esta Plataforma de La Empresa ofrece el enlace con otros sitios web por lo que el acceso a los mismos será por cuenta y riesgo de los Usuarios. De igual forma, los Usuarios podrán encontrar anuncios referentes a las promociones de los productos y servicios de La Empresa los cuales se regirán por los contratos que los regulan  así como, por los términos y condiciones que rijan las respectivas promociones.</p>

            <p>La Empresa declara que la data, información y en general los productos y servicios ofrecidos por ésta, cuando pertenecen o se refieren al Usuario, están sometidos a las disposiciones constitucionales, legales y administrativas que garantizan los derechos a la privacidad de las comunicaciones y del acceso a la información personal, según lo dispuesto en el numeral 6 del artículo 2 de la Constitución Política del Perú y en la Ley 29733, Ley de Protección de Datos Personales y su Reglamento, aprobado mediante Decreto Supremo 003-2013-JUS.</p>

            <p>En tal sentido, los Usuarios entienden que la información contenida, fijada y puesta a disposición del público en La Plataforma de La Empresa son considerados mensajes de datos, según los términos y condiciones que aquí se exponen. Sobre los mensajes de datos se garantizan los derechos a la privacidad de las comunicaciones y del acceso a la información personal.</p>

            <p>La Empresa declara que los mensajes de datos vienen resguardados por dispositivos de seguridad que brindan, para verificar que no han sido alterados, que han permanecido íntegros durante su generación, comunicación y transmisión, recepción y archivo, y para confirmar la identidad del emisor, con ello se puede evidenciar su origen. Asimismo, estos mensajes de datos son grabados y pueden ser recuperados para ulterior consulta.</p>

            <p>Así mismo, La Empresa declara que todas las creaciones intelectuales, marcas, slogans, nombres de dominio, diseños y cualquier otro bien inmaterial, estén o no protegidos bajo las normas de Propiedad Intelectual: Propiedad Industrial y Derechos de Autor, tendrán como único titular de los derechos económicos sobre los objetos inmateriales protegidos a La Empresa, quien es la única que los podrá utilizar conforme a la protección y facultades que les otorga en Perú, el sistema jurídico de propiedad intelectual vigente.</p>

            <p>La Empresa hará sus mejores esfuerzos para el adecuado uso de sus plataformas tecnológicas, garantizando el honor y la intimidad personal y familiar de sus Usuarios, y así lo entienden estos últimos. No obstante, La Empresa se reserva el derecho de suspender el servicio temporalmente en cualquier momento sin previa notificación a los Usuarios, siempre y cuando sea por razones de mantenimiento de La Plataforma u otras razones de carácter técnico que se consideren necesarias y convenientes. En estos casos, no existirá ningún tipo de indemnización por parte de La Empresa a los Usuarios.</p>

            <p>Los Usuarios, de conformidad con las políticas de seguridad y privacidad de La Plataforma , podrán revocar su consentimiento o autorización por cualquiera de los canales de atención que mantiene La Empresa, si no desea recibir mensajes electrónicos comerciales, en cuyo caso, La Empresa cesará dichos envíos y aplicará las medidas correctivas amigables correspondientes.</p>

            <p>La Empresa se reserva a su total discreción, emplear todos los medios necesarios a su alcance para retirar de forma inmediata al usuario que infrinja cualquiera de las condiciones de seguridad  y privacidad de La Plataforma , lo cual incluye que los Usuarios hayan enviado información falsa que no sea susceptible de verificarla en cuanto a su autenticidad.</p>

            <p>Igualmente, La Empresa, tiene el derecho de cambiar las políticas de seguridad y privacidad, siendo que todo cambio será publicado en La Plataforma  a los fines de notificar a sus Usuarios.</p>
            <p>Así pues, en caso de cualquier violación a las condiciones de seguridad y privacidad, a los sistemas que utilizan tecnología de la información, a la privacidad de las personas y comunicaciones y a la propiedad intelectual que estén vinculados a La Plataforma , se le aplicará lo dispuesto en el Código Penal sobre Delitos Informáticos y demás normas vigentes y aplicables del ordenamiento jurídico del Perú.</p>

        <?php elseif (ucwords($this->session->userdata('pais')) == 'Ve'): ?>
            <p><strong>Tebca Transferencia Electrónica de Beneficios, C.A</strong> y <strong> Servitebca Servicio de Transferencia Electrónica de Beneficios, C.A,</strong> ambas sociedades domiciliadas en la ciudad de Caracas e inscritas ante el Registro Mercantil Primero de la Circunscripción Judicial del Distrito Capital y Estado Miranda,  en fechas 02 de agosto de 2004 y 12 de mayo de 2005 y  registradas bajo los Nos. 79 y 72, Tomos 128-A-Pro. y 60-A-Pro., respectivamente,  quienes en lo adelante, conjunta o indistintamente, se denominarán ”La Empresa”; a continuación describen los términos y condiciones que rigen el uso y la confidencialidad de esta plataforma electrónica, en lo adelante “La Plataforma”:</p>
            <p>Sus Usuarios se obligan a leer las presentes Condiciones y Términos Generales de Uso y Confidencialidad cuidadosamente antes de continuar su recorrido en este sitio web y, de hacerlo, se entenderá que están de acuerdo con las mismas y declaran que aceptan cumplir a cabalidad con las instrucciones y obligaciones aquí contenidas. </p>
            <p>La Empresa, no se hace responsable por las medidas de seguridad que deben ser tomadas por los Usuarios para el uso adecuado de La Plataforma; siendo así plenamente responsables del manejo de la obtención de sus claves y contraseñas personales y del uso y resguardo de las mismas; en ese sentido, La Empresa se libera de toda responsabilidad con relación al mal uso de claves, contraseñas, firmas electrónicas, certificados e incluso del hardware en donde se almacena la información que es privilegiada. Asimismo, esta liberación de responsabilidad, se extiende a cualquier daño causado por los Usuarios derivado del mal uso de la información contenida en La Plataforma. </p>
            <p>Esta Plataforma les proporciona a sus Usuarios las herramientas necesarias para cumplir y hacer uso de los distintos programas que ofrece de manera eficaz, rápida y segura. Sin embargo, La Empresa no garantiza de forma alguna el servicio ininterrumpido o libre de error a través de este sitio  web.</p>
            <p>Igualmente, La Empresa no se hace responsable por el incumplimiento o retardo en la prestación de sus servicios cuando éste sea derivado de un caso fortuito y/o fuerza mayor durante todo el tiempo que éstos persistan.</p>
            <p>Esta Plataforma ofrece el enlace con otros sitios web con respecto a los cuales, La Empresa no es responsable de las políticas de uso y privacidad de los mismos; siendo que el acceso a éstos será por cuenta y riesgo de los Usuarios. De igual forma, los Usuarios podrán encontrar anuncios referentes a promociones de los productos y servicios de La Empresa los cuales se regirán por los contratos particulares que los regulan  así como, por los términos y condiciones que rijan las respectivas promociones. </p>
            <p>La Empresa declara que establecerá y se acogerá a las políticas de seguridad, privacidad, transparencia y confiabilidad necesarias, a fin de resguardar los intereses de los Usuarios de conformidad con la legislación vigente. De igual forma, la data, información y en general, los productos y servicios ofrecidos por La Empresa, cuando pertenecen o se refieren a los Usuarios, están sometidos a las disposiciones constitucionales, legales y administrativas que garantizan los derechos a la privacidad de las comunicaciones y del acceso a la información personal.</p>
            <p>La Empresa podrá transferir los datos en caso de venta o cualquier otro mecanismo de cesión de derechos del que sea partícipe, sin necesidad de autorización de los Usuarios pero, siempre respetando y garantizado la privacidad, el honor y la reputación de los Usuarios.</p>
            <p>En tal sentido, los Usuarios entienden que la información contenida, fijada y puesta a disposición del público en la página web de La Empresa son considerados mensajes de datos, según los términos y condiciones que aquí se exponen; sobre los cuales se garantizan los derechos a la privacidad de las comunicaciones y del acceso a la información personal. </p>
            <p>La Empresa declara que los mensajes de datos vienen resguardados por dispositivos de seguridad para verificar que no han sido alterados, que han permanecido íntegros durante su generación, comunicación y transmisión, recepción y archivo, y para confirmar la identidad del emisor, con lo cual se puede evidenciar su origen. Asimismo, estos mensajes de datos son grabados y pueden ser recuperados para ulterior consulta. </p>
            <p>Igualmente, La Empresa declara que todas las creaciones intelectuales, marcas, slogans, nombres de dominio, diseños y cualquier otro bien inmaterial, estén o no protegidos bajo las normas de Propiedad Intelectual, Propiedad Industrial y Derecho de Autor, tendrán como único titular de los derechos económicos sobre los objetos inmateriales protegidos a La Empresa quien es la única que los podrá utilizar conforme a la protección y facultades que les otorga en Venezuela el sistema jurídico de propiedad intelectual vigente.</p>
            <p>A su vez, queda expresamente entendido que entre La Empresa y los Usuarios de las bases de datos digitales, originales o no, que han sido creadas con ocasión de brindar servicios y productos con data e información personal, privada y confidencial de los Usuarios le pertenecen a La Empresa quien es la única titular de los derechos económicos sobre la misma. No obstante, La Empresa protegerá  y respetará los derechos de intimidad, honor y reputación de las personas establecidos en la Constitución de la República Bolivariana de Venezuela. En tal sentido, La Empresa hará sus mejores esfuerzos para el mejor uso de las plataformas tecnológicas, garantizando el honor y la intimidad personal y familiar de los Usuarios, y así lo entienden estos últimos.</p>
            <p>Los Usuarios, de conformidad con las políticas de seguridad y privacidad de La Plataforma, podrán manifestar expresamente, por los mecanismos de comunicación que La Empresa ponga a su disposición, si no desea recibir mensajes electrónicos comerciales en sus diversas facetas, en cuyo caso La Empresa cesará dichos envíos y aplicará las medidas correctivas amigables correspondientes.</p>
            <p>La Empresa se reserva, a su total discreción, la posibilidad de emplear todos los medios necesarios a su alcance para retirar de forma inmediata al Usuario que infrinja cualquiera de las condiciones de seguridad  y privacidad de La Plataforma tecnológica, lo cual incluye que el Usuario haya enviado información falsa que no sea susceptible la verificación de su autenticidad. Así pues, en caso de cualquier violación a las condiciones de seguridad y privacidad, a los sistemas que utilizan tecnología de la información, a la privacidad de las personas y comunicaciones y a la propiedad intelectual que estén vinculados a La Plataforma, se aplicará lo dispuesto en la Ley Especial contra Delitos Informáticos vigente en la República Bolivariana de Venezuela así como, cualquier otra normativa que le aplique.</p>
            <p>Igualmente, La Empresa tiene el derecho de cambiar las políticas de seguridad y privacidad, siendo que todo cambio será publicado en esta Plataforma a los fines de notificar a sus Usuarios. </p>

        <?php endif; ?>
    </div>
    <div class="form-actions">
        <button id="ok"> Aceptar </button>
    </div>


</div>
