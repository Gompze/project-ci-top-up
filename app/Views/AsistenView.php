<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($judul) ?></title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #444; padding: 4px 8px; text-align: left; }
        th { background: #ddd; }
    </style>
</head>
<body>
    <h1><?= esc($judul) ?></h1>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Kelas Praktikum</th>
                <th>IPK</th>
            </tr>
        </thead>
        <tbody>
        <?php if (! empty($asisten) && is_array($asisten)): ?>
            <?php $no = 1; ?>
            <?php foreach ($asisten as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($row['NIM']) ?></td>
                    <td><?= esc($row['NAMA']) ?></td>
                    <td><?= esc($row['PRAKTIKUM']) ?></td>
                    <td><?= esc($row['IPK']) ?></td>
                </tr>
            <?php endforeach ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Data masih kosong.</td>
            </tr>
        <?php endif ?>
        </tbody>
    </table>
</body>
</html>
