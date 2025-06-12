<!DOCTYPE html>
<html>
<head>
    <title>Rumah Sakit Sehat Sejahtera</title>
    <style>
        .container { width: 800px; margin: 0 auto; }
        .form-group { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; padding: 5px; }
        th { background: #ddd; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Rumah Sakit Sehat Sejahtera</h2>
        <h3>Pendaftaran Pasien</h3>

        <form action="/pasien/simpan" method="post">
            <div class="form-group">
                <label>No. Rekam Medis:</label>
                <input type="text" name="no_rm" required>
            </div>

            <div class="form-group">
                <label>Nama Pasien:</label>
                <input type="text" name="nama" required>
            </div>

            <div class="form-group">
                <label>Jenis Pasien:</label>
                <input type="radio" name="jenis" value="BPJS" required> BPJS
                <input type="radio" name="jenis" value="Non BPJS"> Non BPJS
            </div>

            <div class="form-group">
                <label>Dokter:</label>
                <select name="dokter" required>
                    <option value="">Pilih Dokter</option>
                    <option value="Umum">Umum</option>
                    <option value="Gigi">Gigi</option>
                    <option value="Penyakit Dalam">Penyakit Dalam</option>
                    <option value="Kulit dan Kelamin">Kulit dan Kelamin</option>
                    <option value="Jantung">Jantung</option>
                    <option value="Kandungan">Kandungan</option>
                </select>
            </div>

            <button type="submit">Simpan</button>
        </form>

        <h3>Daftar Pasien</h3>
        <table>
            <thead>
                <tr>
                    <th>No. RM</th>
                    <th>Nama Pasien</th>
                    <th>Jenis</th>
                    <th>Dokter</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <?php foreach($pasien as $p): ?>
    <tr>
        <td><?= $p['no_rm'] ?></td>
        <td><?= $p['nama'] ?></td>
        <td><?= $p['jenis'] ?></td>
        <td><?= $p['dokter'] ?></td>
        <td>
            <a href="/pasien/hapus/<?= $p['id'] ?>" > Hapus</a>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
        </table>
    </div>
</body>
</html>