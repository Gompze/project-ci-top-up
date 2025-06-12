<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran</title>
</head>
<body>
    <h1>PENDAFTARAN ASISTEN PRAKTIKUM</h1>
    <form action="/asisten/simpan" method="post">
        <?= csrf_field() ?>
        NIM:<input type="text" name="nim" /><br />
        NAMA:<input type="text" name="nama" /><br />
        PRAKTIKUM:<input type="text" name="praktikum" /><br />
        IPK:<input type="text" name="ipk" /><br />
        <input type="submit" name="" value="Simpan">
    </form>
</body>
</html>