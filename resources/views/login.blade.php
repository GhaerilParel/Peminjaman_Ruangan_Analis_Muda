<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">
    <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Peminjaman Ruangan Laboratorium Komputer Sekolah Vokasi IPB University</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/all.min.css" rel="stylesheet">
    <link href="css/perfect-scrollbar.css" rel="stylesheet">


    <!-- Theme Styles -->
    <link href="css/main.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>

<body class="login-page">
    <div class='loader'>
        <div class='spinner-grow text-primary' role='status'>
            <span class='sr-only'>Loading...</span>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-12 col-lg-4">
                <div class="card login-box-container">
                    <div class="card-body">
                        <div class="authent-logo">
                            <img src="img/logo.png" height="40" width="40" alt="">
                        </div>
                        <div class="authent-text">
                            <p>Selamat Datang!</p>
                            <p>Silakan Masuk ke akun Anda.</p>
                        </div>

                        <form action="{{ url('/login') }}" method="POST">
                            @csrf

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="email" name="email" class="form-control" id="floatingInput"
                                        placeholder="name@example.com" value="{{ old('email') }}">
                                    <label for="floatingInput">Alamat Email</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="password" name="password" class="form-control" id="floatingPassword"
                                        placeholder="Password">
                                    <label for="floatingPassword">Kata Sandi</label>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-info">Masuk</button>
                            </div>
                        </form>


                        <div class="authent-reg">
                            <p>Belum Punya Akun? <a href="{{ url('/register') }}">Daftar</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Javascripts -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="js/perfect-scrollbar.min.js"></script>
    <script src="js/main.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector("form");
            const emailInput = document.querySelector('input[name="email"]');

            form.addEventListener("submit", function(event) {
                const email = emailInput.value;

                // Validasi email harus menggunakan domain @apps.ipb.ac.id
                if (!email.endsWith("@apps.ipb.ac.id")) {
                    event.preventDefault();
                    alert("Email harus menggunakan domain @apps.ipb.ac.id.");
                }
            });
        });
    </script>
</body>

</html>
