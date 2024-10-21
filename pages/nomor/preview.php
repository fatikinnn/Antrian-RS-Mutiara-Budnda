<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Cetak</title>
</head>
<body>
    <h1>Preview Nomor Antrian</h1>
    
    <?php
    // Ambil nomor antrian dari form
    $no_antrian = $_POST['no_antrian'];
    $hariIni = new DateTime();
    ?>
    
    <div>
        <h2>RSUD BATIN MANGUNANG</h2>
        <p>Jl. Soekarno Hatta, Komplek Islamic Centre</p>
        <p>Kota Agung, Tanggamus</p>
        <hr>
        <h3>NOMOR ANTRIAN ANDA</h3>
        <h2><?php echo htmlspecialchars($no_antrian); ?></h2>
        <p>Silahkan menunggu nomor antrian dipanggil</p>
        <p>Nomor ini hanya berlaku pada hari dicetak</p>
        <p><?php echo hariIndo(date('l')) . " " . strftime('%d %B %Y', $hariIni->getTimestamp()); ?></p>
        <hr>
        <p>TERIMA KASIH, ANDA TELAH TERTIB</p>
    </div>
    
    <form action="cetak.php" method="POST">
        <input type="hidden" name="no_antrian" value="<?php echo htmlspecialchars($no_antrian); ?>">
        <button type="submit">Cetak</button>
    </form>
    <form action="input.php" method="GET">
        <button type="button" onclick="window.location.href='input.php'">Kembali</button>
    </form>
</body>
</html>

<?php
function hariIndo($hariInggris) {
    switch ($hariInggris) {
        case 'Sunday':
            return 'Minggu';
        case 'Monday':
            return 'Senin';
        case 'Tuesday':
            return 'Selasa';
        case 'Wednesday':
            return 'Rabu';
        case 'Thursday':
            return 'Kamis';
        case 'Friday':
            return 'Jumat';
        case 'Saturday':
            return 'Sabtu';
        default:
            return 'hari tidak valid';
    }
}
