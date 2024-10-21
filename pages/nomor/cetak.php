<?php
require __DIR__ . '/../../vendor/autoload.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\EscposImage;

function resizeImage($source, $destination, $maxWidth, $maxHeight) {
    list($width, $height) = getimagesize($source);
    $ratio = $width / $height;

    if ($maxWidth / $maxHeight > $ratio) {
        $maxWidth = $maxHeight * $ratio;
    } else {
        $maxHeight = $maxWidth / $ratio;
    }

    // Buat gambar baru dengan latar belakang transparan
    $newImage = imagecreatetruecolor($maxWidth, $maxHeight);
    // Mengatur transparansi
    $transparentColor = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
    imagefill($newImage, 0, 0, $transparentColor);
    imagealphablending($newImage, true);
    imagesavealpha($newImage, true);

    // Memuat gambar sumber dan meresample
    $sourceImage = imagecreatefrompng($source); // Ganti dengan imagecreatefromjpeg jika format JPG
    imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $maxWidth, $maxHeight, $width, $height);
    
    // Simpan gambar yang telah di-resize
    imagepng($newImage, $destination); // Simpan gambar resized
    imagedestroy($newImage);
    imagedestroy($sourceImage);
}


function cetak($no_antrian) {
    $hariIni = new DateTime();

    // Array nama bulan dalam bahasa Indonesia
    $bulanIndo = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    try {
        // Masukkan nama share printer USB
        $connector = new WindowsPrintConnector("POS-80");

        /* Print a receipt */
        $printer = new Printer($connector);
        $printer->initialize();

        // Cetak logo
        $logoPath = __DIR__ . '/../../assets/img/logo.png'; // Ganti dengan path logo Anda
        $resizedLogoPath = __DIR__ . '/../../assets/imgrez/resized_logo.png'; // Path untuk gambar yang di-resize

        // Resize gambar
        resizeImage($logoPath, $resizedLogoPath, 200, 100); // Sesuaikan ukuran sesuai kebutuhan

        if (file_exists($resizedLogoPath)) {
            // Menggunakan metode load() untuk memuat gambar
            $logo = EscposImage::load($resizedLogoPath, false);
            
            // Cetak gambar
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->bitImage($logo);
            $printer->feed(1); // Memberi jarak setelah logo
        }

        // Header
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setEmphasis(true);
        $printer->setFont(Printer::FONT_A);
        $printer->setTextSize(2, 1);
        $printer->text("RSUI MUTIARA BUNDA\n");
        $printer->setEmphasis(false);
        $printer->setTextSize(1, 1); // Menghindari tanda seru tambahan
        $printer->text("Jl. Raya Pantura Cenderawasih, Tanjung, Brebes\n");
        $printer->text("Brebes, Jawa Tengah\n");
        $printer->text("=============================================\n\n");

        // Nomor Antrian
        $printer->setEmphasis(true); // Emphasis hanya untuk teks tertentu
        $printer->setTextSize(2, 1);
        $printer->text("NOMOR ANTRIAN\n\n");
        $printer->setEmphasis(false);
        $printer->setTextSize(6, 3); // Menghindari angka tambahan
        $printer->text($no_antrian . "\n\n\n");

        // Pesan
        $printer->setTextSize(1, 1);
        $printer->text("Silahkan menunggu nomor antrian dipanggil\n");
        $printer->text("Nomor ini hanya berlaku pada hari dicetak\n");

        // Ambil bulan dalam bahasa Indonesia
        $bulan = $bulanIndo[(int)$hariIni->format('n')];
        $printer->text(hariIndo(date('l')) . ", " . $hariIni->format('d') . " " . $bulan . " " . $hariIni->format('Y') . "\n\n");

        // Footer
        $printer->setTextSize(1, 1);
        $printer->text("Terima kasih, Anda telah tertib.\n\n\n\n");

        // Potong kertas
        $printer->cut();

        // Close printer
        $printer->close();
    } catch (Exception $e) {
        echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
    }
}


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
