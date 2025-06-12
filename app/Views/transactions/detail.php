<h3>Detail Transaksi #<?= $transaction['id'] ?></h3>
<p>Tanggal: <?= date('d M Y H:i', strtotime($transaction['created_at'])) ?></p>
<p>Status: <?= ucfirst($transaction['status']) ?></p>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>Game</th>
      <th>Diamond</th>
      <th>Harga (pcs)</th>
      <th>Jumlah</th>
      <th>Subtotal</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($items as $item): ?>
      <tr>
        <td><?= esc($item['game']) ?></td>
        <td><?= esc($item['diamond']) ?></td>
        <td>Rp <?= number_format($item['price_each'],0,',','.') ?></td>
        <td><?= $item['quantity'] ?></td>
        <td>Rp <?= number_format($item['subtotal'],0,',','.') ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<div class="text-right">
  <h5>Total: <strong>Rp <?= number_format($transaction['total_price'],0,',','.') ?></strong></h5>
</div>
<a href="<?= base_url('transactions') ?>" class="btn btn-link">Kembali</a>
