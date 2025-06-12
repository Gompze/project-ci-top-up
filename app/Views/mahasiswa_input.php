<!DOCTYPE html>
<html>
<head>
    <title>Input Mahasiswa</title>
</head>
<body>
    <form action="/submitMahasiswa" method="post">
        <?= csrf_field() ?>
        <label for="nim">NIM</label>
        <input type="text" name="nim" id="nim">
        <label for="nama">NAMA</label>
        <input type="text" name="nama" id="nama">
        <input type="submit" value="Simpan">
    </form>
</body>
</html>
