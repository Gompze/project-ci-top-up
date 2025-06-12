<h3>Daftar Paket Diamond</h3>
<div class="row">
  <?php foreach($products as $p): ?>
    <div class="col-md-3 mb-3">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title"><?= esc($p['game']) ?></h5>
          <p class="card-text"><?= esc($p['diamond']) ?></p>
          <p><strong>Rp <?= number_format($p['price'],0,',','.') ?></strong></p>
          <a href="<?= base_url('product/'.$p['id']) ?>" class="btn btn-sm btn-primary">Detail & Beli</a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
