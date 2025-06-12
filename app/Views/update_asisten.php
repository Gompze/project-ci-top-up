<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Asisten Form</title>
</head>
<body>
     <h1>Update Asisten Form</h1>
    <form action="/updateAsisten" method="post">
        <label for="nim">NIM:</label>
        <input type="text" name="nim" id="nim"><br>
        <label for="nama">NAMA:</label>
        <input type="text" name="nama" id="nama"><br>
        <label for="praktikum">Praktikum</label>
        <input type="text" name="praktikum" id="praktikum"><br>
        <label for="ipk">Ipk</label>
        <input type="text" name="ipk" id="ipk">
        <input type="submit" value="Update">
    </form>
</body>
</html>