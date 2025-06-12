<!-- app/Views/topup/purchase.php -->

<div class="text-center mb-5">
  <h1 class="fw-bold" style="color:#FF0066;">Top Up Diamond</h1>
  <p>Pilih Game, Pilih Paket & Metode Pembayaran</p>
</div>

<form id="purchaseForm" action="<?= base_url('topup/processPurchase') ?>" method="post">
  <?= csrf_field() ?>

  <!-- 1. Pilih Game -->
  <div class="row g-4 justify-content-center">
    <?php 
      $games = [
        ['name'=>'Mobile Legends','logo'=>'https://play-lh.googleusercontent.com/QXCVbZd0d71ho4MIYHHxnY6BJFGXI-fzRS5MXJXU1n4n2T-VdQgB1vrdJpydokA34UA'],
        ['name'=>'PUBG Mobile','logo'=>'https://i.namu.wiki/i/QN3f9O-XMyCmUUHzphCAYOtOhNFOlbWleXP_d14o64fNZPRZ0UbNDqMKueyGWK1ug5ZNvdvNqtUkBZGlhW0qpg.jpg'],
        ['name'=>'Valorant','logo'=>'https://logos-download.com/wp-content/uploads/2021/01/Valorant_Logo.png'],
        ['name'=>'Free Fire','logo'=>'https://play-lh.googleusercontent.com/sKh_B4ZLfu0jzqx9z98b2APe2rxDb8dIW-QqFHyS3cpzDK2Qq8tAbRAz3rXzOFtdAw=w240-h480-rw'],
      ];
      foreach($games as $g): 
    ?>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
      <div class="card game-card" data-game="<?= $g['name'] ?>">
        <img src="<?= $g['logo'] ?>" alt="<?= $g['name'] ?>" class="card-img-top">
        <div class="card-body"><div class="card-title"><?= $g['name'] ?></div></div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- 2. Form Pembelian -->
  <div class="purchase-form mt-5" style="display:none; background-color:#2A195B; padding:20px; border-radius:8px;">
    <h4>Pembelian <span id="unitLabel">Diamonds</span> untuk: <span class="fw-bold" id="selected-game">–</span></h4>

    <div class="mb-4" id="userZoneGroup">
      <label id="userLabel" class="form-label">1. Masukkan User ID / ID Karakter</label>
      <div class="row gx-2">
        <div class="col"><input type="text" id="userIdInput" class="form-control" placeholder="User ID"></div>
        <div class="col" id="zoneCol"><input type="text" id="zoneIdInput" class="form-control" placeholder="Zone ID (Jika Perlu)"></div>
      </div>
    </div>

    <div class="mb-4">
      <label class="form-label">2. Pilih Paket</label>
      <div class="row g-3" id="diamond-options"></div>
    </div>

    <div class="mb-4">
      <label class="form-label">3. Pilih Metode Pembayaran</label>
      <div class="d-flex flex-wrap g-3" id="payment-methods">
        <?php 
          $banks = [
            ['code'=>'BCA','logo'=>'https://buatlogoonline.com/wp-content/uploads/2022/10/Logo-Bank-BCA-1.png'],
            ['code'=>'Mandiri','logo'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRMXAvyfQ1jaXQUTVdm5w2JGnfQcJLW1hHmkw&s'],
            ['code'=>'BNI','logo'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShne_g0DhrXLV1yNO6k48XQuzfkn6QNtQcOg&s'],
            ['code'=>'BRI','logo'=>'https://seeklogo.com/images/B/bank-bri-logo-32EFAA879E-seeklogo.com.png'],
          ];
          foreach($banks as $b):
        ?>
        <div class="payment-method p-2 d-flex align-items-center" data-method="<?= $b['code'] ?>">
          <img src="<?= $b['logo'] ?>" alt="<?= $b['code'] ?>" width="40">
          <span class="ms-2"><?= $b['code'] ?></span>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="mb-4">
      <label class="form-label">4. Masukkan Email Anda</label>
      <input type="email" id="emailInput" class="form-control" placeholder="contoh@domain.com">
    </div>

    <!-- Hidden Inputs -->
    <input type="hidden" name="selected_game" id="hiddenSelectedGame">
    <input type="hidden" name="zone_id"       id="hiddenZoneId">
    <input type="hidden" name="diamond_amount" id="hiddenDiamondAmount">
    <input type="hidden" name="diamond_price"  id="hiddenDiamondPrice">
    <input type="hidden" name="payment_method" id="hiddenPaymentMethod">
    <input type="hidden" name="email"          id="hiddenEmail">

    <div class="text-center">
      <button type="submit" class="btn btn-lg text-white" style="background-color:#FF0066;">
        Bayar Sekarang
      </button>
    </div>
  </div>
</form>

<!-- Tombol Riwayat di Bawah -->
<div class="mt-5 px-3">
  <div class="d-flex justify-content-end">
    <a href="<?= base_url('transactions') ?>" class="btn btn-outline-light">
      Lihat Riwayat Transaksi
    </a>
  </div>
</div>

<script>
// Data paket
const diamondData = {
  'Mobile Legends': [ {amount:12,price:3688}, {amount:28,price:8436}, {amount:45,price:11436}, {amount:92,price:22872} ],
  'PUBG Mobile':   [ {amount:60,price:15000}, {amount:125,price:30000}, {amount:255,price:60000}, {amount:505,price:118000} ],
  'Valorant':      [ {amount:420,price:60000}, {amount:840,price:115000}, {amount:1060,price:147000} ],
  'Free Fire':     [ {amount:50,price:9000}, {amount:140,price:25000}, {amount:355,price:60000}, {amount:715,price:120000} ]
};
// Satuan
const unitPerGame = { 'Mobile Legends':'Diamonds', 'Free Fire':'Diamonds', 'PUBG Mobile':'UC', 'Valorant':'VP' };
// Icon di atas paket
const iconPerGame = {
  'Mobile Legends': 'https://emofly.b-cdn.net/hbd_exvhac6ayb3ZKT/width:1080/plain/https://storage.googleapis.com/takeapp/media/clwh3tmic00040cl5fmk1fpqq.png',
  'PUBG Mobile':    'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSYhMTvz6kJ_8ow-sabIIKSQZHgJMoIcKBakA&s',
  'Valorant':       'https://cdn1.codashop.com/images/420_cb24d54b-97d5-48fe-a3d3-11d91371141d_b2a1734a945f6ba573385051a922d8b3_image/95ca0bd6c1e3b6589e63a173dede3ebf.png',
  'Free Fire':      'https://i.pinimg.com/474x/f0/bb/4a/f0bb4a3107e285557f8764c0eb546e67.jpg'
};

document.addEventListener('DOMContentLoaded', () => {
  let lastCard = null;
  const formWrapper  = document.querySelector('.purchase-form');
  const selectedEl   = document.getElementById('selected-game');
  const unitLabel    = document.getElementById('unitLabel');
  const userLabel    = document.getElementById('userLabel');
  const userInput    = document.getElementById('userIdInput');
  const zoneCol      = document.getElementById('zoneCol');
  const emailInput   = document.getElementById('emailInput');
  const hGame        = document.getElementById('hiddenSelectedGame');
  const hZone        = document.getElementById('hiddenZoneId');
  const hAmount      = document.getElementById('hiddenDiamondAmount');
  const hPrice       = document.getElementById('hiddenDiamondPrice');
  const hPayment     = document.getElementById('hiddenPaymentMethod');
  const hEmail       = document.getElementById('hiddenEmail');
  const form         = document.getElementById('purchaseForm');

  document.querySelectorAll('.game-card').forEach(card => {
    card.addEventListener('click', () => {
      // Toggle form pada klik ulang
      if (lastCard === card) {
        card.classList.remove('active');
        formWrapper.style.display = 'none';
        lastCard = null;
        return;
      }
      // Klik game baru
      if (lastCard) lastCard.classList.remove('active');
      card.classList.add('active');
      lastCard = card;
      formWrapper.style.display = 'block';

      const game = card.dataset.game;
      selectedEl.textContent = game;
      hGame.value = game;
      unitLabel.textContent = unitPerGame[game] || 'Diamonds';

      // Dinamis label ID / Zone
      if (game === 'Mobile Legends') {
        userLabel.textContent = '1. Masukkan User ID / Zone ID';
        zoneCol.style.display = 'block';
      } else if (game === 'PUBG Mobile') {
        userLabel.textContent = '1. Masukkan User ID';
        zoneCol.style.display = 'none';
      } else if (game === 'Valorant') {
        userLabel.textContent = '1. Masukkan Riot ID';
        zoneCol.style.display = 'none';
      } else { // Free Fire
        userLabel.textContent = '1. Masukkan Player ID';
        zoneCol.style.display = 'none';
      }

      emailInput.value = '';
      document.querySelectorAll('.payment-method').forEach(pm => pm.classList.remove('active'));
      generateDiamondOptions(game);
    });
  });

  function generateDiamondOptions(game) {
    const container = document.getElementById('diamond-options');
    container.innerHTML = '';
    const unit = unitPerGame[game] || 'Diamonds';
    const icon = iconPerGame[game];

    diamondData[game].forEach(item => {
      const col = document.createElement('div');
      col.className = 'col-6 col-md-4 col-lg-3';

      const box = document.createElement('div');
      box.className = 'price-option p-3 text-center';
      box.dataset.amount = item.amount;
      box.dataset.price  = item.price;

      // Tambahkan icon
      if (icon) {
        const img = document.createElement('img');
        img.src = icon;
        img.alt = unit;
        img.style.width = '40px';
        img.style.marginBottom = '8px';
        box.appendChild(img);
      }

      const title = document.createElement('div');
      title.className = 'price-title';
      title.textContent = `${item.amount} ${unit}`; 
      box.appendChild(title);

      const price = document.createElement('div');
      price.className = 'price-value';
      price.textContent = 'Rp ' + formatRupiah(item.price);
      box.appendChild(price);

      col.appendChild(box);
      container.appendChild(col);

      box.addEventListener('click', () => {
        document.querySelectorAll('.price-option').forEach(po => po.classList.remove('active'));
        box.classList.add('active');
      });
    });
  }

  document.querySelectorAll('.payment-method').forEach(pm => {
    pm.addEventListener('click', () => {
      document.querySelectorAll('.payment-method').forEach(el => el.classList.remove('active'));
      pm.classList.add('active');
    });
  });

  form.addEventListener('submit', e => {
    const game      = selectedEl.textContent.trim();
    const userId    = userInput.value.trim();
    const zoneVal   = zoneCol.style.display === 'block'
                      ? document.getElementById('zoneIdInput').value.trim()
                      : '';
    const email     = emailInput.value.trim();
    const chosen    = document.querySelector('.price-option.active');
    const chosenBank= document.querySelector('.payment-method.active');

    if (!game || game==='–') {
      alert('Pilih game.');
      e.preventDefault();
      return;
    }
    if (!userId) {
      alert('Isi '+ userLabel.textContent.replace('1. ','') +'.');
      e.preventDefault();
      return;
    }
    if (!chosen) {
      alert('Pilih paket.');
      e.preventDefault();
      return;
    }
    if (!chosenBank) {
      alert('Pilih metode bank.');
      e.preventDefault();
      return;
    }
    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      alert('Email tidak valid.');
      e.preventDefault();
      return;
    }

    hZone.value    = zoneVal;
    hAmount.value  = chosen.dataset.amount;
    hPrice.value   = chosen.dataset.price;
    hPayment.value = chosenBank.dataset.method;
    hEmail.value   = email;
  });

  function formatRupiah(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  }
});
</script>
