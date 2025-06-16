<form action="<?= base_url('cart/add') ?>" method="post">
  <?= csrf_field() ?>
  <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
  
  <div class="form-group">
    <label>Jumlah</label>
    <input type="number" name="quantity" class="form-control" value="1" min="1">
  </div>

  <div class="form-group">
    <label for="payment_method">Pilih Metode Pembayaran:</label>
    <select name="payment_method" class="form-control" required>
      <option value="">-- Pilih Bank --</option>
      <option value="BCA">BCA</option>
      <option value="MANDIRI">MANDIRI</option>
      <option value="BNI">BNI</option>
      <option value="BRI">BRI</option>
    </select>
  </div>

  <button type="submit" class="btn btn-success">Tambah ke Keranjang</button>
  <a href="<?= base_url('/') ?>" class="btn btn-link">Kembali</a>
</form>
