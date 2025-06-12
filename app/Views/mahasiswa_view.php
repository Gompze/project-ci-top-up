<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?= $judul ?></h1>
    <table>
        <tr>
            <td>NIM</td>
            <td>Nama</td>
</tr>
<?php if(!empty($daftarMhs) && is_array($daftarMhs)): ?>
    <?php foreach($daftarMhs as $mhs): ?>
        <tr>
            <td><?= esc($mhs['nim']) ?></td>
            <td><?= esc($mhs['nama']) ?></td>
        </tr>
    <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="2">Kosong</td>
        </tr>
        <?php endif ?>
    </table>
</body>
</html>