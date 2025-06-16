<div class="text-center mb-5">
  <h1 class="fw-bold" style="color:#FF0066;">PayStore</h1>
  <p>Pilih Game, Pilih Paket & Metode Pembayaran</p>
</div>

<form id="purchaseForm" action="<?= base_url('cart/add') ?>" method="post">
  <?= csrf_field() ?>

  <div class="row g-4 justify-content-center">
    <?php 
      $games = [
        ['name'=>'Mobile Legends','logo'=>'https://play-lh.googleusercontent.com/QXCVbZd0d71ho4MIYHHxnY6BJFGXI-fzRS5MXJXU1n4n2T-VdQgB1vrdJpydokA34UA'],
        ['name'=>'PUBG Mobile','logo'=>'https://i.namu.wiki/i/QN3f9O-XMyCmUUHzphCAYOtOhNFOlbWleXP_d14o64fNZPRZ0UbNDqMKueyGWK1ug5ZNvdvNqtUkBZGlhW0qpg.jpg'],
        ['name'=>'Valorant','logo'=>'https://i.pinimg.com/474x/a4/00/33/a400333f7c9137ad1ebb9ded69755c48.jpg'],
        ['name'=>'Free Fire','logo'=>'https://play-lh.googleusercontent.com/sKh_B4ZLfu0jzqx9z98b2APe2rxDb8dIW-QqFHyS3cpzDK2Qq8tAbRAz3rXzOFtdAw=w240-h480-rw'],
      ];
      foreach($games as $g): 
    ?>
      <div class="col-6 col-sm-4 col-md-3 col-lg-2">
        <div class="card game-card border-0" data-game="<?= esc($g['name']) ?>" style="cursor:pointer">
          <img src="<?= esc($g['logo']) ?>" class="card-img-top" alt="">
          <div class="card-body text-center">
            <div class="card-title"><?= esc($g['name']) ?></div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="purchase-form mt-5 p-4" style="display:none; background:#2A195B; border-radius:8px;">
    <h4>Pembelian <span id="unitLabel">Diamonds</span> untuk: 
      <span class="fw-bold" id="selected-game">–</span>
    </h4>

    <div class="mb-3" id="userZoneGroup">
      <label id="userLabel" class="form-label">1. Masukkan User ID</label>
      <div class="row gx-2">
        <div class="col"><input type="text" id="userIdInput" class="form-control" placeholder="User ID"></div>
        <div class="col" id="zoneCol" style="display:none">
          <input type="text" id="zoneIdInput" class="form-control" placeholder="Zone ID (Jika Perlu)">
        </div>
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">2. Pilih Paket</label>
      <div class="row g-3" id="diamond-options"></div>
    </div>

    <div class="mb-3">
      <label class="form-label">3. Pilih Metode Pembayaran</label>
      <div class="d-flex flex-wrap g-3" id="payment-methods">
        <?php 
          $banks = [
            ['code'=>'BCA',     'logo'=>'https://buatlogoonline.com/wp-content/uploads/2022/10/Logo-Bank-BCA-1.png'],
            ['code'=>'Mandiri', 'logo'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRMXAvyfQ1jaXQUTVdm5w2JGnfQcJLW1hHmkw&s'],
            ['code'=>'BNI',     'logo'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShne_g0DhrXLV1yNO6k48XQuzfkn6QNtQcOg&s'],
            ['code'=>'BRI',     'logo'=>'https://seeklogo.com/images/B/bank-bri-logo-32EFAA879E-seeklogo.com.png'],
          ];
          foreach($banks as $b): 
        ?>
          <div class="payment-method border rounded p-2 d-flex align-items-center"
               data-method="<?= esc($b['code']) ?>" style="cursor:pointer">
            <img src="<?= esc($b['logo']) ?>" width="40" alt="">
            <span class="ms-2 text-white"><?= esc($b['code']) ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">4. Masukkan Email Anda</label>
      <input type="email" id="emailInput" class="form-control" placeholder="contoh@domain.com">
    </div>

    <input type="hidden" name="item_name" value="UC">
    <input type="hidden" name="game"             id="hiddenGame">
    <input type="hidden" name="zone_id"          id="hiddenZoneId">
    <input type="hidden" name="diamond_amount"   id="hiddenAmount">
    <input type="hidden" name="diamond_price"    id="hiddenPrice">
    <input type="hidden" name="payment_method"   id="hiddenPayment">
    <input type="hidden" name="email"            id="hiddenEmail">
    <input type="hidden" name="quantity"         value="1">

    <div class="text-center">
      <button id="btnAddToCart" type="button" class="btn btn-lg btn-outline-light">
        Tambahkan ke Keranjang
      </button>
    </div>
  </div>
</form>

<script>
const diamondData = {
  'Mobile Legends': [ {amount:12, price:3688}, {amount:28, price:8436}, {amount:45, price:11436}, {amount:92, price:22872} ],
  'PUBG Mobile':    [ {amount:60, price:15000}, {amount:125, price:30000}, {amount:255, price:60000}, {amount:505, price:118000} ],
  'Valorant':       [ {amount:420, price:60000}, {amount:840, price:115000}, {amount:1060, price:147000} ],
  'Free Fire':      [ {amount:50, price:9000}, {amount:140, price:25000}, {amount:355, price:60000}, {amount:715, price:120000} ],
};

const unitPerGame = {
  'Mobile Legends':'Diamonds',
  'PUBG Mobile':'UC',
  'Valorant':'VP',
  'Free Fire':'Diamonds'
};

document.addEventListener('DOMContentLoaded', () => {
  let lastCard = null;
  const cards    = document.querySelectorAll('.game-card');
  const formWrap = document.querySelector('.purchase-form');
  const selGame  = document.getElementById('selected-game');
  const unitLbl  = document.getElementById('unitLabel');
  const userLbl  = document.getElementById('userLabel');
  const zoneCol  = document.getElementById('zoneCol');
  const userIn   = document.getElementById('userIdInput');
  const zoneIn   = document.getElementById('zoneIdInput');
  const emailIn  = document.getElementById('emailInput');
  const payMods  = document.querySelectorAll('.payment-method');
  const optDiv   = document.getElementById('diamond-options');

  const hGame    = document.getElementById('hiddenGame');
  const hZone    = document.getElementById('hiddenZoneId');
  const hAmt     = document.getElementById('hiddenAmount');
  const hPrice   = document.getElementById('hiddenPrice');
  const hPay     = document.getElementById('hiddenPayment');
  const hEmail   = document.getElementById('hiddenEmail');
  const btn      = document.getElementById('btnAddToCart');

  const iconLinks = {
    'Mobile Legends': 'https://play-lh.googleusercontent.com/W2No_0FwCtgq_ToxyzqxBy6ae7ygGUI4SR45_b_B0ModrvqpSIMcDYTLeziZynxQ6Q',
    'PUBG Mobile':    'https://media.sketchfab.com/models/1f3b20840ecd47e4b922bce557348a9f/thumbnails/5ce683c255fb415ab435b1af185903d0/a372896730dd4c4d89be88303a19486f.jpeg',
    'Valorant':       'https://cdn1.codashop.com/images/420_cb24d54b-97d5-48fe-a3d3-11d91371141d_b2a1734a945f6ba573385051a922d8b3_image/95ca0bd6c1e3b6589e63a173dede3ebf.png',
    'Free Fire':      'https://i.pinimg.com/564x/cf/06/0d/cf060dabb8abc5d73e03eb5cb9dfcd96.jpg'
  };

  cards.forEach(card => card.addEventListener('click', () => {
    if (lastCard === card) {
      lastCard.classList.remove('border','border-2','border-primary');
      formWrap.style.display='none'; lastCard=null; return;
    }
    if (lastCard) lastCard.classList.remove('border','border-2','border-primary');
    card.classList.add('border','border-2','border-primary');
    lastCard = card; formWrap.style.display = 'block';

    const game = card.dataset.game;
    selGame.textContent = game;
    unitLbl.textContent = unitPerGame[game];
    hGame.value = game;

    if (game === 'Mobile Legends') {
      userLbl.textContent = '1. Masukkan User ID / Zone ID';
      zoneCol.style.display = 'block';
    } else {
      userLbl.textContent = game === 'Valorant' ? '1. Masukkan Riot ID' : '1. Masukkan User ID';
      zoneCol.style.display = 'none'; zoneIn.value = '';
    }

    emailIn.value = '';
    payMods.forEach(pm => pm.classList.remove('border','border-2','border-primary'));
    optDiv.innerHTML = '';

    diamondData[game].forEach(item => {
      const col = document.createElement('div');
      col.className = 'col-6 col-md-4 col-lg-3';

      const box = document.createElement('div');
      box.className = 'price-option p-3 text-center border rounded';

      const img = document.createElement('img');
      img.src = iconLinks[game];
      img.alt = unitPerGame[game];
      img.style.width = '40px';
      img.classList.add('mb-2');

      const text = document.createElement('div');
      text.textContent = `${item.amount} ${unitPerGame[game]} — Rp ${item.price.toLocaleString('id')}`;

      box.dataset.amount = item.amount;
      box.dataset.price = item.price;
      box.appendChild(img);
      box.appendChild(text);

      box.addEventListener('click', () => {
        optDiv.querySelectorAll('.price-option')
              .forEach(x => x.classList.remove('bg-primary','text-white'));
        box.classList.add('bg-primary','text-white');
      });

      col.appendChild(box);
      optDiv.appendChild(col);
    });
  }));

  payMods.forEach(pm => pm.addEventListener('click', () => {
    payMods.forEach(x => x.classList.remove('border','border-2','border-primary'));
    pm.classList.add('border','border-2','border-primary');
  }));

  btn.addEventListener('click', () => {
    const game  = selGame.textContent;
    const uid   = userIn.value.trim();
    const zid   = zoneCol.style.display === 'block' ? zoneIn.value.trim() : '';
    const pkg   = document.querySelector('.price-option.bg-primary');
    const pay   = document.querySelector('.payment-method.border-primary');
    const email = emailIn.value.trim();
    if (!game)   return alert('Pilih game.');
    if (!uid)    return alert('Isi ' + userLbl.textContent);
    if (!pkg)    return alert('Pilih paket.');
    if (!pay)    return alert('Pilih metode.');
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))
      return alert('Email tidak valid.');

    hZone.value  = zid;
    hAmt.value   = pkg.dataset.amount;
    hPrice.value = pkg.dataset.price;
    hPay.value   = pay.dataset.method;
    hEmail.value = email;

    document.getElementById('purchaseForm').submit();
  });
});
</script>
