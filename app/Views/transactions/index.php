<!-- app/Views/transactions/index.php -->

<h2>Riwayat Transaksi</h2>

<!-- Link kembali ke Top-Up -->
<p class="mb-3">
  <a href="<?= base_url('topup') ?>" class="btn btn-outline-light">
    Ingin Top-Up Lagi?
  </a>
</p>

<?php if (empty($transactions)): ?>
  <p>Belum ada transaksi. <a href="<?= base_url('topup') ?>">Belanja Sekarang</a></p>
<?php else: ?>
  <table class="table table-dark table-striped mt-4">
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Game</th>
        <th>ID</th>
        <th>Satuan</th>
        <th>Jumlah</th>
        <th>Harga</th>
        <th>Bank</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($transactions as $t): ?>
      <tr>
        <td><?= date('Y-m-d H:i', strtotime($t['created_at'])) ?></td>
        <td><?= esc($t['game']) ?></td>
        <td>
          <?= esc($t['user_id']) ?>
          <?= $t['zone_id'] ? '/'.esc($t['zone_id']) : '' ?>
        </td>
        <td>
          <?php
            $map = [
              'Mobile Legends' => 'Diamonds',
              'Free Fire'      => 'Diamonds',
              'PUBG Mobile'    => 'UC',
              'Valorant'       => 'VP',
            ];
            echo $map[$t['game']] ?? '';
          ?>
        </td>
        <td><?= esc($t['diamond_amount']) ?></td>
        <td>Rp <?= number_format($t['total_price'], 0, ',', '.') ?></td>
        <td><?= esc($t['bank']) ?></td>
        <td><?= esc($t['status']) ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>
