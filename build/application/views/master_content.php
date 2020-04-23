<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="ES">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>CEO - Banco Bogota</title>
	<?= $this->asset->insertCss($countryUri,'css'); ?>
</head>

<body>
	<article class="main">
    <div class="login-content flex flex-column items-center bg-primary">
      <img class="logo-banco mb-2" src="<?= $this->asset->insertFile('img-banco_bogota.svg','img',$countryUri); ?>" alt="">
      <span class="mb-2 secondary center h3">Personas</span>
      <div class="login bg-widget rounded">
        <form class="" action="">
          <div class="form-group">
            <label for="username">Usuario</label>
            <input id="username" class="form-control" type="text" placeholder="Usuario">
          </div>
          <div class="form-group">
            <label for="userpwd">Contraseña</label>
            <input id="userpwd" class="form-control" type="password" placeholder="Contraseña">
          </div>
        </form>
        <button id="login" class="btn btn-primary btn-icon icon-lock mx-auto my-3 flex">Ingreso Seguro</button>
        <a href="#!" class="block mb-1 h5">Olvidé mi usuario</a>
        <a href="#!" class="block mb-1 h5">Olvidé mi Contraseña</a>
        <p class="mb-0 h5">¿No posees usuario? <a href="#!">Regístrate</a></p>
      </div>
    </div>
  </article>

	<footer class="main-footer p-5 flex">
		<div class="flex mr-4">
			<img class="" src="<?= $this->asset->insertFile('img-mark.svg','img',$countryUri); ?>" alt="Logo Superintendencia">
		</div>
    <div class="flex flex-auto flex-wrap justify-between items-center">
			<img class="order-first" src="<?= $this->asset->insertFile('img-bogota_white.svg','img',$countryUri); ?>" alt="Logo Banco de Bogotá">
			<img class="order-1" src="<?= $this->asset->insertFile('img-pci_compliance.svg','img',$countryUri); ?>" alt="Logo PCI">
			<img class="order-1" src="<?= $this->asset->insertFile('img-engine.svg','img',$countryUri); ?>assets/images/img-engine.svg" alt="Logo NovoPayment">

      <span class="copyright-footer mt-1 nowrap flex-auto lg-flex-none order-1 order-lg-0 center h6">© Todos los derechos reservados. Banco de Bogotá - 2019.</span>
    </div>
	</footer>

</body>

</html>
