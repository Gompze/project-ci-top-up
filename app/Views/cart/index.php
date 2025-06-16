<div class="container py-5">
  <h3>Keranjang Saya</h3>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
      <?= session()->getFlashdata('success') ?>
    </div>
  <?php elseif (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
      <?= session()->getFlashdata('error') ?>
    </div>
  <?php endif; ?>

  <?php
  function getItemLabel($game) {
      $labels = [
          'Mobile Legends' => 'Diamond',
          'Free Fire'      => 'Diamond',
          'PUBG Mobile'    => 'UC',
          'Valorant'       => 'VP',
          'Genshin Impact' => 'Genesis Crystal',
      ];
      return $labels[$game] ?? 'Item';
  }
  ?>

  <?php if (empty($carts)): ?>
    <p>Keranjang kosong. <a href="<?= base_url('topup') ?>">Kembali berbelanja</a></p>
  <?php else: ?>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Game</th>
          <th>Item</th>
          <th>Harga</th>
          <th class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($carts as $item): ?>
          <tr>
            <td><?= esc($item['game']) ?></td>
            <td><?= getItemLabel($item['game']) ?> <?= esc($item['diamond_amount']) ?></td>
            <td>Rp <?= number_format($item['diamond_price'],0,',','.') ?></td>
            <td class="text-center">
              <form action="<?= base_url('cart/update/'.$item['id']) ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="quantity" value="0">
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus item?')">
                  Hapus
                </button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="text-end mb-3">
      <h5>Total: <strong>
        Rp <?= number_format($total,0,',','.') ?>
      </strong></h5>
    </div>

    <div class="d-flex justify-content-start gap-2">
  <a href="<?= base_url('topup') ?>" class="btn btn-outline-primary">
    Beli Lagi?
  </a>
  <a href="<?= base_url('cart/checkout') ?>" class="btn btn-success">
    Checkout
  </a>
</div>

  <?php endif; ?>
</div>
