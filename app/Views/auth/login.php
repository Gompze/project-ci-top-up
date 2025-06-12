<!-- app/Views/auth/login.php -->
<div class="row justify-content-center">
  <div class="col-md-6">
    <h3 class="mb-4 text-white">Login</h3>

    <!-- Tampilkan pesan error jika ada -->
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('login') ?>" method="post">
      <?= csrf_field() ?>

      <div class="form-group mb-2">
        <label for="username" class="text-white">Username</label>
        <input
          type="text"
          name="username"
          id="username"
          class="form-control"
          value="<?= old('username') ?>"
          placeholder="Masukkan username"
        >
        <?php if (isset($validation) && $validation->hasError('username')): ?>
          <small class="text-danger"><?= $validation->getError('username') ?></small>
        <?php endif; ?>
      </div>

      <div class="form-group mb-3">
        <label for="password" class="text-white">Password</label>
        <input
          type="password"
          name="password"
          id="password"
          class="form-control"
          placeholder="Masukkan password"
        >
        <?php if (isset($validation) && $validation->hasError('password')): ?>
          <small class="text-danger"><?= $validation->getError('password') ?></small>
        <?php endif; ?>
      </div>

      <div class="d-flex align-items-center">
        <button type="submit" class="btn btn-primary me-3">Login</button>
        <a href="<?= base_url('register') ?>" class="text-white">
          Belum punya akun? <u>Daftar</u>
        </a>
      </div>
    </form>
  </div>
</div>
