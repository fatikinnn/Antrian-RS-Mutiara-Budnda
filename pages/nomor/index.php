<!doctype html>
<html lang="en" class="h-100">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Aplikasi Antrian RSUI Mutiara Bunda">
    <meta name="author" content="AF">

    <!-- Title -->
    <title>Ambil Antrian</title>

    <!-- Favicon icon -->
    <link href="../../assets/img/logo.png" type="image/x-icon" rel="shortcut icon">

    <!-- Bootstrap CSS -->
    <link href="../../assets/vendor/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="../../assets/vendor/css/bootstrap-icons.css" rel="stylesheet">

    <!-- Font -->
    <link href="../../assets/vendor/css/swap.css" rel="stylesheet">

    <!-- Custom Style -->
    <link rel="stylesheet" href="../../assets/css/style.css">
    <style>
        /* Custom style for RSUI Mutiara Bunda */
        body {
            background-color: #f0f2f5;
        }
        
        .text-brand {
            color: #007bff;
        }
        
        .card {
            border-color: #dc3545;
        }

        .text-primary {
            color: #007bff !important;
        }

        .bg-white {
            background-color: #fff;
            border: 2px solid #dc3545;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #b82029;
        }

        .border-primary {
            border-color: #007bff !important;
        }

        h1, h3 {
            color: #dc3545;
        }

        footer {
            background-color: #343a40;
            color: #ffffff;
        }

        /* Additional custom style */
        .info-box {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-block {
            font-size: 1.2rem;
            padding: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .container.pt-5 {
            padding-top: 3rem !important;
        }

        .fade-in {
            animation: fadeIn 1s ease-in;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    <main class="flex-shrink-0">
        <div class="container pt-5">
            <div class="row justify-content-lg-center">
                <div class="col-lg-5 mb-4">
                    <div class="px-4 py-3 mb-4 bg-white rounded-2 shadow-sm text-center">
                        <!-- judul halaman -->
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="../../assets/img/logo.png" alt="Logo RSUI Mutiara Bunda" width="50" class="me-3">
                            <h1 class="h5 pt-2 text-danger">RSUI Mutiara Bunda</h1>
                        </div>
                        <p class="text-muted">Sistem Antrian RSUI Mutiara Bunda, Ambil nomor antrian dengan mudah</p>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center d-grid p-5 fade-in">
                            <div class="border border-primary rounded-2 py-2 mb-4">
                                <h3 class="pt-3">ANTRIAN SAAT INI</h3>
                                <!-- menampilkan informasi jumlah antrian -->
                                <h1 id="antrian" class="display-1 fw-bold text-primary text-center lh-1 pb-3"></h1>
                            </div>
                            <!-- button pengambilan nomor antrian -->
                            <a id="insert" href="javascript:void(0)" class="btn btn-danger btn-block rounded-pill px-5 py-4 mb-3">
                                <i class="bi-person-plus fs-3 me-2"></i> Ambil Nomor Antrian
                            </a>
                            <div class="info-box">
                                <p><i class="bi-info-circle-fill"></i> Mohon menunggu hingga nomor antrian Anda dipanggil. Terima kasih atas kesabaran Anda!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto py-4">
        <div class="container">
            <!-- copyright -->
            <div class="copyright text-center mb-2 mb-md-0">&copy; <?php echo date('Y'); ?> - <a href="https://www.rsuimutiarabundabrebes.com/" target="_blank" class="text-brand text-decoration-none">RSUI Mutiara Bunda</a></div>
        </div>
    </footer>

    <!-- jQuery Core -->
    <script src="../../assets/vendor/js/jquery-3.6.0.min.js" type="text/javascript"></script>
    <!-- Popper and Bootstrap JS -->
    <script src="../../assets/vendor/js/popper.min.js" type="text/javascript"></script>
    <!-- Bootstrap JS -->
    <script src="../../assets/vendor/js/bootstrap.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // tampilkan jumlah antrian
            $('#antrian').load('get_antrian.php');

            // proses insert data
            $('#insert').on('click', function() {
                $.ajax({
                    type: 'POST', // mengirim data dengan method POST
                    url: 'insert.php', // url file proses insert data
                    success: function(result) { // ketika proses insert data selesai
                        // jika berhasil
                        if (result === 'Sukses') {
                            // tampilkan jumlah antrian
                            $.get("get_antrian.php", function(data, status) {
                                $('#antrian').html(data).fadeIn('slow');
                            });
                        } else if (result.includes('Sukses')) {
                            $.get("get_antrian.php", function(data, status) {
                                $('#antrian').html(data).fadeIn('slow');
                                // alert("Antrian anda " + data + " berhasil di ambil, tapi printer bermasalah!");
                            });
                        } else {
                            alert("Eits ada masalah nih, hubungi IT Support yaa!");
                        }
                    },
                });
            });
        });
    </script>
</body>

</html>
