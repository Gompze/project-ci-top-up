<!-- Notifikasi jika ada transaksi baru -->
<?php if (session()->has('success')): ?>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <?= session('success') ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<table class="table table-dark table-striped mt-4">
  <thead>
    <tr>
      <th>Game</th>
      <th>ID</th>
      <th>Satuan</th>
      <th>Jumlah</th>
      <th>Harga</th>
      <th>Bank</th>
    </tr>
  </thead>
  <tbody>
  <?php
    $lastTransactionId = null;
    $map = [
      'Mobile Legends' => 'Diamonds',
      'Free Fire'      => 'Diamonds',
      'PUBG Mobile'    => 'UC',
      'Valorant'       => 'VP',
    ];
  ?>

  <?php foreach ($transactions as $t): ?>
    <tr>
      <td><?= esc($t['game']) ?></td>
      <td>
        <?= esc($t['user_id']) ?>
        <?= $t['zone_id'] ? '/' . esc($t['zone_id']) : '' ?>
      </td>
      <td><?= $map[$t['game']] ?? '-' ?></td>
      <td><?= esc($t['quantity']) ?></td>
      <td>Rp <?= number_format($t['subtotal'], 0, ',', '.') ?></td>
      <td>
        <?= esc($t['bank']) ?: '-' ?>
      </td>
    </tr>
    <?php $lastTransactionId = $t['transaction_id']; ?>
  <?php endforeach; ?>
  </tbody>
</table>
