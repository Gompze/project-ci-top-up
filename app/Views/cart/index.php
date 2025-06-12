<h3>Keranjang Saya</h3>
<?php if (empty($carts)): ?>
  <p>Keranjang kosong. <a href="<?= base_url('/') ?>">Kembali berbelanja</a></p>
<?php else: ?>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Game</th>
        <th>Diamond</th>
        <th>Harga (pcs)</th>
        <th>Jumlah</th>
        <th>Subtotal</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($carts as $item): ?>
        <tr>
          <td><?= esc($item['game']) ?></td>
          <td><?= esc($item['diamond']) ?></td>
          <td>Rp <?= number_format($item['price'],0,',','.') ?></td>
          <td>
            <form action="<?= base_url('cart/update/'.$item['id']) ?>" method="post" class="form-inline">
              <?= csrf_field() ?>
              <input type="number" name="quantity" class="form-control form-control-sm mr-2" value="<?= $item['quantity'] ?>" min="0" style="width: 60px;">
              <button type="submit" class="btn btn-sm btn-primary">Update</button>
            </form>
          </td>
          <td>Rp <?= number_format($item['price'] * $item['quantity'],0,',','.') ?></td>
          <td>
            <form action="<?= base_url('cart/update/'.$item['id']) ?>" method="post">
              <?= csrf_field() ?>
              <input type="hidden" name="quantity" value="0">
              <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus item?')">Hapus</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <div class="text-right mb-3">
    <h5>Total: <strong>Rp <?= number_format($total,0,',','.') ?></strong></h5>
  </div>
  <a href="<?= base_url('cart/checkout') ?>" class="btn btn-success">Checkout</a>
<?php endif; ?>
