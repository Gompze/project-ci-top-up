<!-- app/Views/templates/header.php -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Top Up Diamond</title>
  
  <!-- Bootstrap 5 CSS (letakkan file di public/css atau gunakan CDN) -->
  <link
    href="<?= base_url('css/bootstrap.min.css') ?>"
    rel="stylesheet"
  >
  <!-- (Opsional) file CSS kustom Anda -->
  <link
    href="<?= base_url('css/style.css') ?>"
    rel="stylesheet"
  >
  <!-- Google Fonts (contoh: Montserrat) -->
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap"
    rel="stylesheet"
  >
  <link
  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css"
  rel="stylesheet"
/>
  <style>
    /* Jika ingin inline CSS kustom ringkas, bisa letakkan di sini,
       atau simpan di public/css/style.css dan load di atas. */
    body {
      font-family: 'Montserrat', sans-serif;
      background-color: #1A0E3A;
      color: #fff;
    }
    /* … lainnya (bisa sesuai kode CSS yang sudah ada di contoh purchase.html) … */
  </style>
</head>
<body>
  <div class="container py-5">
