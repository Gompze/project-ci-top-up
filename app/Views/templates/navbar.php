<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="<?= base_url() ?>">TopUp Diamond</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navBarContent" aria-controls="navBarContent"
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navBarContent">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link position-relative" href="<?= base_url('cart') ?>">
            <i class="fa fa-shopping-cart"></i>
            <?php if (session()->get('cart_count') > 0): ?>
              <span class="badge bg-danger position-absolute"
                    style="top:0; right:0; font-size:.7rem;">
                <?= session()->get('cart_count') ?>
              </span>
            <?php endif; ?>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
