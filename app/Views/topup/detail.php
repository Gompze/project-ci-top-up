<!-- app/Views/topup/detail.php -->
<div class="row justify-content-center mt-5">
  <div class="col-md-8">
    <div class="card bg-dark text-white border-0">
      <div class="card-body">
        <h3 class="card-title mb-4" style="color: #FF0066;">Detail Pembelian</h3>

        <p><strong>Game          :</strong> <?= esc($game) ?></p>
        <p><strong>User ID / Zone :</strong>
          <?= esc($user_id) ?>
          <?= ! empty($zone_id) ? ' / ' . esc($zone_id) : '' ?>
        </p>
        <p><strong>Diamond       :</strong> <?= esc($diamond_amount) ?></p>
        <p><strong>Harga         :</strong>
          Rp <?= number_format($diamond_price, 0, ',', '.') ?>
        </p>
        <p><strong>Bank          :</strong> <?= esc($payment_method) ?></p>
        <p><strong>Email         :</strong> <?= esc($email) ?></p>

        <hr class="border-secondary">

        <p class="mt-3">Silakan lanjutkan ke halaman konfirmasi transfer.</p>
        <a href="<?= base_url('topup/confirm-transfer') ?>" class="btn btn-lg btn-primary">
          Lanjut ke Konfirmasi Transfer
        </a>
      </div>
    </div>
  </div>
</div>
