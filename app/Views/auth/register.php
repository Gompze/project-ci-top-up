<div class="row justify-content-center">
  <div class="col-md-6">
    <h3>Register Akun</h3>
    <form action="<?= base_url('register') ?>" method="post">
      <?= csrf_field() ?>
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" class="form-control" value="<?= set_value('username') ?>">
        <?php if (isset($validation) && $validation->hasError('username')): ?>
          <small class="text-danger"><?= $validation->getError('username') ?></small>
        <?php endif; ?>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="<?= set_value('email') ?>">
        <?php if (isset($validation) && $validation->hasError('email')): ?>
          <small class="text-danger"><?= $validation->getError('email') ?></small>
        <?php endif; ?>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control">
        <?php if (isset($validation) && $validation->hasError('password')): ?>
          <small class="text-danger"><?= $validation->getError('password') ?></small>
        <?php endif; ?>
      </div>
      <div class="form-group">
        <label>Konfirmasi Password</label>
        <input type="password" name="pass_confirm" class="form-control">
        <?php if (isset($validation) && $validation->hasError('pass_confirm')): ?>
          <small class="text-danger"><?= $validation->getError('pass_confirm') ?></small>
        <?php endif; ?>
      </div>
      <button type="submit" class="btn btn-primary">Daftar</button>
    </form>
  </div>
</div>
