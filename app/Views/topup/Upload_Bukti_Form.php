<!-- app/Views/topup/upload_bukti_form.php -->

<div class="row justify-content-center mt-5">
  <div class="col-md-6">
    <div class="card bg-dark text-white border-0">
      <div class="card-body">
        <h3 class="card-title mb-4" style="color: #FF0066;">Upload Bukti Transfer</h3>

        <!-- Tampilkan pesan error jika ada -->
        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
          </div>
        <?php endif; ?>

        <!-- Tampilkan pesan sukses jika ada -->
        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
          </div>
        <?php endif; ?>

        <!-- Form upload (multipart/form-data) -->
        <?= form_open_multipart('topup/upload-bukti/process') ?>
          <div class="mb-3">
            <label for="buktiTransfer" class="form-label">Pilih File Bukti Transfer (JPG, PNG, PDF)</label>
            <input type="file" name="bukti_transfer" id="buktiTransfer" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-lg btn-success">Upload Bukti</button>
        <?= form_close() ?>
      </div>
    </div>
  </div>
</div>
