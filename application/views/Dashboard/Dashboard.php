<div class="row">
  <div class="col-4">
    <?php if($this->session->userdata('id_role') == 1) : ?>
    <a href="<?= site_url('Barang'); ?>" title="Barang" class="text-decoration-none">
      <?php else : ?>
        <a href="#" title="Barang" class="text-decoration-none">
    <?php endif; ?>
      <div class="card bg-primary text-white">
        <div class="card-body">
          <div class="row">
            <div class="col-8">
              <span class="h4 font-weight-bold">JUMLAH BARANG</span>
              <br>
              <span class="h2 float-right"><?= number_format($barang); ?></span>
            </div>
            <div class="col-4 m-auto"><i class="fa fa-th-large fa-2x"></i></div>
          </div>
        </div>
      </div>
    </a>
  </div>
  <div class="col-4">
    <a href="<?= site_url('Stok/in'); ?>" title="Stok Masuk" class="text-decoration-none">
      <div class="card bg-info text-white">
        <div class="card-body">
          <div class="row">
            <div class="col-8">
              <span class="h4 font-weight-bold">JUMLAH STOK MASUK</span>
              <br>
              <span class="h2 float-right"><?= number_format($in->s_in); ?></span>
            </div>
            <div class="col-4 m-auto"><i class="fa fa-cart-plus fa-2x"></i></div>
          </div>
        </div>
      </div>
    </a>
  </div>
  <div class="col-4">
    <a href="<?= site_url('Stok/out'); ?>" title="Stok Keluar" class="text-decoration-none">
      <div class="card bg-danger text-white">
        <div class="card-body">
          <div class="row">
            <div class="col-8">
              <span class="h4 font-weight-bold">JUMLAH STOK KELUAR</span>
              <br>
              <span class="h2 float-right"><?= number_format($out->s_out); ?></span>
            </div>
            <div class="col-4 m-auto"><i class="fa fa-cart-arrow-down fa-2x"></i></div>
          </div>
        </div>
      </div>
    </a>
  </div>
</div>