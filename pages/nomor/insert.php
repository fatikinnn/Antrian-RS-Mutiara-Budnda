<?php
// Mengatasi CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, x-requested-with, Content-Type, Accept, Access-Control-Request-Method");
header('Access-Control-Allow-Methods: GET, POST');
header("Allow: GET, POST");
require ('cetak.php');
// pengecekan ajax request untuk mencegah direct access file, agar file tidak bisa diakses secara langsung dari browser
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    // panggil file "database.php" untuk koneksi ke database
    require_once "../../config/database.php";

    // ambil tanggal sekarang
    $tanggal = gmdate("Y-m-d", time() + 60 * 60 * 7);

    // membuat "no_antrian"
    $query = mysqli_query($mysqli, "SELECT max(no_antrian) as nomor FROM queue_antrian_admisi WHERE tanggal='$tanggal'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
    $rows = mysqli_num_rows($query);

    if ($rows <> 0) {
        $data = mysqli_fetch_assoc($query);
        $no_antrian = sprintf("%03s", (int)$data['nomor'] + 1);
    } else {
        $no_antrian = sprintf("%03s", 1);
    }

    // sql statement untuk insert data ke tabel "queue_antrian_admisi"
    $insert = mysqli_query($mysqli, "INSERT INTO queue_antrian_admisi(tanggal, no_antrian) VALUES('$tanggal', '$no_antrian')") or die('Ada kesalahan pada query insert : ' . mysqli_error($mysqli));

    if ($insert) {
        echo "Sukses";
        
        // Cetak antrian
        cetak($no_antrian);
    }
}

// function cetak($no_antrian) {
//     // Membuat konten HTML untuk cetak
//     $output = "
//     <!DOCTYPE html>
//     <html lang='id'>
//     <head>
//         <meta charset='UTF-8'>
//         <meta name='viewport' content='width=device-width, initial-scale=1.0'>
//         <title>Cetak Nomor Antrian</title>
//         <style>
//             body {
//                 font-family: Arial, sans-serif;
//                 margin: 0;
//                 padding: 0;
//                 width: 80mm; /* Lebar kertas untuk printer POS 80 mm */
//                 text-align: center; /* Semua teks akan berada di tengah */
//             }
//             h1 {
//                 font-size: 18px; /* Ukuran font untuk judul */
//                 margin: 0;
//             }
//             .content {
//                 margin-top: 10px;
//                 border: 1px solid #000; /* Border kotak */
//                 padding: 10px;
//                 box-shadow: 0 0 5px rgba(0,0,0,0.5); /* Bayangan untuk tampilan lebih menarik */
//             }
//             .nomor-antrian {
//                 font-size: 24px; /* Ukuran font untuk nomor antrian */
//                 font-weight: bold; /* Menebalkan nomor antrian */
//                 margin: 10px 0; /* Margin atas dan bawah */
//             }
//             p {
//                 margin: 5px 0; /* Margin untuk paragraf */
//             }
//             @media print {
//                 body {
//                     -webkit-print-color-adjust: exact; /* Memastikan warna cetak sesuai */
//                 }
//                 @page {
//                     margin: 0; /* Mengatur margin halaman menjadi 0 */
//                 }
//             }
//         </style>
//     </head>
//     <body>

//     <h1>RSUI Mutiara Bunda</h1>
//     <div class='content'>
//         <h2>NOMOR ANTRIAN</h2>
//         <p class='nomor-antrian'>" . htmlspecialchars($no_antrian) . "</p>
//         <p>Silakan menuju loket pendaftaran.</p>
//     </div>

//     <script>
//         window.print(); // Memanggil dialog cetak
//         window.onafterprint = function() {
//             window.close(); // Menutup jendela setelah cetak selesai
//         };
//     </script>

//     </body>
//     </html>";

//     // Menggunakan file sementara untuk menyimpan konten HTML
//     $filename = "antrian_$no_antrian.html"; // File HTML sementara
//     file_put_contents($filename, $output);

//     // Membuka file HTML di browser
//     exec("start $filename"); // Gunakan exec() untuk membuka file HTML di browser
// }


