// public/js/script.js

// Data Paket Diamond per game
const diamondData = {
  'Mobile Legends': [
    { amount: 12, price: 3688 },
    { amount: 28, price: 8436 },
    { amount: 45, price: 11436 },
    { amount: 92, price: 22872 }
  ],
  'PUBG Mobile': [
    { amount: 60, price: 15000 },
    { amount: 125, price: 30000 },
    { amount: 255, price: 60000 },
    { amount: 505, price: 118000 }
  ],
  'Valorant': [
    { amount: 420, price: 60000 },
    { amount: 840, price: 115000 },
    { amount: 1060, price: 147000 }
  ],
  'Free Fire': [
    { amount: 50, price: 9000 },
    { amount: 140, price: 25000 },
    { amount: 355, price: 60000 },
    { amount: 715, price: 120000 }
  ]
};

// Pasang event listener ketika DOM sudah siap
document.addEventListener('DOMContentLoaded', function() {
  // 1. Saat klik kartu game
  document.querySelectorAll('.game-card').forEach(card => {
    card.addEventListener('click', function() {
      // Hilangkan active dari semua, beri ke yang ini
      document.querySelectorAll('.game-card').forEach(c => c.classList.remove('active'));
      this.classList.add('active');

      // Ambil nama game dan tampilkan di judul form
      const game = this.getAttribute('data-game');
      document.getElementById('selected-game').textContent = game;

      // Tampilkan form pembelian
      document.querySelector('.purchase-form').style.display = 'block';

      // Generate pilihan diamond
      generateDiamondOptions(game);

      // Reset input email & metode pembayaran
      document.getElementById('emailInput').value = '';
      document.querySelectorAll('.payment-method').forEach(pm => pm.classList.remove('active'));
    });
  });

  // 2. Saat klik metode pembayaran
  document.querySelectorAll('.payment-method').forEach(pm => {
    pm.addEventListener('click', function() {
      document.querySelectorAll('.payment-method').forEach(el => el.classList.remove('active'));
      this.classList.add('active');
    });
  });

  // 3. Saat klik tombol Bayar Sekarang
  document.getElementById('btn-submit').addEventListener('click', function(e) {
    e.preventDefault();

    const selectedGame = document.getElementById('selected-game').textContent;
    const userId = document.getElementById('userIdInput').value.trim();
    const zoneId = document.getElementById('zoneIdInput').value.trim();
    const email = document.getElementById('emailInput').value.trim();

    const chosenDiamondBox = document.querySelector('.price-option.active');
    const chosenPayment = document.querySelector('.payment-method.active');

    // Validasi
    if (!userId) {
      alert('Silakan isi User ID terlebih dahulu.');
      return;
    }
    if (!chosenDiamondBox) {
      alert('Silakan pilih paket Diamond.');
      return;
    }
    if (!chosenPayment) {
      alert('Silakan pilih metode transfer bank.');
      return;
    }
    if (!email || !validateEmail(email)) {
      alert('Silakan masukkan email yang valid.');
      return;
    }

    // Ambil detail
    const diamondAmount = chosenDiamondBox.getAttribute('data-amount');
    const diamondPrice  = chosenDiamondBox.getAttribute('data-price');
    const bankName      = chosenPayment.getAttribute('data-method');

    console.log({
      game: selectedGame,
      userId: userId,
      zoneId: zoneId,
      diamond: diamondAmount,
      price: diamondPrice,
      paymentMethod: bankName,
      email: email
    });

    alert(
      `Detail Pembelian:\n\n` +
      `Game    : ${selectedGame}\n` +
      `User ID / Zone: ${userId}${zoneId ? ' / ' + zoneId : ''}\n` +
      `Diamond : ${diamondAmount}\n` +
      `Harga   : Rp ${formatRupiah(diamondPrice)}\n` +
      `Bank    : ${bankName}\n` +
      `Email   : ${email}\n\n` +
      `Silakan lanjutkan ke halaman konfirmasi transfer.`
    );

    // TODO: Submit ke backend (misalnya via fetch/AJAX)
  });
});

// Fungsi untuk generate kotak pilihan diamond
function generateDiamondOptions(game) {
  const container = document.getElementById('diamond-options');
  container.innerHTML = '';

  diamondData[game].forEach(item => {
    const col = document.createElement('div');
    col.classList.add('col-6','col-md-4','col-lg-3');

    const box = document.createElement('div');
    box.classList.add('price-option','p-3','text-center');
    box.setAttribute('data-amount', item.amount);
    box.setAttribute('data-price', item.price);

    const title = document.createElement('div');
    title.classList.add('price-title');
    title.textContent = item.amount + ' Diamonds';

    const price = document.createElement('div');
    price.classList.add('price-value');
    price.textContent = 'Rp ' + formatRupiah(item.price);

    box.appendChild(title);
    box.appendChild(price);
    col.appendChild(box);
    container.appendChild(col);

    // Event listener untuk setiap box diamond
    box.addEventListener('click', function() {
      document.querySelectorAll('.price-option').forEach(po => po.classList.remove('active'));
      this.classList.add('active');
    });
  });
}

// Fungsi format angka ke Rupiah (tanpa 'Rp')
function formatRupiah(angka) {
  return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

// Fungsi validasi email sederhana
function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}
