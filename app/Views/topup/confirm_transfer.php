<!-- app/Views/topup/confirm_transfer.php -->

<div class="row justify-content-center mt-5">
  <div class="col-md-6">
    <div class="card bg-dark text-white rounded">
      <div class="card-body">
        <h3 class="card-title mb-3" style="color: #FF0066;">Konfirmasi Transfer</h3>

        <p>
          Silakan transfer sejumlah 
          <strong>Rp <?= number_format($amount, 0, ',', '.') ?></strong>
          ke rekening berikut:
        </p>

        <?php if ($account): ?>
          <ul class="list-unstyled ms-3">
            <li>
              <strong><?= esc($bank) ?>:</strong>
              <?= esc($account) ?>
            </li>
          </ul>
        <?php else: ?>
          <p class="text-warning">
            Metode pembayaran tidak dikenali. Silakan kembali dan pilih kembali bank.
          </p>
        <?php endif; ?>

        <p class="mt-4">
        </p>
        <form action="/transactions/create" method="post">
          <button type="submit" class="btn btn-primary">Lanjut!</button>
        </form>
      </div>
    </div>
  </div>
</div>
