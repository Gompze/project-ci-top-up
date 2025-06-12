<div class="row">
  <div class="col-md-6">
    <h4><?= esc($product['game']) ?> – <?= esc($product['diamond']) ?></h4>
    <p>Harga: <strong>Rp <?= number_format($product['price'],0,',','.') ?></strong></p>
    <form action="<?= base_url('cart/add') ?>" method="post">
      <?= csrf_field() ?>
      <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
      <div class="form-group">
        <label>Jumlah</label>
        <input type="number" name="quantity" class="form-control" value="1" min="1">
      </div>
      <button type="submit" class="btn btn-success">Tambah ke Keranjang</button>
      <a href="<?= base_url('/') ?>" class="btn btn-link">Kembali</a>
    </form>
  </div>
</div>
