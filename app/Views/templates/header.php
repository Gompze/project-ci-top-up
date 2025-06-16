
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TopUp Game</title>


  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-…"
    crossorigin="anonymous"
  >
 
  <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="<?= base_url('topup') ?>">TopUp Game</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#mainNav"
        aria-controls="mainNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav ms-auto align-items-center">
          <?php if (session()->get('isLoggedIn')): ?>

             <li class="nav-item me-3">
              <a class="nav-link" href="<?= base_url('transactions') ?>">
                Riwayat Transaksi
              </a>


            <li class="nav-item me-3">
              <a class="nav-link" href="<?= base_url('topup') ?>">
                Beranda
              </a>
            </li>
            <li class="nav-item me-3">
              <a class="nav-link" href="<?= base_url('cart') ?>">
                🛒 Keranjang
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url('logout') ?>">Logout</a>
            </li>
          <?php else: ?>
            
          <?php endif ?>
        </ul>
      </div>
    </div>
  </nav>

 
  <main class="flex-grow-1">
    <div class="container py-5">
