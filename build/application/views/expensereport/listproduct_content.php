<div id="dashboard" class="dashboard-content h-100 bg-content">
  <div class="py-4 px-5">
    <header class="">
      <h1 class="h3 semibold primary">Reportes</h1>
    </header>
    <section>
      <div class="pt-3">
        <h2 class="h4 regular tertiary">Selecciona un producto</h2>
        <div class="line mt-1"></div>
        <div id="dashboard" class="dashboard-items flex max-width-xl-6 mt-3 mx-auto flex-wrap justify-center">
          <form action="<?= base_url('detallereporte'); ?>" id="frmProducto" method="post">
            <input type='hidden' name='<?php echo $novoName ?>' value='<?php echo $novoCook ?>'>
            <input type='hidden' name='nroTarjeta' id='nroTarjeta' value=''>
            <input type='hidden' name='noTarjetaConMascara' id='noTarjetaConMascara' value=''>
            <input type='hidden' name='prefix' id='prefix' value=''>
          </form>
          <?php
          if (is_array($data) && count($data) > 0) {
            foreach ($data as $row) {
              $state = '';
              $infoCard = '';
              $title = '';
              switch ($row) {
                case ($row['bloque'] !== '' && $row['bloque'] == 'S'):
                  $infoCard = '<span class="semibold danger">' . lang('GEN_TEXT_BLOCK_PRODUCT') . '</span>';
                  break;
                default:
                  $infoCard = '<p class="mb-0 h6 light text">' . strtoupper($row['nomEmp']) . '</p>';
              }
          ?>
              <div class="dashboard-item big-modal p-1 mx-1 mb-1 <?= $state; ?>" id="<?= $row['nroTarjeta']; ?>" title="<?= $title; ?>">
                <img class=" item-img" src="<?= $this->asset->insertFile($row['nameImage'], 'images', 'bdb', 'programs'); ?>" alt="Tarjeta gris">
                <div class="item-info <?= lang('SETT_FRANCHISE_LOGO') === 'ON' ? strtolower($row['marca']) : '' ?> p-2 h5 tertiary bg-white">
                  <p class="item-category semibold primary"><?= $row['nombre_producto']; ?></p>
                  <p class="item-cardnumber mb-0"><?= $row['nroTarjetaMascara']; ?></p>
                  <?= $infoCard; ?>
                </div>
                <form action="<?= base_url('detallereporte'); ?>" id="frmProduct-<?= $row['nroTarjeta']; ?>" method="post">
                  <input type='hidden' name='<?php echo $novoName ?>' value='<?php echo $novoCook ?>'>
                  <input type='hidden' id='nroTarjeta' name='nroTarjeta' value='<?= $row['nroTarjeta']; ?>'>
                  <input type='hidden' id='producto' name='producto' value='<?= $row['prefix']; ?>'>
                  <input type='hidden' id='bloque' name='bloque' value='<?= $row['bloque']; ?>'>
                  <input type='hidden' id='nom_plastico' name='nom_plastico' value='<?= $row['nomPlastico']; ?>'>
                  <input type='hidden' id='nroTarjetaMascara' name='nroTarjetaMascara' value='<?= $row['nroTarjetaMascara']; ?>'>
                  <input type='hidden' id='nomEmp' name='nomEmp' value='<?= $row['nomEmp']; ?>'>
                  <input type='hidden' id='marca' name='marca' value='<?= $row['marca']; ?>'>
                  <input type='hidden' id='nombre_producto' name='nombre_producto' value='<?= $row['nombre_producto']; ?>'>
                  <input type='hidden' id='tarjetaHabiente' name='tarjetaHabiente' value='<?= $row['tarjetaHabiente']; ?>'>
                  <input type='hidden' id='id_ext_per' name='id_ext_per' value='<?= $row['id_ext_per']; ?>'>
                  <input type='hidden' id='id_ext_emp' name='id_ext_emp' value='<?= $row['id_ext_emp']; ?>'>
                  <input type='hidden' id='nameImage' name='nameImage' value='<?= $row['nameImage']; ?>'>
                  <input type='hidden' id='totalProducts' name='totalProducts' value='<?= $totalProducts; ?>'>
                </form>
              </div>
            <?php
            }
            ?>
            <div class="dashboard-item mx-1"></div>
            <div class="dashboard-item mx-1"></div>
            <div class="dashboard-item mx-1"></div>
          <?php
          } else {
          ?>
            <h3 class="h4 regular tertiary pt-3"><?= $data->msg; ?></h3>
          <?php
          }
          ?>
        </div>
      </div>
    </section>
  </div>
</div>